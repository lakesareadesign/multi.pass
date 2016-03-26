<?php

	/***
	***	@extend core fields
	***/
	add_filter("um_predefined_fields_hook", 'um_online_add_field', 100 );
	function um_online_add_field($fields){

		$fields['online_status'] = array(
				'title' => __('Online Status','um-online'),
				'metakey' => 'online_status',
				'type' => 'text',
				'label' => __('Online Status','um-online'),
				'edit_forbidden' => 1,
				'show_anyway' => true,
				'custom' => true,
		);

		return $fields;
		
	}
	
	/***
	***	@Shows the online status
	***/
	add_filter('um_profile_field_filter_hook__online_status', 'um_online_show_status', 99, 2);
	function um_online_show_status( $value, $data ) {
		global $um_online;
		$output = '';
		
		if ( $um_online->is_online( um_user('ID') ) ) {
			$output = '<span class="um-online-status online">' . __('online','um-online') . '</span>';
		} else {
			$output = '<span class="um-online-status offline">' . __('offline','um-online') . '</span>';
		}
		
		return $output;
	}