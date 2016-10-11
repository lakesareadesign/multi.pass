<?php

class UM_Friends_Enqueue {

	function __construct() {
	
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 9999);

	}
	
	function wp_enqueue_scripts(){
		
		wp_register_style('um_friends', um_friends_url . 'assets/css/um-friends.css' );
		wp_enqueue_style('um_friends');
		
		wp_register_script('um_friends', um_friends_url . 'assets/js/um-friends.js', '', '', true );
		wp_enqueue_script('um_friends');
		
	}
	
}