<?php

class UM_Social_Login_Enqueue {

	function __construct() {
	
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 9);

	}

	/***
	***	@styles
	***/
	function wp_enqueue_scripts() {
		
		wp_register_style('um_social_login', um_social_login_url . 'assets/css/um-social-connect.css' );
		wp_enqueue_style('um_social_login');
		
		wp_register_script('um_social_login', um_social_login_url . 'assets/js/um-social-connect.js', array('jquery'), '', true );
		wp_enqueue_script('um_social_login');
		
	}

}