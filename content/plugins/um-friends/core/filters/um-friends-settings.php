<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_friends_config', 26 );
	function um_friends_config($sections){
		global $um_friends;
	
		$fields[] = array(
			'id'       		=> 'friends_show_stats',
			'type'     		=> 'switch',
			'title'   		=> __('Show friends stats in member directory','um-notifications'),
			'default' 		=> 1,
		);

		$fields[] = array(
			'id'       		=> 'friends_show_button',
			'type'     		=> 'switch',
			'title'   		=> __('Show friend button in member directory','um-notifications'),
			'default' 		=> 1,
		);
		
		$fields[] = array(
			'id'       		=> 'new_friend_request_on',
			'type'     		=> 'switch',
			'title'    		=> __( 'New Friend Request Notification','um-friends' ),
			'default'  		=> 1,
			'desc' 	   		=> __('Send a notification to user when they receive a new friend request','um-friends'),
		);
				
		$fields[] = array(
			'id'       		=> 'new_friend_request_sub',
			'type'     		=> 'text',
			'title'   		=> __( 'New Friend Request Notification','um-friends' ),
			'subtitle' 		=> __( 'Subject Line','um-friends' ),
			'default'  		=> '{friend} wants to be friends with you on {site_name}',
			'required' 		=> array( 'new_friend_request_on', '=', 1 ),
			'desc' 	   		=> __('This is the subject line of the e-mail','um-friends'),
		);

		$fields[] = array(
			'id'       		=> 'new_friend_request',
			'type'     		=> 'textarea',
			'title'    		=> __( 'New Friend Request Notification','um-friends' ),
			'subtitle' 		=> __( 'Message Body','um-friends' ),
			'required' 		=> array( 'new_friend_request_on', '=', 1 ),
			'default'  		=> 'Hi {receiver},' . "\r\n\r\n" .
								'{friend} has just sent you a friend request on {site_name}.' . "\r\n\r\n" .
								'View their profile to accept/reject this friendship request:'  . "\r\n" .
								'{friend_profile}'  . "\r\n\r\n" .
								'This is an automated notification from {site_name}. You do not need to reply.',
		);
		
		$fields[] = array(
			'id'       		=> 'new_friend_on',
			'type'     		=> 'switch',
			'title'    		=> __( 'New Friend Notification','um-friends' ),
			'default'  		=> 1,
			'desc' 	   		=> __('Send a notification to user when a friend request get appproved','um-friends'),
		);
				
		$fields[] = array(
			'id'       		=> 'new_friend_sub',
			'type'     		=> 'text',
			'title'   		=> __( 'New Friend Notification','um-friends' ),
			'subtitle' 		=> __( 'Subject Line','um-friends' ),
			'default'  		=> '{friend} has accepted your friend request',
			'required' 		=> array( 'new_friend_on', '=', 1 ),
			'desc' 	   		=> __('This is the subject line of the e-mail','um-friends'),
		);

		$fields[] = array(
			'id'       		=> 'new_friend',
			'type'     		=> 'textarea',
			'title'    		=> __( 'New Friend Notification','um-friends' ),
			'subtitle' 		=> __( 'Message Body','um-friends' ),
			'required' 		=> array( 'new_friend_on', '=', 1 ),
			'default'  		=> 'Hi {receiver},' . "\r\n\r\n" .
								'You are now friends with {friend} on {site_name}.' . "\r\n\r\n" .
								'View their profile:'  . "\r\n" .
								'{friend_profile}'  . "\r\n\r\n" .
								'This is an automated notification from {site_name}. You do not need to reply.',
		);
		
		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'Friends','um-friends'),
			'fields'     => $fields

		);

		return $sections;
		
	}
	
	/***
	***	@Adds a notification type
	***/
	add_filter('um_notifications_core_log_types', 'um_friends_add_notification_type', 200 );
	function um_friends_add_notification_type( $array ) {
		
		$array['new_friend_request'] = array(
			'title' => __('User get a new friend request','um-friends'),
			'template' => '<strong>{member}</strong> has sent you a friendship request',
			'account_desc' => __('When someone requests friendship','um-friends'),
		);
		
		$array['new_friend'] = array(
			'title' => __('User get a new friend','um-friends'),
			'template' => '<strong>{member}</strong> has accepted your friendship request',
			'account_desc' => __('When someone accepts friendship','um-friends'),
		);
		
		return $array;
	}
	
	/***
	***	@Adds a notification icon
	***/
	add_filter('um_notifications_get_icon', 'um_friends_add_notification_icon', 10, 2 );
	function um_friends_add_notification_icon( $output, $type ) {
		if ( $type == 'new_friend_request' ) {
			$output = '<i class="um-icon-android-person-add" style="color: #44b0ec"></i>';
		}
		
		if ( $type == 'new_friend' ) {
			$output = '<i class="um-icon-android-person" style="color: #44b0ec"></i>';
		}
		return $output;
	}