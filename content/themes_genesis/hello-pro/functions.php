<?php
/**
 * Hello Pro 2
 *
 * This file adds functions to the Hello Pro 2 Theme.
 *
 * @package Hello Pro
 * @author  brandiD
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/hello/
 */

// * Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Load constants - use constants in code instead of functions to improve performance. Hat Tip to Tonya at Knowthecode.io.
$child_theme = wp_get_theme( get_stylesheet_directory() );

// * Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Hello Pro', 'hello-pro' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/hello' );
define( 'CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );
define( 'SITE_NAME', get_bloginfo( 'name' ) );
define( 'SITE_DESCRIPTION', get_bloginfo( 'description' ) );

// No longer need to hard code version in functions.php file - it is pulled from version in stylesheet.
// If WP_DEBUG is on, this adds unique string to css file reduce stylesheet cached issues during development or testing.
if ( WP_DEBUG ) {
	define( 'CHILD_THEME_VERSION', filemtime( CHILD_THEME_DIR . '/style.css' ) );
} else {
	define( 'CHILD_THEME_VERSION', $child_theme->get( 'Version' ) );
}

define( 'CHILD_TEXT_DOMAIN', $child_theme->get( 'TextDomain' ) );
define( 'ROOT_DOMAIN_URL', home_url() );
define( 'CHILD_SITE_NAME', get_bloginfo( 'name' ) );


// Set Localization (do not remove).
add_action( 'after_setup_theme','hello_pro_localization_setup' );
/**
 * Loads text Domain
 *
 * @since  1.0.0
 */
function hello_pro_localization_setup() {
	load_child_theme_textdomain( 'hello-pro', apply_filters( 'child_theme_textdomain', CHILD_THEME_DIR . '/languages', 'hello-pro' ) );
}


// * Setup Theme
include_once( CHILD_THEME_DIR  . '/lib/theme-defaults.php' );

// Add Front Page Image options to WordPress Theme Customizer.
require_once( CHILD_THEME_DIR . '/lib/customize.php' );

// Add helper functions.
include_once( CHILD_THEME_DIR . '/lib/helper-functions.php' );

// Include Customizer CSS for home page. Load this after enqueue scripts.
include_once( CHILD_THEME_DIR . '/lib/theme-setup.php' );

// Add scripts functions.
include_once( CHILD_THEME_DIR . '/lib/load-scripts.php' );

// Include Customizer CSS for home page. Load this after enqueue scripts.
include_once( CHILD_THEME_DIR . '/lib/widget-setup.php' );

// Include Customizer CSS for home page. Load this after enqueue scripts.
include_once( CHILD_THEME_DIR . '/lib/output.php' );
