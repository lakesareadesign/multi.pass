<?php

/**
 * This file adds the Theme Defaults to the elegance Theme.
 *
 * @package      elegance
 * @subpackage   Customizations
 * @link         http://stephaniehellwig.com/themes
 * @author       Stephanie Hellwig
 * @copyright    Copyright (c) 2016, Stephanie Hellwig, Released 06/04/2016
 * @license      GPL-2.0+
 */

//* elegance Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'elegance_theme_defaults' );
function elegance_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 100;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_size']                = 'blog-image';
	$defaults['image_alignment']           = 'alignnone';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* elegance Theme Setup
add_action( 'after_switch_theme', 'elegance_theme_setting_defaults' );
function elegance_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 100,
			'content_archive_thumbnail' => 1,
			'image_size'                => 'blog-image',
			'image_alignment'           => 'alignnone',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
	
	} 

	update_option( 'posts_per_page', 6 );

}

//* elegance Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'elegance_social_default_styles' );
function elegance_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#D3D3D3',
		'background_color_hover' => '#829da5',
		'border_radius'          => 0,
		'border_color'           => '#FFFFFF',
		'border_color_hover'     => '#FFFFFF',
		'border_width'           => 0,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 22,
		'new_window'             => 1,
	);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}

