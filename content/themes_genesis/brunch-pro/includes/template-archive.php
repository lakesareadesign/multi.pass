<?php
/**
 * Archive template modifications.
 *
 * @package    BrunchPro\Functions\Template
 * @subpackage Genesis
 * @author     Robert Neu
 * @copyright  Copyright (c) 2016, Shay Bocks
 * @license    GPL-2.0+
 * @link       http://www.shaybocks.com/brunch-pro/
 * @since      1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_action( 'genesis_before_loop',  'brunch_pro_blog_page_maybe_add_grid',     99 );
add_action( 'genesis_after_loop',   'brunch_pro_blog_page_maybe_remove_grid',   5 );
add_action( 'genesis_before_entry', 'brunch_pro_archive_maybe_add_grid',       10 );
add_action( 'genesis_before_entry', 'brunch_pro_archive_maybe_remove_title',   10 );
add_action( 'genesis_before_entry', 'brunch_pro_archive_maybe_remove_info',    10 );
add_action( 'genesis_before_entry', 'brunch_pro_archive_maybe_remove_content', 10 );
add_action( 'genesis_before_entry', 'brunch_pro_archive_maybe_remove_meta',    10 );
add_action( 'genesis_before_entry', 'brunch_pro_archive_maybe_move_image',     10 );

/**
 * Check to see if the current blog page has the blog grid layout enabled.
 *
 * @since  1.0.0
 * @return bool true if the grid is enabled, false otherwise.
 */
function brunch_pro_blog_page_is_grid_enabled( $post_id = false ) {
	static $enabled;

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( null === $enabled ) {
		$enabled = get_post_meta( $post_id, '_brunch_pro_enable_blog_grid', true );

		if ( empty( $enabled ) ) {
			$enabled = 'yes';
		}
	}

	return 'yes' === $enabled;
}

/**
 * Add the archive grid filter to the main loop.
 *
 * @since  1.0.0
 * @uses   genesis_is_blog_template()
 * @uses   brunch_pro_grid_exists()
 * @return bool true if the filter has been added, false otherwise.
 */
function brunch_pro_blog_page_maybe_add_grid() {
	if ( ! genesis_is_blog_template() || ! brunch_pro_blog_page_is_grid_enabled() ) {
		return false;
	}

	if ( $grid = brunch_pro_grid_exists( get_theme_mod( 'archive_grid', 'full' ) ) ) {
		return add_filter( 'post_class', "brunch_pro_grid_{$grid}" );
	}

	return false;
}

/**
 * Remove the archive grid filter to ensure other loops are unaffected.
 *
 * @since  1.0.0
 * @uses   genesis_is_blog_template()
 * @uses   brunch_pro_grid_exists()
 * @return bool true if the filter has been removed, false otherwise.
 */
function brunch_pro_blog_page_maybe_remove_grid() {
	if ( ! genesis_is_blog_template() || ! brunch_pro_blog_page_is_grid_enabled() ) {
		return false;
	}

	if ( $grid = brunch_pro_grid_exists( get_theme_mod( 'archive_grid', 'full' ) ) ) {
		return remove_filter( 'post_class', "brunch_pro_grid_{$grid}" );
	}

	return false;
}

/**
 * Add the archive grid filter to the main loop.
 *
 * @since  1.0.0
 * @uses   brunch_pro_is_blog_archive()
 * @uses   brunch_pro_grid_exists()
 * @return bool true if the filter has been added, false otherwise.
 */
function brunch_pro_archive_maybe_add_grid() {
	if ( ! brunch_pro_is_blog_archive() ) {
		return false;
	}

	if ( $grid = brunch_pro_grid_exists( get_theme_mod( 'archive_grid', 'full' ) ) ) {
		return add_filter( 'post_class', "brunch_pro_grid_{$grid}_main" );
	}

	return false;
}

/**
 * Remove the entry title if the user has disabled it via the customizer.
 *
 * @since  1.0.0
 * @uses   brunch_pro_is_blog_archive()
 * @return void
 */
function brunch_pro_archive_maybe_remove_title() {
	if ( brunch_pro_is_blog_archive() && ! get_theme_mod( 'archive_show_title', true ) ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	}
}

/**
 * Remove the entry info if the user has disabled it via the customizer.
 *
 * @since  1.0.0
 * @uses   brunch_pro_is_blog_archive()
 * @return void
 */
function brunch_pro_archive_maybe_remove_info() {
	if ( brunch_pro_is_blog_archive() && ! get_theme_mod( 'archive_show_info', true ) ) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	}
}

/**
 * Remove the entry content if the user has disabled it via the customizer.
 *
 * @since  1.0.0
 * @uses   brunch_pro_is_blog_archive()
 * @return void
 */
function brunch_pro_archive_maybe_remove_content() {
	if ( brunch_pro_is_blog_archive() && ! get_theme_mod( 'archive_show_content', true ) ) {
		remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
	}
}

/**
 * Remove the entry meta if the user has disabled it via the customizer.
 *
 * @since  1.0.0
 * @uses   brunch_pro_is_blog_archive()
 * @return void
 */
function brunch_pro_archive_maybe_remove_meta() {
	if ( brunch_pro_is_blog_archive() && ! get_theme_mod( 'archive_show_meta', true ) ) {
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}

/**
 * Move the post image if the user has changed the placement via the customizer.
 *
 * @since  1.0.0
 * @uses   brunch_pro_is_blog_archive()
 * @return void
 */
function brunch_pro_archive_maybe_move_image() {
	if ( ! brunch_pro_is_blog_archive() ) {
		return;
	}
	$placement = get_theme_mod( 'archive_image_placement', 'after_title' );
	if ( 'after_title' !== $placement ) {
		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
	}
	if ( 'before_title' === $placement ) {
		add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );
	}
	if ( 'after_content' === $placement ) {
		add_action( 'genesis_entry_footer', 'genesis_do_post_image', 0 );
	}
}
