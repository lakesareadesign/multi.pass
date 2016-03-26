<?php

class UM_Verified_Enqueue {

	function __construct() {
	
		$priority = apply_filters( 'um_verified_enqueue_priority', 0 );
		
		add_action('wp_enqueue_scripts',  array(&$this, '_enqueue_scripts'), $priority );
		add_action('admin_enqueue_scripts',  array(&$this, '_enqueue_scripts'), $priority );
	
	}

	function _enqueue_scripts(){
		
		wp_register_style('um_verified', um_verified_url . 'assets/css/um-verified.css' );
		wp_enqueue_style('um_verified');

	}
	
}