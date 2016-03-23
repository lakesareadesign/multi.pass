<?php
/**
 * This file adds the Home Page to the Daily Dish Pro Child Theme.
 *
 * @author StudioPress
 * @package Daily Dish Pro
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'daily_dish_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function daily_dish_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-bottom' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_site_layout', '__genesis_return_content_sidebar' );

		// Add daily-dish-home body class
		add_filter( 'body_class', 'daily_dish_body_class' );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets
		add_action( 'genesis_loop', 'daily_dish_homepage_widgets' );

	}

}

function daily_dish_body_class( $classes ) {

	$classes[] = 'daily-dish-home';
	return $classes;
	
}

function daily_dish_homepage_widgets() {

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-middle', array(
		'before' => '<div class="home-middle widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="home-bottom widget-area">',
		'after'  => '</div>',
	) );

}

genesis();
