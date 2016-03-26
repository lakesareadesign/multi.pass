<?php

	/***
	***	@creates the Writing metabox
	***/
	add_action('um_admin_custom_access_metaboxes', 'um_bbpress_add_access_metabox');
	function um_bbpress_add_access_metabox( $action ){
		
		global $ultimatemember;
		
		$metabox = new UM_Admin_Access();

		add_meta_box("um-admin-access-bbpress{" . um_bbpress_path . "}", __('Permissions','um-bbpress'), array(&$metabox, 'load_metabox_form'), 'forum', 'side', 'low');
		
	}
	
	/***
	***	@creates options in Role page
	***/
	add_action('um_admin_custom_role_metaboxes', 'um_bbpress_add_role_metabox');
	function um_bbpress_add_role_metabox( $action ){
		
		global $ultimatemember;
		
		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-bbpress{" . um_bbpress_path . "}", __('bbPress','um-bbpress'), array(&$metabox, 'load_metabox_role'), 'um_role', 'normal', 'low');
		
	}