<?php

	/***
	***	@extend mycred settings
	***/
	add_filter('um_mycred_extend_award_settings', 'um_social_login_mycred_settings_award');
	function um_social_login_mycred_settings_award( $settings ) {
		global $um_social_login;
		$networks = $um_social_login->networks;
		foreach( $networks as $id => $arr ) {
			$settings[$id] = sprintf(__('user connects with %s','um-social-login'), $arr['name']);
		}
		return $settings;
	}
	
	/***
	***	@extend mycred settings
	***/
	add_filter('um_mycred_extend_deduct_settings', 'um_social_login_mycred_settings_deduct');
	function um_social_login_mycred_settings_deduct( $settings ) {
		global $um_social_login;
		$networks = $um_social_login->networks;
		foreach( $networks as $id => $arr ) {
			$settings[$id] = sprintf(__('user disconnects from %s','um-social-login'), $arr['name']);
		}
		return $settings;
	}
	
	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_social_login_config', 1000 );
	function um_social_login_config($sections){
		global $um_social_login;
		
		$networks = $um_social_login->networks;
		
		$sections[] = array(

			'icon'       => 'um-faicon-sign-in',
			'title'      => __( 'Social Connect','um-social-login'),
			'fields'     => array()

		);
		
		$main_opts[] = array(
                'id'       		=> 'account_tab_social',
                'type'     		=> 'switch',
                'title'   		=> __( 'Social Account Tab','um-social-login' ),
				'default' 		=> 1,
				'desc' 	   		=> __('Enable/disable the Social account tab in account page','um-social-login'),
				'on'			=> __('On','um-social-login'),
				'off'			=> __('Off','um-social-login'),
        );
		
        $main_opts[] = array(
                'id'       		=> 'register_show_social',
                'type'     		=> 'switch',
                'title'    		=> __( 'Show social connect on registration forms','um-social-login' ),
				'default' 		=> 1,
				'desc' 	   		=> __('Show/hide social connect on all registration forms by default','um-social-login'),
				'on'			=> __('On','um-social-login'),
				'off'			=> __('Off','um-social-login'),
        );
		
        $main_opts[] = array(
                'id'       		=> 'login_show_social',
                'type'     		=> 'switch',
                'title'    		=> __( 'Show social connect on login forms','um-social-login' ),
				'default' 		=> 1,
				'desc' 	   		=> __('Show/hide social connect on all login forms by default','um-social-login'),
				'on'			=> __('On','um-social-login'),
				'off'			=> __('Off','um-social-login'),
        );
		
		$i = 0;
		foreach( $networks as $id => $arr ) {
			$i++;
			$sort[$i] = $id;
		}

		$sections[] = array(

			'subsection' => true,
			'title'      => __('General','um-social-login'),
			'fields'     => $main_opts

		);
		
		foreach( $networks as $network_id => $array ) {

			$options = null;
			
			$options[] = array(
                'id'       		=> 'enable_' . $network_id,
                'type'     		=> 'switch',
                'title'    		=> sprintf(__('%s Social Connect','um-social-login'), $array['name'] ),
				'default' 		=> 0,
				'on'			=> __('On','um-social-login'),
				'off'			=> __('Off','um-social-login'),
			);
			
			if ( isset( $array['opts'] ) ) {
				foreach( $array['opts'] as $opt_id => $title ) {
					$options[] = array(
						'id'       		=> $opt_id,
						'type'     		=> 'text',
						'title'    		=> $title,
						'default' 		=> '',
						'required'		=> array( "enable_$network_id", '=', '1' ),
					);
				}
			}
			
			$sections[] = array(

				'subsection' => true,
				'title'      => $array['name'],
				'fields'     => $options

			);

		}

		return $sections;
		
	}