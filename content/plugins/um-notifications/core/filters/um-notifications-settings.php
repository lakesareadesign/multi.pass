<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_notifications_config', 30 );
	function um_notifications_config($sections){
		global $um_notifications;

			$fields[] = array(
						'id'       		=> 'realtime_notify',
						'type'     		=> 'switch',
						'title'   		=> __('Enable real-time instant notification','um-notifications'),
						'desc'			=> __('Turn off please If your server is getting some load.','um-notifications'),
						'default' 		=> 1,
			);
			
			$fields[] = array(
						'id'       		=> 'notify_pos',
						'type'     		=> 'select',
						'select2'		=> array( 'allowClear' => 0, 'minimumResultsForSearch' => -1 ),
						'title'    		=> __( 'Where should the notification icon appear?','um-notifications' ),
						'default'  		=> 'right',
						'options' 		=> array(
											'right' 			=> __('Right bottom','um-notifications'),
											'left' 			=> __('Left bottom','um-notifications')
						),
						'placeholder' 	=> __('Select...','um-notifications'),
						'required'		=> array( 'realtime_notify', '=', 1 )
			);
			
			$fields[] = array(
						'id'       		=> 'realtime_notify_timer',
						'type'     		=> 'text',
						'title'   		=> __('How often do you want the ajax notifier to check for new notifications? (in seconds)','um-notifications'),
						'validate' 		=> 'numeric',
						'default' 		=> 45,
						'required'		=> array( 'realtime_notify', '=', 1 ),
			);

			$fields[] = array(
						'id'       		=> 'notification_icon_visibility',
						'type'     		=> 'switch',
						'title'   		=> __('Always display the notification icon','um-notifications'),
						'desc'			=> __('If turned off, the icon will only show when there\'s a new notification.','um-notifications'),
						'default' 		=> 1,
			);
			
			$fields[] = array(
						'id'       		=> 'account_tab_webnotifications',
						'type'     		=> 'switch',
						'title'   		=> __( 'Account Tab','um-notifications' ),
						'default' 		=> 1,
						'desc' 	   		=> __('Show or hide an account tab that shows the web notifications.','um-notifications'),
						'on'			=> __('On','um-notifications'),
						'off'			=> __('Off','um-notifications'),
			);
			
		foreach( $um_notifications->api->get_log_types() as $k => $desc ) {

			$fields[] = array(
						'id'       		=> 'log_' . $k,
						'type'     		=> 'switch',
						'title'   		=> $desc['title'],
						'default' 		=> 1,
			);

			$fields[] = array(
						'id'       		=> 'log_' . $k . '_template',
						'type'     		=> 'textarea',
						'title'   		=> __( 'Template','um-notifications' ),
						'required'		=> array('log_' . $k, '=', 1),
						'default'		=> $desc['template'],
						'rows'			=> 2
			);

		}



		
		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'Notifications','um-notifications'),
			'fields'     => $fields

		);

		return $sections;
		
	}