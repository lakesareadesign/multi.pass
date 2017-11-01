<?php
/**
 * Authority Pro.
 *
 * This file adds the landing page template to the Authority Pro Theme.
 *
 * Template Name: Landing
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

add_filter( 'body_class', 'authority_add_body_class' );
/**
 * Adds the landing page body class to the head.
 *
 * @since 1.0.0
 *
 * @param array $classes Current list of classes.
 * @return array New classes.
 */
function authority_add_body_class( $classes ) {

	$classes[] = 'landing-page';

	return $classes;

}

// Removes skip links.
remove_action( 'genesis_before', 'genesis_skip_links', 5 );

add_action( 'wp_enqueue_scripts', 'authority_dequeue_skip_links' );
/**
 * Dequeues the skip links and top banner scripts.
 *
 * @since 1.0.0
 */
function authority_dequeue_skip_links() {

	wp_dequeue_script( 'skip-links' );
	wp_dequeue_script( 'top-banner-js' );

}

// Forces full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Removes top banner output and body classes.
remove_action( 'genesis_before', 'authority_do_top_banner' );
remove_action( 'body_class', 'top_banner_classes' );

// Removes site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Removes navigation.
remove_theme_support( 'genesis-menus' );

// Remove social navigation.
remove_action( 'genesis_before_header', 'authority_do_social_menu', 9 );

// Removes breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Removes footer widgets.
remove_action( 'genesis_before_footer', 'authority_footer_widgets' );

// Removes site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Runs the Genesis loop.
genesis();
