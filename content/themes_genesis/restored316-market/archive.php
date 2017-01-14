<?php
/**
 * This file adds the Custom Archives to the Market Theme.
 *
 * @package      Market
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 05/03/2016
 * @license      GPL-2.0+
 */

//* Adds a CSS class to the body element
add_filter( 'body_class', 'market_archives_body_class' );
function market_archives_body_class( $classes ) {

	$classes[] = 'market-archives';
	return $classes;

}

//* Display as Columns
add_filter( 'post_class', 'market_grid_post_class' );
function market_grid_post_class( $classes ) {

	if ( is_main_query() ) { // conditional to ensure that column classes do not apply to Featured widgets
		$columns = 2; // Set the number of columns here

		$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
		$classes[] = $column_classes[$columns];
		global $wp_query;
		if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % $columns )
			$classes[] = 'first';
	}

	return $classes;

}

//* Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 9 );

//* Remove Featured image (if set in Theme Settings)
add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'market_no_post_image' );
function market_no_post_image() {
	return '0';
}

//* Add the featured image before post title
add_action( 'genesis_entry_header', 'market_archive_grid', 9 );
function market_archive_grid() {

    if ( $image = genesis_get_image( 'format=url&size=blog-square-featured' ) ) {
        printf( '<div class="market-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );

    }

}

//* Show Excerpts regardless of Theme Settings
add_filter( 'genesis_pre_get_option_content_archive', 'market_show_excerpts' );
function market_show_excerpts() {
	return 'excerpts';
}

//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'market_excerpt_length' );
function market_excerpt_length( $length ) {
	return 20; // pull first 50 words
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

//* Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();