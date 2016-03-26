<?php

	/***
	***	@A widget in user role page
	***/
	add_action('um_admin_custom_role_metaboxes', 'um_profile_completeness_add_role_metabox');
	function um_profile_completeness_add_role_metabox( $action ){
		
		global $ultimatemember;
		
		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-profilecompleteness{" . um_profile_completeness_path . "}", __('Profile Completeness','um-profile-completeness'), array(&$metabox, 'load_metabox_role'), 'um_role', 'side', 'low');
		
	}