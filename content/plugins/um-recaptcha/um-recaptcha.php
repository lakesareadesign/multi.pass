<?php
/*
Plugin Name: Ultimate Member - Google reCAPTCHA
Plugin URI: http://ultimatemember.com/
Description: Protect your website from spam and integrate Google reCAPTCHA into your Ultimate Member forms
Version: 1.0.2
Author: Ultimate Member
Author URI: http://ultimatemember.com/
*/

	require_once(ABSPATH.'wp-admin/includes/plugin.php');
	
	$plugin_data = get_plugin_data( __FILE__ );

	define('um_recaptcha_url',plugin_dir_url(__FILE__ ));
	define('um_recaptcha_path',plugin_dir_path(__FILE__ ));
	define('um_recaptcha_plugin', plugin_basename( __FILE__ ) );
	define('um_recaptcha_extension', $plugin_data['Name'] );
	define('um_recaptcha_version', $plugin_data['Version'] );
	
	define('um_recaptcha_requires', '1.3.35');
	
	$plugin = um_recaptcha_plugin;

	/***
	***	@Init
	***/
	require_once um_recaptcha_path . 'core/um-recaptcha-init.php';

	function um_recaptcha_plugins_loaded() {
		load_plugin_textdomain( 'um-recaptcha', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	add_action( 'plugins_loaded', 'um_recaptcha_plugins_loaded', 0 );