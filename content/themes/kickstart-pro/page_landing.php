<?php
/**
 * Kickstart Pro
 *
 * @author  Lean Themes
 * @license GPL-2.0+
 * @link    http://demo.leanthemes.co/kickstart/
 */

// Template Name: Landing

add_filter( 'body_class', 'kickstart_add_body_class' );
// Add custom body class to the head
function kickstart_add_body_class( $classes ) {
   $classes[] = 'page-landing';

   return $classes;
}

// Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );
remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );

// Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove site footer widgets
remove_action( 'genesis_before_footer', 'kickstart_before_footer', 5 );
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_before_footer', 'kickstart_footer_social', 15 );

// Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

genesis();
