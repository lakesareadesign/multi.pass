<?php
/**
 * Provide compatibility with various plugins.
 *
 * @package   Cookd
 * @copyright Copyright (c) 2016, Shay Bocks
 * @license   GPL-2.0+
 * @link      http://www.feastdesignco.com/cookd/
 * @since     1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'simple_social_default_styles', 'cookd_social_default_styles' );
/**
 * Override the default settings in the Simple Social Icons plugin.
 *
 * @since  1.0.0
 * @access public
 * @param  array $defaults the default settings.
 * @return array $defaults the overridden default settings.
 */
function cookd_social_default_styles( $defaults ) {
	return wp_parse_args( array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#f04848',
		'border_radius'          => 60,
		'icon_color'             => '#000000',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 60,
	), $defaults );
}

/**
 * Determine whether or not Facet WP is currently active.
 *
 * @since  1.0.0
 * @access public
 * @return bool True if the plugin is activated, false otherwise.
 */
function cookd_facetwp_is_active() {
	static $is_active;

	if ( null === $is_active ) {
		$is_active = function_exists( 'FWP' );
	}

	return $is_active;
}

add_action( 'widgets_init', 'cookd_facetwp_register_widget' );
/**
 * Register a widget for displaying FacetWP facets if the plugin is active.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function cookd_facetwp_register_widget() {
	global $_cooked_dir;

	if ( cookd_facetwp_is_active() ) {
		require_once "{$_cooked_dir}/lib/class-widget-facet.php";

		register_widget( 'Cookd_Facet_Widget' );
	}
}

add_filter( 'facetwp_is_main_query', 'cookd_facetwp_is_main_query', 10, 2 );
/**
 * Filter the main FacetWP query to allow custom queries.
 *
 * @since  1.0.0
 * @access public
 * @param  bool     $is_main_query The default value for the FacetWP main query.
 * @param  WP_Query $query The current WordPress query object.
 * @return bool $is_main_query True if the facetwp query var is true.
 */
function cookd_facetwp_is_main_query( $is_main_query, $query ) {
	if ( isset( $query->query_vars['facetwp'] ) ) {
		$is_main_query = true;
	}

	return $is_main_query;
}

add_filter( 'facetwp_assets', 'cookd_recipe_archive_pagination_js' );
/**
 * Load a custom FacetWP handler for the Genesis pagination.
 *
 * @since  1.0.0
 * @access public
 * @param  array $assets
 * @return array $assets
 */
function cookd_recipe_archive_pagination_js( $assets ) {
	$assets['cookd-pagination.js'] = untrailingslashit( get_stylesheet_directory_uri() ) . '/js/facetwp-pagination.js';

	return $assets;
}
