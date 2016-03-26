<?php

class UM_Reviews_Enqueue {

	function __construct() {
	
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 0);
	
	}

	function wp_enqueue_scripts(){
		
		wp_register_style('um_reviews', um_reviews_url . 'assets/css/um-reviews.css' );
		wp_enqueue_style('um_reviews');
		
		wp_register_script('um_reviews', um_reviews_url . 'assets/js/um-reviews.js', '', '', true );
		wp_enqueue_script('um_reviews');
		
	}
	
}