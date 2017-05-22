<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Milan
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/featured-content/
 * See: https://jetpack.me/support/responsive-videos/
 */
function milan_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'article-wrap',
		'render'    => 'milan_infinite_scroll_render',
		'footer'    => 'page',
	) );

	add_theme_support( 'featured-content', array(
	    'filter'     => 'milan_get_featured_content',
	    'max_posts'  => 5,
	    'post_types' => array( 'post' ),
	) );

	add_theme_support( 'jetpack-responsive-videos' );
} // end function milan_jetpack_setup
add_action( 'after_setup_theme', 'milan_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function milan_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_archive() ) {
			get_template_part( 'template-parts/infinity', 'masonry' );
		} else {
			get_template_part( 'template-parts/infinity', 'content' );		
		}
	}
} // end function milan_infinite_scroll_render

/**
 * Custom render function for Featured Posts.
 */
function milan_get_featured_content() {
    return apply_filters( 'milan_get_featured_content', array() );
} // end function milan_get_featured_content

/**
 * Conditional function for checking if we have at least five Featured Content posts
 */
function milan_has_enough_featured_posts() {
	$featured_posts = apply_filters( 'milan_get_featured_content', array() );
	if ( is_array( $featured_posts ) && 4 < count( $featured_posts ) ) {
		return true;
	} else {
		return false;
	}
}
