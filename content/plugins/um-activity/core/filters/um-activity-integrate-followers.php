<?php

	/***
	***	@Works on inserting/updating wall posts
	***/
	add_filter('um_activity_insert_post_content_filter', 'um_activity_mention_followers', 99, 4 );
	add_filter('um_activity_update_post_content_filter', 'um_activity_mention_followers', 99, 4 );
	function um_activity_mention_followers( $content, $user_id, $post_id, $status ){
		if ( !class_exists('UM_Followers_API') )
			return $content;
		
		if ( !um_get_option('activity_followers_mention') )
			return $content;
		
		global $um_followers, $um_activity, $um_notifications;
		
		$mentioned_in_post = get_post_meta( $post_id, '_mentioned', true );
		
		$following = $um_followers->api->following( $user_id );
		if ( $following ) {
			foreach( $following as $k => $arr ) {
				extract( $arr );
				um_fetch_user( $user_id1 );
				
				if ( !stristr( $content, um_user('display_name') ) ) continue;
				
				if ( $mentioned_in_post && in_array( $user_id1, $mentioned_in_post ) ) {
					$user_mentioned_in_post = true;
				} else {
					$user_mentioned_in_post = false;
				}
				
				$user_link = '<a href="' . um_user_profile_url() . '" class="um-link um-user-tag">' . um_user('display_name') . '</a>';
				$content = str_ireplace( '@' . um_user('display_name'), $user_link, $content );
				
				if ( defined('um_notifications_version') && $user_mentioned_in_post == false ) {
					um_fetch_user( $user_id );
					$vars['photo'] = um_get_avatar_url( get_avatar( $user_id, 40 ) );
					$vars['member'] = um_user('display_name');
					$vars['notification_uri'] = $um_activity->api->get_permalink( $post_id );
					$um_notifications->api->store_notification( $user_id1, 'new_mention', $vars );
					$mention[] = $user_id1;
				}
					
			}
		}
		
		$followers = $um_followers->api->followers( $user_id );
		if ( $followers ) {
			foreach( $followers as $k => $arr ) {
				extract( $arr );
				um_fetch_user( $user_id2 );

				if ( !stristr( $content, um_user('display_name') ) ) continue;
				
				if ( $mentioned_in_post && in_array( $user_id2, $mentioned_in_post ) ) {
					$user_mentioned_in_post = true;
				} else {
					$user_mentioned_in_post = false;
				}
				
				$user_link = '<a href="' . um_user_profile_url() . '" class="um-link um-user-tag">' . um_user('display_name') . '</a>';
				$content = str_ireplace( '@' .um_user('display_name'), $user_link, $content );
				
				if ( defined('um_notifications_version') && $user_mentioned_in_post == false  ) {
					um_fetch_user( $user_id );
					$vars['photo'] = um_get_avatar_url( get_avatar( $user_id, 40 ) );
					$vars['member'] = um_user('display_name');
					$vars['notification_uri'] = $um_activity->api->get_permalink( $post_id );
					$um_notifications->api->store_notification( $user_id2, 'new_mention', $vars );
					$mention[] = $user_id2;
				}
				
			}
		}

		if ( isset( $mention ) ) {
			update_post_meta( $post_id, '_mentioned', $mention );
		}
		
		return $content;
	}