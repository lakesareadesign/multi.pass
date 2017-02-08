<?php
/**
 * Wellness Pro.
 *
 * This file adds the front page to the Wellness Pro Theme.
 *
 * @package Wellness
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/wellness/
 */

add_action( 'genesis_meta', 'wellness_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function wellness_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' )  || is_active_sidebar( 'front-page-6' ) ) {

		// Enqueue scripts.
		add_action( 'wp_enqueue_scripts', 'wellness_enqueue_front_script_styles' );

		// Add front-page body class.
		add_filter( 'body_class', 'wellness_body_class' );

		// Hook sticky message before site header.
		add_action( 'genesis_before', 'wellness_sticky_message' );

		// Remove breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets.
		add_action( 'genesis_loop', 'wellness_front_page_widgets' );

		// Force full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

	}

}

// Define front page scripts.
function wellness_enqueue_front_script_styles() {

	wp_enqueue_script( 'wellness-front-script', get_stylesheet_directory_uri() . '/js/front-page.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'wellness-front-styles', get_stylesheet_directory_uri() . '/css/style-front.css' );

}

// Define front-page body class.
function wellness_body_class( $classes ) {

	$classes[] = 'front-page';

	return $classes;

}

// Add markup for the sticky message.
function wellness_sticky_message() {

	genesis_widget_area( 'sticky-message', array(
		'before' => '<div class="sticky-message widget-area"><div class="wrap">',
		'after'  => '<a class="dismiss dashicons dashicons-no-alt" href="#"><span class="screen-reader-text">Dismiss</span></a></div></div>',
	) );

}

// Add markup for front page widgets.
function wellness_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'wellness-pro' ) . '</h2>';

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1 image-section"><div class="flexible-widgets widget-area' . wellness_widget_area_class( 'front-page-1' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2"><div class="flexible-widgets widget-area' . wellness_widget_area_class( 'front-page-2' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3 image-section"><div class="flexible-widgets widget-area' . wellness_widget_area_class( 'front-page-3' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4"><div class="flexible-widgets widget-area' . wellness_widget_area_class( 'front-page-4' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-5', array(
		'before' => '<div id="front-page-5" class="front-page-5 image-section"><div class="flexible-widgets widget-area' . wellness_widget_area_class( 'front-page-5' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-6', array(
		'before' => '<div id="front-page-6" class="front-page-6"><div class="flexible-widgets widget-area' . wellness_widget_area_class( 'front-page-6' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

// Run the Genesis loop.
genesis();
