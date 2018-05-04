<?php
/**
 * This file adds the grid layout for the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

// Registers the grid layout for category archives.
genesis_register_layout( 'authority-grid', array(
	'label' => __( 'Three-column Grid', 'authority-pro' ),
	'img'   => get_stylesheet_directory_uri() . '/images/grid.gif',
	'type'  => array( 'category', 'post_tag' ),
) );

// Adds site layouts back to categories and tags.
if ( function_exists( 'genesis_add_type_to_layout' ) ) {
	genesis_add_type_to_layout( 'content-sidebar', array( 'category', 'post_tag' ) );
	genesis_add_type_to_layout( 'sidebar-content', array( 'category', 'post_tag' ) );
	genesis_add_type_to_layout( 'full-width-content', array( 'category', 'post_tag' ) );
}

add_action( 'genesis_meta', 'authority_grid_layout' );
/**
 * Sets up the grid layout.
 *
 * @since 1.0.0
 */
function authority_grid_layout() {

	$site_layout = genesis_site_layout();

	if ( 'authority-grid' === $site_layout ) {
		remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
		remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
		add_filter( 'genesis_skip_links_output', 'authority_grid_skip_links_output' );
		add_filter( 'genesis_pre_get_option_content_archive_limit', 'authority_grid_archive_limit' );
		add_filter( 'genesis_pre_get_option_content_archive_thumbnail', 'authority_grid_archive_thumbnail' );
		add_filter( 'genesis_pre_get_option_content_archive', 'authority_grid_content_archive' );
		add_filter( 'genesis_pre_get_option_image_size', 'authority_grid_image_size' );
		add_filter( 'genesis_pre_get_option_image_alignment', 'authority_grid_image_alignment' );
	}

}

add_filter( 'genesis_pre_get_option_site_layout', 'authority_grid_category_layout' );
/**
 * Sets the default layout for category and tag archive pages.
 *
 * @since 1.0.0
 *
 * @param string $layout The current layout.
 * @return string The new layout.
 */
function authority_grid_category_layout( $layout ) {

	$layout_option = get_theme_mod( 'authority-grid-option', true );

	if ( $layout_option && ( is_category() || is_tag() ) ) {
		$layout = 'authority-grid';
	}

	return $layout;

}

add_action( 'pre_get_posts', 'authority_grid_posts_per_page' );
/**
 * Sets the number of posts in the grid.
 *
 * @since 1.0.0
 *
 * @param WP_Query $query The query object.
 */
function authority_grid_posts_per_page( $query ) {

	$site_layout = genesis_site_layout( false );
	$posts       = get_theme_mod( 'authority-grid-posts-per-page', authority_get_default_grid_posts_per_page() );

	if ( ! $query->is_main_query() ) {
		return;
	}

	if ( 'authority-grid' === $site_layout ) {
		$query->set( 'posts_per_page', intval( $posts ) );
	}

}

/**
 * Gets the content limit for the grid layout.
 *
 * @since 1.0.0
 *
 * @return int The grid content limit.
 */
function authority_grid_archive_limit() {

	return get_theme_mod( 'authority-grid-archive-limit', authority_get_default_grid_limit() );

}

/**
 * Gets the archive thumbnail for the grid layout.
 *
 * @since 1.0.0
 *
 * @return bool The grid archive thumbnail.
 */
function authority_grid_archive_thumbnail() {

	return get_theme_mod( 'authority-grid-thumbnail', true );

}

/**
 * Sets the grid content display type.
 *
 * @since 1.0.0
 *
 * @return string The grid display type.
 */
function authority_grid_content_archive() {

	return get_theme_mod( 'authority-content-archive', authority_content_archive_option() );

}

/**
 * Removes skip link for primary navigation and primary sidebar and adds skip link for footer widgets.
 *
 * @since 1.0.0
 *
 * @param array $links The current skip links.
 * @return array The new skip links.
 */
function authority_grid_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	if ( isset( $links['genesis-sidebar-primary'] ) ) {
		unset( $links['genesis-sidebar-primary'] );
	}

	$new_links = $links;
	array_splice( $new_links, 3 );

	if ( is_active_sidebar( 'authority-footer' ) ) {
		$new_links['footer'] = __( 'Skip to footer', 'authority-pro' );
	}

	return array_merge( $new_links, $links );

}

/**
 * Gets the grid image size.
 *
 * @since 1.0.0
 *
 * @return string The grid image size.
 */
function authority_grid_image_size() {

	return 'blog-featured-image';

}

/**
 * Gets the grid image alignment.
 *
 * @since 1.0.0
 *
 * @return string The grid image alignment.
 */
function authority_grid_image_alignment() {

	return 'aligncenter';

}

/**
 * Gets default grid layout posts per page.
 *
 * @since 1.0.0
 *
 * @return string Number of posts to show.
 */
function authority_get_default_grid_posts_per_page() {

	return 6;

}

/**
 * Gets default grid layout content limit.
 *
 * @since 1.0.0
 *
 * @return string Number of characters to show.
 */
function authority_get_default_grid_limit() {

	return 200;

}

/**
 * Gets default grid layout content limit.
 *
 * @since 1.0.0
 *
 * @return string Content display option.
 */
function authority_content_archive_option() {

	return 'full';

}
