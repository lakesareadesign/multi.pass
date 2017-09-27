<?php
/**
 * This file adds the blog masonry template to the Business Pro theme.
 *
 * @package      Business Pro
 * @link         https://seothemes.com/themes/business-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

add_filter( 'body_class', 'business_masonry_body_class', 99 );
/**
 * Add blog-masonry body class.
 *
 * @since  1.0.0
 *
 * @param  array $classes Default body classes.
 * @return array $classes Default body classes.
 */
function business_masonry_body_class( $classes ) {

	$classes[] = 'masonry';

	return $classes;

}

add_action( 'wp_enqueue_scripts', 'business_masonry_scripts' );
/**
 * Enqueue masonry script.
 *
 * Uses the masonry script from wp-includes/js/masonry.min.js
 *
 * @since  1.0.0
 *
 * @return void
 */
function business_masonry_scripts() {

	// Enqueue script.
	wp_enqueue_script( 'masonry', '', array( 'js' ), CHILD_THEME_VERSION, true );

	// Add inline script.
	wp_add_inline_script( 'masonry',
		'jQuery( window ).on( "load resize scroll", function() {
			jQuery(".content").masonry({
				itemSelector: ".entry",
				columnWidth: ".entry",
				gutter: 30,
			});
		});'
	);

}

add_filter( 'genesis_post_meta', 'business_entry_meta_footer' );
/**
 * Customize Entry Meta Filed Under and Tagged Under.
 *
 * @since 1.0.0
 *
 * @return string $post_meta Post meta string.
 */
function business_entry_meta_footer() {

	$post_meta = get_avatar( get_the_author_meta( 'email' ), 25 );
	$post_meta .= '&nbsp; [post_author_posts_link]';
	$post_meta = '[post_categories]';

	return $post_meta;

}

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_filter( 'genesis_post_info', 'business_post_info_filter' );
add_action( 'genesis_entry_header', 'genesis_post_info', 2 );
/**
 * Customize the post info function.
 *
 * @since 1.0.0
 *
 * @param  string $post_info The default post info string.
 * @return string $post_info Post info string.
 */
function business_post_info_filter( $post_info ) {

	$post_info = '<i class="fa fa-calendar"></i> [post_date]';

	return $post_info;

}

// Reposition the breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_before_content', 'genesis_do_breadcrumbs' );

// Move pagination outside of masonry.
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
add_action( 'genesis_after_content', 'genesis_posts_nav' );

// Run Genesis.
genesis();
