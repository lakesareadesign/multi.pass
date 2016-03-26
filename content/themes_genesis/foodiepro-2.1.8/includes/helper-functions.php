<?php
/**
 * Template helper functions.
 *
 * @package     FoodiePro
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Shay Bocks
 * @license     GPL-2.0+
 * @since       2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper function to determine if we're on a blog section of a Genesis site.
 *
 * @since   2.0.0
 *
 * @param   $archives_only set to false to return true on singular posts
 * @return  bool True if we're on any section of the blog.
 */
function foodie_pro_is_blog( $archives_only = true ) {
	$is_blog = array(
		'blog_template' => genesis_is_blog_template(),
		'single_post'   => $archives_only ? false : is_singular( 'post' ),
		'archive'       => is_archive() && ! is_post_type_archive(),
		'home'          => is_home() && ! is_front_page(),
		'search'        => is_search(),
	);
	return in_array( true, $is_blog );
}

/**
 * Helper function to determine if we should use a grid archive filter.
 *
 * @since   2.0.0
 *
 * @return  bool $grid true if the archive grid is enabled
 */
function foodie_pro_archive_grid() {
	$grid = get_theme_mod( 'foodie_pro_archive_grid', 'full' );
	if ( ! function_exists( 'foodie_pro_grid_' . $grid ) || ! foodie_pro_is_blog() || 'full' === $grid ) {
		return false;
	}
	return $grid;
}

add_action( 'genesis_before_loop', 'foodie_pro_archive_maybe_add_grid' );
/**
 * Add the archive grid filter to the main loop.
 *
 * @since  2.0.0
 *
 * @uses   foodie_pro_archive_grid()
 */
function foodie_pro_archive_maybe_add_grid() {
	if ( $grid = foodie_pro_archive_grid() ) {
		add_filter( 'post_class', 'foodie_pro_grid_' . $grid );
	}
}

add_action( 'genesis_after_loop', 'foodie_pro_archive_maybe_remove_grid' );
/**
 * Remove the archive grid filter to ensure other loops are unaffected.
 *
 * @since  2.0.0
 *
 * @uses   foodie_pro_archive_grid()
 */
function foodie_pro_archive_maybe_remove_grid() {
	if ( $grid = foodie_pro_archive_grid() ) {
		remove_filter( 'post_class', 'foodie_pro_grid_' . $grid );
	}
}

add_action( 'genesis_before_content', 'foodie_pro_archive_maybe_remove_title' );
/**
 * Remove the entry title if the user has disabled it via the customizer.
 *
 * @since  2.0.0
 *
 * @uses   foodie_pro_is_blog()
 */
function foodie_pro_archive_maybe_remove_title() {
	if ( ! foodie_pro_is_blog() ) {
		return;
	}
	//* Remove the entry title if the user has disabled it.
	if ( ! get_theme_mod( 'foodie_pro_archive_show_title', true ) ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	}
}

add_action( 'genesis_before_content', 'foodie_pro_archive_maybe_remove_info' );
/**
 * Remove the entry info if the user has disabled it via the customizer.
 *
 * @since  2.0.0
 *
 * @uses   foodie_pro_is_blog()
 */
function foodie_pro_archive_maybe_remove_info() {
	if ( ! foodie_pro_is_blog() ) {
		return;
	}
	//* Remove the entry info if the user has disabled it.
	if ( ! get_theme_mod( 'foodie_pro_archive_show_info', true ) ) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	}
}

add_action( 'genesis_before_content', 'foodie_pro_archive_maybe_remove_content' );
/**
 * Remove the entry content if the user has disabled it via the customizer.
 *
 * @since  2.0.0
 *
 * @uses   foodie_pro_is_blog()
 */
function foodie_pro_archive_maybe_remove_content() {
	if ( ! foodie_pro_is_blog() ) {
		return;
	}
	//* Remove the entry content if the user has disabled it.
	if ( ! get_theme_mod( 'foodie_pro_archive_show_content', true ) ) {
		remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
	}
}

add_action( 'genesis_before_content', 'foodie_pro_archive_maybe_remove_meta' );
/**
 * Remove the entry meta if the user has disabled it via the customizer.
 *
 * @since  2.0.0
 *
 * @uses   foodie_pro_is_blog()
 */
function foodie_pro_archive_maybe_remove_meta() {
	if ( ! foodie_pro_is_blog() ) {
		return;
	}
	//* Remove the entry meta if the user has disabled it.
	if ( ! get_theme_mod( 'foodie_pro_archive_show_meta', true ) ) {
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}

add_action( 'genesis_before_content', 'foodie_pro_archive_maybe_move_image' );
/**
 * Move the post image if the user has changed the placement via the customizer.
 *
 * @since  2.0.0
 *
 * @uses   foodie_pro_is_blog()
 */
function foodie_pro_archive_maybe_move_image() {
	if ( ! foodie_pro_is_blog() ) {
		return;
	}
	$image_placement = get_theme_mod( 'foodie_pro_archive_image_placement', 'after_title' );
	//* Remove the default post image if it isn't in the default location.
	if ( 'after_title' !== $image_placement ) {
		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
	}
	//* Add the image before the title if the user has placed it there.
	if ( 'before_title' === $image_placement ) {
		add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );
	}
	//* Add the image after the content if the user has placed it there.
	if ( 'after_content' === $image_placement ) {
		add_action( 'genesis_entry_footer', 'genesis_do_post_image', 0 );
	}
}

add_action( 'genesis_after_loop', 'foodie_pro_archive_reset_loop' );
/**
 * Make sure our archive customizations don't spill over into other loops.
 *
 * @since  2.0.0
 */
function foodie_pro_archive_reset_loop() {
	remove_action( 'genesis_before_loop', 'foodie_pro_archive_maybe_add_grid' );
	remove_action( 'genesis_before_content', 'foodie_pro_archive_maybe_remove_title' );
	remove_action( 'genesis_before_content', 'foodie_pro_archive_maybe_remove_info' );
	remove_action( 'genesis_before_content', 'foodie_pro_archive_maybe_remove_content' );
	remove_action( 'genesis_before_content', 'foodie_pro_archive_maybe_remove_meta' );
	remove_action( 'genesis_before_content', 'foodie_pro_archive_maybe_move_image' );
}
