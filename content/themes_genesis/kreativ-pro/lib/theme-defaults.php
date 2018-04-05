<?php
/**
 * Kreativ Pro.
 *
 * This file adds the default theme settings to the Kreativ Pro Theme.
 *
 * @package Kreativ
 * @author  ThemeSquare
 * @license GPL-2.0+
 * @link    http://themesquare.com/themes/kreativ/
 */

add_filter( 'genesis_theme_settings_defaults', 'kreativ_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 1.0.0
 */
function kreativ_theme_defaults( $defaults ) {

	$defaults['content_archive']           = 'excerpts';
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_size']                = 'blog';
	$defaults['image_alignment']           = '';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'kreativ_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 1.0.0
 */
function kreativ_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'content_archive'           => 'excerpts',
			'content_archive_thumbnail' => 1,
			'image_size'                => 'blog',
			'image_alignment'           => '',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 6 );

}

// Simple Social Icons Defaults.
add_filter( 'simple_social_default_styles', 'kreativ_simple_social_styles' );
/**
 * Updates Simple Social Icon settings on activation.
 *
 * @since 1.0.0
 */
function kreativ_simple_social_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '',
		'background_color_hover' => '',
		'border_radius'          => 0,
		'icon_color'             => '',
		'icon_color_hover'       => '',
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}

add_filter( 'simple_social_default_stylesheet', 'kreativ_simple_social_stylesheet' );
/**
 * Removes Simple Social Icons stylesheet.
 *
 * @since 1.1.0
 */
function kreativ_simple_social_stylesheet( $css_file ) {
	$css_file = ''; // Remove simple social icons stylesheet.
	return $css_file;
}

add_filter( 'genesis_portfolio_load_default_styles', 'kreativ_portfolio_pro_stylesheet' );
/**
 * Removes Genesis Portfolio Pro stylesheet.
 *
 * @since 1.1.0
 */
function kreativ_portfolio_pro_stylesheet() {
	return false;
}
