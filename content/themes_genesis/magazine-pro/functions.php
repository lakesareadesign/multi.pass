<?php
/**
 * Magazine Pro.
 *
 * This file adds the functions to the Magazine Pro Theme.
 *
 * @package Magazine
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    http://my.studiopress.com/themes/magazine/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', __( 'Magazine Pro', 'magazine-pro' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/magazine/' );
define( 'CHILD_THEME_VERSION', '3.3.0' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'magazine_localization_setup' );
function magazine_localization_setup(){
	load_child_theme_textdomain( 'magazine-pro', get_stylesheet_directory() . '/languages' );
}

// Add the theme helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add the Customizer options.
include_once( get_stylesheet_directory() . '/lib/customize.php' );

// Add the Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the WooCommerce customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Include notice to install Genesis Connect for WooCommerce.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * Allows plugins to remove support if required.
 *
 * @since 3.3.0
 */
function genesis_child_gutenberg_support() {

	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';

}

// Enqueue required fonts, scripts, and styles.
add_action( 'wp_enqueue_scripts', 'magazine_enqueue_scripts' );
function magazine_enqueue_scripts() {

	wp_enqueue_script(
		'magazine-entry-date',
		get_stylesheet_directory_uri() . '/js/entry-date.js',
		array( 'jquery' ),
		'1.0.0'
	);

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style(
		'google-fonts', '//fonts.googleapis.com/css?family=Roboto:300,400|Raleway:400,500,900',
		array(),
		CHILD_THEME_VERSION
	);

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script(
		'magazine-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menus' . $suffix . '.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	wp_localize_script(
		'magazine-responsive-menu',
		'genesis_responsive_menu',
		magazine_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function magazine_responsive_menu_settings() {

	$settings = array(
		'mainMenu'    => __( 'Menu', 'magazine-pro' ),
		'subMenu'     => __( 'Submenu', 'magazine-pro' ),
		'menuClasses' => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
				'.nav-secondary',
			),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add image sizes.
add_image_size( 'home-middle', 630, 350, true );
add_image_size( 'home-top', 750, 420, true );
add_image_size( 'sidebar-thumbnail', 100, 100, true );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'default-text-color' => '000000',
	'flex-height'        => true,
	'header-selector'    => '.site-title a',
	'header-text'        => false,
	'height'             => 180,
	'width'              => 760,
) );

// Rename menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Before Header Menu', 'magazine-pro' ), 'secondary' => __( 'After Header Menu', 'magazine-pro' ) ) );

// Remove skip link for primary navigation.
add_filter( 'genesis_skip_links_output', 'magazine_skip_links_output' );
function magazine_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	$new_links = $links;
	array_splice( $new_links, 1 );

	if ( has_nav_menu( 'secondary' ) ) {
		$new_links['genesis-nav-secondary'] = __( 'Skip to secondary menu', 'magazine-pro' );
	}

	return array_merge( $new_links, $links );

}

// Add ID to secondary navigation.
add_filter( 'genesis_attr_nav-secondary', 'magazine_add_nav_secondary_id' );
function magazine_add_nav_secondary_id( $attributes ) {

	$attributes['id'] = 'genesis-nav-secondary';

	return $attributes;

}

// Reposition the primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

// Remove output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

// Remove navigation meta box.
add_action( 'genesis_theme_settings_metaboxes', 'magazine_remove_genesis_metaboxes' );
function magazine_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

// Add primary-nav class if primary navigation is used.
add_filter( 'body_class', 'magazine_no_nav_class' );
function magazine_no_nav_class( $classes ) {

	$menu_locations = get_theme_mod( 'nav_menu_locations' );

	if ( ! empty( $menu_locations['primary'] ) ) {
		$classes[] = 'primary-nav';
	}

	return $classes;

}

// Customize search form input box text.
add_filter( 'genesis_search_text', 'magazine_search_text' );
function magazine_search_text( $text ) {
	return esc_attr( __( 'Search the site ...', 'magazine-pro' ) );
}

// Remove entry meta in entry footer.
add_action( 'genesis_before_entry', 'magazine_remove_entry_meta' );
function magazine_remove_entry_meta() {

	// Remove if not single post.
	if ( ! is_single() ) {
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
	}

}

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Relocate after entry widget.
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_entry_footer', 'genesis_add_id_to_global_exclude', 9 );
add_action( 'genesis_entry_footer', 'genesis_after_entry_widget_area' );

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'magazine-pro' ),
	'description' => __( 'This is the top section of the homepage.', 'magazine-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home - Middle', 'magazine-pro' ),
	'description' => __( 'This is the middle section of the homepage.', 'magazine-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'magazine-pro' ),
	'description' => __( 'This is the bottom section of the homepage.', 'magazine-pro' ),
) );
