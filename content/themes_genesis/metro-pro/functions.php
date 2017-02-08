<?php
/**
 * Metro Pro.
 *
 * This file adds the functions to the Metro Pro Theme.
 *
 * @package Metro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/metro/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'metro_localization_setup' );
function metro_localization_setup(){
	load_child_theme_textdomain( 'metro-pro', get_stylesheet_directory() . '/languages' );
}

// Add the theme helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Include WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Include WooCommerce stylesheet and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Include Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', __( 'Metro Pro', 'metro-pro' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/metro/' );
define( 'CHILD_THEME_VERSION', '2.2.1' );

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Enqueue Scripts.
add_action( 'wp_enqueue_scripts', 'metro_load_scripts' );
function metro_load_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'metro-responsive-menus', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'metro-responsive-menus',
		'genesis_responsive_menu',
		metro_get_responsive_menu_settings()
	);

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Oswald:400', array(), CHILD_THEME_VERSION );

}

// Setup our responsive menu settings.
function metro_get_responsive_menu_settings() {

	$settings = array(
		'mainMenu'    => __( 'Menu', 'metro-pro' ),
		'subMenu'     => __( 'Submenu', 'metro-pro' ),
		'menuClasses' => array(
			'combine' => array(
				'.nav-secondary',
				'.nav-header',
				'.nav-primary',
			),
		),
	);

	return $settings;

}

// Enqueue Backstretch script and prepare images for loading.
add_action( 'wp_enqueue_scripts', 'metro_enqueue_scripts' );
function metro_enqueue_scripts() {

	$image = get_option( 'metro-backstretch-image', sprintf( '%s/images/bg.jpg', get_stylesheet_directory_uri() ) );

	// Load scripts only if custom backstretch image is being used.
	if ( ! empty( $image ) ) {

		wp_enqueue_script( 'metro-pro-backstretch', get_stylesheet_directory_uri() . '/js/backstretch.js', array( 'jquery' ), '1.0.0' );
		wp_enqueue_script( 'metro-pro-backstretch-set', get_stylesheet_directory_uri() . '/js/backstretch-set.js' , array( 'jquery', 'metro-pro-backstretch' ), '1.0.0' );

		wp_localize_script( 'metro-pro-backstretch-set', 'BackStretchImg', array( 'src' => str_replace( 'http:', '', $image ) ) );

	}

}

// Add image sizes.
add_image_size( 'home-bottom', 150, 150, TRUE );
add_image_size( 'home-middle', 332, 190, TRUE );
add_image_size( 'home-top', 700, 400, TRUE );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'width'           => 540,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false
) );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Rename menus.
add_theme_support( 'genesis-menus', array( 'secondary' => __( 'Before Header Menu', 'metro-pro' ), 'primary' => __( 'After Header Menu', 'metro-pro' ) ) );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'metro_remove_genesis_metaboxes' );
function metro_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

// Open wrap within site-container.
add_action( 'genesis_before_header', 'metro_open_site_container_wrap' );
function metro_open_site_container_wrap() {
	echo '<div class="site-container-wrap">';
}

// Reposition the secondary navigation.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav', 6 );

// Hooks after-entry widget area to single posts.
add_action( 'genesis_entry_footer', 'metro_after_post'  );
function metro_after_post() {

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	genesis_widget_area( 'after-entry', array(
		'before' => '<div class="after-entry widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

// Close wrap within site-container.
add_action( 'genesis_after_footer', 'metro_close_site_container_wrap' );
function metro_close_site_container_wrap() {
	echo '</div>';
}

// Reposition the footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
add_action( 'genesis_after', 'genesis_footer_widget_areas' );

// Reposition the footer.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_after', 'genesis_footer_markup_open', 11 );
add_action( 'genesis_after', 'genesis_do_footer', 12 );
add_action( 'genesis_after', 'genesis_footer_markup_close', 13 );

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'metro-pro' ),
	'description' => __( 'This is the top section of the homepage.', 'metro-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-left',
	'name'        => __( 'Home - Middle Left', 'metro-pro' ),
	'description' => __( 'This is the middle left section of the homepage.', 'metro-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-right',
	'name'        => __( 'Home - Middle Right', 'metro-pro' ),
	'description' => __( 'This is the middle right section of the homepage.', 'metro-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'metro-pro' ),
	'description' => __( 'This is the bottom section of the homepage.', 'metro-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'metro-pro' ),
	'description' => __( 'This is the after entry section.', 'metro-pro' ),
) );
