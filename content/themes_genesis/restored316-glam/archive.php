<?php
/**
 * This file adds the Custom Archives to the Glam Theme.
 *
 * @package      Glam
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 02/03/2016
 * @license      GPL-2.0+
 */

//* Adds a CSS class to the body element
add_filter( 'body_class', 'archives_body_class' );
function archives_body_class( $classes ) {

	$classes[] = 'posts-archive';
	return $classes;

}

//* Display as Columns
add_filter( 'post_class', 'glam_grid_post_class' );
function glam_grid_post_class( $classes ) {

	if ( is_main_query() ) { // conditional to ensure that column classes do not apply to Featured widgets
		$columns = 3; // Set the number of columns here

		$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
		$classes[] = $column_classes[$columns];
		global $wp_query;
		if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % $columns )
			$classes[] = 'first';
	}

	return $classes;

}

//* Remove Featured image (if set in Theme Settings)
add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'glam_no_post_image' );
function glam_no_post_image() {
	return '0';
}

//* Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 12);

//* Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Remove the post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

//* Remove between posts widget
remove_action( 'genesis_after_entry', 'glam_between_posts_area' );

//* Add the featured image before post title
add_action( 'genesis_entry_header', 'glam_archive_grid', 9 );
function glam_archive_grid() {

    if ( $image = genesis_get_image( 'format=url&size=blog-square-featured' ) ) {
        printf( '<div class="glam-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );

    }

}

//* Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();