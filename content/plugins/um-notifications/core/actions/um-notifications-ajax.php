<?php

	/***
	***	@deletes a notification log
	***/
	add_action('wp_ajax_nopriv_um_notification_delete_log', 'um_notification_delete_log');
	add_action('wp_ajax_um_notification_delete_log', 'um_notification_delete_log');
	function um_notification_delete_log(){
		global $ultimatemember, $um_notifications;
		if ( !isset( $_POST['notification_id'] ) || !is_user_logged_in() ) die(0);
		$notification_id = $_POST['notification_id'];
		$um_notifications->api->delete_log( $notification_id );
		die(0);
	}
	
	/***
	***	@mark a notification as read
	***/
	add_action('wp_ajax_nopriv_um_notification_mark_as_read', 'um_notification_mark_as_read');
	add_action('wp_ajax_um_notification_mark_as_read', 'um_notification_mark_as_read');
	function um_notification_mark_as_read(){
		global $ultimatemember, $um_notifications;
		if ( !isset( $_POST['notification_id'] ) || !is_user_logged_in() ) die(0);
		$notification_id = $_POST['notification_id'];
		$um_notifications->api->set_as_read( $notification_id );
		die(0);
	}

	/***
	***	@checks for update
	***/
	add_action('wp_ajax_nopriv_um_notification_check_update', 'um_notification_check_update');
	add_action('wp_ajax_um_notification_check_update', 'um_notification_check_update');
	function um_notification_check_update(){
		global $ultimatemember, $um_notifications;
		extract($_POST);
		$output = '';
		
		$unread = $um_notifications->api->get_notifications( 0, 'unread', true );
		if ( $unread ) {

			$output['refresh_count'] = ( absint( $unread ) > 9 ) ? '+9' : $unread;

			$notifications = $um_notifications->api->get_notifications( 1, 'unread');
			
			if ( $notifications ) {
			foreach( $notifications as $notification ) {

				$output['unread'] = '<div class="um-notification ' . $notification->status . '" data-notification_id="' . $notification->id . '" data-notification_uri="'. $notification->url . '">'. '<img src="'. $notification->photo .'" alt="" class="um-notification-photo" />' . $notification->content;
				
				$output['unread'] .= '<span class="b2">' . $um_notifications->api->get_icon( $notification->type ) . $um_notifications->api->nice_time( $notification->time ) . '</span>';
				
				$output['unread'] .= '<span class="um-notification-hide"><a href="#"><i class="um-icon-android-close"></i></a></span></div>';

			 }
			}
			
		}

		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	
	}