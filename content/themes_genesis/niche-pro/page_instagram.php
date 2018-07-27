<?php
/**
 * Niche Pro.
 *
 * This file adds the instagram page template to the Niche Pro Theme.
 *
 * Template Name: Instagram
 *
 * @package Niche
 * @author  Bloom
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/niche/
 */

// Add landing body class to the head.
add_filter( 'body_class', 'bloom_add_body_class' );
function bloom_add_body_class( $classes ) {

	$classes[] = 'bloom-instagram';
	return $classes;

}

// Force full-width-content layout.
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove Instagram feed.
remove_action( 'genesis_before_header', 'instagram', 3 );

// Remove site header elements.
// remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
// remove_action( 'genesis_header', 'genesis_do_header' );
// remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove site footer widgets.
remove_theme_support( 'genesis-footer-widgets' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Adds widget support for category index.
add_action( 'genesis_meta', 'bloom_instagram_genesis_meta' );
function bloom_instagram_genesis_meta() {

	if ( is_active_sidebar( 'page-instagram' ) ) {

		// * Remove the genesis default loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// * Add the widget area.
		add_action( 'genesis_loop', 'bloom_instagram_widget_area' );

	}

}

// Load the widget area.
function bloom_instagram_widget_area() {

	genesis_widget_area(
		'page-instagram', array(
			'before' => '<div class="page-instagram widget-area">',
			'after'  => '</div>',
		)
	);

}

genesis();