<?php
/**
 * General template helper functions.
 *
 * @package    BrunchPro\Functions\Helpers
 * @subpackage Genesis
 * @author     Robert Neu
 * @copyright  Copyright (c) 2016, Shay Bocks
 * @license    GPL-2.0+
 * @link       http://www.shaybocks.com/brunch-pro/
 * @since      1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Determine if we're viewing a "plural" page.
 *
 * Note that this is similar to, but not quite the same as `! is_singular()`,
 * which wouldn't account for the 404 page.
 *
 * @since  1.0.0
 * @access public
 * @return bool True if we're on any page which displays multiple entries.
 */
function brunch_pro_is_plural() {
	if ( brunch_pro_blog_page_is_grid_enabled() ) {
		$is_plural = is_archive() || is_search() || genesis_is_blog_template();
	} else {
		$is_plural = ( is_archive() || is_search() ) && ! genesis_is_blog_template();
	}

	return $is_plural;
}

/**
 * Determine if we're within a blog section archive.
 *
 * @since  1.0.0
 * @access public
 * @return bool True if we're on a blog archive page.
 */
function brunch_pro_is_blog_archive() {
	return brunch_pro_is_plural() && ! ( is_post_type_archive() || is_tax() );
}

/**
 * Determine if we're anywhere within the blog section of a Genesis site.
 *
 * @since  1.0.0
 * @access public
 * @return bool True if we're on any section of the blog.
 */
function brunch_pro_is_blog() {
	return brunch_pro_is_blog_archive() || is_singular( 'post' );
}
