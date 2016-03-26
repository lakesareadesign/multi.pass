<?php

	/***
	***	@Send a mail notification
	***/
	add_action('um_followers_after_user_follow','um_followers_mail_notification', 20, 2 );
	function um_followers_mail_notification( $user_id1, $user_id2 ) {
		global $ultimatemember, $um_followers;
		
		if ( !$um_followers->api->enabled_email( $user_id1 ) ) return false;
		
		// send a mail notification
		um_fetch_user( $user_id1 );
		$followed_email = um_user('user_email');
		$followed = um_user('display_name');
		$followers_url = add_query_arg('profiletab', 'followers', um_user_profile_url() );
	
		// follower
		um_fetch_user( $user_id2 );
		$follower = um_user('display_name');
		$follower_profile = um_user_profile_url();
				
		$ultimatemember->mail->send( $followed_email, 'new_follower', array(
				
					'plain_text' => 1,
					'path' => um_followers_path . 'templates/email/',
					'tags' => array(
						'{followed}',
						'{followers_url}',
						'{follower}',
						'{follower_profile}'
					),
					'tags_replace' => array(
						$followed,
						$followers_url,
						$follower,
						$follower_profile
					)
					
		) );
				
	}
				
	/***
	***	@Send a web notification
	***/
	add_action('um_followers_after_user_follow','um_followers_web_notification', 10, 2 );
	function um_followers_web_notification( $user_id1, $user_id2 ) {
		if ( !defined('um_notifications_version') ) return false;
		global $um_notifications;
		um_fetch_user( $user_id2 );
			
		$vars['photo'] = um_get_avatar_url( get_avatar( $user_id2, 40 ) );
		$vars['member'] = um_user('display_name');
		$vars['notification_uri'] = um_user_profile_url();
			
		um_fetch_user( $user_id1 );
		$um_notifications->api->store_notification( $user_id1, 'new_follow', $vars );

	}