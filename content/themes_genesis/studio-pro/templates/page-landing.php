<?php
/**
 * Template Name: Landing Page
 *
 * This file adds the landing page template to the Studio Pro Theme.
 *
 * @package Studio Pro
 * @author  SeoThemes
 * @license GPL-2.0+
 * @link    https://seothemes.com/themes/studio-pro
 */

/**
 * Add landing page body class to the head.
 *
 * @param  array $classes Array of body classes.
 * @return array $classes Array of body classes.
 */
function studio_add_body_class( $classes ) {
	$classes[] = 'landing-page';
	return $classes;
}
add_filter( 'body_class', 'studio_add_body_class' );

// Remove Skip Links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );

/**
 * Dequeue Skip Links Script.
 */
function studio_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}
add_action( 'wp_enqueue_scripts', 'studio_dequeue_skip_links' );

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_header', 'studio_header_right_widget_area', 14 );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove widget areas.
remove_action( 'genesis_header', 'studio_before_header_widget_area', 5 );
remove_action( 'genesis_before_footer', 'studio_before_footer_widget_area', 5 );
remove_action( 'genesis_before_footer', 'studio_before_footer_widget_area' );

// Remove footer widgets.
remove_theme_support( 'genesis-footer-widgets' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'studio_footer_menu', 7 );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Run the Genesis loop.
genesis();
