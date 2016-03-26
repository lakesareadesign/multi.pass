<?php
/*
Plugin Name: Ultimate Member - Verified Users
Plugin URI: https://ultimatemember.com/
Description: Allow users to get verified and have a verification badge next to their name
Version: 1.0.8
Author: Ultimate Member
Author URI: https://ultimatemember.com/
*/

	require_once(ABSPATH.'wp-admin/includes/plugin.php');
	
	$plugin_data = get_plugin_data( __FILE__ );

	define('um_verified_url',plugin_dir_url(__FILE__ ));
	define('um_verified_path',plugin_dir_path(__FILE__ ));
	define('um_verified_plugin', plugin_basename( __FILE__ ) );
	define('um_verified_extension', $plugin_data['Name'] );
	define('um_verified_version', $plugin_data['Version'] );
	
	define('um_verified_requires', '1.3.36');
	
	$plugin = um_verified_plugin;

	/***
	***	@Init
	***/
	require_once um_verified_path . 'core/um-verified-users-init.php';

	function um_verified_plugins_loaded() {
		load_plugin_textdomain( 'um-verified', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	add_action( 'plugins_loaded', 'um_verified_plugins_loaded', 0 );
	
	/* Licensing */

	if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
		include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
	}
	function um_verified_plugin_updater() {
		if ( !function_exists( 'um_get_option' ) ) return;
		$item_key = 'um_verified_license_key';
		$item_status = 'um_verified_license_status';
		$product = 'Verified Users';
		$license_key = trim( um_get_option( $item_key ) );
		$edd_updater = new EDD_SL_Plugin_Updater( 'https://ultimatemember.com/', __FILE__, array( 
				'version' 	=> '1.0.8',
				'license' 	=> $license_key,
				'item_name' => $product,
				'author' 	=> 'Ultimate Member'
			)
		);

	}
	add_action( 'admin_init', 'um_verified_plugin_updater', 0 );
	
	add_filter('um_licensed_products_settings', 'um_verified_license_key');
	function um_verified_license_key( $array ) {
		if ( !function_exists( 'um_get_option' ) ) return;
		$item_key = 'um_verified_license_key';
		$item_status = 'um_verified_license_status';
		$product = 'Verified Users';
		$array[] = 	array(
				'id'       		=> $item_key,
				'type'     		=> 'text',
				'title'   		=> $product . ' License Key',
				'compiler' 		=> true,
			);
		return $array;
	}

	add_filter('redux/options/um_options/compiler', 'um_verified_license_status', 10, 3);
	function um_verified_license_status($options, $css, $changed_values) {
		if ( !function_exists( 'um_get_option' ) ) return;
		$item_key = 'um_verified_license_key';
		$item_status = 'um_verified_license_status';
		$product = 'Verified Users';
		if ( isset( $options[$item_key] ) && isset($changed_values[$item_key]) && $options[$item_key] != $changed_values[$item_key] ) {
			
			if ( $options[$item_key] == '' ) {
				
				$license = trim( $options[$item_key] );
				$api_params = array( 
					'edd_action'=> 'deactivate_license', 
					'license' 	=> $changed_values[$item_key], 
					'item_name' => urlencode( $product ), // the name of our product in EDD
					'url'       => home_url()
				);

				$response = wp_remote_get( add_query_arg( $api_params, 'https://ultimatemember.com/' ), array( 'timeout' => 30, 'sslverify' => false ) );
				if ( is_wp_error( $response ) )
					return false;

				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				delete_option( $item_status );
				
			} else {
			
				$license = trim( $options[$item_key] );
				$api_params = array( 
					'edd_action'=> 'activate_license', 
					'license' 	=> $license, 
					'item_name' => urlencode( $product ), // the name of our product in EDD
					'url'       => home_url()
				);

				$response = wp_remote_get( add_query_arg( $api_params, 'https://ultimatemember.com/' ), array( 'timeout' => 30, 'sslverify' => false ) );
				if ( is_wp_error( $response ) )
					return false;

				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				update_option( $item_status, $license_data->license );
				
			}
			
		}
	}