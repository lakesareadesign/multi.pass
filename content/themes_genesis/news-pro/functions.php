<?php
/**
 * News Pro.
 *
 * This file adds the functions to the News Pro Theme.
 *
 * @package News
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/news/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'news_localization_setup' );
function news_localization_setup(){
	load_child_theme_textdomain( 'news-pro', get_stylesheet_directory() . '/languages' );
}

// Add the theme helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Include WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Include WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Include Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', __( 'News Pro', 'news-pro' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/news/' );
define( 'CHILD_THEME_VERSION', '3.2.1' );

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Enqueue Scripts and required fonts.
add_action( 'wp_enqueue_scripts', 'news_load_scripts' );
function news_load_scripts() {

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Raleway:400,700', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'news-match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_enqueue_script( 'news-global-js', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery', 'news-match-height' ), CHILD_THEME_VERSION, true );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'news-responsive-menus', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'news-responsive-menus',
		'genesis_responsive_menu',
		news_get_responsive_menu_settings()
	);

}

// Define the responsive menu settings.
function news_get_responsive_menu_settings() {

	$settings = array(
		'mainMenu'    => __( 'Menu', 'news-pro' ),
		'subMenu'     => __( 'Submenu', 'news-pro' ),
		'menuClasses' => array(
			'combine' => array(
				'.nav-secondary',
				'.nav-primary',
				'.nav-header',
			),
		),
	);

	return $settings;

}

// Add image sizes.
add_image_size( 'home-bottom', 150, 150, TRUE );
add_image_size( 'home-middle', 348, 180, TRUE );
add_image_size( 'home-top', 740, 400, TRUE );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 180,
	'width'           => 520,
) );

// Rename menus.
add_theme_support( 'genesis-menus', array( 'secondary' => __( 'Before Header Menu', 'news-pro' ), 'primary' => __( 'After Header Menu', 'news-pro' ) ) );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'news_remove_genesis_metaboxes' );
function news_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

// Open wrap within site-container.
add_action( 'genesis_before_header', 'news_open_site_container_wrap' );
function news_open_site_container_wrap() {

	echo '<div class="site-container-wrap">';

}

// Reposition the secondary navigation.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );

// Close wrap within site-container.
add_action( 'genesis_after_footer', 'news_close_site_container_wrap' );
function news_close_site_container_wrap() {

	echo '</div>';

}

// Add support for 6-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 6 );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Relocate after entry widget.
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'news-pro' ),
	'description' => __( 'This is the top section of the homepage.', 'news-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-left',
	'name'        => __( 'Home - Middle Left', 'news-pro' ),
	'description' => __( 'This is the middle left section of the homepage.', 'news-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-right',
	'name'        => __( 'Home - Middle Right', 'news-pro' ),
	'description' => __( 'This is the middle right section of the homepage.', 'news-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'news-pro' ),
	'description' => __( 'This is the bottom section of the homepage.', 'news-pro' ),
) );
