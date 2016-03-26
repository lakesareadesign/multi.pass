<?php

	add_action('bbp_new_reply', 'um_notification_log_bbpress_reply', 1000, 7);
	function um_notification_log_bbpress_reply( $reply_id = 0, $topic_id = 0, $forum_id = 0, $anonymous_data = array(), $reply_author_id = 0, $bool = 0, $reply_to = 0 ) {
		global $um_notifications;
		
		$vars = array();
		$user_id = bbp_get_topic_author_id( $topic_id );
		
		if ( $reply_author_id == $user_id ) return; // Notify himself? no.
		
		// Not a guest
		if ( $reply_author_id ) {
			
			um_fetch_user( $reply_author_id );
			$vars['photo'] = um_get_avatar_url( get_avatar( $reply_author_id, 40 ) );
			$vars['member'] = um_user('display_name');
			
			$user = 'user';
			
		} else {	
			$user = 'guest';
		}
		
		$vars['notification_uri'] = bbp_get_reply_url( $reply_id );
		
		$um_notifications->api->store_notification( $user_id, "bbpress_{$user}_reply", $vars );
		
	}