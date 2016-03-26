<?php

	/***
	***	@Bulk verify
	***/
	add_action('um_admin_custom_hook_um_verify_accounts', 'um_admin_custom_hook_um_verify_accounts', 10 );
	function um_admin_custom_hook_um_verify_accounts( $user_id ) {
		if ( !um_is_verified( $user_id ) ) {
			um_verify( $user_id, true );
		}
	}

	/***
	***	@Bulk unverify
	***/
	add_action('um_admin_custom_hook_um_unverify_accounts', 'um_admin_custom_hook_um_unverify_accounts', 10 );
	function um_admin_custom_hook_um_unverify_accounts( $user_id ) {
		um_unverify( $user_id );
	}
	
	/***
	***	@Verify user in backend
	***/
	add_action('um_admin_do_action__verify_user', 'um_admin_do_action__verify_user');
	function um_admin_do_action__verify_user( $action ){
		global $ultimatemember;
		if ( !is_admin() || !current_user_can( 'edit_user' ) ) die();
		if ( !isset($_REQUEST['uid']) || !is_numeric( $_REQUEST['uid'] ) ) die();

		$user_id = (int) $_REQUEST['uid'];
		um_verify( $user_id, true );
		
		exit( wp_redirect( admin_url('users.php?update=users_updated') ) );
	
	}
	
	/***
	***	@Unverify user in backend
	***/
	add_action('um_admin_do_action__unverify_user', 'um_admin_do_action__unverify_user');
	function um_admin_do_action__unverify_user( $action ){
		global $ultimatemember;
		if ( !is_admin() || !current_user_can( 'edit_user' ) ) die();
		if ( !isset($_REQUEST['uid']) || !is_numeric( $_REQUEST['uid'] ) ) die();

		$user_id = (int) $_REQUEST['uid'];
		um_unverify( $user_id );
		
		exit( wp_redirect( admin_url('users.php?update=users_updated') ) );
	
	}
	
	/***
	***	@Add verification info to profile
	***/
	add_action('um_after_header_meta', 'um_verified_info', 50, 2 );
	function um_verified_info( $user_id, $args ) {
		
		if ( um_profile_id() != get_current_user_id() )
			return;
		
		if ( um_user('verified_req_disallowed') )
			return;
			
		if ( um_verified_status( $user_id ) == 'unverified' ) {
			echo '<div class="um-verified-info"><a href="' . um_verify_url( $user_id, um_user_profile_url() ) . '" class="um-link um-verified-request-link">' . __('Request Verification','um-verified') . '</a></div>';
		}
		
		if ( um_verified_status( $user_id ) == 'pending' ) {
			$cancel = um_verify_cancel_url( $user_id, um_user_profile_url() );
			echo '<div class="um-verified-info">' . sprintf(__('Your verification request is currently pending. <a href="%s" class="um-verified-cancel-request">Cancel request?</a>','um-verified'), $cancel ) . '</div>';
		}
	}
	
	/***
	***	@Add verification info to account
	***/
	add_action('um_after_account_general', 'um_verified_account_info');
	function um_verified_account_info() {
		
		$user_id = um_user('ID');
		
		if ( um_is_verified( $user_id ) ) return;
		
		if ( um_user('verified_req_disallowed') )
			return;
		
		echo '<div class="um-field">';
		
		echo '<div class="um-field-label"><label>' . __('Get Verified','um-verified') . '</label><div class="um-clear"></div></div>';
		
		if ( um_verified_status( $user_id ) == 'unverified' ) {
			echo '<div class="um-verified-info"><a href="' . um_verify_url( $user_id, um_get_core_page('account') ) . '" class="um-link um-verified-request-link">' . __('Request Verification','um-verified') . '</a></div>';
		}
		
		if ( um_verified_status( $user_id ) == 'pending' ) {
			$cancel = um_verify_cancel_url( $user_id, um_get_core_page('account') );
			echo '<div class="um-verified-info">' . sprintf(__('Your verification request is currently pending. <a href="%s" class="um-verified-cancel-request">Cancel request?</a>','um-verified'), $cancel ) . '</div>';
		}
		
		echo '</div>';
		
	}
	
	/* add activity */
	add_action('um_after_user_is_verified','um_verified_integrate_activity', 90, 1 );
	function um_verified_integrate_activity( $user_id ) {
		if ( !defined('um_activity_version') ) return false;
		global $um_activity;
		if ( !um_get_option('activity-verified-account') )
			return;
		
		um_fetch_user( $user_id );
		$author_name = um_user('display_name');
		$author_profile = um_user_profile_url();
		$user_photo = get_avatar( $user_id, 24 );

		$um_activity->api->save(
			array(
				'template' => 'verified-account',
				'wall_id' => 0,
				'author' => $user_id,
				'author_name' => $author_name,
				'author_profile' => $author_profile,
				'user_photo' => $user_photo,
				'related_id' => $user_id,
				'custom_path' => um_verified_path . 'templates/verified-account.php',
				'verified' => um_verified()
			)
		);

	}
	
	/* remove activity */
	add_action('um_after_user_is_unverified','um_verified_deintegrate_activity', 90, 1 );
	function um_verified_deintegrate_activity( $user_id ) {
		if ( !defined('um_activity_version') ) return false;
		global $um_activity;
		if ( !um_get_option('activity-verified-account') )
			return;
		$args = array(
			'post_type' => 'um_activity',
		);
		
		$args['meta_query'][] = array('key' => '_user_id','value' => $user_id,'compare' => '=');
		$args['meta_query'][] = array('key' => '_related_id','value' => $user_id,'compare' => '=');
		$args['meta_query'][] = array('key' => '_action','value' => 'verified-account','compare' => '=');
		$get = new WP_Query( $args );
		if ( $get->found_posts == 0 ) return;
		foreach( $get->posts as $post ) {
			wp_delete_post( $post->ID, true );
		}
	}
	
	/***
	***	@Clear pending queue in backend
	***/
	add_action('um_after_user_request_verification', 'um_verified_cached_queue_clear');
	add_action('um_after_user_undo_request_verification', 'um_verified_cached_queue_clear');
	add_action('um_after_user_is_verified','um_verified_cached_queue_clear' );
	add_action('um_after_user_is_unverified','um_verified_cached_queue_clear' );
	function um_verified_cached_queue_clear( $user_id ) {
		delete_option('um_cached_users_queue');
	}
	
	/***
	***	@send a web notification after user account is verified
	***/
	add_action('um_after_user_is_verified','um_after_user_is_verified_webnotify' );
	function um_after_user_is_verified_webnotify( $user_id ) {
		if ( !defined('um_notifications_version') ) return false;
		global $um_notifications;
		
		um_fetch_user( $user_id );
		$vars['photo'] = um_get_avatar_url( get_avatar( $user_id, 40 ) );
		$vars['member'] = um_user('display_name');
		$url = um_user_profile_url();
		$vars['notification_uri'] = $url;
		
		$um_notifications->api->store_notification( $user_id, 'account_verified', $vars );
	}
	
	/***
	***	@sort by verified accounts
	***/
	add_action('um_admin_directory_sort_users_select', 'um_verified_sort_user_option');
	function um_verified_sort_user_option( $option ) {
		global $ultimatemember; ?>
		
		<option value="verified_first" <?php selected('verified_first', $ultimatemember->query->get_meta_value('_um_sortby') ); ?>><?php _e('Verified accounts first','um-verified'); ?></option>
		
		<?php
	}
	
	/***
	***	@creates options in role page
	***/
	add_action('um_admin_custom_role_metaboxes', 'um_verified_add_role_metabox');
	function um_verified_add_role_metabox( $action ){
		
		global $ultimatemember;
		
		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-verified{" . um_verified_path . "}", __('Verified Accounts','um-verified') . um_verified() , array(&$metabox, 'load_metabox_role'), 'um_role', 'side', 'low');
		
	}