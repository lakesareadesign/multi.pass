<?php
/**
 * Modern Portfolio Pro.
 *
 * This file adds the landing page template to the Modern Portfolio Pro Theme.
 *
 * Template Name: Landing
 *
 * @package Modern Portfolio
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/modern-portfolio/
 */

add_filter( 'body_class', 'modern_portfolio_add_body_class' );
/**
 * Adds the landing page body class to the head.
 *
 * @since 1.0.0
 *
 * @param array $classes Current list of classes.
 * @return array New classes.
 */
function modern_portfolio_add_body_class( $classes ) {

	$classes[] = 'mpp-landing';

	return $classes;

}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove site footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Runs the Genesis loop.
genesis();
