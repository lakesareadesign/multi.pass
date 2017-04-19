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
