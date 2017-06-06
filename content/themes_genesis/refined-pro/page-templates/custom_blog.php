<?php
/**
 * Template Name: Custom Blog
 *
 * This file adds the blog page template to the Refined theme.
 *
 * @package      Refined
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 04/12/2017
 * @license      GPL-2.0+
 */

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'refined_do_custom_loop' );
/**
 * Replace the standard loop with our custom loop.
 *
 * @since 1.0.0
 */
function refined_do_custom_loop() {

    global $paged; // current paginated page
    global $query_args; // grab the current wp_query() args
    $args = array(
        'paged'            => $paged, // respect pagination
    );

    genesis_custom_loop( wp_parse_args($query_args, $args) );

}

add_filter( 'body_class', 'refined_add_archive_body_class' );
/**
 * Add archive body class to the head.
 *
 * @since 1.0.0
 *
 * @param  array $classes Array of default body classes.
 * @return array $classes Updated array of body classes.
 */
function refined_add_archive_body_class( $classes ) {
   $classes[] = 'refined-blog';
   return $classes;
}

add_action( 'genesis_after_header', 'refined_above_blog_content'  );
/**
 * Adds flexible featured content above content on Blog Page Template.
 *
 * @since 1.0.0
 */
function refined_above_blog_content() {

    genesis_widget_area( 'above-blog-content', array(
		'before' => '<div id="above-blog-content" class="above-blog-content"><div class="wrap"><div class="flexible-widgets widget-area' . refined_widget_area_class( 'above-blog-content' ) . '">',
		'after'  => '</div></div></div>',
	) );

}

add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'refined_no_post_image' );
/**
 * Remove Featured image (if set in Theme Settings).
 *
 * @since 1.0.0
 */
function refined_no_post_image() {
	return '0';
}

add_filter( 'genesis_pre_get_option_content_archive', 'refined_show_excerpts' );
/**
 * Show Excerpts regardless of Theme Settings.
 *
 * @since 1.0.0
 */
function refined_show_excerpts() {
	return 'excerpts';
}

add_filter( 'excerpt_length', 'refined_excerpt_length' );
/**
 * Modify the length of post excerpts.
 *
 * @since 1.0.0
 *
 * @param  int $length Length of excerpt.
 * @return int         New length of excerpt.
 */
function refined_excerpt_length( $length ) {
	return 60; // Pull first 50 words.
}

add_filter('excerpt_more', 'refined_new_excerpt_more');
/**
 * Modify the Excerpt read more link.
 *
 * @since 1.0.0
 *
 * @param  string $more Default more link HTML.
 * @return string       New more link HTML.
 */
function refined_new_excerpt_more($more) {
	return '... <br><a class="more-link" href="' . get_permalink() . '">Read More</a>';
}

add_filter( 'genesis_pre_get_option_content_archive_limit', 'refined_no_content_limit' );
/**
 * Make sure content limit (if set in Theme Settings) doesn't apply.
 *
 * @since 1.0.0
 */
function refined_no_content_limit() {
	return '0';
}

add_action( 'genesis_entry_header', 'refined_show_featured_image', 8 );
/**
 * Display centered wide featured image for First Post
 * and left aligned thumbnail for the next five.
 *
 * @since 1.0.0
 */
function refined_show_featured_image() {

	if ( ! has_post_thumbnail() ) {
		return;
	}

	global $wp_query;

	if( ( $wp_query->current_post <= 0 ) ) {
		$image_args = array(
			'size' => 'horizontal-entry-image',
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

// Remove entry meta.
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Run Genesis.
genesis();
