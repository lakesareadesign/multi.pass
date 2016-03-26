<?php

class UM_Activity_API_Core {

	function __construct() {

		$this->global_actions['status'] = __('New wall post','um-activity');
		$this->global_actions['new-user'] = __('New user','um-activity');
		$this->global_actions['new-post'] = __('New blog post','um-activity');
		$this->global_actions['new-product'] = __('New product','um-activity');
		$this->global_actions['new-follow'] = __('New follow','um-activity');
		$this->global_actions['new-topic'] = __('New forum topic','um-activity');

		add_filter('um_profile_tabs', array(&$this, 'add_tab'), 5);
		add_filter('um_user_profile_tabs', array(&$this, 'add_user_tab'), 5);

		add_action('um_profile_content_activity', array(&$this, 'show_wall') );

	}

	/***
	***	@API to automate activity posts
	***/
	function save( $array = array() ) {
		global $ultimatemember;
		extract( $array );

		$args = array(
			'post_title'		=> '',
			'post_type' 	  	=> 'um_activity',
			'post_status'		=> 'publish',
			'post_author'   	=> $array['author'],
		);

		ob_start();
		$file = ( isset( $array['custom_path'] ) ) ? $array['custom_path'] : um_activity_path . 'templates/html/' . $array['template'] . '.php';
		$theme_file = get_stylesheet_directory() . '/ultimate-member/templates/activity/' . $array['template'] . '.php';
		if ( file_exists( $theme_file ) )
			$file = $theme_file;
		if ( file_exists( $file ) )
			include $file;
		$args['post_content'] = ob_get_contents();
		ob_end_clean();

		$search = array(
			'{author_name}',
			'{author_profile}',
			'{user_name}',
			'{user_profile}',
			'{user_photo}',
			'{post_title}',
			'{post_url}',
			'{post_excerpt}',
			'{post_image}',
			'{price}',
		);
		$search = apply_filters('um_activity_search_tpl', $search);

		$replace = array(
			isset( $array['author_name'] ) ? $array['author_name'] : '',
			isset( $array['author_profile'] ) ? $array['author_profile'] : '',
			isset( $array['user_name'] ) ? $array['user_name'] : '',
			isset( $array['user_profile'] ) ? $array['user_profile'] : '',
			isset( $array['user_photo'] ) ? $array['user_photo'] : '',
			isset( $array['post_title'] ) ? $array['post_title'] : '',
			isset( $array['post_url'] ) ? $array['post_url'] : '',
			isset( $array['post_excerpt'] ) ? $array['post_excerpt'] : '',
			isset( $array['post_image'] ) ? $array['post_image'] : '',
			isset( $array['price'] ) ? $array['price'] : '',
		);
		$replace = apply_filters('um_activity_replace_tpl', $replace, $array );

		$args['post_content'] = str_replace($search, $replace, $args['post_content'] );

		$args['post_content'] = trim( $args['post_content'] );

		$post_id = wp_insert_post( $args );

		wp_update_post( array('ID' => $post_id, 'post_title' => $post_id, 'post_name' => $post_id ) );

		$_permalink = add_query_arg( 'wall_post', $post_id, get_permalink( $ultimatemember->permalinks->core['activity'] ) );

		update_post_meta( $post_id, '_wall_id', $array['wall_id'] );
		update_post_meta( $post_id, '_action', $array['template'] );
		update_post_meta( $post_id, '_user_id', $array['author'] );
		update_post_meta( $post_id, '_likes', 0 );
		update_post_meta( $post_id, '_comments', 0 );

		if ( isset( $array['related_id'] ) ) {
			update_post_meta( $post_id, '_related_id', absint( $array['related_id'] ) );
		}

	}

	/***
	***	@Grab followed user IDs
	***/
	function followed_ids() {
		global $ultimatemember, $um_followers;
		$array = '';

		if ( !$this->followed_activity() )
			return null;

		if ( !is_user_logged_in() )
			return array( 0 );

		$array[] = get_current_user_id();

		$following = $um_followers->api->following( get_current_user_id() );
		if ( $following ) {
			foreach( $following as $k => $arr ) {
				$array[] = $arr['user_id1'];
			}
		}

		if ( isset( $array ) )
			return $array;

		return null;
	}

