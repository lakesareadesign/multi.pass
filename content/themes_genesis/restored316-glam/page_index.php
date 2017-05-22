<?php
/**
 * This file adds the Category Index to the Glam Theme.
 *
 * @package      Glam
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 02/03/2016
 * @license      GPL-2.0+
 */
 
/* Template Name: Category Index */

//* Adds a CSS class to the body element
add_filter( 'body_class', 'archives_body_class' );
function archives_body_class( $classes ) {

	$classes[] = 'posts-archive';
	return $classes;

}

//* Adds widget support for category index.  If no widgets are active, display the default loop.
add_action( 'genesis_meta', 'glam_category_genesis_meta' );
function glam_category_genesis_meta() {

	if ( is_active_sidebar( 'category-index' )) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'glam_category_sections' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

	}
	
}

function glam_category_sections() {

	genesis_widget_area( 'category-index', array(
		'before' => '<div class="category-index widget-area">',
		'after'  => '</div>',
	) );
	
}

genesis();