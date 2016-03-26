<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_mycred_config', 2000 );
	function um_mycred_config( $sections ){
		
		$sections[] = array(

						'icon'       => 'um-faicon-trophy',
						'title'      => __( 'myCRED','um-mycred'),
						'fields'     => array(),

		);
		
		$fields[] = array(
						'id'       		=> 'mycred_badge_size',
						'type'     		=> 'text',
						'validate'		=> 'numeric',
						'title'   		=> __( 'Width / height of badge in pixels (Badges appearing in profile tab)','um-mycred' ),
						'default' 		=> 80,
		);
		
		$fields[] = array(
						'id'       		=> 'account_tab_points',
						'type'     		=> 'switch',
						'title'   		=> __( 'Account Tab','um-mycred' ),
						'default' 		=> 1,
						'desc' 	   		=> __('Show or hide an account tab that shows the user balance','um-mycred'),
						'on'			=> __('On','um-mycred'),
						'off'			=> __('Off','um-mycred'),
        );
		
		$fields[] = array(
						'id'       		=> 'mycred_refer',
						'type'     		=> 'switch',
						'title'   		=> __( 'Show user affiliate link in account page','um-mycred' ),
						'default' 		=> 0,
						'on'			=> __('On','um-mycred'),
						'off'			=> __('Off','um-mycred'),
        );

		$fields[] = array(
						'id'       		=> 'mycred_show_badges_in_header',
						'type'     		=> 'switch',
						'title'   		=> __( 'Show user badges in profile header?','um-mycred' ),
						'default' 		=> 0,
						'on'			=> __('On','um-mycred'),
						'off'			=> __('Off','um-mycred'),
        );
	
		$fields[] = array(
						'id'       		=> 'mycred_decimals',
						'type'     		=> 'text',
						'title'   		=> __( 'Number of decimals to allow in balance','um-mycred' ),
						'default' 		=> 0,
		);
				
		if ( defined('um_bbpress_version') ) {
		$fields[] = array(
						'id'       		=> 'mycred_hide_role',
						'type'     		=> 'switch',
						'title'   		=> __( 'Hide bbPress Role?','um-mycred' ),
						'default' 		=> 0,
		);
		$fields[] = array(
						'id'       		=> 'mycred_show_bb_rank',
						'type'     		=> 'switch',
						'title'   		=> __( 'Show user rank in bbPress replies','um-mycred' ),
						'default' 		=> 0,
		);
		$fields[] = array(
						'id'       		=> 'mycred_show_bb_points',
						'type'     		=> 'switch',
						'title'   		=> __( 'Show user balance in bbPress replies','um-mycred' ),
						'default' 		=> 0,
		);
		$fields[] = array(
						'id'       		=> 'mycred_show_bb_progress',
						'type'     		=> 'switch',
						'title'   		=> __( 'Show user rank progress in bbPress replies','um-mycred' ),
						'default' 		=> 0,
		);
		}
		
		$sections[] = array(

						'subsection' => true,
						'title'      => __('General','um-mycred'),
						'fields'     => $fields

		);
		
		$award_a = array(
			'login' => __('user login','um-mycred'),
			'register' => __('new user is approved','um-mycred'),
			'editprofile' => __('user updates profile','um-mycred'),
			'photo' => __('user uploads a profile photo','um-mycred'),
			'cover' => __('user uploads a cover photo','um-mycred'),
		);
		
		$award_a = apply_filters('um_mycred_extend_award_settings', $award_a);
		
		foreach( $award_a as $k => $option_title ) {

			$award[] = array(
						'id'       		=> 'mycred_' . $k,
						'type'     		=> 'switch',
						'title'   		=> $option_title,
						'default' 		=> 0,
			);

			$award[] = array(
						'id'       		=> 'mycred_' . $k . '_points',
						'type'     		=> 'text',
						'title'   		=> __( 'points','um-mycred' ),
						'required'		=> array('mycred_' . $k, '=', 1),
						'validate' 		=> 'numeric',
						'default'		=> '0',
			);

			$award[] = array(
						'id'       		=> 'mycred_' . $k . '_limit',
						'type'     		=> 'text',
						'title'   		=> __( 'limit','um-mycred' ),
						'required'		=> array('mycred_' . $k, '=', 1),
						'desc'			=> __('How many times this can be awarded.','um-mycred'),
			);

		}
		
		$deduct_a = array(
			'photo' => __('user removes a profile photo','um-mycred'),
			'cover' => __('user removes a cover photo','um-mycred'),
		);
		
		$deduct_a = apply_filters('um_mycred_extend_deduct_settings', $deduct_a);
		
		foreach( $deduct_a as $k => $option_title ) {

			$deduct[] = array(
						'id'       		=> 'mycred_d_' . $k,
						'type'     		=> 'switch',
						'title'   		=> $option_title,
						'default' 		=> 0,
			);

			$deduct[] = array(
						'id'       		=> 'mycred_d_' . $k . '_points',
						'type'     		=> 'text',
						'title'   		=> __( 'points','um-mycred' ),
						'required'		=> array('mycred_d_' . $k, '=', 1),
						'validate' 		=> 'numeric',
						'default'		=> '0',
			);

			$deduct[] = array(
						'id'       		=> 'mycred_d_' . $k . '_limit',
						'type'     		=> 'text',
						'title'   		=> __( 'limit','um-mycred' ),
						'required'		=> array('mycred_d_' . $k, '=', 1),
						'desc'			=> __('How many times this can be deducted.','um-mycred'),
			);

		}

		$sections[] = array(

						'subsection' => true,
						'title'      => __('Award points when','um-mycred'),
						'fields'     => $award

		);
		
		$sections[] = array(

						'subsection' => true,
						'title'      => __('Deduct points when','um-mycred'),
						'fields'     => $deduct

		);

		return $sections;
		
	}