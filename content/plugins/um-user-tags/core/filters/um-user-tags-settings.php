<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_user_tags_config', 11 );
	function um_user_tags_config( $sections ){
		global $um_user_tags;
		
		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'User Tags','um-user-tags'),
			'fields'     => array(

				array(
						'id'       => 'user_tags_max_num',
						'type'     => 'text',
						'title'    => __( 'Maximum number of tags to display in user profile','um-user-tags' ),
						'default'  => 5,
						'validate' => 'numeric',
						'desc' 	   => __('Remaining tags will appear by clicking on a link','um-user-tags'),
				),

			)

		);

		return $sections;
	}