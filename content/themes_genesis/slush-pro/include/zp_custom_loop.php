<?php
/**
 * Slush Pro.
 *
 * This file creates the custom loop in the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

function zp_blog_loop() {

	global $post, $paged;

	// If in blog template.
	if ( is_page_template( 'page_blog.php' ) ) {
		$include = genesis_get_option( 'blog_cat' );
		$exclude = genesis_get_option( 'blog_cat_exclude' ) ? explode( ',', str_replace( ' ', '', genesis_get_option( 'blog_cat_exclude' ) ) ) : '';

		if ( is_front_page() ) {
			$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
		} else {
			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		}

		// Arguments.
		$args = array(
				'cat'              => $include,
				'category__not_in' => $exclude,
				'posts_per_page'   => genesis_get_option( 'blog_cat_num' ),
				'paged'            => $paged,
		);

		zp_custom_blog_loop( $args );
	} else {
		zp_standard_loop(); 
	}

}

/**
 * Custom Loop.
 *
 * Contains new query of posts.
 */
function zp_custom_blog_loop( $args ) {

	global $wp_query, $more;

	$wp_query = new WP_Query( $args );

	// Only sets $more to 0 if we're on an archive.
	$more = is_singular() ? $more : 0;

	zp_standard_loop();

	// Restores original query.
	wp_reset_query();

}

/**
 * Default/Standard Loop.
 *
 * Renders posts with no modifications on the query.
 */
function zp_standard_loop() {

	if ( have_posts() ) :
		do_action( 'genesis_before_while' );
		while ( have_posts() ) : the_post();

			do_action( 'genesis_before_entry' );

			printf( '<article %s>', genesis_attr( 'entry' ) );

				$format = get_post_format(); 
				get_template_part( 'templates/content', $format );

			echo '</article>';

			do_action( 'genesis_after_entry' );

		endwhile; // End of one post.
		do_action( 'genesis_after_endwhile' );

	else : // If no posts exist.
		do_action( 'genesis_loop_else' );
	endif; // Ends loop.

}
