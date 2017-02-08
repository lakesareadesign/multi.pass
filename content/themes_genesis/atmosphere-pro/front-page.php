<?php
/**
 * Atmosphere Pro.
 *
 * This file adds the front page to the Atmosphere Pro Theme.
 *
 * @package Atmosphere
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/atmosphere/
 */

add_action( 'genesis_meta', 'atmosphere_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function atmosphere_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) ) {

		// Enqueue scripts.
		add_action( 'wp_enqueue_scripts', 'atmosphere_enqueue_atmosphere_script' );

		// Enqueue scripts for backstretch.
		add_action( 'wp_enqueue_scripts', 'atmosphere_front_page_backstretch_scripts' );

		// Add front-page body class.
		add_filter( 'body_class', 'atmosphere_body_class' );

		// Remove breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets.
		add_action( 'genesis_loop', 'atmosphere_front_page_widgets' );

	}

}

// Add front page scripts.
function atmosphere_enqueue_atmosphere_script() {

	wp_enqueue_script( 'atmosphere-front-script', get_stylesheet_directory_uri() . '/js/front-page.js', array( 'jquery' ), CHILD_THEME_VERSION );

	wp_enqueue_style( 'atmosphere-front-styles', get_stylesheet_directory_uri() . '/style-front.css' );

}

// Add front page backstretch scripts.
function atmosphere_front_page_backstretch_scripts() {

	$image = get_option( 'atmosphere-front-image', sprintf( '%s/images/front-page-1.jpg', get_stylesheet_directory_uri() ) );

	if ( empty( $image ) ) {

		// Add no-image body class.
		add_filter( 'body_class', 'atmosphere_image_body_class' );

	}

	// Load scripts only if custom backstretch image is being used.
	if ( ! empty( $image ) && is_active_sidebar( 'front-page-1' ) ) {

		// Enqueue Backstretch scripts.
		wp_enqueue_script( 'atmosphere-backstretch', get_stylesheet_directory_uri() . '/js/backstretch.js', array( 'jquery' ), '1.0.0' );
		wp_enqueue_script( 'atmosphere-backstretch-set', get_stylesheet_directory_uri() . '/js/backstretch-set.js' , array( 'jquery', 'atmosphere-backstretch' ), '1.0.0' );

		wp_localize_script( 'atmosphere-backstretch-set', 'BackStretchImg', array( 'src' => str_replace( 'http:', '', $image ) ) );

	}

}

// Define front-page body class.
function atmosphere_body_class( $classes ) {

	$classes[] = 'front-page';

	return $classes;

}

// Define no-image body class.
function atmosphere_image_body_class( $classes ) {

	$classes[] = 'no-image';

	return $classes;

}

// Add markup for front page widgets.
function atmosphere_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'atmosphere-pro' ) . '</h2>';

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1"><div class="widget-area"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2"><div class="flexible-widgets widget-area' . atmosphere_widget_area_class( 'front-page-2' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	// Add entry-title filter.
	add_filter( 'the_title', 'atmosphere_title' );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3"><div class="widget-area"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	// Remove entry-title filter.
	remove_filter( 'the_title', 'atmosphere_title' );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4"><div class="flexible-widgets widget-area' . atmosphere_widget_area_class( 'front-page-4' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

// Run the Genesis loop.
genesis();
