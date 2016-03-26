<?php

	/***
	***	@extend core fields
	***/
	add_filter("um_predefined_fields_hook", 'um_profile_completeness_add_field', 100 );
	function um_profile_completeness_add_field($fields){

		$fields['completeness_bar'] = array(
				'title' => __('Profile Completeness','um-profile-completeness'),
				'metakey' => 'completeness_bar',
				'type' => 'text',
				'label' => __('Profile Completeness','um-profile-completeness'),
				'required' => 0,
				'public' => 1,
				'editable' => 0,
				'edit_forbidden' => 1,
				'show_anyway' => true,
				'custom' => true,
		);

		return $fields;
		
	}
	
	/***
	***	@Display the progress bar
	***/
	add_filter('um_profile_field_filter_hook__completeness_bar', 'um_profile_field_filter_hook__completeness_bar', 99, 2);
	function um_profile_field_filter_hook__completeness_bar( $value, $data ) {
		global $um_profile_completeness;
		return do_shortcode('[ultimatemember_profile_progress_bar user_id='.um_profile_id().']');
	}