<?php
/**
 * Twenty Seven.
 *
 * This file adds functions to the Twenty Seven Pro Theme.
 *
 * @package Twenty Seven
 * @author  Brian Gardner
 * @license GPL-2.0+
 * @link    http://briangardner.com/
 */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'twenty-seven', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'twenty-seven' ) );

//* Add color select to WordPress theme customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Twenty Seven Pro' );
define( 'CHILD_THEME_URL', 'http://briangardner.com/themes/twenty-seven/' );
define( 'CHILD_THEME_VERSION', '1.0' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style( 'twenty-seven-fonts', '//fonts.googleapis.com/css?family=Playfair+Display:400|Quattrocento+Sans:400,400i,700,700i', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'twenty-seven-ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'twenty-seven-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'twenty-seven-matchHeights', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.js', array( 'jquery' ), '0.5.2', true );

	wp_enqueue_script( 'twenty-seven-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => __( 'Menu', 'twenty-seven' ),
		'subMenu'  => __( 'Menu', 'twenty-seven' ),
	);
	wp_localize_script( 'twenty-seven-responsive-menu', 'twentySevenL10n', $output );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 512,
	'height'          => 134,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Rename menus
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Left Menu', 'modern-studio' ), 'secondary' => __( 'Right Menu', 'modern-studio' ) ) );

//* Reposition the left menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 5 );

//* Reposition the right menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_subnav', 12 );

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

//* Remove secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Remove site layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove navigation meta box
add_action( 'genesis_theme_settings_metaboxes', 'twenty_seven_remove_genesis_metaboxes' );
function twenty_seven_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'twenty_seven_author_box_gravatar' );
function twenty_seven_author_box_gravatar( $size ) {

	return 90;

}

//* Modify size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'twenty_seven_comments_gravatar' );
function twenty_seven_comments_gravatar( $args ) {

	$args['avatar_size'] = 120;

	return $args;

}

//* Hook sticky message widget area
add_action( 'genesis_before', 'twenty_seven_sticky_message' );
function twenty_seven_sticky_message() {

	genesis_widget_area( 'sticky-message', array(
		'before' => '<div class="sticky-message">',
		'after'  => '</div>',
	) );

}

//* Hook before header widget area
add_action( 'genesis_before_header', 'twenty_seven_before_header' );
function twenty_seven_before_header() {

	genesis_widget_area( 'before-header', array(
		'before' => '<div class="before-header"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

//* Hook before footer widget area
add_action( 'genesis_before_footer', 'twenty_seven_before_footer' );
function twenty_seven_before_footer() {

	genesis_widget_area( 'before-footer', array(
		'before' => '<div class="before-footer"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'sticky-message',
	'name'        => __( 'Sticky Message', 'twenty-seven' ),
	'description' => __( 'This is the sticky message section.', 'twenty-seven' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-header',
	'name'        => __( 'Before Header', 'twenty-seven' ),
	'description' => __( 'This is the before header section.', 'twenty-seven' ),
) );
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer', 'twenty-seven' ),
	'description' => __( 'This is the before footer section.', 'twenty-seven' ),
) );