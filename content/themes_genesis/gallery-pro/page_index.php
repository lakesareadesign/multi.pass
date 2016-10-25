<?php

/*
Template Name: Index
*/


//* Adds a CSS class to the body element
add_filter( 'body_class', 'bbs_index_body_class' );
function bbs_index_body_class( $classes ) {

	$classes[] = 'bbs-index';
	return $classes;

}

//* Adds widget support for category index.
add_action( 'genesis_meta', 'bbs_index_genesis_meta' );
function bbs_index_genesis_meta() {

	if ( is_active_sidebar( 'page-index' )) {

		//* Remove the genesis default loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add the widget area
		add_action( 'genesis_loop', 'bbs_index_widget_area' );

	}

}

//* Load the widget area
function bbs_index_widget_area() {

	genesis_widget_area( 'page-index', array(
		'before' => '<div class="page-index widget-area">',
		'after'  => '</div>',
	) );

}

genesis();
