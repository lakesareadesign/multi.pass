<?php
/**
 * This file adds the Landing page template to the Modern Studio Theme.
 *
 * @author StudioPress
 * @package Modern Studio Theme
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

//* Add landing body class to the head
add_filter( 'body_class', 'ms_add_body_class' );
function ms_add_body_class( $classes ) {

	$classes[] = 'ms-landing';
	return $classes;

}

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove sticky message before site header
remove_action( 'genesis_before', 'ms_sticky_message' );

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//* Reomove Navigation Container
remove_action( 'genesis_after_header', 'ms_menus_container' );

//* Remove Primary (Left) Navigation
remove_action( 'ms_menus', 'genesis_do_nav' );

//* Remove Secondary (Right) Navigation
remove_action( 'ms_menus', 'genesis_do_subnav' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove site footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

//* Remove site footer elements
remove_action( 'genesis_after', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_after', 'genesis_do_footer' );
remove_action( 'genesis_after', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();
