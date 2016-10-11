<?php

	/***
	***	@More profile privacy options
	***/
	add_filter('um_profile_privacy_options', 'um_friends_profile_privacy_options', 100 );
	function um_friends_profile_privacy_options( $options ) {
		$options[] = __('Friends only','um-friends');
		return $options;
	}

	/***
	***	@add a hidden tab
	***/
	add_filter('um_profile_tabs', 'um_friends_add_tabs', 2000 );
	function um_friends_add_tabs( $tabs ) {
		global $um_friends;
		
		$user_id = um_user('ID');
		$username = um_user('display_name');
		
		$myfriends = ( um_is_myprofile() ) ? __('My Friends','um-friends') : sprintf(__('%s\'s friends','um-friends'), $username );
		$myfriends .= '<span>' . $um_friends->api->count_friends( $user_id, false ) . '</span>';
		
		$new_reqs = $um_friends->api->count_friend_requests_received( $user_id );
		
		if ( $new_reqs > 0 ) {
			$class = 'um-friends-notf';
		} else {
			$class = '';
		}
		
		$tabs['friends'] = array(
			//'hidden' => true,
			'_builtin' => true,
			'name' => __('Friends','um-friends'),
			'icon' => 'um-faicon-users',
			'subnav' => array(
				'myfriends' => $myfriends,
				'friendreqs' => __('Friend Requests','um-friends') . '<span class="'. $class . '">' . $new_reqs . '</span>',
				'sentreqs' => __('Friend Requests Sent','um-friends') . '<span>' . $um_friends->api->count_friend_requests_sent( $user_id ) . '</span>'
			),
			'subnav_default' => 'myfriends'
		);
		
		return $tabs;
		
	}
	
	/***
	***	@add tabs based on user
	***/
	add_filter('um_user_profile_tabs', 'um_friends_user_add_tab', 1000 );
	function um_friends_user_add_tab( $tabs ) {
		
		global $um_friends;
		

		if ( ! um_is_myprofile()  ) {
			unset( $tabs['friends']['subnav']['friendreqs'] );
			unset( $tabs['friends']['subnav']['sentreqs'] );
		}

		return $tabs;
		
	}
	
	/***
	***	@Check if user can view user profile
	***/
	add_filter('um_profile_can_view_main', 'um_friends_can_view_main', 10, 2 );
	function um_friends_can_view_main( $can_view, $user_id ) {
		global $ultimatemember;
		
		if ( !is_user_logged_in() || get_current_user_id() != $user_id ) {
			$is_private_case = $ultimatemember->user->is_private_case( $user_id, __('Friends only','um-friends') );
			if ( $is_private_case ) {
				$can_view = __('You must be a friend of this user to view their profile','um-friends');
			}
		}
		
		return $can_view;
	}
	
	/***
	***	@Test case to hide profile
	***/
	add_filter('um_is_private_filter_hook', 'um_friends_private_filter_hook', 100, 3 );
	function um_friends_private_filter_hook( $default, $option, $user_id ) {
		global $um_friends;
		
		// user selected this option in privacy
		if ( $option == __('Friends only','um-friends') ) {
			if ( ! $um_friends->api->is_friend( $user_id, get_current_user_id() ) ) {
				return true;
			}
		}
		
		return $default;
	}