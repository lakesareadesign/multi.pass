<?php
/**
 * Home Page Template
 *
 * @package     FoodiePro
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2013, Shay Bocks
 * @license     GPL-2.0+
 * @since       1.0.1
 */

add_action( 'genesis_meta', 'foodie_pro_home_genesis_meta' );
/**
 * Add widget support for home page.
 * If no widgets active, display the default loop.
 *
 * @since 1.0.1
 */
function foodie_pro_home_genesis_meta() {
	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-bottom' ) ) {
		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		// Add a custom loop for the home page.
		add_action( 'genesis_loop', 'foodie_pro_home_loop_helper' );
	}
}

/**
 * Display the home page widgeted sections.
 *
 * @since 1.0.0
 */
function foodie_pro_home_loop_helper() {
	// Add the home top section if it has content.
	genesis_widget_area( 'home-top', array(
		'before' => '<div class="widget-area home-top">',
		'after'  => '</div> <!-- end .home-top -->',
	) );

	// Add the home middle section if it has content.
	genesis_widget_area( 'home-middle', array(
		'before' => '<div class="widget-area home-middle">',
		'after'  => '</div> <!-- end .home-middle -->',
	) );

	// Add the home bottom section if it has content.
	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="widget-area home-bottom">',
		'after'  => '</div> <!-- end .home-bottom -->',
	) );
}

genesis();
