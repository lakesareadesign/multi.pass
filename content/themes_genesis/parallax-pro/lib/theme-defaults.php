<?php
/**
 * Parallax Pro.
 *
 * This file adds the default theme settings to the Parallax Pro Theme.
 *
 * @package Parallax
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/parallax/
 */

add_filter( 'genesis_theme_settings_defaults', 'parallax_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 1.0.0
 */
function parallax_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 5;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'full-width-content';
	
	return $defaults;

}

add_action( 'after_switch_theme', 'parallax_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 1.0.0
 */
function parallax_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 5,
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'full-width-content',
		) );

	}

	update_option( 'posts_per_page', 5 );

}

add_filter( 'simple_social_default_styles', 'parallax_social_default_styles' );
/**
 * Updates Simple Social Icon settings on activation.
 *
 * @since 1.0.0
 */
function parallax_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#00a0af',
		'border_radius'          => 48,
		'icon_color'             => '#000000',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 48,
		);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
