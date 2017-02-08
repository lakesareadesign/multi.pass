<?php
/**
 * Daily Dish Pro.
 *
 * This file adds the landing page template to the Daily Dish Pro Theme.
 *
 * Template Name: Landing
 *
 * @package Daily Dish Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/daily-dish/
 */

// Add landing body class to the head.
add_filter( 'body_class', 'daily_dish_add_body_class' );
function daily_dish_add_body_class( $classes ) {

	$classes[] = 'daily-dish-landing';

	return $classes;

}

// Remove Skip Links.
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );

// Dequeue Skip Links Script.
add_action( 'wp_enqueue_scripts', 'daily_dish_dequeue_skip_links' );
function daily_dish_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove before header area.
remove_action( 'genesis_before_header', 'daily_dish_before_header', 5 );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove before footer widget area.
remove_action( 'genesis_before_footer', 'daily_dish_before_footer_widgets', 5 );

// Remove site footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Remove after footer widget area.
remove_action( 'genesis_after_footer', 'daily_dish_after_footer' );

// Run the Genesis loop.
genesis();
