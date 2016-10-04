<?php
/**
 * Twenty Seven.
 *
 * This file adds the landing page template to the Twentry Seven Pro Theme.
 *
 * @package Twenty Seven
 * @author  Brian Gardner
 * @license GPL-2.0+
 * @link    http://briangardner.com/
 */

//* Template Name: Landing

//* Add landing page body class to the head
add_filter( 'body_class', 'twenty_seven_add_body_class' );
function twenty_seven_add_body_class( $classes ) {

	$classes[] = 'landing-page';
	return $classes;

}

//* Remove skip links
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );

//* Dequeue skip links script
add_action( 'wp_enqueue_scripts', 'twenty_seven_dequeue_skip_links' );
function twenty_seven_dequeue_skip_links() {

	wp_dequeue_script( 'skip-links' );

}

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove sticky message widget area
remove_action( 'genesis_before', 'twenty_seven_sticky_message' );

//* Remove before header widget area
remove_action( 'genesis_before_header', 'twenty_seven_before_header' );

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//* Remove navigation
remove_theme_support( 'genesis-menus' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove before footer widget area
remove_action( 'genesis_before_footer', 'twenty_seven_before_footer' );

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();
