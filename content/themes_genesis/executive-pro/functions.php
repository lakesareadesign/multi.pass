<?php
/**
 * Executive Pro.
 *
 * This file adds the functions to the Executive Pro Theme.
 *
 * @package Executive
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/executive/
 */

// Start the engine.
require_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'executive_localization_setup' );
function executive_localization_setup(){
	load_child_theme_textdomain( 'executive-pro', get_stylesheet_directory() . '/languages' );
}

// Add the theme helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', __( 'Executive Pro', 'executive-pro' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/executive/' );
define( 'CHILD_THEME_VERSION', '3.2.3' );

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the WooCommerce customizer styles.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Include notice to install Genesis Connect for WooCommerce.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Enqueue fonts, scripts, and styles.
add_action( 'wp_enqueue_scripts', 'executive_load_scripts' );
function executive_load_scripts() {

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700', array(), CHILD_THEME_VERSION );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'executive-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'executive-responsive-menu',
		'genesis_responsive_menu',
		executive_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function executive_responsive_menu_settings() {

	$settings = array(
		'mainMenu'    => __( 'Menu', 'executive-pro' ),
		'subMenu'     => __( 'Submenu', 'executive-pro' ),
		'menuClasses' => array(
			'combine' => array(
				'.nav-header',
				'.nav-primary',
			),
		),
	);

	return $settings;

}

// Add image sizes.
add_image_size( 'featured', 300, 100, TRUE );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 200,
	'width'           => 520,
) );

// Unregister layout settings.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Unregister secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Remove the site description.
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Rename menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'executive-pro' ), 'secondary' => __( 'Footer Menu', 'executive-pro' ) ) );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'executive_remove_genesis_metaboxes' );
function executive_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'executive_secondary_menu_args' );
function executive_secondary_menu_args( $args ){

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Relocate the post info.
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 5 );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Relocate after entry widget.
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'home-slider',
	'name'        => __( 'Home - Slider', 'executive-pro' ),
	'description' => __( 'This is the slider section on the home page.', 'executive-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'executive-pro' ),
	'description' => __( 'This is the top section of the home page.', 'executive-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-cta',
	'name'        => __( 'Home - Call To Action', 'executive-pro' ),
	'description' => __( 'This is the call to action section on the home page.', 'executive-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home - Middle', 'executive-pro' ),
	'description' => __( 'This is the middle section of the home page.', 'executive-pro' ),
) );
