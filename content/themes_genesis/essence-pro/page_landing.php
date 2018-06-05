<?php
/**
 * Essence Pro.
 *
 * This file adds the landing page template to the Essence Pro Theme.
 *
 * Template Name: Landing
 *
 * @package Essence_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/essence/
 */

add_filter( 'body_class', 'essence_add_body_class' );
/**
 * Adds landing page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function essence_add_body_class( $classes ) {

	$classes[] = 'landing-page';
	return $classes;

}

// Removes skip links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );

add_action( 'wp_enqueue_scripts', 'essence_dequeue_skip_links' );
/**
 * Dequeues Skip Links Script.
 *
 * @since 1.0.0
 */
function essence_dequeue_skip_links() {

	wp_dequeue_script( 'skip-links' );

}

// Forces full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Removes site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

remove_action( 'genesis_header', 'essence_header_right_menu', 9 );
remove_action( 'genesis_header', 'essence_header_left_widget', 9 );

// Removes navigation.
remove_theme_support( 'genesis-menus' );

// Removes breadcrumbs.
remove_action( 'genesis_after_header', 'genesis_do_breadcrumbs', 90 );

// Removes footer widgets.
remove_action( 'genesis_before_footer', 'essence_footer_widgets' );

remove_action( 'genesis_before_footer', 'essence_after_content_featured', 13 );
remove_action( 'genesis_before_footer', 'essence_footer_cta', 17 );

// Removes site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Runs the Genesis loop.
genesis();
