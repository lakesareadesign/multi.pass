<?php
/**
 * Modern Portfolio Pro.
 *
 * This file adds functions to the Modern Portfolio Pro Theme.
 *
 * @package Modern Portfolio
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/modern-portfolio/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Sets up the theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

add_action( 'after_setup_theme', 'modern_portfolio_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function modern_portfolio_localization_setup() {

	load_child_theme_textdomain( 'modern-portfolio-pro', get_stylesheet_directory() . '/languages' );

}

// Adds custom site initial field to Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Includes custom site initial CSS output.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', __( 'Modern Portfolio Pro', 'modern-portfolio-pro' ) );
define( 'CHILD_THEME_URL', 'https://my.studiopress.com/themes/modern-portfolio/' );
define( 'CHILD_THEME_VERSION', '2.1.2' );

// Adds HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Adds viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

add_action( 'wp_enqueue_scripts', 'modern_portfolio_load_scripts' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function modern_portfolio_load_scripts() {

	wp_enqueue_script( 'mpp-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400|Merriweather:400,300', array(), CHILD_THEME_VERSION );

}

// Adds new image sizes.
add_image_size( 'blog', 340, 140, TRUE );
add_image_size( 'portfolio', 340, 230, TRUE );

// Adds support for custom header.
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 90,
	'width'           => 300,
) );

// Adds support for additional color style options.
add_theme_support( 'genesis-style-selector', array(
	'modern-portfolio-pro-blue'   => __( 'Modern Portfolio Pro Blue', 'modern-portfolio-pro' ),
	'modern-portfolio-pro-orange' => __( 'Modern Portfolio Pro Orange', 'modern-portfolio-pro' ),
	'modern-portfolio-pro-red'    => __( 'Modern Portfolio Pro Red', 'modern-portfolio-pro' ),
	'modern-portfolio-pro-purple' => __( 'Modern Portfolio Pro Purple', 'modern-portfolio-pro' ),
) );

// Unregisters layout settings.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Unregisters secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Renames menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'modern-portfolio-pro' ), 'secondary' => __( 'Footer Menu', 'modern-portfolio-pro' ) ) );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

add_filter( 'wp_nav_menu_args', 'modern_portfolio_secondary_menu_args' );
/**
 * Reduces the secondary navigation menu to one level depth.
 *
 * @since 1.0.0
 *
 * @param array $args The WP navigation menu arguments.
 * @return array The modified menu arguments.
 */
function modern_portfolio_secondary_menu_args( $args ){

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'modern_portfolio_author_box_gravatar_size' );
/**
 * Modifies the size of the Gravatar in the author box.
 *
 * @since 1.0.0
 *
 * @param int $size Current Gravatar size.
 * @return int New size.
 */
function modern_portfolio_author_box_gravatar_size( $size ) {

	return 80;

}

// Adds support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Relocates after entry widget.
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

// Registers widget areas.
genesis_register_sidebar( array(
	'id'          => 'home-about',
	'name'        => __( 'Home - About','modern-portfolio-pro' ),
	'description' => __( 'This is the about section of the homepage.', 'modern-portfolio-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-portfolio',
	'name'        => __( 'Home - Portfolio','modern-portfolio-pro' ),
	'description' => __( 'This is the portfolio section of the homepage.', 'modern-portfolio-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-services',
	'name'        => __( 'Home - Services','modern-portfolio-pro' ),
	'description' => __( 'This is the Services section of the homepage.', 'modern-portfolio-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-blog',
	'name'        => __( 'Home - Blog','modern-portfolio-pro' ),
	'description' => __( 'This is the Blog section of the homepage.', 'modern-portfolio-pro' ),
) );
