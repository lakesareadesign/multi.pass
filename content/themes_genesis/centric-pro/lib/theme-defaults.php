<?php
/**
 * Centric Pro.
 *
 * This file adds the default theme settings to the Centric Pro Theme.
 *
 * @package Centric
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/centric/
 */

add_filter( 'genesis_theme_settings_defaults', 'centric_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 1.0.0
 *
 * @param array $defaults Default theme settings.
 * @return array Modified defaults.
 */
function centric_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 10;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 500;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'centric_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 1.0.0
 */
function centric_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 10,
			'content_archive'           => 'full',
			'content_archive_limit'     => 500,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 10 );

}

add_filter( 'simple_social_default_styles', 'centric_social_default_styles' );
/**
 * Sets default social icon settings.
 *
 * @since 1.0.0
 *
 * @param array $defaults Default social icon settings.
 * @return array Modified defaults.
 */
function centric_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#2e2f33',
		'border_radius'          => 50,
		'icon_color'             => '#2e2f33',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 60,
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
