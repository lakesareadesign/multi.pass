<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_notices_config', 30 );
	function um_notices_config($sections){
		global $um_notices;
		
		$fields[] = array(
				'id'       		=> 'notice_pos',
                'type'     		=> 'select',
				'select2'		=> array( 'allowClear' => 0, 'minimumResultsForSearch' => -1 ),
                'title'    		=> __( 'Notice Position in Footer','um-notices' ),
                'default'  		=> 'right',
				'options' 		=> array(
									'right' 			=> __('Show to Right','um-notices'),
									'left' 				=> __('Show to Left','um-notices'),
				),
				'placeholder' 	=> __('Select...','um-notices')
        );
		
		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'Notices','um-notices'),
			'fields'     => $fields

		);

		return $sections;
		
	}