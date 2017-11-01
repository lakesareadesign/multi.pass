<?php
/**
 * Authority Pro
 *
 * This file handles the logic for outputting the featured images in the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

add_action( 'genesis_entry_header', 'authority_add_title_filter', 1 );
/**
 * Adds entry title filter to posts and pages.
 *
 * @since 1.0.0
 *
 * @uses authority_title()
 */
function authority_add_title_filter() {

	if ( is_singular() || is_front_page() && ! is_search() ) {
		add_filter( 'the_title', 'authority_title' );
	}

}

/**
 * Modifies the entry title text.
 *
 * @since 1.0.0
 *
 * @param  string $title String of the title.
 * @return string $title Updated title of the string.
 */
function authority_title( $title ) {

	if ( genesis_get_custom_field( 'subtitle' ) ) {
		$title = '<span class="authority-subtitle">' . genesis_get_custom_field( 'subtitle' ) . '</span>' . $title;
	}

	return $title;

}

add_action( 'genesis_entry_header', 'authority_remove_title_filter', 15 );
/**
 * Removes post and page title filter after entry header.
 *
 * @since 1.0.0
 */
function authority_remove_title_filter() {

	if ( is_singular() || is_front_page() && ! is_search() ) {
		remove_filter( 'the_title', 'authority_title' );
	}

}
