<?php
/**
 * This file adds the Landing template to the Wintersong Pro Theme.
 *
 * @author StudioPress
 * @package Wintersong Pro
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

//* Add landing body class to the head
add_filter( 'body_class', 'wintersong_add_body_class' );
function wintersong_add_body_class( $classes ) {

	$classes[] = 'wintersong-landing';
	return $classes;

}

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove Wintersong site Gravatar
remove_action( 'genesis_header', 'wintersong_site_gravatar', 5 );

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//* Remove navigation
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove site footer elements
remove_action( 'genesis_header', 'genesis_footer_markup_open', 11 );
remove_action( 'genesis_header', 'genesis_do_footer', 12 );
remove_action( 'genesis_header', 'genesis_footer_markup_close', 13 );

//* Run the Genesis loop
genesis();