	/***
	***	@Check if enabled followed activity only
	***/
	function followed_activity() {
		if ( class_exists('UM_Followers_API') && um_get_option('activity_followed_users') )
			return true;
		return false;
	}

	/***
	***	@Return to activity post after login
	***/
	function login_to_interact( $post_id ) {
		global $ultimatemember;
		$text = um_get_option('activity_need_to_login');
		$curr_page = $ultimatemember->permalinks->get_current_url();
		$curr_page = add_query_arg('wall_post', $post_id, $curr_page );
		$text = str_replace('{current_page}', $curr_page, $text );
		return $text;
	}

	/***
	***	@adds a tab
	***/
	function add_tab( $tabs ){

		$tabs['activity'] = array(
			'name' => __('Activity','um-activity'),
			'icon' => 'um-icon-compose',
			'_builtin' => true,
		);

		return $tabs;
	}

	/***
	***	@adds user-condition tab
	***/
	function add_user_tab( $tabs ){

		if ( um_user('activity_wall_off') )
			unset( $tabs['activity'] );

		return $tabs;
	}

	/***
	***	@get comment content
	***/
	function commentcontent( $content ) {
		$content = convert_smilies( $content );
		$content = preg_replace('$(\s|^)(https?://[a-z0-9_./?=&-]+)(?![^<>]*>)$i', ' <a class="um-link" href="$2" target="_blank" rel="nofollow">$2</a> ', $content." ");
		$content = preg_replace('$(\s|^)(www\.[a-z0-9_./?=&-]+)(?![^<>]*>)$i', '<a class="um-link" target="_blank" href="http://$2"  target="_blank" rel="nofollow">$2</a> ', $content." ");
		$content = $this->hashtag_links( $content );
		return $content;
	}

	/***
	***	@shorten any string based on word count
	***/
	function shorten_string($string){
		$retval = $string;
		$wordsreturned = um_get_option('activity_post_truncate');
		if ( !$wordsreturned ) return $string;
		$array = explode(" ", $string);
		if (count($array)<=$wordsreturned){
			$retval = $string;
		} else {
			$res = array_splice($array, $wordsreturned);
			$retval = implode(" ", $array)." <span class='um-activity-seemore'>(<a href='' class='um-link'>" . __('See more','um-activity') . "</a>)</span>" . " <span class='um-activity-hiddentext'>" . implode(" ", $res ) . "</span>";
		}
		return $retval;
	}

	/***
	***	@can edit a user comment
	***/
	function can_edit_comment( $comment_id, $user_id ) {
		if ( ! $user_id )
			return false;
		$comment = get_comment( $comment_id );
		if ( $comment->user_id == $user_id )
			return true;
		return false;
	}

	/***
	***	@get a summarized content length
	***/
	function get_content( $post_id = 0 ) {
		global $post;

		if ( $post_id ) {
			$post = get_post($post_id);
			$content = $post->post_content;
		} else {
			$post_id = get_the_ID();
			$content = get_the_content();
		}

		$has_attached_photo = get_post_meta( $post_id, '_photo',true);

		if( empty( $has_attached_photo  ) ){
			$oembed = wp_oembed_get( trim( $content ) );
			if ( $oembed ) {
				return $oembed;
			}
		}

		$content = $this->setup_video( $content, $post_id );

		if ( trim( $content ) != '' ) {
			if ( $this->get_action_type( $post_id ) == 'status' ) {
				$content = $this->shorten_string( $content );
			}
			$content = convert_smilies( $content );
			$content = preg_replace('$(\s|^)(https?://[a-z0-9_./?=&-]+)(?![^<>]*>)$i', ' <a class="um-link" href="$2" target="_blank" rel="nofollow">$2</a> ', $content." ");
			$content = preg_replace('$(\s|^)(www\.[a-z0-9_./?=&-]+)(?![^<>]*>)$i', '<a class="um-link" target="_blank" href="http://$2"  target="_blank" rel="nofollow">$2</a> ', $content." ");
			$content = trim ( $content );
			$content = $this->hashtag_links( $content );

			// strip avatars
			if( preg_match( '/\<img src=\"([^\"]+)\" class="(gr)?avatar/', $content, $matches ) )
			{
				$src = $matches[1];
				$found = @getimagesize( $src );
				if( !$found )
				{
					$content = str_replace( $src, um_get_default_avatar_uri(), $content );
				}
			}

			return nl2br( $content );
		}

		return '';
	}

