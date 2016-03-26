<?php

	/***
	***	@send notification for future messages
	***/
	add_action('um_after_existing_conversation','um_messaging_user_got_message', 20, 3 );
	function um_messaging_user_got_message( $to, $from, $conversation_id ) {
		global $ultimatemember, $um_messaging;

		if ( !$um_messaging->api->enabled_email( $to ) ) return false;

		$get_ts = um_user_last_login_timestamp( $to );
		if ( $get_ts > 0 ) {
			if ( ( current_time('timestamp') - $get_ts ) <= um_get_option('pm_notify_period') ) {
				return false;
			}
		}

		// send a mail notification
		um_fetch_user( $to );
		$recipient_e = um_user('user_email');
		$recipient = um_user('display_name');
		$message_history = add_query_arg('profiletab', 'messages', um_user_profile_url() );

		// who sends the message
		um_fetch_user( $from );
		$sender = um_user('display_name');

		$ultimatemember->mail->send( $recipient_e, 'new_message', array(

					'plain_text' => 1,
					'path' => um_messaging_path . 'templates/email/',
					'tags' => array(
						'{recipient}',
						'{message_history}',
						'{sender}'
					),
					'tags_replace' => array(
						$recipient,
						$message_history,
						$sender
					)

		) );

	}

	/***
	***	@Send a mail notification
	***/
	add_action('um_after_new_conversation','um_messaging_mail_notification', 20, 3 );
	function um_messaging_mail_notification( $to, $from, $conversation_id ) {
		global $ultimatemember, $um_messaging;

		if ( !$um_messaging->api->enabled_email( $to ) ) return false;

		// send a mail notification
		um_fetch_user( $to );
		$recipient_e = um_user('user_email');
		$recipient = um_user('display_name');
		$message_history = add_query_arg('profiletab', 'messages', um_user_profile_url() );

		// who sends the message
		um_fetch_user( $from );
		$sender = um_user('display_name');

		$ultimatemember->mail->send( $recipient_e, 'new_message', array(

					'plain_text' => 1,
					'path' => um_messaging_path . 'templates/email/',
					'tags' => array(
						'{recipient}',
						'{message_history}',
						'{sender}'
					),
					'tags_replace' => array(
						$recipient,
						$message_history,
						$sender
					)

		) );

	}

	/***
	***	@Send a web notification
	***/
	add_action('um_after_new_message','um_messaging_web_notification', 50, 3 );
	function um_messaging_web_notification( $to, $from, $conversation_id ) {
		if ( !defined('um_notifications_version') ) return false;
		global $um_notifications;

		um_fetch_user( $from );

		$vars['photo'] = um_get_avatar_url( get_avatar( $from, 40 ) );
		$vars['member'] = um_user('display_name');

		um_fetch_user( $to );

		$vars['notification_uri'] = add_query_arg( 'profiletab', 'messages', um_user_profile_url() );

		$um_notifications->api->store_notification( $to, 'new_pm', $vars );

	}
