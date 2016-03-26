<?php
/*
Plugin Name: Ultimate Member - Online Users
Plugin URI: http://ultimatemember.com/
Description: Display online users and show the user online status on your site.
Version: 1.1.0
Author: Ultimate Member
Author URI: http://ultimatemember.com/
*/

	require_once(ABSPATH.'wp-admin/includes/plugin.php');
	
	$plugin_data = get_plugin_data( __FILE__ );

	define('um_online_url',plugin_dir_url(__FILE__ ));
	define('um_online_path',plugin_dir_path(__FILE__ ));
	define('um_online_plugin', plugin_basename( __FILE__ ) );
	define('um_online_extension', $plugin_data['Name'] );
	define('um_online_version', $plugin_data['Version'] );
	
	define('um_online_requires', '1.3.17');
	
	$plugin = um_online_plugin;

	/***
	***	@Init
	***/
	require_once um_online_path . 'core/um-online-init.php';

	function um_online_plugins_loaded() {
		load_plugin_textdomain( 'um-online', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	add_action( 'plugins_loaded', 'um_online_plugins_loaded', 0 );