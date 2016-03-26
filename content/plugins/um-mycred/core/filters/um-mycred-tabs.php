<?php

	/***
	***	@adds a main tab to display forum activity in profile
	***/
	add_filter('um_profile_tabs', 'um_mycred_add_tab', 2000 );
	function um_mycred_add_tab( $tabs ) {
		
		if ( !function_exists( 'mycred_get_users_badges' ) ) return $tabs;
		
		global $um_bbpress;
		
		$user_id = um_user('ID');
		
		$display_name = um_user('display_name');
		if ( strstr( $display_name, ' ' ) ) {
		$display_name = explode(' ', $display_name);
		$display_name = $display_name[0];
		}

		$tabs['badges'] = array(
			'name' => __('Badges','um-mycred'),
			'icon' => 'um-icon-ribbon-b',
			'subnav' => array(
				'my_badges' => ( um_is_myprofile() ) ? __('Your Badges','um-mycred') : sprintf(__('%s\'s Badges','um-mycred'), $display_name ),
				'all_badges' => __('All Badges','um-mycred'),
			),
			'subnav_default' => 'my_badges'
		);
		
		return $tabs;
		
	}