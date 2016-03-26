<?php
/**
 * This file adds the Landing page template to the Stretch theme.
 *
 * @author StudioPress
 * @package Stretch
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

// Add custom body class to the head
add_filter( 'body_class', 'stretch_add_body_class' );
function stretch_add_body_class( $classes ) {
   $classes[] = 'stretch-landing';
   return $classes;
}

// Remove header, navigation, breadcrumbs, footer 
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

genesis();