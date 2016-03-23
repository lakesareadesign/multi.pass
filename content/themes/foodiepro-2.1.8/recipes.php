<?php
/**
 * Template Name: Recipe Index
 *
 * @package     FoodiePro
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2013, Shay Bocks
 * @license     GPL-2.0+
 * @since       1.0.1
 */

add_action( 'genesis_meta', 'foodie_pro_recipes_genesis_meta' );
/**
 * Add widget support for recipes page.
 * If no widgets active, display the default page content.
 *
 * @since 1.0.1
 */
function foodie_pro_recipes_genesis_meta() {
	if ( is_active_sidebar( 'recipes-top' ) || is_active_sidebar( 'recipes-bottom' ) ) {
		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		// Add a custom loop for the home page.
		add_action( 'genesis_loop', 'foodie_pro_recipes_loop_helper' );
	}
}

/**
 * Display the recipe page widgeted sections.
 *
 * @since 1.0.0
 */
function foodie_pro_recipes_loop_helper() {
	genesis_widget_area( 'recipes-top',  array(
		'before' => '<div class="widget-area recipes-top">',
		'after'  => '</div> <!-- end .recipes-top -->',
	) );

	genesis_widget_area( 'recipes-bottom', array(
		'before' => '<div class="widget-area recipes-bottom">',
		'after'  => '</div> <!-- end .recipes-bottom -->',
	) );
}

genesis();
