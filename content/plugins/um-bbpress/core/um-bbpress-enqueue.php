<?php

class UM_bbPress_Enqueue {

	function __construct() {
	
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 0);
	
	}

	function wp_enqueue_scripts(){
		
		wp_register_style('um_bbpress', um_bbpress_url . 'assets/css/um-bbpress.css' );
		wp_enqueue_style('um_bbpress');
		
	}
	
}