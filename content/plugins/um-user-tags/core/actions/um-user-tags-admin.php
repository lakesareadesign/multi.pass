<?php

	/***
	***	@creates options in Role page
	***/
	add_action('um_admin_custom_role_metaboxes', 'um_user_tags_add_role_metabox');
	function um_user_tags_add_role_metabox( $action ){
		
		global $ultimatemember;
		
		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-user-tags{" . um_user_tags_path . "}", __('User Tags','um-user-tags'), array(&$metabox, 'load_metabox_role'), 'um_role', 'normal', 'low');
		
	}