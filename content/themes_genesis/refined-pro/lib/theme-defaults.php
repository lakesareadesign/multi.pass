<?php

/**
 * This file adds the Theme Defaults to the Refined Theme.
 *
 * @package      Refined
 * @subpackage   Customizations
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 04/12/2017
 * @license      GPL-2.0+
 */

add_filter( 'genesis_theme_settings_defaults', 'refined_theme_defaults' );
/**
 * Refined Theme Setting Defaults.
 *
 * @since 1.0.0
 *
 * @param  array $defaults Array of default theme settings.
 * @return array $defaults Updated array of default theme settings.
 */
function refined_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 5;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 300;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_size']                = 'vertical-entry-image';
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'refined_theme_setting_defaults' );
/**
 * Function to setup the theme settings.
 *
 * @since 1.0.0
 */
function refined_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 5,
			'content_archive'           => 'full',
			'content_archive_limit'     => 300,
			'content_archive_thumbnail' => 1,
			'image_size'                => 'vertical-entry-image',
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		));

	}

	update_option( 'posts_per_page', 5 );

}

add_filter( 'simple_social_default_styles', 'refined_social_default_styles' );
/**
 * Refined Simple Social Icon default settings.
 *
 * @since 1.0.0
 *
 * @param  array $defaults Array of default Simple Social Icon arguments.
 * @return array $args     New array of Simple Social Icon arguments.
 */
function refined_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#FFFFFF',
		'background_color_hover' => '#FFFFFF',
		'border_radius'          => 0,
		'border_color'           => '#FFFFFF',
		'border_color_hover'     => '#FFFFFF',
		'border_width'           => 0,
		'icon_color'             => '#ae9d78',
		'icon_color_hover'       => '#333333',
		'size'                   => 22,
		'new_window'             => 1,
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}

add_action( 'after_switch_theme', 'refined_theme_reading_defaults' );
/**
 * Set option to show posts on front page after switching themes.
 *
 * @since 1.0.0
 */
function refined_theme_reading_defaults() {

	if ( 'posts' != get_option( 'show_on_front' ) ) {
		update_option( 'show_on_front', 'posts' );
	}

}
