<?php
/**
 * Author Pro.
 *
 * This file adds the functions to the Author Pro Theme.
 *
 * @package Author
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/author/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'author_localization_setup' );
function author_localization_setup(){
	load_child_theme_textdomain( 'author-pro', get_stylesheet_directory() . '/languages' );
}

// Add the theme helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Include WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Include the WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Include the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', __( 'Author Pro', 'author-pro' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/author/' );
define( 'CHILD_THEME_VERSION', '1.2.1' );

// Enqueue scripts and styles.
add_action( 'wp_enqueue_scripts', 'author_enqueue_scripts_styles' );
function author_enqueue_scripts_styles() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,900,400italic', array(), CHILD_THEME_VERSION );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'author-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'author-responsive-menu',
		'genesis_responsive_menu',
		author_responsive_menu_settings()
	);

	wp_enqueue_script( 'author-match-height', get_stylesheet_directory_uri(). '/js/jquery.matchHeight.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_enqueue_script( 'author-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery', 'author-responsive-menu', 'author-match-height' ), CHILD_THEME_VERSION, true );

}

// Define the responsive menu settings.
function author_responsive_menu_settings() {

	$settings = array(
		'mainMenu'    => __( 'Menu', 'author-pro' ),
		'subMenu'     => __( 'Submenu', 'author-pro' ),
		'menuClasses' => array(
			'combine' => array(
				'.nav-primary',
				'.nav-secondary',
			),
		),
	);

	return $settings;

}

// Add new image sizes.
add_image_size( 'featured-content', 800, 800, TRUE );

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Enable Genesis Accessibility Components.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'search-form', 'skip-links' ) );

// Add support for custom background
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Unregister layout settings.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Unregister secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Unregister the header right widget area.
unregister_sidebar( 'header-right' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'width'           => 640,
	'height'          => 140,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

// Rename menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Header Menu', 'author-pro' ), 'secondary' => __( 'After Header Menu', 'author-pro' ) ) );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'author_remove_genesis_metaboxes' );
function author_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

// Remove skip link for primary navigation and add skip link for footer widgets.
add_filter( 'genesis_skip_links_output', 'author_skip_links_output' );
function author_skip_links_output( $links ){

	if( isset( $links['genesis-nav-primary'] ) ){
		unset( $links['genesis-nav-primary'] );
	}

	$new_links = $links;
	array_splice( $new_links, 1 );

	if ( has_nav_menu( 'secondary' ) ) {
		$new_links['genesis-nav-secondary'] = __( 'Skip to secondary navigation', 'author-pro' );
	}

	return array_merge( $new_links, $links );

}

// Add ID to secondary navigation.
add_filter( 'genesis_attr_nav-secondary', 'author_add_nav_secondary_id' );
function author_add_nav_secondary_id( $attributes ) {

	$attributes['id'] = 'genesis-nav-secondary';

	return $attributes;

}

// Reposition the navigation.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_subnav' );

// Setup widget counts.
function author_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

// Function to get the class for a flexible widget.
function author_widget_area_class( $id ) {

	$count = author_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 3 == 0 ) {
		$class .= ' widget-thirds';
	} elseif( $count % 4 == 0 ) {
		$class .= ' widget-fourths';
	} elseif( $count % 2 == 1 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'author-pro' ),
	'description' => __( 'This is the front page 1 section.', 'author-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'author-pro' ),
	'description' => __( 'This is the front page 2 section.', 'author-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'author-pro' ),
	'description' => __( 'This is the front page 3 section.', 'author-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'author-pro' ),
	'description' => __( 'This is the front page 4 section.', 'author-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'author-pro' ),
	'description' => __( 'This is the front page 5 section.', 'author-pro' ),
) );
