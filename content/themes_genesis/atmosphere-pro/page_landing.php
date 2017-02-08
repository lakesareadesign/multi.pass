<?php
/**
 * Atmosphere Pro.
 *
 * This file adds the Landing page template to the Atmosphere Pro Theme.
 *
 * Template Name: Landing
 *
 * @package Atmosphere
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/atmosphere/
 */

// Add landing body class to the head.
add_filter( 'body_class', 'atmosphere_add_body_class' );
function atmosphere_add_body_class( $classes ) {

	$classes[] = 'atmosphere-landing';

	return $classes;

}

// Remove skip links from a template.
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );

// Dequeue skip links script.
add_action( 'wp_enqueue_scripts', 'atmosphere_dequeue_skip_links' );
function atmosphere_dequeue_skip_links() {

	wp_dequeue_script( 'skip-links' );

}

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove site footer widgets.
remove_theme_support( 'genesis-footer-widgets' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Run the Genesis loop.
genesis();
