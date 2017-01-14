<?php
/**
 * This file adds the Landing Page to the Glam Theme.
 *
 * @package      Glam
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 02/03/2016
 * @license      GPL-2.0+
 */
 
//* This theme contains intellectual property owned by Restored 316 LLC, including trademarks, copyrights, proprietary information, and other intellectual property. You may not modify, publish, transmit, participate in the transfer or sale of, create derivative works from, distribute, reproduce or perform, or in any way exploit in any format whatsoever any of this theme or intellectual property, in whole or in part, without our prior written consent.

/*
Template Name: Landing
*/

//* Add landing body class to the head
add_filter( 'body_class', 'glam_add_landing_body_class' );
function glam_add_landing_body_class( $classes ) {

	$classes[] = 'glam-landing';
	return $classes;

}

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_before', 'widget_above_header'  );

//* Remove navigation
remove_action( 'genesis_before', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove site footer widgets
remove_action( 'genesis_after', 'genesis_footer_widget_areas' );

//* Remove site footer elements
remove_action( 'genesis_after', 'genesis_footer_markup_open', 11 );
remove_action( 'genesis_after', 'genesis_do_footer', 12 );
remove_action( 'genesis_after', 'genesis_footer_markup_close', 14 ); 
remove_action( 'genesis_after', 'glam_footer_menu', 13 );

//* Remove widget area before content
remove_action( 'genesis_before_content', 'glam_cta_widget', 2  );

//* Run the Genesis loop
genesis();
