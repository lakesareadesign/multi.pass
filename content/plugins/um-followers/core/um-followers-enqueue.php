<?php

class UM_Followers_Enqueue {

	function __construct() {
	
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 9999);

	}
	
	function wp_enqueue_scripts(){
		
		wp_register_style('um_followers', um_followers_url . 'assets/css/um-followers.css' );
		wp_enqueue_style('um_followers');
		
		wp_register_script('um_followers', um_followers_url . 'assets/js/um-followers.js', '', '', true );
		wp_enqueue_script('um_followers');
		
	}
	
}