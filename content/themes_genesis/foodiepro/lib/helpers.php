<?php
/**
 * Template helper functions.
 *
 * @package   FoodiePro
 * @copyright Copyright (c) 2018, Feast Design Co.
 * @license   GPL-2.0+
 * @since     2.0.0
 */

/**
 * Helper function to determine if we're on a blog section of a Genesis site.
 *
 * @since  2.0.0
 * @param  bool $archives_only set to false to return true on singular posts.
 * @return bool True if we're on any section of the blog.
 */
function foodie_pro_is_blog( $archives_only = true ) {
	$is_blog = array(
		'blog_template' => genesis_is_blog_template(),
		'single_post'   => $archives_only ? false : is_singular( 'post' ),
		'archive'       => is_archive() && ! is_post_type_archive(),
		'home'          => is_home() && ! is_front_page(),
		'search'        => is_search(),
	);

	return in_array( true, $is_blog, true );
}

/**
 * Add post classes for a simple grid loop.
 *
 * @since  1.0.0
 * @access public
 * @param  int $columns The number of grid items desired.
 * @return array $classes The grid classes
 */
function foodie_pro_grid( $columns ) {
	if ( ! in_array( $columns, array( 2, 3, 4, 6 ), true ) ) {
		return array();
	}

	global $wp_query;

	$classes = array( 'simple-grid' );

	$column_classes = array(
		2 => 'one-half',
		3 => 'one-third',
		4 => 'one-fourth',
		6 => 'one-sixth',
	);

	$classes[] = $column_classes[ absint( $columns ) ];

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
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function foodie_pro_grid_one_half( $class ) {
	return array_merge( foodie_pro_grid( 2 ), $class );
}

/**
 * Set up a grid of one-third elements for use in a post_class filter.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function foodie_pro_grid_one_third( $class ) {
	return array_merge( foodie_pro_grid( 3 ), $class );
}

/**
 * Set up a grid of one-fourth elements for use in a post_class filter.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function foodie_pro_grid_one_fourth( $class ) {
	return array_merge( foodie_pro_grid( 4 ), $class );
}

/**
 * Set up a grid of one-sixth elements for use in a post_class filter.
 *
 * @since  1.0.0
 * @access public
 * @param  array $class An array of the current post classes.
 * @return array $class The post classes with the grid appended.
 */
function foodie_pro_grid_one_sixth( $class ) {
	return array_merge( foodie_pro_grid( 6 ), $class );
}

/**
 * Helper function to determine if the requested grid function exists.
 *
 * @since  1.0.0
 * @access public
 * @param  string $grid the grid type to check.
 * @return bool|string false if no grid function exists, grid name otherwise.
 */
function foodie_pro_grid_exists( $grid ) {
	return function_exists( "foodie_pro_grid_{$grid}" ) ? $grid : false;
}

/**
 * Helper function to determine if we should use a grid archive filter.
 *
 * @since   2.0.0
 *
 * @return  bool $grid true if the archive grid is enabled
 */
function foodie_pro_archive_grid() {
	if ( ! foodie_pro_is_blog() ) {
		return false;
	}

	$grid = foodie_pro_grid_exists( get_theme_mod( 'foodie_pro_archive_grid', 'full' ) );

	if ( ! $grid ) {
		return false;
	}

	return $grid;
}
