<?php

	/***
	***	@creates the form metaboxes
	***/
	add_action('um_admin_custom_register_metaboxes', 'um_social_login_add_register_metabox');
	function um_social_login_add_register_metabox( $action ){
		
		global $ultimatemember;
		
		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-register{" . um_social_login_path . "}", __('Social Login','um-social-login'), array(&$metabox, 'load_metabox_form'), 'um_form', 'side', 'low');
		add_meta_box("um-admin-form-login{" . um_social_login_path . "}", __('Social Login','um-social-login'), array(&$metabox, 'load_metabox_form'), 'um_form', 'side', 'low');
		
	}