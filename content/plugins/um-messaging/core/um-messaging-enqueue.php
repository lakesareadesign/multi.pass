<?php

class UM_Messaging_Enqueue {

	function __construct() {
	
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 9999);

	}
	
	function wp_enqueue_scripts(){
		
		wp_register_style('um_messaging', um_messaging_url . 'assets/css/um-messaging.css' );
		wp_enqueue_style('um_messaging');
	
		wp_register_script('um_autosize', um_messaging_url . 'assets/js/autosize.js', '', '', true );
		wp_enqueue_script('um_autosize');
		
		wp_register_script('um_messaging', um_messaging_url . 'assets/js/um-messaging.js', '', '', true );
		wp_enqueue_script('um_messaging');
	
	}
	
}