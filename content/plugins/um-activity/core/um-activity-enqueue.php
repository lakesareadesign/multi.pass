<?php

class UM_Activity_Enqueue {

	function __construct() {
	
		$priority = apply_filters( 'um_activity_enqueue_priority', 0 );
		
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), $priority );
	
	}

	function wp_enqueue_scripts(){
		
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		
		wp_register_style('um_activity', um_activity_url . 'assets/css/um-activity.css' );
		wp_enqueue_style('um_activity');
		
		wp_register_style('um_activity_responsive', um_activity_url . 'assets/css/um-activity-responsive.css' );
		wp_enqueue_style('um_activity_responsive');
		
		wp_register_script('um_activity', um_activity_url . 'assets/js/um-activity.js', '', '', true );
		wp_enqueue_script('um_activity');
		
		wp_register_script('um_autosize', um_activity_url . 'assets/js/autosize.js', '', '', true );
		wp_enqueue_script('um_autosize');
		
	}
	
}