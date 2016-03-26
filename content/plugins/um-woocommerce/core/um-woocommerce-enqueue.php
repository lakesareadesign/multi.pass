<?php

class UM_WooCommerce_Enqueue {

	function __construct() {
	
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 9999);
	
	}

	function wp_enqueue_scripts(){
		
		if ( !is_user_logged_in() ) return;

		wp_register_style('um_woocommerce', um_woocommerce_url . 'assets/css/um-woocommerce.css' );
		wp_enqueue_style('um_woocommerce');
		
		wp_register_script('um_woocommerce', um_woocommerce_url . 'assets/js/um-woocommerce.js', '', '', true );
		wp_enqueue_script('um_woocommerce');
		
	}
	
}