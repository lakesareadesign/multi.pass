<?php

	/***
	***	@log core myCRED actions
	***/
	add_filter('mycred_run_this', 'um_notification_mycred_default_log', 100, 2);
	function um_notification_mycred_default_log( $array, $mycred ) {
		global $um_notifications;
		
		if ( um_user('ID') ) {
			$global_user = um_user('ID');
		}

		$user_id = $array['user_id'];

		$vars['photo'] = um_get_avatar_url( get_avatar( $user_id, 40 ) );
		$vars['mycred_points'] = ( $array['amount'] == 1 ) ? sprintf(__('%s point','um-notifications'), $array['amount'] ) : sprintf(__('%s points','um-notifications'), $array['amount'] );
		$vars['mycred_task'] = preg_replace("/%[^%]*%/","",$array['entry']);

		$um_notifications->api->store_notification( $user_id, 'mycred_award', $vars );

		um_reset_user();
		
		if ( isset( $global_user ) )
			um_fetch_user( $global_user );
		
		return $array;
		
	}
	
	/***
	***	@log UM balance transfer
	***/
	add_action('um_mycred_credit_balance_transfer', 'um_notification_log_mycred_points_sent', 10, 3 );
	function um_notification_log_mycred_points_sent( $to, $amount, $from ) {
		global $um_notifications;
		
		remove_filter('mycred_run_this', 'um_notification_mycred_default_log', 100, 2);
		
		$vars = array();
		$vars['photo'] = um_get_avatar_url( get_avatar( $to, 40 ) );
		$vars['mycred_points'] = sprintf( __('%s points','um-notifications'), $amount );

		$sender = get_userdata( $from );
		$vars['mycred_sender'] = $sender->display_name;

		$um_notifications->api->store_notification( $to, 'mycred_points_sent', $vars );
		
	}
	
	/***
	***	@log UM balance action
	***/
	add_action('um_mycred_credit_balance_user', 'um_notification_log_mycred_credit', 10, 3);
	function um_notification_log_mycred_credit( $user_id, $amount, $action ) {
		global $um_notifications;
		
		remove_filter('mycred_run_this', 'um_notification_mycred_default_log', 100, 2);
		
		$vars = array();
		$vars['photo'] = um_get_avatar_url( get_avatar( $user_id, 40 ) );
		$vars['mycred_points'] = sprintf( __('%s points','um-notifications'), $amount );

		switch ( $action ) {
			case 'mycred_login': $action = __('logging into site','um-notifications'); break;
			case 'mycred_register': $action = __('completing your registration','um-notifications'); break;
			case 'mycred_editprofile': $action = __('updating your profile','um-notifications'); break;
			case 'mycred_photo': $action = __('adding a profile photo','um-notifications'); break;
			case 'mycred_cover': $action = __('adding a cover photo','um-notifications'); break;
		}
		
		$vars['mycred_task'] = $action;
		
		$um_notifications->api->store_notification( $user_id, 'mycred_award', $vars );

	}