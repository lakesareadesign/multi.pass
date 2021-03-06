<?php
/**
 * Niche Pro.
 *
 * This file adds the index page template to the Niche Pro Theme.
 *
 * Template Name: Index
 *
 * @package Niche
 * @author  Bloom
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/niche/
 */

// Adds a CSS class to the body element.
add_filter( 'body_class', 'bloom_index_body_class' );
function bloom_index_body_class( $classes ) {

	$classes[] = 'bloom-index';
	return $classes;

}

// Adds widget support for category index.
add_action( 'genesis_meta', 'bloom_index_genesis_meta' );
function bloom_index_genesis_meta() {

	if ( is_active_sidebar( 'page-index' ) ) {

		// * Remove the genesis default loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// * Add the widget area.
		add_action( 'genesis_loop', 'bloom_index_widget_area' );

	}

}

// Load the widget area.
function bloom_index_widget_area() {

	genesis_widget_area(
		'page-index', array(
			'before' => '<div class="page-index flexible-widgets widget-area">',
			'after'  => '</div>',
		)
	);

}

genesis();
