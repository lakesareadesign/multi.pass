<?php
/**
 * Daily Dish Pro.
 *
 * This file adds the front page to the Daily Dish Pro Theme.
 *
 * @package Daily Dish Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/daily-dish/
 */

add_action( 'genesis_meta', 'daily_dish_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function daily_dish_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-bottom' ) ) {

		// Force content-sidebar layout setting.
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

		// Add daily-dish-home body class.
		add_filter( 'body_class', 'daily_dish_body_class' );

		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets.
		add_action( 'genesis_loop', 'daily_dish_homepage_widgets' );

	}

}

/**
 * Define daily-dish-home body class.
 *
 * @param array $classes Current body classes.
 * @since 1.0.0
 *
 * @return array Modified body classes.
 */
function daily_dish_body_class( $classes ) {

	$classes[] = 'daily-dish-home';

	return $classes;

}

/**
 * Output front page widget areas.
 *
 * @since 1.0.0
 */
function daily_dish_homepage_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'daily-dish-pro' ) . '</h2>';

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

// Run Genesis loop.
genesis();
