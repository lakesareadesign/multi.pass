<?php
/**
 * Template Name: Landing
 *
 * This file adds the Landing Page Template to the Refined Theme.
 *
 * @package      Refined
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 04/12/2017
 * @license      GPL-2.0+
 */

add_filter( 'body_class', 'refined_add_body_class' );
/**
 * Add custom body class to the head.
 *
 * @since 1.0.0
 *
 * @param  array $classes Array of body classes.
 * @return array $classes Updated array of body classes.
 */
function refined_add_body_class( $classes ) {

   $classes[] = 'refined-landing';
   return $classes;

}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove navigation.
remove_action( 'genesis_before_header', 'genesis_do_nav', 7 );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
remove_action( 'genesis_before_footer', 'refined_footer_menu', 7 );
remove_action( 'genesis_header', 'refined_header_right_menu', 9 );
remove_action( 'genesis_header', 'refined_header_left_menu', 6 );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove Announcement bar.
remove_action( 'genesis_before', 'refined_announcement_widget', 8 );

// Remove widget above footer.
remove_action( 'genesis_before_footer', 'refined_widget_above_content', 8 );

// Remove site footer widgets.
remove_action( 'genesis_before_footer', 'refined_footer_widgets', 9 );

// Remove widget below footer.
remove_action( 'genesis_before_footer', 'refined_widget_below_footer', 9 );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Run Genesis.
genesis();
