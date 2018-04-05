<?php
/**
 * Template Name: Recipe Index
 *
 * @package   FoodiePro
 * @copyright Copyright (c) 2018, Feast Design Co.
 * @license   GPL-2.0+
 * @since     1.0.1
 */

add_action( 'genesis_meta', 'foodie_pro_recipes_genesis_meta' );
/**
 * Add widget support for recipes page.
 * If no widgets active, display the default page content.
 *
 * @since 1.0.1
 */
function foodie_pro_recipes_genesis_meta() {
	if ( is_active_sidebar( 'recipe-index-search' ) || is_active_sidebar( 'recipe-index-featured-posts' ) ) {
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
	genesis_widget_area( 'recipe-index-search',  array(
		'before' => '<div class="widget-area recipe-index-search">',
		'after'  => '</div> <!-- end .recipe-index-search -->',
	) );

	genesis_widget_area( 'recipe-index-featured-posts', array(
		'before' => '<div class="widget-area recipe-index-featured-posts">',
		'after'  => '</div> <!-- end .recipe-index-featured-posts -->',
	) );
}

genesis();
