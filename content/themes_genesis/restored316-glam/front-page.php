<?php
/**
 * This file adds the Home Page to the Glam Theme.
 *
 * @package      Glam
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 02/03/2016
 * @license      GPL-2.0+
 */
 
//* This theme contains intellectual property owned by Restored 316 LLC, including trademarks, copyrights, proprietary information, and other intellectual property. You may not modify, publish, transmit, participate in the transfer or sale of, create derivative works from, distribute, reproduce or perform, or in any way exploit in any format whatsoever any of this theme or intellectual property, in whole or in part, without our prior written consent.
 
//* Add widget support for homepage. If no widgets active, display the default loop.
add_action( 'genesis_meta', 'glam_home_genesis_meta' );
function glam_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top-slider' ) || is_active_sidebar( 'home-flexible' ) ) {

		add_action( 'genesis_before_content_sidebar_wrap', 'glam_home_sections', 1 );
		//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
		add_filter( 'body_class', 'glam_add_home_body_class' );
		
		//* Remove default loop & sidebar (remove the // symbols in front of the next two lines to remove the default blog loop and sidebar from the home page of Glam.)
		//remove_action( 'genesis_loop', 'genesis_do_loop' );
		//remove_action( 'genesis_sidebar', 'genesis_do_sidebar' ); 
		
		//* Add body class to home page		
		function glam_add_home_body_class( $classes ) {

			$classes[] = 'glam-home';
			return $classes;
	
		}

	}
	
}

function glam_home_sections() {

if( !is_paged()) {

		echo '<div class="home-top">';

		genesis_widget_area( 'home-top-slider', array(
			'before' => '<div class="home-top-slider widget-area">',
			'after'  => '</div>',
		) );

		echo '</div>';

		genesis_widget_area( 'home-flexible', array(
		'before' => '<div id="home-flexible" class="home-flexible"><div class="widget-area ' . glam_widget_area_class( 'home-flexible' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );
		
}}

//* Remove Featured image (if set in Theme Settings)
add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'glam_no_post_image' );
function glam_no_post_image() {
	return '0';
}

//* Show Excerpts regardless of Theme Settings
add_filter( 'genesis_pre_get_option_content_archive', 'glam_show_excerpts' );
function glam_show_excerpts() {
	return 'excerpts';
}

//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'glam_excerpt_length' );
function glam_excerpt_length( $length ) {
	return 60; // pull first 50 words
}

//* Modify the Excerpt read more link
add_filter('excerpt_more', 'glam_new_excerpt_more');
function glam_new_excerpt_more($more) {
	return '... <a class="more-link" href="' . get_permalink() . '">View Post</a>';
}

//* Make sure content limit (if set in Theme Settings) doesn't apply
add_filter( 'genesis_pre_get_option_content_archive_limit', 'glam_no_content_limit' );
function glam_no_content_limit() {
	return '0';
}

//* Display centered wide featured image for First Post and left aligned thumbnail for the next five
add_action( 'genesis_entry_header', 'glam_show_featured_image', 8 );
function glam_show_featured_image() {
	if ( ! has_post_thumbnail() ) {
		return;
	}

	global $wp_query;

	if( ( $wp_query->current_post <= 0 ) ) {
		$image_args = array(
			'size' => 'large-featured',
			'attr' => array(
				'class' => 'aligncenter',
			),
		);
	
	} else {
		$image_args = array(
			'size' => 'blog-square-featured',
			'attr' => array(
				'class' => 'alignleft',
			),
		);
	}

	$image = genesis_get_image( $image_args );

	echo '<div class="home-featured-image"><a href="' . get_permalink() . '">' . $image .'</a></div>';
}

//* Remove entry meta
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();