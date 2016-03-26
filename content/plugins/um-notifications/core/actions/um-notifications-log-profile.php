<?php

	add_action('um_before_profile_fields', 'um_notification_log_view', 100);
	function um_notification_log_view( $args ) {
		global $um_notifications;
		
		if ( is_user_logged_in() && get_current_user_id() != um_profile_id() ) {
			
			um_fetch_user( get_current_user_id() );
			
			$vars['photo'] = um_get_avatar_url( get_avatar( get_current_user_id(), 40 ) );
			
			$vars['member'] = um_user('display_name');
			
			$vars['notification_uri'] = um_user_profile_url();
			
			um_fetch_user( um_profile_id() );
			
			$um_notifications->api->store_notification( um_profile_id(), 'profile_view', $vars );
		
		}

		if ( !is_user_logged_in() ) {
			
			$vars['photo'] = um_get_avatar_url( get_avatar( '123456789', 40 ) );
			
			um_fetch_user( um_profile_id() );
			
			$um_notifications->api->store_notification( um_profile_id(), 'profile_view_guest', $vars );
			
		}

	}