<?php

	/***
	***	@load wall posts
	***/
	add_action('wp_ajax_nopriv_um_activity_load_wall', 'um_activity_load_wall');
	add_action('wp_ajax_um_activity_load_wall', 'um_activity_load_wall');
	function um_activity_load_wall(){
		global $ultimatemember, $um_activity;

		$number = um_get_option('activity_posts_num');
		$offset = absint( $_POST['offset'] );
		$user_id = absint( $_POST['user_id'] );
		$user_wall = absint( $_POST['user_wall'] );
		$hashtag =  isset( $_POST['hashtag'] ) ? (string) $_POST['hashtag'] : '';

		// Specific user only
		if ( $user_wall ) {

			ob_start();
			$args = array(
				'user_id' => $user_id,
				'user_wall' => 1,
				'offset' => $offset
			);

		// Global feed
		} else {

			ob_start();
			$args = array(
				'user_id' => 0,
				'template' => 'activity',
				'mode' => 'activity',
				'form_id' => 'um_activity_id',
				'user_wall' => 0,
				'offset' => $offset
			);

			if ( isset( $hashtag ) && $hashtag ) {

				$args['tax_query'] = array(
					array(
					'taxonomy' => 'um_hashtag',
					'field' => 'slug',
					'terms' => array ( $hashtag )
					)
				);

				$args['hashtag'] = $hashtag;

			} else if ( $um_activity->api->followed_ids() ) {

				$args['meta_query'][] = array('key' => '_user_id','value' => $um_activity->api->followed_ids(),'compare' => 'IN');

			}

		}

		$um_activity->shortcode->args = $args;
		$um_activity->shortcode->load_template('user-wall');

		die();

	}

	/***
	***	@Get user suggestions
	***/
	add_action('wp_ajax_nopriv_um_activity_get_user_suggestions', 'um_activity_get_user_suggestions');
	add_action('wp_ajax_um_activity_get_user_suggestions', 'um_activity_get_user_suggestions');
	function um_activity_get_user_suggestions(){
		global $ultimatemember, $um_activity;

		if ( !is_user_logged_in() )
			die();

		if ( !class_exists('UM_Followers_API') )
			die();

		if ( !um_get_option('activity_followers_mention') )
			die();

		$term = $_GET['term'];
		$term = str_replace('@','',$term);

		global $um_followers, $um_activity, $um_notifications;

		$user_id = get_current_user_id();

		$following = $um_followers->api->following( $user_id );
		if ( $following ) {
			foreach( $following as $k => $arr ) {
				extract( $arr );
				um_fetch_user( $user_id1 );
				if ( !stristr( um_user('display_name'), $term ) ) continue;
				$data[ $user_id1 ]['user_id'] = $user_id1;
				$data[ $user_id1 ]['photo'] = get_avatar( $user_id1, 30 );
				$data[ $user_id1 ]['name'] = str_replace( $term, '<strong>'. $term . '</strong>', um_user('display_name') );
				$data[ $user_id1 ]['username'] = um_user('user_login');
			}
		}

		$followers = $um_followers->api->followers( $user_id );
		if ( $followers ) {
			foreach( $followers as $k => $arr ) {
				extract( $arr );
				um_fetch_user( $user_id2 );
				if ( !stristr( um_user('display_name'), $term ) ) continue;
				$data[ $user_id2 ]['user_id'] = $user_id2;
				$data[ $user_id2 ]['photo'] = get_avatar( $user_id2, 30 );
				$data[ $user_id2 ]['name'] = str_replace( $term, '<strong>'. $term . '</strong>', um_user('display_name') );
				$data[ $user_id2 ]['username'] = um_user('user_login');
			}
		}

		if ( isset( $data ) )
			wp_send_json( $data );

	}

	/***
	***	@removes a wall post
	***/
	add_action('wp_ajax_nopriv_um_activity_remove_post', 'um_activity_remove_post');
	add_action('wp_ajax_um_activity_remove_post', 'um_activity_remove_post');
	function um_activity_remove_post(){
		global $ultimatemember, $um_activity;

		if ( !isset( $_POST['post_id'] ) || absint( $_POST['post_id'] ) <= 0 )
			die();

		$post_id = absint( $_POST['post_id'] );

		$author_id = $um_activity->api->get_author( $post_id );

		if ( current_user_can('edit_users') ) {
			wp_delete_post( $post_id, true );
		} else if ( $author_id == get_current_user_id() && is_user_logged_in() ) {
			wp_delete_post( $post_id, true );
		}

		die();

	}

	/***
	***	@removes a wall comment
	***/
	add_action('wp_ajax_nopriv_um_activity_remove_comment', 'um_activity_remove_comment');
	add_action('wp_ajax_um_activity_remove_comment', 'um_activity_remove_comment');
	function um_activity_remove_comment(){
		global $ultimatemember, $um_activity, $wpdb;

		if ( !isset( $_POST['comment_id'] ) || absint( $_POST['comment_id'] ) <= 0 )
			die();

		$comment_id = absint( $_POST['comment_id'] );
		$comment = get_comment( $comment_id );

		if ( $um_activity->api->can_edit_comment( $comment_id, get_current_user_id() ) ) {
			// remove comment
			wp_delete_comment( $comment_id, true );

			// remove hashtag(s) from the trending list if it's
			// totally remove from posts / comments
			$content = $comment->comment_content;
			$post_id = $comment->comment_post_ID;
			preg_match_all('/(?<!\&)#([^\s\<]+)/', $content, $matches);
			if ( isset( $matches[1] ) && is_array( $matches[1] ) ) {
				foreach($matches[1] as $hashtag)
				{
					$post_count    = intval( $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE ID = '{$post_id}' AND post_content LIKE '%>#{$hashtag}<%'" ) );
					$comment_count = intval( $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_post_ID = '{$post_id}' AND comment_content LIKE '%>#{$hashtag}<%'" ) );

					if( !$post_count && !$comment_count )
					{
						$term = get_term_by( 'name', $hashtag, 'um_hashtag' );
						wp_remove_object_terms( $post_id, $term->term_id, 'um_hashtag' );
					}
				}
			}
		}

		die();

	}

	/***
	***	@load post likes
	***/
	add_action('wp_ajax_nopriv_um_activity_get_post_likes', 'um_activity_get_post_likes');
	add_action('wp_ajax_um_activity_get_post_likes', 'um_activity_get_post_likes');
	function um_activity_get_post_likes(){
		global $ultimatemember, $um_activity;

		if ( !isset( $_POST['post_id'] ) || absint( $_POST['post_id'] ) <= 0 )
			die();

		$item_id = absint( $_POST['post_id'] );

		if ( !$item_id ) die();

		$users = get_post_meta( $item_id, '_liked', true );
		if ( !$users || !is_array( $users ) ) die();

		$users = array_reverse( $users );

		ob_start();

		$file = um_activity_path . 'templates/likes.php';
		$theme_file = get_stylesheet_directory() . '/ultimate-member/templates/activity/likes.php';

		if ( file_exists( $theme_file ) )
			$file = $theme_file;

		if ( file_exists( $file ) )
			include $file;

		$output = ob_get_contents();
		ob_end_clean();
		die($output);

	}

	/***
	***	@load comment likes
	***/
	add_action('wp_ajax_nopriv_um_activity_get_comment_likes', 'um_activity_get_comment_likes');
	add_action('wp_ajax_um_activity_get_comment_likes', 'um_activity_get_comment_likes');
	function um_activity_get_comment_likes(){
		global $ultimatemember, $um_activity;

		if ( !isset( $_POST['comment_id'] ) || absint( $_POST['comment_id'] ) <= 0 )
			die();

		$item_id = absint( $_POST['comment_id'] );

		if ( !$item_id ) die();

		$users = get_comment_meta( $item_id, '_liked', true );
		if ( !$users || !is_array( $users ) ) die();

		$users = array_reverse( $users );

		ob_start();

		$file = um_activity_path . 'templates/likes.php';
		$theme_file = get_stylesheet_directory() . '/ultimate-member/templates/activity/likes.php';

		if ( file_exists( $theme_file ) )
			$file = $theme_file;

		if ( file_exists( $file ) )
			include $file;

		$output = ob_get_contents();
		ob_end_clean();
		die($output);

	}

	/***
	***	@hide a comment
	***/
	add_action('wp_ajax_nopriv_um_activity_hide_comment', 'um_activity_hide_comment');
	add_action('wp_ajax_um_activity_hide_comment', 'um_activity_hide_comment');
	function um_activity_hide_comment(){
		global $ultimatemember, $um_activity;
		if ( !is_user_logged_in() )
			die();
		$comment_id = absint( $_POST['comment_id'] );
		if ( $comment_id <= 0 ) die();
		$um_activity->api->user_hide_comment( $comment_id );
		die();
	}

	/***
	***	@unhide a comment
	***/
	add_action('wp_ajax_nopriv_um_activity_unhide_comment', 'um_activity_unhide_comment');
	add_action('wp_ajax_um_activity_unhide_comment', 'um_activity_unhide_comment');
	function um_activity_unhide_comment(){
		global $ultimatemember, $um_activity;
		if ( !is_user_logged_in() )
			die();
		$comment_id = absint( $_POST['comment_id'] );
		if ( $comment_id <= 0 ) die();
		$um_activity->api->user_unhide_comment( $comment_id );
		die();
	}

	/***
	***	@report a post
	***/
	add_action('wp_ajax_nopriv_um_activity_report_post', 'um_activity_report_post');
	add_action('wp_ajax_um_activity_report_post', 'um_activity_report_post');
	function um_activity_report_post(){
		global $ultimatemember, $um_activity;

		if ( !is_user_logged_in() )
			die();

		$post_id = absint( $_POST['post_id'] );
		if ( $post_id <= 0 ) die();

		$users_reported = get_post_meta( $post_id, '_reported_by', true );
		$users_reported[ get_current_user_id() ] = current_time('timestamp');
		update_post_meta( $post_id, '_reported_by', $users_reported );

		if ( !get_post_meta( $post_id, '_reported', true ) ) {
			$count = (int)get_option('um_activity_flagged');
			update_option('um_activity_flagged', $count+1);
		}

		$new_r = (int)get_post_meta( $post_id, '_reported', true );
		update_post_meta( $post_id, '_reported', $new_r + 1 );

		die();

	}

	/***
	***	@un-report a post
	***/
	add_action('wp_ajax_nopriv_um_activity_unreport_post', 'um_activity_unreport_post');
	add_action('wp_ajax_um_activity_unreport_post', 'um_activity_unreport_post');
	function um_activity_unreport_post(){
		global $ultimatemember, $um_activity;

		if ( !is_user_logged_in() )
			die();

		$post_id = absint( $_POST['post_id'] );
		if ( $post_id <= 0 ) die();

		$users_reported = get_post_meta( $post_id, '_reported_by', true );
		if ( isset( $users_reported[ get_current_user_id() ] ) ) {
			unset( $users_reported[ get_current_user_id() ] );
		}
		if ( !$users_reported ) {
			$user_reported = '';
		}
		update_post_meta( $post_id, '_reported_by', $users_reported );

		if ( get_post_meta( $post_id, '_reported', true ) ) {

			$new_r = (int)get_post_meta( $post_id, '_reported', true );
			$new_r = $new_r - 1;
			if ( $new_r < 0 ) $new_r = 0;
			update_post_meta( $post_id, '_reported', $new_r );

			if ( $new_r == 0 ) {
				$count = (int)get_option('um_activity_flagged');
				update_option('um_activity_flagged', absint( $count-1 ) );
			}

		}

		die();

	}

	/***
	***	@load wall comments
	***/
	add_action('wp_ajax_nopriv_um_activity_load_more_comments', 'um_activity_load_more_comments');
	add_action('wp_ajax_um_activity_load_more_comments', 'um_activity_load_more_comments');
	function um_activity_load_more_comments(){
		global $ultimatemember, $um_activity;

		$number = um_get_option('activity_load_comments_count');
		$offset = absint( $_POST['offset'] );
		$post_id = absint( $_POST['post_id'] );
		$post_link = $um_activity->api->get_permalink( $post_id );

		ob_start();

		$comments = get_comments( array( 'post_id' => $post_id, 'parent' => 0, 'number' => $number, 'offset' => $offset, 'order' => um_get_option('activity_order_comment') ) );
		$comments_all = $um_activity->api->get_comments_number( $post_id );

		include um_activity_path . 'templates/comment.php';

		if ( $comments_all > ( $offset + $number ) ) {
			echo '<span class="um-activity-commentload-end"></span>';
		}

		die();

	}

	/***
	***	@load wall replies
	***/
	add_action('wp_ajax_nopriv_um_activity_load_more_replies', 'um_activity_load_more_replies');
	add_action('wp_ajax_um_activity_load_more_replies', 'um_activity_load_more_replies');
	function um_activity_load_more_replies(){
		global $ultimatemember, $um_activity;

		$number = um_get_option('activity_load_comments_count');

		$offset = absint( $_POST['offset'] );
		$post_id = absint( $_POST['post_id'] );
		$comment_id = absint( $_POST['comment_id'] );
		$post_link = $um_activity->api->get_permalink( $post_id );

		ob_start();

		$child = get_comments( array( 'post_id' => $post_id, 'parent' => $comment_id, 'number' => $number, 'offset' => $offset, 'order' => um_get_option('activity_order_comment') ) );
		$child_all = get_comments( array( 'post_id' => $post_id, 'parent' => $comment_id, 'number' => 999, 'offset' => 0, 'order' => um_get_option('activity_order_comment') ) );

		foreach( $child as $commentc ) {

			$likes = get_comment_meta( $commentc->comment_ID, '_likes', true );

			$avatar = get_avatar( $commentc->comment_author_email, 20 );

			$user_hidden = $um_activity->api->user_hidden_comment( $commentc->comment_ID );

			include um_activity_path . 'templates/comment-reply.php';

		}

		if ( count( $child_all ) >  ( $offset + $number ) ) {
			echo '<span class="um-activity-ccommentload-end"></span>';
		}

		die();

	}

	/***
	***	@like wall comment
	***/
	add_action('wp_ajax_nopriv_um_activity_like_comment', 'um_activity_like_comment');
	add_action('wp_ajax_um_activity_like_comment', 'um_activity_like_comment');
	function um_activity_like_comment(){
		global $ultimatemember, $um_activity;

		$output['error'] = '';

		if ( !is_user_logged_in() )
			$output['error'] = __('You must login to like','um-activity');

		if ( !isset( $_POST['commentid'] ) || !is_numeric( $_POST['commentid'] ) )
			$output['error'] = __('Invalid comment','um-activity');

		if ( !$output['error'] ) {

			$likes = (int)get_comment_meta( $_POST['commentid'], '_likes', true );
			update_comment_meta( $_POST['commentid'], '_likes', $likes+1 );

			$liked = get_comment_meta( $_POST['commentid'], '_liked', true );
			if ( !$liked ) {
				$liked = array( get_current_user_id() );
			} else {
				$liked[] = get_current_user_id();
			}
			update_comment_meta( $_POST['commentid'], '_liked', $liked );

		}

		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}

	/***
	***	@unlike wall comment
	***/
	add_action('wp_ajax_nopriv_um_activity_unlike_comment', 'um_activity_unlike_comment');
	add_action('wp_ajax_um_activity_unlike_comment', 'um_activity_unlike_comment');
	function um_activity_unlike_comment(){
		global $ultimatemember, $um_activity;

		$output['error'] = '';

		if ( !is_user_logged_in() )
			$output['error'] = __('You must login to unlike','um-activity');

		if ( !isset( $_POST['commentid'] ) || !is_numeric( $_POST['commentid'] ) )
			$output['error'] = __('Invalid comment','um-activity');

		if ( !$output['error'] ) {

			$likes = get_comment_meta( $_POST['commentid'], '_likes', true );
			update_comment_meta( $_POST['commentid'], '_likes', $likes-1 );

			$liked = get_comment_meta( $_POST['commentid'], '_liked', true );
			if ( $liked ) {
				$liked = array_diff( $liked, array( get_current_user_id() ) );
			}
			update_comment_meta( $_POST['commentid'], '_liked', $liked );

		}

		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}

	/***
	***	@like wall post
	***/
	add_action('wp_ajax_nopriv_um_activity_like_post', 'um_activity_like_post');
	add_action('wp_ajax_um_activity_like_post', 'um_activity_like_post');
	function um_activity_like_post(){
		global $ultimatemember, $um_activity;

		$output['error'] = '';

		if ( !is_user_logged_in() )
			$output['error'] = __('You must login to like','um-activity');

		if ( !isset( $_POST['postid'] ) || !is_numeric( $_POST['postid'] ) )
			$output['error'] = __('Invalid wall post','um-activity');

		if ( !$output['error'] ) {

			$likes = get_post_meta( $_POST['postid'], '_likes', true );
			update_post_meta( $_POST['postid'], '_likes', $likes+1 );

			$liked = get_post_meta( $_POST['postid'], '_liked', true );
			if ( !$liked ) {
				$liked = array( get_current_user_id() );
			} else {
				$liked[] = get_current_user_id();
			}
			update_post_meta( $_POST['postid'], '_liked', $liked );

			do_action( 'um_activity_after_wall_post_liked', $_POST['postid'], get_current_user_id() );

		}

		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}

	/***
	***	@unlike wall post
	***/
	add_action('wp_ajax_nopriv_um_activity_unlike_post', 'um_activity_unlike_post');
	add_action('wp_ajax_um_activity_unlike_post', 'um_activity_unlike_post');
	function um_activity_unlike_post(){
		global $ultimatemember, $um_activity;

		$output['error'] = '';

		if ( !is_user_logged_in() )
			$output['error'] = __('You must login to unlike','um-activity');

		if ( !isset( $_POST['postid'] ) || !is_numeric( $_POST['postid'] ) )
			$output['error'] = __('Invalid wall post','um-activity');

		if ( !$output['error'] ) {

			$likes = get_post_meta( $_POST['postid'], '_likes', true );
			update_post_meta( $_POST['postid'], '_likes', $likes-1 );

			$liked = get_post_meta( $_POST['postid'], '_liked', true );
			if ( $liked ) {
				$liked = array_diff( $liked, array( get_current_user_id() ) );
			}
			update_post_meta( $_POST['postid'], '_liked', $liked );

		}

		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}

	/***
	***	@add a new wall post comment
	***/
	add_action('wp_ajax_nopriv_um_activity_wall_comment', 'um_activity_wall_comment');
	add_action('wp_ajax_um_activity_wall_comment', 'um_activity_wall_comment');
	function um_activity_wall_comment(){
		global $ultimatemember, $um_activity;
		$output['error'] = '';

		if ( !is_user_logged_in() )
			$output['error'] = __('Login to post a comment','um-activity');

		if ( !isset( $_POST['postid'] ) || !is_numeric( $_POST['postid'] ) )
			$output['error'] = __('Invalid wall post','um-activity');

		if ( !isset( $_POST['comment'] ) || trim( $_POST['comment'] ) == '' )
			$output['error'] = __('Enter a comment first','um-activity');

		if ( !$output['error'] ) {

			um_fetch_user( get_current_user_id() );
			$time = current_time('mysql');

			$comment_content = wp_kses( $_POST['comment'], array('') );
			$comment_content = apply_filters('um_activity_comment_content_new', $comment_content, absint( $_POST['postid'] ) );
			// apply hashtag
			$um_activity->api->hashtagit( $post_id, $comment_content );
			$comment_content = $um_activity->api->hashtag_links( $comment_content );

			$data = array(
				'comment_post_ID' => absint( $_POST['postid'] ),
				'comment_author' => um_user('display_name'),
				'comment_author_email' => um_user('user_email'),
				'comment_author_url' => um_user_profile_url(),
				'comment_content' => $comment_content,
				'user_id' => get_current_user_id(),
				'comment_date' => $time,
				'comment_approved' => 1,
				'comment_author_IP' => um_user_ip(),
				'comment_type' => 'um-social-activity'
			);

			$output['comment_content'] = $comment_content;

			if ( isset( $_POST['reply_to'] ) && absint( $_POST['reply_to'] ) ) {
				$data['comment_parent'] = absint( $_POST['reply_to'] );
				$comment_parent = $data['comment_parent'];
			} else {
				$comment_parent = 0;
			}

			$commentid = wp_insert_comment( $data );

			$comment_count = get_post_meta( $_POST['postid'], '_comments', true );
			update_post_meta( $_POST['postid'], '_comments', $comment_count + 1 );

			$output['commentid'] = $commentid;

			do_action( 'um_activity_after_wall_comment_published', $commentid, $comment_parent, absint( $_POST['postid'] ), get_current_user_id() );

		}

		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}

	/***
	***	@add a new wall post
	***/
	add_action('wp_ajax_nopriv_um_activity_publish', 'um_activity_publish');
	add_action('wp_ajax_um_activity_publish', 'um_activity_publish');
	function um_activity_publish(){
		global $ultimatemember, $um_activity;
		extract($_POST);

		$output['error'] = '';

		if ( !is_user_logged_in() )
			$output['error'] = __('You can not post as guest','um-activity');

		if ( $_post_content == '' || trim( $_post_content ) == '' ) {
			if ( trim( $_post_img ) == '' ) {
				$output['error'] = __('You should type something first','um-activity');
			}
		}

		if ( !$output['error'] ) {

			if ( $_POST['_post_id'] == 0 ) {

				$args = array(
					'post_title'		=> '',
					'post_type' 	  	=> 'um_activity',
					'post_status'		=> 'publish',
					'post_author'   	=> get_current_user_id(),
				);

				if ( trim( $_post_content ) ) {
					$orig_content = trim( $_post_content );
					$safe_content = wp_kses( $_post_content, array(
						'br' => array()
					) );

					// shared a link
					$shared_link = $um_activity->api->get_content_link( $safe_content );
					if ( isset( $shared_link ) && $shared_link && !$_post_img ) {
						$safe_content = str_replace( $shared_link, '', $safe_content );
					}

					$args['post_content'] = $safe_content;
				}

				$args = apply_filters('um_activity_insert_post_args', $args );

				$post_id = wp_insert_post( $args );

				// shared a link
				if ( isset( $shared_link ) && $shared_link && !$_post_img ) {
					$output['link'] = $um_activity->api->set_url_meta( $shared_link, $post_id );
				} else {
					delete_post_meta( $post_id, '_shared_link' );
				}

				$args['post_content'] = apply_filters('um_activity_insert_post_content_filter', $args['post_content'], get_current_user_id(), $post_id, 'new' );

				wp_update_post( array('ID' => $post_id, 'post_title' => $post_id, 'post_name' => $post_id, 'post_content' => $args['post_content'] ) );

				if ( isset( $safe_content ) ) {
					$um_activity->api->hashtagit( $post_id, $safe_content );
					update_post_meta( $post_id, '_original_content', $orig_content );
					$output['orig_content'] = $orig_content;
				}

				if ( absint( $_POST['_wall_id'] ) > 0 ) {
					update_post_meta( $post_id, '_wall_id', absint( $_POST['_wall_id'] ) );
				}

				// Save item meta
				update_post_meta( $post_id, '_action', 'status');
				update_post_meta( $post_id, '_user_id', get_current_user_id() );
				update_post_meta( $post_id, '_likes', 0 );
				update_post_meta( $post_id, '_comments', 0 );

				if ( $_post_img ) {
					$um_is_temp_image = um_is_temp_image( $_post_img );
					$photo_uri = $ultimatemember->files->new_user_upload( get_current_user_id(), $um_is_temp_image, '_um_wall_img_upload' );
					update_post_meta( $post_id, '_photo', $photo_uri );
					$output['photo'] = $photo_uri;
				}

				$output['postid'] = $post_id;
				$output['content'] = $um_activity->api->get_content( $post_id );
				$output['video'] = $um_activity->api->get_video( $post_id );

				do_action( 'um_activity_after_wall_post_published', $post_id, get_current_user_id(), absint( $_POST['_wall_id'] ) );

			} else {

				// Updating a current wall post
				$post_id = absint( $_POST['_post_id'] );

				if ( trim( $_post_content ) ) {
					$orig_content = trim( $_post_content );
					$safe_content = wp_kses( $_post_content, array(
						'br' => array()
					) );

					// shared a link
					$shared_link = $um_activity->api->get_content_link( $safe_content );
					if ( isset( $shared_link ) && $shared_link && !$_post_img ) {
						$safe_content = str_replace( $shared_link, '', $safe_content );
						$output['link'] = $um_activity->api->set_url_meta( $shared_link, $post_id );
					} else {
						delete_post_meta( $post_id, '_shared_link' );
					}

					$safe_content = apply_filters('um_activity_update_post_content_filter', $safe_content, $um_activity->api->get_author( $post_id ), $post_id, 'save' );

					$args['post_content'] = $safe_content;
				}

				$args['ID'] = $post_id;
				$args = apply_filters('um_activity_update_post_args', $args );

				wp_update_post( $args );

				if ( isset( $safe_content ) ) {
					$um_activity->api->hashtagit( $post_id, $safe_content );
					update_post_meta( $post_id, '_original_content', $orig_content );
					$output['orig_content'] = $orig_content;
				}

				if ( trim( $_post_img ) != '' ) {

					$um_is_temp_image = um_is_temp_image( $_post_img );

					if ( $um_is_temp_image ) {
						$photo_uri = $ultimatemember->files->new_user_upload( get_current_user_id(), $um_is_temp_image, '_um_wall_img_upload' );
						update_post_meta( $post_id, '_photo', $photo_uri );
						$output['photo'] = $photo_uri;
					} else {
						$output['photo'] = $um_is_temp_image;
					}

				} else {

					delete_post_meta( $post_id, '_photo' );

				}

				$output['postid'] = $post_id;
				$output['content'] = $um_activity->api->get_content( $post_id );
				$output['video'] = $um_activity->api->get_video( $post_id );

				do_action( 'um_activity_after_wall_post_updated', $post_id, get_current_user_id(), absint( $_POST['_wall_id'] ) );

			}

			// other output
			$output['permalink'] = add_query_arg( 'wall_post', $post_id, get_permalink( $ultimatemember->permalinks->core['activity'] ) );

		}

		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}
