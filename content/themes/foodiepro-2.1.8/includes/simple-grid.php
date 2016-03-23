<?php
/**
 * Simple grid helper functions.
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
 * Add post classes for a simple grid loop.
 *
 * @since      2.0.0
 * @category   Grid Loop
 * @param      $classes array An array of classes that should be appended
 * @param      $columns int   The number of grid items desired
 * @return     $classes array The grid classes
 */
function foodie_pro_simple_grid( $classes, $columns ) {
	global $wp_query;

	//* Bail if we don't have a column number or the one we do have is invalid.
	if ( ! isset( $columns ) || ! in_array( $columns, array( 2, 3, 4, 6 ) ) ) {
		return;
	}

	$classes = array( 'simple-grid' );

	$column_classes = array(
		2 => 'one-half',
		3 => 'one-third',
		4 => 'one-fourth',
		6 => 'one-sixth',
	);

	//* Add the appropriate column class.
	$classes[] = $column_classes[ absint( $columns ) ];

	//* Add an "odd" class to allow for more control of grid clollapse.
	if ( ( $wp_query->current_post + 1 ) % 2 ) {
		$classes[] = 'odd';
	}

	if ( 0 === $wp_query->current_post || 0 === $wp_query->current_post % $columns ) {
		$classes[] = 'first';
	}

	return $classes;
}

/**
 * Set up a grid of one-half elements for use in a post_class filter.
 *
 * @since      2.0.0
 * @category   Grid Loop
 * @param      $classes array An array of the current post classes
 * @return     $classes array The currnt post classes with the grid appended
 */
function foodie_pro_grid_one_half( $classes ) {
	return array_merge( (array) foodie_pro_simple_grid( $classes, 2 ), $classes );
}

/**
 * Set up a grid of one-third elements for use in a post_class filter.
 *
 * @since      2.0.0
 * @category   Grid Loop
 * @param      $classes array An array of the current post classes
 * @return     $classes array The currnt post classes with the grid appended
 */
function foodie_pro_grid_one_third( $classes ) {
	return array_merge( (array) foodie_pro_simple_grid( $classes, 3 ), $classes );
}

/**
 * Set up a grid of one-fourth elements for use in a post_class filter.
 *
 * @since      2.0.0
 * @category   Grid Loop
 * @param      $classes array An array of the current post classes
 * @return     $classes array The currnt post classes with the grid appended
 */
function foodie_pro_grid_one_fourth( $classes ) {
	return array_merge( (array) foodie_pro_simple_grid( $classes, 4 ), $classes );
}

/**
 * Set up a grid of one-sixth elements for use in a post_class filter.
 *
 * @since      2.0.0
 * @category   Grid Loop
 * @param      $classes array An array of the current post classes
 * @return     $classes array The currnt post classes with the grid appended
 */
function foodie_pro_grid_one_sixth( $classes ) {
	return array_merge( (array) foodie_pro_simple_grid( $classes, 6 ), $classes );
}
