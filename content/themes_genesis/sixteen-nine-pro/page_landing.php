<?php
/**
 * This file adds the Landing template to the Sixteen Nine Pro Theme.
 *
 * @author StudioPress
 * @package Sixteen Nine Pro
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

//* Add landing body class to the head
add_filter( 'body_class', 'sixteen_nine_add_body_class' );
function sixteen_nine_add_body_class( $classes ) {

	$classes[] = 'sixteen-nine-landing';
	return $classes;

}

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Remove Sixteen Nine site Gravatar
remove_action( 'genesis_header', 'sixteen_nine_site_gravatar', 5 );

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

//* Remove site footer elements
remove_action( 'genesis_header', 'genesis_footer_markup_open', 11 );
remove_action( 'genesis_header', 'genesis_do_footer', 12 );
remove_action( 'genesis_header', 'genesis_footer_markup_close', 13 );

//* Run the Genesis loop
genesis();
