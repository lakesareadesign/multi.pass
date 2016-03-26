<?php
/**
 * Plugin Name: 	  Ultimate Member - Instagram
 * Plugin URI:        https://ultimatemember.com/
 * Description:       An extension to allow a user to connect to their instagram account which embeds their most recent instagram photos onto their Ultimate Member profile
 * Version:           1.0.1
 * Author:            Ultimate Member
 * Author URI:        https://ultimatemember.com/
 * Text Domain:       um-instagram
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-um-instagram-activator.php
 */
function activate_um_instagram() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-um-instagram-activator.php';
	Um_Instagram_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-um-instagram-deactivator.php
 */
function deactivate_um_instagram() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-um-instagram-deactivator.php';
	Um_Instagram_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_um_instagram' );
register_deactivation_hook( __FILE__, 'deactivate_um_instagram' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-um-instagram.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_um_instagram() {

	$plugin = new Um_Instagram();
	$plugin->plugin_check();
	
	if( class_exists('UM_API') ){
		$plugin->run();
	}

}
run_um_instagram();
