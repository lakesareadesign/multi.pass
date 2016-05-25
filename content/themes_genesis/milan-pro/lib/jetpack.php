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
 */
function milan_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'article-wrap',
		'render'    => 'milan_infinite_scroll_render',
		'footer'    => 'page',
	) );
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
