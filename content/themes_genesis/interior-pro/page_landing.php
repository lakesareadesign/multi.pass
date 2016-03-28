<?php
/**
 * Interior Pro.
 *
 * This file adds the landing page template to the Interior Pro Theme.
 *
 * @package Interior
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/interior/
 */

//* Template Name: Landing

//* Add landing body class to the head
add_filter( 'body_class', 'interior_add_body_class' );
function interior_add_body_class( $classes ) {

	$classes[] = 'interior-landing';

	return $classes;

}

//* Remove Skip Links
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );

//* Dequeue Skip Links Script
add_action('wp_enqueue_scripts','interior_dequeue_myscript');
function interior_dequeue_myscript() {

	wp_dequeue_script( 'skip-links' );

}

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_after_header', 'interior_open_after_header', 5 );
remove_action( 'genesis_after_header', 'interior_close_after_header', 15 );

//* Remove navigation
remove_theme_support( 'genesis-menus' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove site footer widgets
remove_action( 'genesis_before_footer', 'interior_footer_widgets' );

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Run the Genesis loop
genesis();
