<?php
/**
 * This file adds the Custom Archives to the Refined Theme.
 *
 * @package      Refined
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 04/12/2017
 * @license      GPL-2.0+
 */

add_filter( 'body_class', 'refined_archives_body_class' );
/**
 * Adds a CSS class to the body element.
 *
 * @since 1.0.0
 *
 * @param  array $classes Array of body classes.
 * @return array $classes Updated array of body classes.
 */
function refined_archives_body_class( $classes ) {

	$classes[] = 'refined-archives';
	return $classes;

}

add_filter( 'post_class', 'refined_grid_post_class' );
/**
 * Display as Columns.
 *
 * @since 1.0.0
 *
 * @param  array $classes Array of post classes.
 * @return array $classes Updated array of post classes.
 */
function refined_grid_post_class( $classes ) {

	// Conditional to ensure that column classes do not apply to Featured widgets.
	if ( is_main_query() ) {

		$columns = 2;
		$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
		$classes[] = $column_classes[$columns];
		global $wp_query;

		if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % $columns ) {
			$classes[] = 'first';
		}

	}

	return $classes;

}

// Remove the breadcrumb navigation.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove the post info function.
remove_action( 'genesis_entry_header', 'genesis_post_info', 9 );

add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'refined_no_post_image' );
/**
 * Remove Featured image (if set in Theme Settings).
 *
 * @since 1.0.0
 */
function refined_no_post_image() {
	return '0';
}

add_action( 'genesis_entry_header', 'refined_archive_grid', 9 );
/**
 * Add the featured image before post title.
 *
 * @since 1.0.0
 */
function refined_archive_grid() {

    if ( $image = genesis_get_image( 'format=url&size=square-entry-image' ) ) {

        printf( '<div class="refined-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );

    }

}

add_filter( 'genesis_pre_get_option_content_archive', 'refined_show_excerpts' );
/**
 * Show Excerpts regardless of theme settings.
 *
 * @since 1.0.0
 */
function refined_show_excerpts() {
	return 'excerpts';
}

add_filter( 'excerpt_length', 'refined_excerpt_length' );
/**
 * Modify the length of post excerpts to the first 50 words.
 *
 * @since 1.0.0
 *
 * @param  int $length Default excerpt length.
 * @return int         New excerpt length.
 */
function refined_excerpt_length( $length ) {
	return 20;
}

add_filter( 'excerpt_more', 'refined_new_excerpt_more' );
/**
 * Modify the Excerpt read more link.
 *
 * @since 1.0.0
 *
 * @param  string $more Default more link HTML.
 * @return sring        New more link HTML.
 */
function refined_new_excerpt_more( $more ) {
	return '... <br><a class="more-link" href="' . get_permalink() . '">Read More</a>';
}

add_filter( 'genesis_pre_get_option_content_archive_limit', 'refined_no_content_limit' );
/**
 * Make sure content limit (if set in Theme settings) doesn't apply.
 *
 * @since 1.0.0
 */
function refined_no_content_limit() {
	return '0';
}

// Remove entry footer.
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

// Run Genesis.
genesis();
