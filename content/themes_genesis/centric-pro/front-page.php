<?php
/**
 * Centric Pro.
 *
 * This file adds the front page to the Centric Pro Theme.
 *
 * @package Centric
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/centric/
 */
 
add_action( 'wp_enqueue_scripts', 'centric_enqueue_home_scripts' );
/**
 * Enqueues the front page widget scripts.
 *
 * @since 1.0.0
 */
function centric_enqueue_home_scripts() {

	wp_enqueue_script( 'centric-home', get_stylesheet_directory_uri() . '/js/home.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '2.0.0', true );

}

add_action( 'genesis_meta', 'centric_home_genesis_meta' );
/**
 * Adds widget support for homepage. If no widgets active, displays the default loop.
 *
 * @since 1.0.0
 */
function centric_home_genesis_meta() {

	if ( is_active_sidebar( 'home-widgets-1' ) || is_active_sidebar( 'home-widgets-2' ) || is_active_sidebar( 'home-widgets-3' ) || is_active_sidebar( 'home-widgets-4' ) || is_active_sidebar( 'home-widgets-5' ) || is_active_sidebar( 'home-widgets-6' ) ) {

		// Forces full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Adds centric-pro-home body class.
		add_filter( 'body_class', 'centric_body_class' );

		// Removes breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Removes the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Removes static page title.
		remove_action( 'genesis_before', 'centric_post_title' );

		// Adds home featured widget.
		add_action( 'genesis_after_header', 'centric_home_featured_widget', 1 );

		// Removes .site-inner
		add_filter( 'genesis_markup_site-inner', '__return_null' );
		add_filter( 'genesis_markup_content-sidebar-wrap_open', '__return_false' ); 
		add_filter( 'genesis_markup_content-sidebar-wrap_close', '__return_false' );
		add_filter( 'genesis_markup_content', '__return_null' );

		// Adds home widgets.
		add_action( 'genesis_before_footer', 'centric_home_widgets', 5 );

		// Adds support for structural wraps.
		add_theme_support( 'genesis-structural-wraps', array(
			'header',
			'nav',
			'subnav',
			'footer-widgets',
			'footer',
		) );

	}

}

/**
 * Defines the centric-pro-home body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function centric_body_class( $classes ) {

	$classes[] = 'centric-pro-home';

	return $classes;

}

/**
 * Adds markup for front page featured widget area.
 *
 * @since 1.0.0
 */
function centric_home_featured_widget() {

	genesis_widget_area( 'home-widgets-1', array(
		'before' => '<div class="home-featured"><div class="wrap"><div class="home-widgets-1 color-section widget-area">',
		'after'  => '</div></div></div>',
	) );

}

/**
 * Adds markup for front page widget areas.
 *
 * @since 1.0.0
 */
function centric_home_widgets() {

	echo '<div id="home-widgets" class="home-widgets">';

	genesis_widget_area( 'home-widgets-2', array(
		'before' => '<div class="home-widgets-2 widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-widgets-3', array(
		'before' => '<div class="home-widgets-3 color-section widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-widgets-4', array(
		'before' => '<div class="home-widgets-4 dark-section widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-widgets-5', array(
		'before' => '<div class="home-widgets-5 widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-widgets-6', array(
		'before' => '<div class="home-widgets-6 color-section widget-area">',
		'after'  => '</div>',
	) );

	echo '</div>';

}

// Runs the Genesis loop.
genesis();
