<?php

class UM_Profile_Completeness_Enqueue {

	function __construct() {
	
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 9999);
		
	}

	function wp_enqueue_scripts(){
		
		wp_register_style('um_profile_completeness', um_profile_completeness_url . 'assets/css/um-profile-completeness.css' );
		wp_enqueue_style('um_profile_completeness');
		
		wp_register_script('um_profile_completeness', um_profile_completeness_url . 'assets/js/um-profile-completeness.js', '', '', true );
		wp_enqueue_script('um_profile_completeness');
		
	}
	
}