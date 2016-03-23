<?php
/**
 * Admin functions.
 *
 * @package     FoodiePro
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Shay Bocks
 * @license     GPL-2.0+
 * @since       2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'tgmpa_register', 'foodie_pro_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 *
 * @since  2.0.0
 */
function foodie_pro_register_required_plugins() {
	//* Array of plugin arrays.
	$plugins = array(
		array(
			'name'      => 'Genesis Responsive Slider',
			'slug'      => 'genesis-responsive-slider',
			'required'  => false,
		),
		array(
			'name'      => 'Genesis eNews Extended',
			'slug'      => 'genesis-enews-extended',
			'required'  => false,
		),
		array(
			'name'      => 'Simple Social Icons',
			'slug'      => 'simple-social-icons',
			'required'  => false,
		),
		array(
			'name'      => 'Genesis Latest Tweets',
			'slug'      => 'genesis-latest-tweets',
			'required'  => false,
		),
	);
	//* Configuration options for TGMPA.
	$config = array(
		'id'           => 'foodie-pro',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'foodiepro' ),
			'menu_title'                      => __( 'Install Plugins', 'foodiepro' ),
			'installing'                      => __( 'Installing Plugin: %s', 'foodiepro' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'foodiepro' ),
			'notice_can_install_required'     => _n_noop( 'Foodie Pro requires the following plugin: %1$s.', 'Foodie Pro requires the following plugins: %1$s.', 'foodiepro' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'Foodie Pro recommends the following plugin: %1$s.', 'Foodie Pro recommends the following plugins: %1$s.', 'foodiepro' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'foodiepro' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'foodiepro' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'foodiepro' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'foodiepro' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'foodiepro' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'foodiepro' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Install Plugin Now', 'Install Plugins Now', 'foodiepro' ),
			'activate_link'                   => _n_noop( 'Activate Plugin Now', 'Activate Plugins now', 'foodiepro' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'foodiepro' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'foodiepro' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'foodiepro' ), // %s = dashboard link.
			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $plugins, $config );
}

add_action( 'admin_enqueue_scripts', 'foodie_pro_load_admin_styles' );
/**
 * Enqueue Genesis admin styles.
 *
 * @since 2.0.0
 *
 * @uses  CHILD_THEME_VERSION
 */
function foodie_pro_load_admin_styles() {
	$css_uri = get_stylesheet_directory_uri() . '/assets/css';
	wp_enqueue_style( 'foodie-pro-admin', $css_uri . '/admin.css', array(), CHILD_THEME_VERSION );
}

/**
 * Perform a check to see whether or not a widgeted page template is being used.
 *
 * @since   1.0.0
 *
 * @param   $templates an array of widgetized templates to check for
 * @return  bool
 */
function foodie_pro_using_widgeted_template( $templates = array() ) {
	// Return false if we have post data.
	if ( ! isset( $_REQUEST['post'] ) ) {
		return false;
	}

	// If no widgeted templates are passed in, check only the default recipes.php.
	if ( empty( $templates ) ) {
		$templates[] = 'recipes.php';
	}

	foreach ( (array) $templates as $template ) {
		// Return true for all widgeted templates
		if ( get_page_template_slug( $_REQUEST['post'] ) === $template ) {
			return true;
		}
	}

	// Return false for other templates.
	return false;
}

add_action( 'admin_init', 'foodie_pro_remove_widgeted_editor' );
/**
 * Check to make sure a widgeted page template is is selected and then disable
 * the default WordPress editor.
 *
 * @since   1.0.0
 *
 * @return  null if a widgeted template isn't in use.
 */
function foodie_pro_remove_widgeted_editor() {
	// Return early if a widgeted template isn't selected.
	if ( ! foodie_pro_using_widgeted_template() ) {
		return;
	}

	// Disable the standard WordPress editor.
	remove_post_type_support( 'page', 'editor' );

	//* Add an admin notice for the recipe page template.
	add_action( 'admin_notices', 'foodie_pro_widgeted_admin_notice' );
}

/**
 * Check to make sure a widgeted page template is is selected and then show a
 * notice about the editor being disabled.
 *
 * @since  1.0.0
 */
function foodie_pro_widgeted_admin_notice() {
	// Display a notice to users about the widgeted template.
	echo '<div class="updated"><p>';
		printf(
			__( 'The normal editor is disabled because you\'re using a widgeted page template. You need to <a href="%s">use widgets</a> to edit this page.', 'foodiepro' ),
			'widgets.php'
		);
	echo '</p></div>';
}
