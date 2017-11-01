<?php
/**
 * Centric Pro.
 *
 * This file adds the landing page template to the Centric Pro Theme.
 *
 * Template Name: Landing
 *
 * @package Centric
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/centric/
 */

add_filter( 'body_class', 'centric_add_body_class' );
/**
 * Adds the landing page body class to the head.
 *
 * @since 1.0.0
 *
 * @param array $classes Current list of classes.
 * @return array New classes.
 */
function centric_add_body_class( $classes ) {

	$classes[] = 'centric-pro-landing';

	return $classes;

}

// Forces full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Removes site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Removes navigation.
remove_action( 'genesis_after_header', 'genesis_do_nav' );

// Removes breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Removes site footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Removes site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Runs the Genesis loop.
genesis();
