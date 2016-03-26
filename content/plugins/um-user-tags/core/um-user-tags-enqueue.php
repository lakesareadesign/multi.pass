<?php

class UM_User_Tags_Enqueue {

	function __construct() {
	
		$priority = apply_filters( 'um_user_tags_enqueue_priority', 0 );
		
		add_action('wp_enqueue_scripts',  array(&$this, '_enqueue_scripts'), $priority );
		add_action('admin_enqueue_scripts',  array(&$this, '_enqueue_scripts'), $priority );
	
	}

	function _enqueue_scripts(){
		
		wp_register_style('um_user_tags', um_user_tags_url . 'assets/css/um-user-tags.css' );
		wp_enqueue_style('um_user_tags');

		wp_register_script('um_user_tags', um_user_tags_url . 'assets/js/um-user-tags.js', '', '', true );
		wp_enqueue_script('um_user_tags');
		
	}
	
}