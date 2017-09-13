<?php
/**
 * Outfitter Pro.
 *
 * This file adds the landing page template to the Outfitter Pro Theme.
 *
 * Template Name: Landing
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

// Adds the landing page body class to the head.
add_filter( 'body_class', 'outfitter_add_body_class' );
function outfitter_add_body_class( $classes ) {

	$classes[] = 'landing-page';
	return $classes;

}

// Removes skip links.
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );

// Dequeues the skip links script.
add_action( 'wp_enqueue_scripts', 'outfitter_dequeue_skip_links' );
function outfitter_dequeue_skip_links() {

	wp_dequeue_script( 'skip-links' );

}

// Removes Header Icons
remove_action( 'genesis_meta', 'outfitter_setup_header_icons' );

// Forces full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Removes site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Removes navigation.
remove_theme_support( 'genesis-menus' );

// Removes breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Removes footer widgets.
remove_action( 'genesis_before_footer', 'outfitter_footer_widgets' );

// Removes site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Runs the Genesis loop.
genesis();
