<?php
/**
 * Kreativ Pro.
 *
 * This file registers required plugins for Kreativ Pro Theme.
 *
 * @package Kreativ
 * @author  ThemeSquare
 * @license GPL-2.0+
 * @link    http://themesquare.com/themes/kreativ/
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_stylesheet_directory() . '/lib/class-plugin-activation.php';


add_action( 'tgmpa_register', 'kreativ_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 */
function kreativ_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 */
	$plugins = array(

		array(
			'name'     => 'Genesis eNews Extended',
			'slug'     => 'genesis-enews-extended',
			'required' => true,
		),

		array(
			'name'     => 'Genesis Portfolio Pro',
			'slug'     => 'genesis-portfolio-pro',
			'required' => true,
		),

		array(
			'name'     => 'Simple Social Icons',
			'slug'     => 'simple-social-icons',
			'required' => true,
		),

		array(
			'name'     => 'One Click Demo Import',
			'slug'     => 'one-click-demo-import',
			'required' => false,
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 */
	$config = array(
		'id'           => 'kreativ-pro',           // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}
