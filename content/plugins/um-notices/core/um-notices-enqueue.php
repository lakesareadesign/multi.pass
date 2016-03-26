<?php

class UM_Notices_Enqueue {

	function __construct() {

		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 0);

	}

	/***
	***	@enqueue
	***/
	function wp_enqueue_scripts(){

		wp_register_style('um_notices', um_notices_url . 'assets/css/um-notices.css' );
		wp_enqueue_style('um_notices');

		wp_register_script('um_notices', um_notices_url . 'assets/js/um-notices.js', '', '', true );
		wp_enqueue_script('um_notices');

	}
	
}