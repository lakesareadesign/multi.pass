<?php
/**
 * Smart Passive Income Pro.
 *
 * This file adds the default theme settings to the Smart Passive Income Pro.
 *
 * @package Smart Passive Income Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

add_filter( 'genesis_theme_settings_defaults', 'spi_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 1.0.0
 */
function spi_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'spi_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 1.0.0
 */
function spi_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 1,
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
		
	} 

	update_option( 'posts_per_page', 6 );

}

add_filter( 'simple_social_default_styles', 'spi_social_default_styles' );
/**
 * Set the default styling for Simple Social Icons.
 *
 * @since 1.0.0
 */
function spi_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#ffffff',
		'border_radius'          => 0,
		'icon_color'             => '#d4d4d4',
		'icon_color_hover'       => '#b4151b',
		'size'                   => 72,
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
