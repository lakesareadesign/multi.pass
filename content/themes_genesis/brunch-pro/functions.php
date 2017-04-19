<?php
/**
 * Theme setup and initialization.
 *
 * @package     BrunchPro
 * @subpackage  Genesis
 * @author      Robert Neu
 * @copyright   Copyright (c) 2016, Shay Bocks
 * @license     GPL-2.0+
 * @link        http://www.shaybocks.com/brunch-pro/
 * @since       1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'CHILD_THEME_NAME', 'Brunch Pro Theme' );
define( 'CHILD_THEME_VERSION', '2.1.2' );
define( 'CHILD_THEME_URL', 'http://shaybocks.com/brunch-pro/' );
define( 'CHILD_THEME_DEVELOPER', 'Shay Bocks' );

/**
 * Require an included theme file once.
 *
 * @since  1.0.0
 * @access public
 * @param  string $path the relative path of the file to be included.
 * @return void
 */
function brunch_pro_require_once( $path ) {
	require_once trailingslashit( get_stylesheet_directory() ) . 'includes/' . ltrim( $path );
}

add_action( 'after_setup_theme', 'brunch_pro_content_width', 0 );
/**
 * Set the content width and allow it to be filtered directly.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'brunch_pro_content_width', 980 );
}

add_action( 'after_setup_theme', 'brunch_pro_load_textdomain' );
/**
 * Load the child theme textdomain.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_load_textdomain() {
	load_child_theme_textdomain(
		'brunch-pro',
		trailingslashit( get_stylesheet_directory() ) . 'languages'
	);
}

add_action( 'init', 'brunch_pro_register_image_sizes', 5 );
/**
 * Register custom image sizes for the theme.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_register_image_sizes() {
	add_image_size( 'horizontal-thumbnail', 680, 450, true );
	add_image_size( 'vertical-thumbnail',   680, 900, true );
	add_image_size( 'square-thumbnail',     320, 320, true );
}

add_action( 'init', 'brunch_pro_register_layouts' );
/**
 * Register additional theme layout options.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_register_layouts() {
	genesis_register_layout( 'full-width-slim', array(
		'label' => __( 'Full Width Slim', 'brunch-pro' ),
		'img'   => trailingslashit( get_stylesheet_directory_uri() ) . 'images/layout-slim.gif',
	) );
	genesis_register_layout( 'alt-sidebar-content', array(
		'label' => __( 'Alt Sidebar/Content', 'brunch-pro' ),
		'img'   => trailingslashit( get_stylesheet_directory_uri() ) . 'images/layout-alt-sidebar-content.gif',
	) );
}

add_action( 'genesis_setup', 'brunch_pro_theme_setup', 15 );
/**
 * Theme Setup
 *
 * This setup function hooks into the Genesis Framework to allow access to all
 * of the core Genesis functions. All the child theme functionality can be found
 * in files located within the /includes/ directory.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_theme_setup() {
	add_theme_support( 'genesis-responsive-viewport' );

	add_theme_support( 'html5' );

	add_theme_support( 'custom-background' );

	add_theme_support( 'genesis-accessibility', array(
		'headings',
		'search-form',
		'skip-links',
	) );

	add_theme_support( 'custom-header', array(
		'width'           => 640,
		'height'          => 300,
		'header-selector' => '.site-title a',
		'header-text'     => false,
	) );

	add_theme_support( 'genesis-footer-widgets', 4 );

	add_theme_support( 'genesis-after-entry-widget-area' );
}

add_action( 'genesis_setup', 'brunch_pro_includes', 15 );
/**
 * Load additional functions and helpers.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_includes() {
	brunch_pro_require_once( 'vendor/customizer-library/customizer-library.php' );
	brunch_pro_require_once( 'customize/helpers-colors.php' );
	brunch_pro_require_once( 'customize/helpers-fonts.php' );
	brunch_pro_require_once( 'customize/helpers-general.php' );
	brunch_pro_require_once( 'customize/library-filters.php' );
	brunch_pro_require_once( 'helpers-archive.php' );
	brunch_pro_require_once( 'helpers-layout.php' );
	brunch_pro_require_once( 'compatibility.php' );
	brunch_pro_require_once( 'scripts.php' );
	brunch_pro_require_once( 'template-archive.php' );
	brunch_pro_require_once( 'template-global.php' );
	brunch_pro_require_once( 'widgets-init.php' );
	if ( genesis_is_customizer() ) {
		brunch_pro_require_once( 'customize/settings-archives.php' );
		brunch_pro_require_once( 'customize/settings-colors.php' );
		brunch_pro_require_once( 'customize/settings-fonts.php' );
	}
}

add_action( 'genesis_setup', 'brunch_pro_admin_includes', 15 );
/**
 * Load admin functions and helpers.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_admin_includes() {
	if ( is_admin() ) {
		brunch_pro_require_once( 'vendor/class-tgm-plugin-activation.php' );
		brunch_pro_require_once( 'admin/functions.php' );
	}
}

/**
 * Load Genesis
 *
 * This is technically not needed. Unfortunately, to make functions.php
 * snippets work, it is necessary.
 */
require_once get_template_directory() . '/lib/init.php';
