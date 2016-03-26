<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_bbpress_config', 9.120 );
	function um_bbpress_config($sections){
		global $um_bbpress;
		
		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'bbPress','um-bbpress'),
			'fields'     => array(

				array(
						'id'       		=> 'bbpress_hide_from_guests',
						'type'     		=> 'switch',
						'default'		=> 0,
						'title'   		=> __( 'Hide forums tab from Guests','um-bbpress' ),
						'desc' 	   		=> __('Enable this option If you do not want to show the forums tab for guests.','um-bbpress'),
						'on'			=> __('On','um-bbpress'),
						'off'			=> __('Off','um-bbpress'),
				),

			)

		);

		return $sections;
		
	}