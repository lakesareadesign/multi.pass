<?php
/**
 * Parallax Pro.
 *
 * This file adds the front page to the Parallax Pro Theme.
 *
 * @package Parallax
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/parallax/
 */

add_action( 'genesis_meta', 'parallax_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function parallax_home_genesis_meta() {

	if ( is_active_sidebar( 'home-section-1' ) || is_active_sidebar( 'home-section-2' ) || is_active_sidebar( 'home-section-3' ) || is_active_sidebar( 'home-section-4' ) || is_active_sidebar( 'home-section-5' ) ) {

		// Enqueue parallax script.
		add_action( 'wp_enqueue_scripts', 'parallax_enqueue_parallax_script' );

		// Add parallax-home body class.
		add_filter( 'body_class', 'parallax_body_class' );

		// Force full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Remove primary navigation.
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

		// Remove breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets.
		add_action( 'genesis_loop', 'parallax_homepage_widgets' );

	}
}

// Remove skip link for primary navigation.
add_filter( 'genesis_skip_links_output', 'parallax_skip_links_output' );
function parallax_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}
	
	return $links;

}

// Add front page scripts.
function parallax_enqueue_parallax_script() {

	if ( ! wp_is_mobile() ) {
		wp_enqueue_script( 'parallax-script', get_stylesheet_directory_uri() . '/js/parallax.js', array( 'jquery' ), '1.0.0' );
	}

}

// Define parallax-home body class.
function parallax_body_class( $classes ) {

	$classes[] = 'parallax-home';

	return $classes;

}

// Add markup for homepage widgets.
function parallax_homepage_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'parallax-pro' ) . '</h2>';

	genesis_widget_area( 'home-section-1', array(
		'before' => '<div class="home-odd home-section-1 widget-area"><div class="full-height"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'home-section-2', array(
		'before' => '<div class="home-even home-section-2 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-3', array(
		'before' => '<div class="home-odd home-section-3 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-4', array(
		'before' => '<div class="home-even home-section-4 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-5', array(
		'before' => '<div class="home-odd home-section-5 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

// Run the Genesis loop.
genesis();