	/***
	***	@Get content link
	***/
	function get_content_link( $content ) {
		preg_match_all('/https?\:\/\/[^\"\s]+/i', $content, $matches);
		if ( isset( $matches[0] ) ) {
			foreach( $matches[0] as $key => $url ) {
				$parse = parse_url($url);
				if ( !strstr( $url, 'vimeo' ) && !strstr( $url, 'youtube' ) && !strstr( $url, 'vimeo' ) && !strstr( $url, 'youtu.be' ) ) {
					$oembed = wp_oembed_get( $url );
					if ( !$oembed ) {
						return $url;
					}
				}
			}
		}
		return null;
	}

	/***
	***	@Set url meta
	***/
	function set_url_meta( $url, $post_id ) {

		$request = wp_remote_get( $url );
		$response = wp_remote_retrieve_body( $request );

		$html = new DOMDocument();
		@$html->loadHTML(mb_convert_encoding($response, 'HTML-ENTITIES', 'UTF-8'));
		$tags = null;

		$title = $html->getElementsByTagName('title');
		$tags['title'] = $title->item(0)->nodeValue;

		foreach($html->getElementsByTagName('meta') as $meta) {
			if($meta->getAttribute('property')=='og:image'){
				$src = trim( str_replace('\\','/', $meta->getAttribute('content') ) );
				$data = $this->is_image( $src );
				if (  is_array( $data ) ) {
					$tags['image'] = $src;
					$tags['image_width'] = $data[0];
					$tags['image_height'] = $data[1];
				}
			}
			if($meta->getAttribute('name')=='description'){
				$tags['description'] = trim( str_replace('\\','/', $meta->getAttribute('content') ) );
			}
		}

		if ( !isset( $tags['image'] ) ) {
			$stop = false;
			foreach( $html->getElementsByTagName('img') as $img ) {
				if ( $stop == true ) continue;
				$src = trim( str_replace('\\','/', $img->getAttribute('src') ) );
				$data = $this->is_image( $src );
				if (  is_array( $data ) ) {
					$tags['image'] = $src;
					$tags['image_width'] = $data[0];
					$tags['image_height'] = $data[1];
					$stop = true;
				}
			}
		}

		/* Display the meta now */

		if ( isset( $tags['image_width'] ) && $tags['image_width'] <= 400 ) {
			$content = '<span class="post-meta" style="position:relative;min-height: ' . ( absint( $tags['image_height']/2 ) - 10 ) . 'px;padding-left:' . $tags['image_width']/2 . 'px;"><a href="{post_url}" target="_blank">{post_image} {post_title} {post_excerpt} {post_domain}</a></span>';
		} else {
			$content = '<span class="post-meta"><a href="{post_url}" target="_blank">{post_image} {post_title} {post_excerpt} {post_domain}</a></span>';
		}

		if ( isset( $tags['description'] ) ) {
			if ( isset( $tags['image_width'] ) && $tags['image_width'] <= 400 ) {
				$content = str_replace('{post_excerpt}', '', $content );
			} else {
				$content = str_replace('{post_excerpt}', '<span class="post-excerpt">' . $tags['description'] . '</span>', $content );
			}
		} else {
			$content = str_replace('{post_excerpt}', '', $content );
		}

		if ( isset( $tags['title'] ) ) {
			$content = str_replace('{post_title}', '<span class="post-title">' . mb_convert_encoding( $tags['title'], 'HTML-ENTITIES', 'UTF-8') . '</span>', $content );
		} else {
			$content = str_replace('{post_title}', '<span class="post-title">' . __('Untitled','um-activity') . '</span>', $content );
		}

		if ( isset( $tags['image'] ) ) {
			if ( isset( $tags['image_width'] ) && $tags['image_width'] <= 400 ) {
				$content = str_replace('{post_image}', '<span class="post-image" style="position:absolute;left:0;top:0;width:' . $tags['image_width']/2  . 'px;"><img src="'. $tags['image'] . '" alt="" title="" class="um-activity-featured-img" /></span>', $content );
			} else {
				$content = str_replace('{post_image}', '<span class="post-image"><img src="'. $tags['image'] . '" alt="" title="" class="um-activity-featured-img" /></span>', $content );
			}
		} else {
			$content = str_replace('{post_image}', '', $content );
		}

		$parse = parse_url($url);

		$content = str_replace('{post_url}', $url, $content );

		$content = str_replace('{post_domain}', '<span class="post-domain">'. strtoupper( $parse['host'] ) .'</span>', $content );
		

		update_post_meta( $post_id, '_shared_link', trim( $content ) );

		return trim( $content );

	}

