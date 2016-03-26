<?php

	/***
	***	@Add bulk actions
	***/
	add_filter('um_admin_bulk_user_actions_hook', 'um_verified_extend_bulk_actions', 100 );
	function um_verified_extend_bulk_actions( $actions ){
		$actions['um_verify_accounts'] = array( 'label' => __('Mark accounts as verified','um-verified') );
		$actions['um_unverify_accounts'] = array( 'label' => __('Mark accounts as unverified','um-verified') );
		return $actions;
	}
	
	/***
	***	@adding default order on directory
	***/
	add_filter('um_modify_sortby_parameter', 'um_verified_sortby_', 100, 2);
	function um_verified_sortby_( $query_args, $sortby ) {
		if ( $sortby != 'verified_first' ) return $query_args;

		unset($query_args['orderby']);
		unset($query_args['order']);
		
		$query_args['meta_key'] = '_um_verified';
		$query_args['orderby'] = 'meta_value';
		$query_args['order'] = 'DESC';

		return $query_args;
	}
	
	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_verified_config', 88 );
	function um_verified_config($sections){
		global $um_verified;
	
		$fields[] = array(
			'id'       		=> 'verified_redirect',
			'type'     		=> 'text',
			'title'   		=> __( 'Content Lock Redirect','um-verified' ),
			'default'  		=> home_url(),
			'desc' 	   		=> __('Unverified users who access verified areas will be redirected to that URL.','um-verified'),
		);
		
		$fields[] = array(
			'id'       		=> 'email-verified-account',
			'type'     		=> 'textarea',
			'title'    		=> __( 'Verified Account User E-mail','um-verified' ),
			'subtitle' 		=> __( 'Message Body','um-verified' ),
			'default'  		=> 'Hi {display_name},' . "\r\n\r\n" .
								'Good News! We have reviewed your verification request and are happy to say that your account is now verified.' . "\r\n\r\n" .
								'View your profile:'  . "\r\n" .
								'{user_profile_link}'  . "\r\n\r\n" .
								'Thank You!'  . "\r\n" .
								'{site_name}',
		);
		
		$fields[] = array(
			'id'       		=> 'verified_notify_admin',
			'type'     		=> 'switch',
			'default'		=> 1,
			'title'   		=> __( 'Send a notification e-mail to admin?','um-verified' ),
			'desc' 	   		=> __('When a user requests to have their account verified.','um-verified'),
			'on'			=> __('On','um-verified'),
			'off'			=> __('Off','um-verified'),
		);
		
		$fields[] = array(
			'id'       		=> 'email-verification-request',
			'type'     		=> 'textarea',
			'title'    		=> __( 'Verification Request  E-mail','um-verified' ),
			'subtitle' 		=> __( 'Message Body','um-verified' ),
			'default'  		=> '{display_name} ({username}) has requested that their account be verified.' . "\r\n\r\n" .
								'View their profile:'  . "\r\n" .
								'{user_profile_link}'  . "\r\n\r\n" .
								'To approve request:'  . "\r\n" .
								'{verify_approve}' . "\r\n\r\n" .
								'To reject request:' . "\r\n" .
								'{verify_reject}',
			'required'		=> array( 'verified_notify_admin', '=', 1 )
		);
		
		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'Verified Users','um-verified'),
			'fields'     => $fields

		);
		return $sections;
	}
	
	/***
	***	@Quick actions in users list
	***/
	add_filter('um_admin_user_row_actions', 'um_verified_user_row_actions', 10, 2);
	function um_verified_user_row_actions( $actions, $user_id ) {
		
		if ( um_verified_status( $user_id ) == 'unverified' ) {
			$actions['verify'] = "<a class='' href='" . um_verify_user_url( $user_id ) . "'>" . __( 'Verify','um-verified') . "</a>";
		}
		
		if ( um_verified_status( $user_id ) == 'pending' ) {
			$actions['verify'] = "<a class='' href='" . um_verify_user_url( $user_id ) . "'>" . __( 'Approve verification request','um-verified') . "</a>";
			$actions['unverify'] = "<a class='' href='" . um_unverify_user_url( $user_id ) . "'>" . __( 'Reject verification','um-verified') . "</a>";
		}
		
		if ( um_verified_status( $user_id ) == 'verified' ) {
			$actions['unverify'] = "<a class='' href='" . um_unverify_user_url( $user_id ) . "'>" . __( 'Unverify','um-verified') . "</a>";
		}
		
		return $actions;
	}
	
	/***
	***	@Add badge to display name
	***/
	add_filter("um_user_display_name_filter", 'um_verified_add_badge', 50, 3 );
	function um_verified_add_badge( $name, $user_id, $html ) {
		
		if ( !$html )
			return $name;
		
		if ( um_is_verified( $user_id ) ) {
			$name = $name . um_verified();
		}

		return $name;
	}
	
	/***
	***	@New tag for activity
	***/
	add_filter('um_activity_search_tpl', 'um_verified_search_tpl');
	function um_verified_search_tpl( $args ) {
		$args[] = '{verified}';
		return $args;
	}
	
	/***
	***	@New tag replace for activity
	***/
	add_filter('um_activity_replace_tpl', 'um_verified_replace_tpl', 10, 2 );
	function um_verified_replace_tpl( $args, $array ) {
		$args[] = isset( $array['verified'] ) ? $array['verified'] : '';
		return $args;
	}
	
	/***
	***	@Add new activity action
	***/
	add_filter('um_activity_global_actions', 'um_verified_activity_action');
	function um_verified_activity_action( $actions ) {
		$actions['verified-account'] = __('Account Verifications','um-verified');
		return $actions;
	}
	
	/***
	***	@Modify pending users queue
	***/
	add_filter('um_admin_pending_queue_filter', 'um_verified_admin_queue_extend');
	function um_verified_admin_queue_extend( $args ) {
		$args['meta_query'][] = array(
				'key' => '_um_verified',
				'value' => 'pending',
				'compare' => '='
		);
		return $args;
	}
	
	add_filter('um_admin_views_users', 'um_verified_admin_views_users');
	function um_verified_admin_views_users( $views ) {
		
		if ( isset($_REQUEST['status']) && $_REQUEST['status'] == 'needs-verification' ) {
			$current = 'class="current"';
		} else {
			$current = '';
		}
			
		$views['needs-verification'] = '<a href="'.admin_url('users.php').'?status=needs-verification" ' . $current . '>'. __('Request Verification','um-verified') . ' <span class="count">(' . um_verified_requests_count() . ')</span></a>';
		return $views;
	}
	
	/***
	***	@Adds a notification type
	***/
	add_filter('um_notifications_core_log_types', 'um_verified_add_notification_type', 200 );
	function um_verified_add_notification_type( $array ) {
		
		$array['account_verified'] = array(
			'title' => __('User account is verified','um-verified'),
			'template' => 'Congratulations! Your account is now verified.',
			'account_desc' => __('When my account gets verified','um-verified'),
		);
		return $array;
	}
	
	/***
	***	@Adds a notification icon
	***/
	add_filter('um_notifications_get_icon', 'um_verified_add_notification_icon', 10, 2 );
	function um_verified_add_notification_icon( $output, $type ) {
		
		if ( $type == 'account_verified' ) {
			$output = '<i class="um-icon-ios-checkmark" style="color: #5EA5E7"></i>';
		}

		return $output;
	}