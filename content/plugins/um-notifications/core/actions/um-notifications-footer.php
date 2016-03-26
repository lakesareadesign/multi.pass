<?php

	add_action('wp_footer', 'um_notification_show_feed', 99999999999);
	function um_notification_show_feed() {
		global $ultimatemember, $um_notifications;

		if ( !is_user_logged_in() ) return;

		$notifications = $um_notifications->api->get_notifications( 10 );
		if ( !$notifications ) {
			$template = 'no-notifications';
		} else {
			$template = 'notifications';
		}
		
		$unread = (int)$um_notifications->api->get_notifications( 0, 'unread', true );
		
		$unread_count = ( absint( $unread ) > 9 ) ? '+9' : $unread;

		echo '<div data-show-always="'.um_get_option('notification_icon_visibility').'" class="um-notification-b '. um_get_option('notify_pos') . '">';
		echo '<i class="um-icon-ios-bell"></i>';
		echo '<span class="um-notification-live-count count-'. $unread . '">'. $unread_count .'</span>';
		echo '</div>';

		echo '<div class="um-notification-live-feed"><div class="um-notification-live-feed-inner">';

			include um_notifications_path . 'templates/'. $template . '.php';

		echo '</div></div>';
		
	}