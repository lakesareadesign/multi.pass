<?php
/**
 * AgentPress Pro.
 *
 * This file adds the landing page template to the AgentPress Pro Theme.
 *
 * Template Name: Landing
 *
 * @package AgentPress
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/agencypress/
 */

// Add custom body class to the head.
add_filter( 'body_class', 'agentpress_add_body_class' );
function agentpress_add_body_class( $classes ) {

	$classes[] = 'agentpress-pro-landing';

	return $classes;

}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation.
remove_action( 'genesis_before_header', 'genesis_do_nav' );

// Remove breadcrumbs.
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );

// Remove site footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'agentpress_disclaimer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Run the Genesis loop.
genesis();
