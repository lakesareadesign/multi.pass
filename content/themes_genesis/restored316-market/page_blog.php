<?php
/**
 * This file adds the blog page template to the Market theme.
 *
 * @package      Market
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 05/03/2016
 * @license      GPL-2.0+
 */

/*
Template Name: Blog Page
*/

//* Add archive body class to the head
add_filter( 'body_class', 'market_add_archive_body_class' );
function market_add_archive_body_class( $classes ) {
   $classes[] = 'market-archive';
   return $classes;
}

//* Remove featured image from the blog page template
remove_action( 'genesis_after_header','market_relocate_entry_title_pages' );

//* Hooks Slider Above Blog Content
add_action( 'genesis_before_loop', 'market_above_blog_slider'  ); 
function market_above_blog_slider() {
    
    genesis_widget_area( 'above-blog-slider', array(
		'before' => '<div class="above-blog-slider widget-area">',
		'after'  => '</div>',
    ) );

}

//* Remove Featured image (if set in Theme Settings)
add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'market_no_post_image' );
function market_no_post_image() {
	return '0';
}

//* Show Excerpts regardless of Theme Settings
add_filter( 'genesis_pre_get_option_content_archive', 'market_show_excerpts' );
function market_show_excerpts() {
	return 'excerpts';
}

//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'market_excerpt_length' );
function market_excerpt_length( $length ) {
	return 60; // pull first 50 words
}

//* Modify the Excerpt read more link
add_filter('excerpt_more', 'market_new_excerpt_more');
function market_new_excerpt_more($more) {
	return '... <br><a class="more-link" href="' . get_permalink() . '">Read More</a>';
}

//* Make sure content limit (if set in Theme Settings) doesn't apply
add_filter( 'genesis_pre_get_option_content_archive_limit', 'market_no_content_limit' );
function market_no_content_limit() {
	return '0';
}

//* Display centered wide featured image for First Post and left aligned thumbnail for the next five
add_action( 'genesis_entry_header', 'market_show_featured_image', 8 );
function market_show_featured_image() {
	if ( ! has_post_thumbnail() ) {
		return;
	}

	global $wp_query;

	if( ( $wp_query->current_post <= 0 ) ) {
		$image_args = array(
			'size' => 'blog-entry-image',
			'attr' => array(
				'class' => 'aligncenter',
			),
		);
	
	} else {
		$image_args = array(
			'size' => 'square-entry-image',
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