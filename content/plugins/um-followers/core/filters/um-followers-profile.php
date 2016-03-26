<?php

	/***
	***	@More profile privacy options
	***/
	add_filter('um_profile_privacy_options', 'um_followers_profile_privacy_options', 100 );
	function um_followers_profile_privacy_options( $options ) {
		$options[] = __('Only people I follow can view my profile','um-followers');
		$options[] = __('Followers','um-followers');
		return $options;
	}

	/***
	***	@add a hidden tab
	***/
	add_filter('um_profile_tabs', 'um_followers_add_tabs', 2000 );
	function um_followers_add_tabs( $tabs ) {
		
		$tabs['followers'] = array(
			'hidden' => true,
			'_builtin' => true,
		);
		
		$tabs['following'] = array(
			'hidden' => true,
			'_builtin' => true,
		);
		
		return $tabs;
		
	}
	
	/***
	***	@Check if user can view user profile
	***/
	add_filter('um_profile_can_view_main', 'um_followers_can_view_main', 10, 2 );
	function um_followers_can_view_main( $can_view, $user_id ) {
		global $ultimatemember;
		
		if ( !is_user_logged_in() || get_current_user_id() != $user_id ) {
			$is_private_case = $ultimatemember->user->is_private_case( $user_id, __('Followers','um-followers') );
			if ( $is_private_case ) {
				$can_view = __('You must follow this user to view profile','um-followers');
			}
			
			$is_private_case = $ultimatemember->user->is_private_case( $user_id, __('Only people I follow can view my profile','um-followers') );
			if ( $is_private_case ) {
				$can_view = __('You cannot view this profile because the user has not followed you','um-followers');
			}
		}
		
		return $can_view;
	}
	
	/***
	***	@Test case to hide profile
	***/
	add_filter('um_is_private_filter_hook', 'um_followers_private_filter_hook', 100, 3 );
	function um_followers_private_filter_hook( $default, $option, $user_id ) {
		global $um_followers;
		
		// user selected this option in privacy
		if ( $option == __('Followers','um-followers') ) {
			if ( !$um_followers->api->followed( $user_id, get_current_user_id() ) ) {
				return true;
			}
		}
		
		if ( $option == __('Only people I follow can view my profile','um-followers') ) {
			if ( !$um_followers->api->followed( get_current_user_id(), $user_id ) ) {
				return true;
			}
		}
		
		return $default;
	}