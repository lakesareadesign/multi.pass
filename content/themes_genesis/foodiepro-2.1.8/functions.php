<?php
/**
 * Custom amendments for the theme.
 *
 * @package     FoodiePro
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Shay Bocks
 * @license     GPL-2.0+
 * @link        http://www.shaybocks.com/foodie-pro/
 * @since       1.0.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CHILD_THEME_NAME', 'Foodie Pro Theme' );
define( 'CHILD_THEME_VERSION', '2.1.8' );
define( 'CHILD_THEME_URL', 'http://shaybocks.com/foodie-pro/' );
define( 'CHILD_THEME_DEVELOPER', 'Shay Bocks' );

add_action( 'after_setup_theme', 'foodie_pro_load_textdomain' );
/**
 * Loads the child theme textdomain.
 *
 * @since  2.1.0
 * @return void
 */
function foodie_pro_load_textdomain() {
	load_child_theme_textdomain(
		'foodiepro',
		trailingslashit( get_stylesheet_directory() ) . 'languages'
	);
}

add_action( 'genesis_setup', 'foodie_pro_theme_setup', 15 );
/**
 * Theme Setup
 *
 * This setup function hooks into the Genesis Framework to allow access to all
 * of the core Genesis functions. All the child theme functionality can be found
 * in files located within the /includes/ directory.
 *
 * @since  1.0.1
 * @return void
 */
function foodie_pro_theme_setup() {
	//* Add viewport meta tag for mobile browsers.
	add_theme_support( 'genesis-responsive-viewport' );

	//* Add HTML5 markup structure.
	add_theme_support( 'html5' );

	//*	Set content width.
	$content_width = apply_filters( 'content_width', 610, 610, 980 );

	//* Add new featured image sizes.
	add_image_size( 'horizontal-thumbnail', 680, 450, true );
	add_image_size( 'vertical-thumbnail', 680, 900, true );
	add_image_size( 'square-thumbnail', 320, 320, true );

	//* Add Accessibility support
	add_theme_support(
		'genesis-accessibility',
		array(
			'headings',
			'search-form',
			'skip-links',
		)
	);

	//* Add support for custom background.
	add_theme_support( 'custom-background' );

	//* Unregister header right sidebar.
	unregister_sidebar( 'header-right' );

	//* Add support for custom header.
	add_theme_support( 'genesis-custom-header', array(
			'width'  => 800,
			'height' => 340,
		)
	);

	//* Add support for 4-column footer widgets.
	add_theme_support( 'genesis-footer-widgets', 4 );
}

add_action( 'genesis_setup', 'foodie_pro_includes', 20 );
/**
 * Load additional functions and helpers.
 *
 * DO NOT MODIFY ANYTHING IN THIS FUNCTION.
 *
 * @since   2.0.0
 * @return  void
 */
function foodie_pro_includes() {
	$includes_dir = trailingslashit( get_stylesheet_directory() ) . 'includes/';

	// Load the customizer library.
	require_once $includes_dir . 'vendor/customizer-library/customizer-library.php';

	// Load all customizer files.
	require_once $includes_dir . 'customizer/customizer-display.php';
	require_once $includes_dir . 'customizer/customizer-settings.php';

	// Load everything in the includes root directory.
	require_once $includes_dir . 'helper-functions.php';
	require_once $includes_dir . 'compatability.php';
	require_once $includes_dir . 'simple-grid.php';
	require_once $includes_dir . 'widgeted-areas.php';
	require_once $includes_dir . 'widgets.php';

	// End here if we're not in the admin panel.
	if ( ! is_admin() ) {
		return;
	}

	// Load the TGM Plugin Activation class.
	require_once $includes_dir . 'vendor/class-tgm-plugin-activation.php';

	// Load everything in the admin root directory.
	require_once $includes_dir . 'admin/functions.php';
}

/**
 * Load Genesis
 *
 * This is technically not needed.
 * However, to make functions.php snippets work, it is necessary.
 */
require_once( get_template_directory() . '/lib/init.php' );

add_action( 'wp_enqueue_scripts', 'foodie_pro_enqueue_js' );
/**
 * Load all required JavaScript for the Foodie theme.
 *
 * @since   1.0.1
 * @return  void
 */
function foodie_pro_enqueue_js() {
	$js_uri = get_stylesheet_directory_uri() . '/assets/js/';
	// Add general purpose scripts.
	wp_enqueue_script(
		'foodie-pro-general',
		$js_uri . 'general.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
}

add_filter( 'body_class', 'foodie_pro_add_body_class' );
/**
 * Add the theme name class to the body element.
 *
 * @since  1.0.0
 *
 * @param  string $classes
 * @return string Modified body classes.
 */
function foodie_pro_add_body_class( $classes ) {
	$classes[] = 'foodie-pro';
	return $classes;
}

//* Add post navigation.
add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

add_filter( 'excerpt_more', 'foodie_pro_read_more_link' );
add_filter( 'get_the_content_more_link', 'foodie_pro_read_more_link' );
add_filter( 'the_content_more_link', 'foodie_pro_read_more_link' );
/**
 * Modify the Genesis read more link.
 *
 * @since  1.0.0
 *
 * @param  string $more
 * @return string Modified read more text.
 */
function foodie_pro_read_more_link() {
	return '...</p><p><a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'foodiepro' ) . ' &raquo;</a></p>';
}

add_filter( 'genesis_comment_form_args', 'foodie_pro_comment_form_args' );
/**
 * Modify the speak your mind text.
 *
 * @since   1.0.0
 *
 * @param   $args the default comment reply text.
 * @return  $args the modified comment reply text.
 */
function foodie_pro_comment_form_args( $args ) {
	$args['title_reply'] = __( 'Comments', 'foodiepro' );
	return $args;
}

add_filter( 'genesis_footer_creds_text', 'foodie_pro_footer_creds_text' );
/**
 * Customize the footer text
 *
 * @since  1.0.0
 *
 * @param  string $creds Default credits.
 * @return string Modified Shay Bocks credits.
 */
function foodie_pro_footer_creds_text( $creds ) {
	return sprintf(
		'[footer_copyright before="%s "] &middot; [footer_childtheme_link before=""] %s <a href="http://shaybocks.com/">%s</a> &middot; %s [footer_genesis_link url="http://www.studiopress.com/" before=""] &middot; [footer_wordpress_link before=" %s"]',
		__( 'Copyright', 'foodiepro' ),
		__( 'by', 'foodiepro' ),
		CHILD_THEME_DEVELOPER,
		__( 'Built on the ', 'foodiepro' ),
		__( 'Powered by ', 'foodiepro' )
	);
}
