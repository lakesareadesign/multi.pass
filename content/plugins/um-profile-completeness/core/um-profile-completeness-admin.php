<?php

class UM_Profile_Completeness_Admin {

	function __construct() {
	
		$this->slug = 'ultimatemember';
		$this->pagehook = 'toplevel_page_ultimatemember';
		
		add_action('admin_enqueue_scripts',  array(&$this, 'admin_enqueue_scripts'), 9);

	}

	/***
	***	@admin styles
	***/
	function admin_enqueue_scripts() {
		
		wp_register_style('um_admin_profile_completeness', um_profile_completeness_url . 'assets/css/um-admin-profile-completeness.css' );
		wp_enqueue_style('um_admin_profile_completeness');
		
		wp_register_script('um_admin_profile_completeness', um_profile_completeness_url . 'assets/js/um-admin-profile-completeness.js', '', '', true );
		wp_enqueue_script('um_admin_profile_completeness');
		
	}

}