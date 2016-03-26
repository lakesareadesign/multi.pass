<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_followers_config', 26 );
	function um_followers_config($sections){
		global $um_followers;
	
		$fields[] = array(
			'id'       		=> 'followers_show_stats',
			'type'     		=> 'switch',
			'title'   		=> __('Show followers stats in member directory','um-notifications'),
			'default' 		=> 1,
		);

		$fields[] = array(
			'id'       		=> 'followers_show_button',
			'type'     		=> 'switch',
			'title'   		=> __('Show follow button in member directory','um-notifications'),
			'default' 		=> 1,
		);
		
		$fields[] = array(
			'id'       		=> 'new_follower_on',
			'type'     		=> 'switch',
			'title'    		=> __( 'New Follower Notification','um-followers' ),
			'default'  		=> 1,
			'desc' 	   		=> __('Send a notification to user when he receives a new review','um-followers'),
		);
				
		$fields[] = array(
			'id'       		=> 'new_follower_sub',
			'type'     		=> 'text',
			'title'   		=> __( 'New Follower Notification','um-followers' ),
			'subtitle' 		=> __( 'Subject Line','um-followers' ),
			'default'  		=> '{follower} is now following you on {site_name}!',
			'required' 		=> array( 'new_follower_on', '=', 1 ),
			'desc' 	   		=> __('This is the subject line of the e-mail','um-followers'),
		);

		$fields[] = array(
			'id'       		=> 'new_follower',
			'type'     		=> 'textarea',
			'title'    		=> __( 'New Follower Notification','um-followers' ),
			'subtitle' 		=> __( 'Message Body','um-followers' ),
			'required' 		=> array( 'new_follower_on', '=', 1 ),
			'default'  		=> 'Hi {followed},' . "\r\n\r\n" .
								'{follower} has just followed you on {site_name}.' . "\r\n\r\n" .
								'View his/her profile:'  . "\r\n" .
								'{follower_profile}'  . "\r\n\r\n" .
								'Click on the following link to see your followers:'  . "\r\n" .
								'{followers_url}'  . "\r\n\r\n" .
								'This is an automated notification from {site_name}. You do not need to reply.',
		);
		
		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'Followers','um-followers'),
			'fields'     => $fields

		);

		return $sections;
		
	}
	
	/***
	***	@Adds a notification type
	***/
	add_filter('um_notifications_core_log_types', 'um_followers_add_notification_type', 200 );
	function um_followers_add_notification_type( $array ) {
		
		$array['new_follow'] = array(
			'title' => __('User get followed by a person','um-followers'),
			'template' => '<strong>{member}</strong> has just followed you!',
			'account_desc' => __('When someone follows me','um-followers'),
		);
		
		return $array;
	}
	
	/***
	***	@Adds a notification icon
	***/
	add_filter('um_notifications_get_icon', 'um_followers_add_notification_icon', 10, 2 );
	function um_followers_add_notification_icon( $output, $type ) {
		if ( $type == 'new_follow' ) {
			$output = '<i class="um-icon-android-person-add" style="color: #44b0ec"></i>';
		}
		return $output;
	}