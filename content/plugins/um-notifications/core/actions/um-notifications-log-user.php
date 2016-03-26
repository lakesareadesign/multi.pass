<?php

	add_action('um_member_role_upgrade', 'um_notification_log_role_chnage', 10, 2);
	function um_notification_log_role_chnage( $new_role, $old_role ) {
		global $ultimatemember, $um_notifications;
		
		if ( $new_role == $old_role ) return; // role not updated

		$vars['photo'] = um_get_avatar_url( get_avatar( um_user('ID'), 40 ) );
		$vars['notification_uri'] = um_user_profile_url();
		
		$vars['role_pre'] = $ultimatemember->user->get_role_name( $old_role );
		
		$vars['role_post'] =  $ultimatemember->user->get_role_name( $new_role );

		$um_notifications->api->store_notification( um_user('ID'), 'upgrade_role', $vars );

	}