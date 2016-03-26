<?php

	/* new user follow */
	add_action('um_followers_after_user_follow','um_activity_new_follow', 9999, 2 );
	function um_activity_new_follow( $user_id1, $user_id2 ) {
		global $ultimatemember, $um_activity, $um_followers;
		if ( !class_exists('UM_Followers_API') ) return;
		if ( !um_get_option('activity-new-follow') )
			return;

		um_fetch_user( $user_id2 );
		$author_name = um_user('display_name');
		$author_profile = um_user_profile_url();

		um_fetch_user( $user_id1 );
		$user_name = um_user('display_name');
		$user_profile = um_user_profile_url();
		$user_photo = get_avatar( $user_id1, 24 );

		$um_activity->api->save(
			array(
				'template' => 'new-follow',
				'wall_id' => 0,
				'author' => $user_id2,
				'related_id' => $user_id1,
				'author_name' => $author_name,
				'author_profile' => $author_profile,
				'user_name' => $user_name,
				'user_profile' => $user_profile,
				'user_photo' => $user_photo,
			)
		);

	}

	/* undo new follow */
	add_action('um_followers_after_user_unfollow', 'um_activity_new_unfollow', 9999, 2 );
	function um_activity_new_unfollow( $user_id1, $user_id2 ) {
		global $ultimatemember, $um_activity, $um_followers;
		if ( !class_exists('UM_Followers_API') ) return;
		if ( !um_get_option('activity-new-follow') )
			return;

		$args = array(
			'post_type' => 'um_activity',
		);

		$args['meta_query'][] = array('key' => '_user_id','value' => $user_id2,'compare' => '=');
		$args['meta_query'][] = array('key' => '_related_id','value' => $user_id1,'compare' => '=');
		$args['meta_query'][] = array('key' => '_action','value' => 'new-follow','compare' => '=');
		$get = new WP_Query( $args );
		if ( $get->found_posts == 0 ) return;
		foreach( $get->posts as $post ) {
			wp_delete_post( $post->ID, true );
		}
	}

	/* new user registration */
	add_action('um_after_user_is_approved','um_activity_new_user', 90, 1 );
	function um_activity_new_user( $user_id ) {
		global $um_activity;
		if ( !um_get_option('activity-new-user') )
			return;

		um_fetch_user( $user_id );
		$author_name = um_user('display_name');
		$author_profile = um_user_profile_url();

		$um_activity->api->save(
			array(
				'template' => 'new-user',
				'wall_id' => 0,
				'author' => $user_id,
				'author_name' => $author_name,
				'author_profile' => $author_profile
			)
		);

	}

	/* new forum topic */
	add_action('bbp_new_topic', 'um_activity_new_topic', 9999, 1 );
	function um_activity_new_topic($topic_id=0) {
		global $ultimatemember, $um_activity;
		if ( !um_get_option('activity-new-topic') )
			return;

		$user_id = bbp_get_topic_author_id( $topic_id );

		um_fetch_user( $user_id );
		$author_name = um_user('display_name');
		$author_profile = um_user_profile_url();

		if ( bbp_get_topic_content( $topic_id ) ) {
			$post_excerpt = '<span class="post-excerpt">' . wp_trim_words( strip_shortcodes( bbp_get_topic_content( $topic_id ) ), $num_words = 25, $more = null ) . '</span>';
		} else {
			$post_excerpt = '';
		}

		$um_activity->api->save(
			array(
				'template' => 'new-topic',
				'wall_id' => 0,
				'author' => $user_id,
				'author_name' => $author_name,
				'author_profile' => $author_profile,
				'post_title' => '<span class="post-title">' . bbp_get_topic_title( $topic_id ) . '</span>',
				'post_url' => bbp_get_topic_permalink( $topic_id ),
				'post_excerpt' => $post_excerpt,
			)
		);

	}

	/* blog post is unpublished */
	add_action( 'transition_post_status', 'um_activity_new_blog_post_undo', 10, 3 );
	function um_activity_new_blog_post_undo( $new_status, $old_status, $post ) {
		if ( 'post' !== $post->post_type )
			return;
		global $um_activity;
		if ( !um_get_option('activity-new-post') )
			return;

		if ( 'publish' !== $new_status && 'publish' === $old_status ) {
			$args = array(
				'post_type' => 'um_activity',
			);

			$args['meta_query'][] = array('key' => '_related_id','value' => $post->ID,'compare' => '=');
			$args['meta_query'][] = array('key' => '_action','value' => 'new-post','compare' => '=');
			$get = new WP_Query( $args );
			if ( $get->found_posts == 0 ) return;
			foreach( $get->posts as $post ) {
				wp_delete_post( $post->ID, true );
			}
		}
	}

	/* new blog post */
	add_action('publish_post', 'um_activity_new_blog_post');
	function um_activity_new_blog_post( $post_id ) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if ( get_post_type( $post_id ) != 'post' ) return;
		if ( !isset( $_POST['original_post_status'] ) ) return;

		if( ( $_POST['post_status'] == 'publish' ) && ( $_POST['original_post_status'] == 'publish' ) ) return;

		global $um_activity;
		if ( !um_get_option('activity-new-post') )
			return;

		$post = get_post( $post_id );
		$user_id = $post->post_author;

		um_fetch_user( $user_id );
		$author_name = um_user('display_name');
		$author_profile = um_user_profile_url();

		if (has_post_thumbnail( $post_id ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
			$post_image = '<span class="post-image"><img src="'. $image[0] . '" alt="" title="" class="um-activity-featured-img" /></span>';
		} else {
			$post_image = '';
		}

		if ( $post->post_content ) {
			$post_excerpt = '<span class="post-excerpt">' . wp_trim_words( strip_shortcodes( $post->post_content ), $num_words = 25, $more = null ) . '</span>';
		} else {
			$post_excerpt = '';
		}

		$um_activity->api->save(
			array(
				'template' => 'new-post',
				'wall_id' => $user_id,
				'related_id' => $post_id,
				'author' => $user_id,
				'author_name' => $author_name,
				'author_profile' => $author_profile,
				'post_title' => '<span class="post-title">' . $post->post_title . '</span>',
				'post_url' => get_permalink( $post_id ),
				'post_excerpt' => $post_excerpt,
				'post_image' => $post_image,
			)
		);

    }

	/* new product */
	add_action('save_post', 'um_activity_new_woo_product', 99999, 1 );
	function um_activity_new_woo_product( $post_id ) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if ( get_post_type( $post_id ) != 'product' || get_post_status( $post_id ) != 'publish' ) return;

		global $um_activity;

		if ( !um_get_option('activity-new-product') )
			return;

		$post = get_post($post_id);
		if( $post->post_modified_gmt != $post->post_date_gmt ) return;

		if ( !isset( $_POST['original_post_status'] ) ) return;
		if( ( $_POST['post_status'] == 'publish' ) && ( $_POST['original_post_status'] == 'publish' ) ) return;

		$product = new WC_Product( $post_id );
		$user_id = $post->post_author;

		um_fetch_user( $user_id );
		$author_name = um_user('display_name');
		$author_profile = um_user_profile_url();

		if (has_post_thumbnail( $post_id ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
			$post_image = '<span class="post-image"><img src="'. $image[0] . '" alt="" title="" class="um-activity-featured-img" /></span>';
		} else {
			$post_image = '';
		}

		if ( $post->post_excerpt ) {
			$post_excerpt = '<span class="post-excerpt">' . strip_tags( apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ) . '</span>';
		} elseif ( $post->post_content ) {
			$post_excerpt = '<span class="post-excerpt">' . wp_trim_words( strip_shortcodes( $post->post_content ), $num_words = 25, $more = null ) . '</span>';
		} else  {
			$post_excerpt = '';
		}

		$um_activity->api->save(
			array(
				'template' => 'new-product',
				'wall_id' => $user_id,
				'author' => $user_id,
				'author_name' => $author_name,
				'author_profile' => $author_profile,
				'post_title' => '<span class="post-title">' . $post->post_title . '</span>',
				'post_url' => get_permalink( $post_id ),
				'post_excerpt' => $post_excerpt,
				'post_image' => $post_image,
				'price' => '<span class="post-price">' . $product->get_price_html() . '</span>',
			)
		);

    }

    /**
     * Remove 'deleted forum topic' from the activties
     */
    add_action('before_delete_post', 'um_activity_remove_forum_post');
    function um_activity_remove_forum_post($postid) {
    	global $wpdb;

    	if(function_exists('bbp_get_topic_post_type')) {
    		$post = get_post($postid);

    		if($post && !is_wp_error($post) && bbp_get_topic_post_type() == $post->post_type) {
    			$permalink = get_permalink($post->ID);

    			$activities = $wpdb->get_col("SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_content LIKE '%just created a new forum%' AND post_content LIKE '%{$permalink}%'");

    			if($activities && count($activities)) {
    				foreach($activities as $activityId) {
    					wp_delete_post($activityId);
    				}
    			}
    		}
    	}
    }