	/***
	***	@Checks if image is valid
	***/
	function is_image($url) {
		$size = @getimagesize( $url );
		if ( isset( $size['mime'] ) && strstr( $size['mime'], 'image' ) && !strstr( $size['mime'], 'gif') && !strstr( $size['mime'], 'png') && isset( $size[0] ) && absint( $size[0] ) > 100 && isset( $size[1] ) && ( $size[0] / $size[1] >= 1 )  && ( $size[0] / $size[1] <= 3 ) )
			return $size;
		return 0;
	}

	/***
	***	@convert hashtags
	***/
	function hashtag_links( $content ) {
		preg_match_all('/(?<!\&)#([^\s]+)/', $content, $matches);
		if ( isset( $matches[1] ) && is_array( $matches[1] ) ) {
			foreach( $matches[1] as $match ) {
				$link = '<a href="' . add_query_arg( 'hashtag', $match, um_get_core_page('activity') ) . '" class="um-link">#'. $match . '</a>';
				$content = str_replace( '#' . $match, $link, $content);
			}
		}
		return $content;
	}

	/***
	***	@add hashtags
	***/
	function hashtagit( $post_id, $content, $append = false ) {
		preg_match_all('/(?<!\&)#([^\s]+)/', $content, $matches);
		if ( isset( $matches[1] ) && is_array( $matches[1] ) ) {
			wp_set_post_terms( $post_id, $matches[1], 'um_hashtag', $append );
		}
	}

	/***
	***	@get a possible photo
	***/
	function get_photo( $post_id = 0, $class='' ) {
		$uri = get_post_meta( $post_id, '_photo', true );
		if ( !$uri )
			return '';
		if ( $class == 'backend') {
			$content = '<a href="'. $uri . '" target="_blank"><img src="'. $uri . '" alt="" /></a>';
		} else {
			$content = '<a href="#" class="um-photo-modal" data-src="'.$uri.'"><img src="'. $uri . '" alt="" /></a>';
		}
		return $content;
	}

	/***
	***	@get a possible video
	***/
	function get_video( $post_id = 0, $args = array() ) {
		$uri = get_post_meta( $post_id, '_video_url', true );
		if(!$uri)
			return '';
		$content = wp_oembed_get( $uri, $args );
		return $content;
	}

	/***
	***	@strip video URLs as we need to convert them
	***/
	function setup_video( $content, $post_id ) {
		preg_match_all("#(https?://vimeo.com)/([0-9]+)#i", $content, $matches1);
		preg_match_all('/https?:\/\/(?:www\.)?youtu(?:\.be|be\.com)\/watch(?:\?(.*?)&|\?)v=([a-zA-Z0-9_\-]+)(\S*)/i',$content,$matches2);
		if ( isset( $matches1 ) && isset( $matches1[0] ) ) { foreach( $matches1[0] as $key => $val ) { $videos[] = trim( $val ); } }
		if ( isset( $matches2[0] ) ) { foreach( $matches2[0] as $key => $val ) { $videos[] = trim( $val ); } }
		if ( isset( $videos ) ) {
			$content = str_replace( $videos[0], '', $content );
			update_post_meta( $post_id, '_video_url', $videos[0] );
		} else {
			delete_post_meta( $post_id, '_video_url' );
		}
		return $content;
	}

