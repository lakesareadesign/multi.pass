<?php
/**
 * Centric Pro.
 *
 * This file adds functions to the Centric Pro Theme.
 *
 * @package Centric
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/centric/
 */

// Starts the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Sets up the theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

add_action( 'after_setup_theme', 'centric_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function centric_localization_setup() {

	load_child_theme_textdomain( 'centric-pro', get_stylesheet_directory() . '/languages' );

}

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', __( 'Centric Theme', 'centric-pro' ) );
define( 'CHILD_THEME_URL', 'https://my.studiopress.com/themes/centric/' );
define( 'CHILD_THEME_VERSION', '1.1.2' );

// Adds HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Adds viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

add_action( 'wp_enqueue_scripts', 'centric_load_scripts' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function centric_load_scripts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,700|Spinnaker', array(), CHILD_THEME_VERSION );

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script( 'centric-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), '1.0.0', true );

}

// Adds new image sizes.
add_image_size( 'featured-page', 960, 700, TRUE );
add_image_size( 'featured-post', 400, 300, TRUE );

// Adds support for custom background.
add_theme_support( 'custom-background' );

// Adds support for custom header.
add_theme_support( 'custom-header', array(
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 80,
	'width'           => 360,
) );

// Adds support for structural wraps.
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer',
) );

// Adds support for additional color style options.
add_theme_support( 'genesis-style-selector', array(
	'centric-pro-charcoal' => __( 'Centric Charcoal', 'centric-pro' ),
	'centric-pro-green'    => __( 'Centric Green', 'centric-pro' ),
	'centric-pro-orange'   => __( 'Centric Orange', 'centric-pro' ),
	'centric-pro-purple'   => __( 'Centric Purple', 'centric-pro' ),
	'centric-pro-red'      => __( 'Centric Red', 'centric-pro' ),
	'centric-pro-yellow'   => __( 'Centric Yellow', 'centric-pro' ),
) );

// Unregisters layout settings.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Unregisters secondary navigation menu.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'centric-pro' ) ) );

// Unregister secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

add_action( 'genesis_before', 'centric_post_title' );
/**
 * Repositions the Page Title.
 *
 * @since 1.0.0
 */
function centric_post_title() {

	if ( is_page() and !is_page_template() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 );
		add_action( 'genesis_after_header', 'genesis_do_post_title', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	} elseif ( is_category() ) {
		remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 ) ;
		add_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	} elseif ( is_search() ) {
		remove_action( 'genesis_before_loop', 'genesis_do_search_title' );
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 ) ;
		add_action( 'genesis_after_header', 'genesis_do_search_title', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	}

}

/**
 * Opens the post title wrapper.
 *
 * @since 1.0.0
 */
function centric_open_post_title() {

	echo '<div class="page-title"><div class="wrap">';

}

/**
 * Closes the post title wrapper.
 *
 * @since 1.0.0
 */
function centric_close_post_title() {

	echo '</div></div>';

}

add_filter( 'the_content_more_link', 'centric_remove_more_link_scroll' );
/**
 * Prevents Page Scroll When Clicking the More Link.
 *
 * @since 1.0.0
 *
 * @param $link Current link.
 * @return New link.
 */
function centric_remove_more_link_scroll( $link ) {

	$link = preg_replace( '|#more-[0-9]+|', '', $link );

	return $link;

}

add_filter( 'genesis_author_box_gravatar_size', 'centric_author_box_gravatar_size' );
/**
 * Modifies the size of the Gravatar in the author box.
 *
 * @since 1.0.0
 *
 * @param int $size Current Gravatar size.
 * @return int New size.
 */
function centric_author_box_gravatar_size( $size ) {

	return 96;

}

add_filter( 'genesis_comment_list_args', 'centric_comment_list_args' );
/**
 * Modifies the size of the Gravatar in comments.
 *
 * @since 1.0.0
 *
 * @param int $size Current Gravatar size.
 * @return int New size.
 */
function centric_comment_list_args( $args ) {

    $args['avatar_size'] = 60;

	return $args;

}

// Adds support for 4-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 4 );

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Relocates after entry widget.
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

// Registers widget areas.
genesis_register_sidebar( array(
	'id'          => 'home-widgets-1',
	'name'        => __( 'Home 1', 'centric-pro' ),
	'description' => __( 'This is the first section of the home page.', 'centric-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-2',
	'name'        => __( 'Home 2', 'centric-pro' ),
	'description' => __( 'This is the second section of the home page.', 'centric-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-3',
	'name'        => __( 'Home 3', 'centric-pro' ),
	'description' => __( 'This is the third section of the home page.', 'centric-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-4',
	'name'        => __( 'Home 4', 'centric-pro' ),
	'description' => __( 'This is the fourth section of the home page.', 'centric-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-5',
	'name'        => __( 'Home 5', 'centric-pro' ),
	'description' => __( 'This is the fifth section of the home page.', 'centric-pro' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-6',
	'name'        => __( 'Home 6', 'centric-pro' ),
	'description' => __( 'This is the sixth section of the home page.', 'centric-pro' ),
) );
