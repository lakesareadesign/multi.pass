<?php
/**
 * This file adds the Landing template to the Daily Dish Pro Theme.
 *
 * @author StudioPress
 * @package Daily Dish Pro
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

//* Add landing body class to the head
add_filter( 'body_class', 'daily_dish_add_body_class' );
function daily_dish_add_body_class( $classes ) {

	$classes[] = 'daily-dish-landing';
	return $classes;

}

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove before header area
remove_action( 'genesis_before', 'daily_dish_before_header' );

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//* Remove navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_before_header', 'genesis_do_subnav' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove before footer widget area
remove_action( 'genesis_before_footer', 'daily_dish_before_footer_widgets', 5 );

//* Remove site footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Remove after footer widget area
remove_action( 'genesis_after', 'daily_dish_after_footer' );

//* Run the Genesis loop
genesis();