	/***
	***	@can post on that wall
	***/
	function can_write() {
		$res = 1;

		if ( um_user_can('activity_posts_off') )
			$res = 0;

		if ( !is_user_logged_in() )
			$res = 0;

		$res = apply_filters('um_activity_can_post_on_wall', $res );
		return $res;
	}

	/***
	***	@can comment on wall
	***/
	function can_comment() {
		$res = 1;

		if ( um_user_can('activity_comments_off') )
			$res = 0;

		if ( !is_user_logged_in() )
			$res = 0;

		$res = apply_filters('um_activity_can_post_comment_on_wall', $res );
		return $res;
	}

	/***
	***	@show wall
	***/
	function show_wall() {

		$can_view = apply_filters('um_wall_can_view', -1, um_profile_id() );
		if ( $can_view == -1 ) {

			echo do_shortcode('[ultimatemember_wall user_id='.um_profile_id().']');

		} else {

			echo '<div class="um-profile-note"><span><i class="um-faicon-lock"></i>' . $can_view . '</span></div>';

		}
	}

	/***
	***	@cice time difference
	***/
	function human_time_diff( $from, $to = '' ) {
		if ( empty( $to ) ) {
			$to = time();
		}
		$diff = (int) abs( $to - $from );
		if ( $diff < 60 ) {

			$since = __('Just now','um-activity');

		} elseif ( $diff < HOUR_IN_SECONDS ) {

			$mins = round( $diff / MINUTE_IN_SECONDS );
			if ( $mins <= 1 )
				$mins = 1;
			if ( $mins == 1 ) {
				$since = sprintf( __('%s min','um-activity'), $mins );
			} else {
				$since = sprintf( __('%s mins','um-activity'), $mins );
			}

		} elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {

			$hours = round( $diff / HOUR_IN_SECONDS );
			if ( $hours <= 1 )
				$hours = 1;
			if ( $hours == 1 ) {
				$since = sprintf( __('%s hr','um-activity'), $hours );
			} else {
				$since = sprintf( __('%s hrs','um-activity'), $hours );
			}

		} elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {

			$days = round( $diff / DAY_IN_SECONDS );
			if ( $days <= 1 )
				$days = 1;
			if ( $days == 1 ) {
				$since = sprintf( __('Yesterday at %s','um-activity'), date('g:ia', $from ) );
			} else {
				$since = sprintf(__('%s at %s','um-activity'), date('F d', $from ), date('g:ia', $from ) );
			}

		} elseif ( $diff < 30 * DAY_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {

			$since = sprintf(__('%s at %s','um-activity'), date('F d', $from ), date('g:ia', $from ) );

		} elseif ( $diff < YEAR_IN_SECONDS && $diff >= 30 * DAY_IN_SECONDS ) {

			$since = sprintf(__('%s at %s','um-activity'), date('F d', $from ), date('g:ia', $from ) );

		} elseif ( $diff >= YEAR_IN_SECONDS ) {

			$since = sprintf(__('%s at %s','um-activity'), date( 'F d, Y', $from ), date('g:ia', $from ) );

		}

		return apply_filters( 'um_activity_human_time_diff', $since, $diff, $from, $to );
	}

	/***
	***	@Get faces of people who liked
	***/
	function get_faces( $post_id, $num = 10 ) {
		global $ultimatemember;
		$res = '';
		$users = get_post_meta( $post_id, '_liked', true );
		if ( $users && is_array( $users ) ) {
			$users = array_reverse( $users );
			$users = array_slice( $users, 0, $num );
			foreach( $users as $user_id ) {
				if ( absint( $user_id ) && $user_id ) {
					$res .= get_avatar( $user_id, 34 );
				}
			}
		}
		return '<a href="#" data-post_id="'.$post_id.'" class="um-activity-show-likes um-tip-s" title="'. __('People who like this','um-activity') . '" data-post_id="'. $post_id .'">' . $res . '</a>';
	}

	/***
	***	@Hide a comment for user
	***/
	function user_hide_comment( $comment_id ) {
		$users = get_comment_meta( $comment_id, '_hidden_from', true );
		$users[ get_current_user_id() ] = current_time('timestamp');
		update_comment_meta( $comment_id, '_hidden_from', $users );
	}

	/***
	***	@Unhide a comment for user
	***/
	function user_unhide_comment( $comment_id ) {
		$users = get_comment_meta( $comment_id, '_hidden_from', true );
		if ( isset( $users[ get_current_user_id() ] ) ) {
			unset( $users[ get_current_user_id() ] );
		}
		if ( !$users ) {
			delete_comment_meta( $comment_id, '_hidden_from' );
		} else {
			update_comment_meta( $comment_id, '_hidden_from', $users );
		}
	}

	/***
	***	@Checks if user hidden comment
	***/
	function user_hidden_comment( $comment_id ) {
		$users = get_comment_meta( $comment_id, '_hidden_from', true );
		if ( $users && is_array( $users ) && isset( $users[ get_current_user_id() ] ) )
			return 1;
		return 0;
	}

	/***
	***	@Checks if user liked specific wall comment
	***/
	function user_liked_comment( $comment_id ) {
		$res = '';
		$users = get_comment_meta( $comment_id, '_liked', true );
		if ( $users && is_array( $users ) && in_array( get_current_user_id(), $users ) )
			return true;
		return false;
	}

	/***
	***	@Checks if user liked specific wall post
	***/
	function user_liked( $post_id ) {
		$res = '';
		$users = get_post_meta( $post_id, '_liked', true );
		if ( $users && is_array( $users ) && in_array( get_current_user_id(), $users ) )
			return true;
		return false;
	}

	/***
	***	@Checks if post is reported
	***/
	function reported( $post_id ) {
		$reported = get_post_meta( $post_id, '_reported', true );
		return ( $reported ) ? 1 : 0;
	}

	/***
	***	@Gets action name
	***/
	function get_action( $post_id ) {
		$action = (string)get_post_meta( $post_id, '_action', true );
		$action = ( $action ) ? $action : 'status';
		return $this->global_actions[$action];
	}

	/***
	***	@Gets action type
	***/
	function get_action_type( $post_id ) {
		$action = (string)get_post_meta( $post_id, '_action', true );
		$action = ( $action ) ? $action : 'status';
		return $action;
	}

	/***
	***	@Get comment time
	***/
	function get_comment_time( $time ) {
		$timestamp = strtotime( $time );
		$time = $this->human_time_diff( $timestamp, current_time('timestamp') );
		return $time;
	}

	/***
	***	@Get comment link
	***/
	function get_comment_link( $post_link, $comment_id ) {
		$link = add_query_arg( 'wall_comment_id', $comment_id, $post_link );
		return $link;
	}

	/***
	***	@Gets activity in nice time format
	***/
	function get_post_time( $post_id ) {
		$time = $this->human_time_diff( get_the_time('U', $post_id ), current_time('timestamp') );
		return $time;
	}

	/***
	***	@Gets post permalink
	***/
	function get_permalink( $post_id ) {
		global $ultimatemember;
		return add_query_arg( 'wall_post', $post_id, get_permalink( $ultimatemember->permalinks->core['activity'] ) );
	}

	/***
	***	@Gets post author
	***/
	function get_author( $post_id ) {
		$author = (int)get_post_meta( $post_id, '_user_id', true );
		return ( $author ) ? $author : 0;
	}

	/***
	***	@Gets post wall ID
	***/
	function get_wall( $post_id ) {
		$wall = (int)get_post_meta( $post_id, '_wall_id', true );
		return ( $wall ) ? $wall : 0;
	}

	/***
	***	@Get likes count
	***/

	function get_likes_number( $post_id ) {
		return (int)get_post_meta( $post_id, '_likes', true );
	}

	/***
	***	@Get comment count
	***/
	function get_comments_number( $post_id ) {
		$comments_all = get_comments( array( 'post_id' => $post_id, 'parent' => 0, 'number' => 10000, 'offset' => 0 ) );
		return count( $comments_all );
	}

}
