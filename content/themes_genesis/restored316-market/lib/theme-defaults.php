<?php

/**
 * This file adds the Theme Defaults to the Market Theme.
 *
 * @package      Market
 * @subpackage   Customizations
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 05/03/2016
 * @license      GPL-2.0+
 */

//* Market Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'market_theme_defaults' );
function market_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 100;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_size']                = 'square-entry-image';
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* Market Theme Setup
add_action( 'after_switch_theme', 'market_theme_setting_defaults' );
function market_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 100,
			'content_archive_thumbnail' => 1,
			'image_size'                => 'square-entry-image',
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
	
	} 

	update_option( 'posts_per_page', 6 );

}

//* Market Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'market_social_default_styles' );
function market_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#FAF9F7',
		'background_color_hover' => '#FAF9F7',
		'border_radius'          => 0,
		'border_color'           => '#FFFFFF',
		'border_color_hover'     => '#FFFFFF',
		'border_width'           => 0,
		'icon_color'             => '#666666',
		'icon_color_hover'       => '#7d947d',
		'size'                   => 22,
		'new_window'             => 1,
		);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}

//* Market Genesis Responsive Slider defaults
add_filter( 'genesis_responsive_slider_settings_defaults', 'market_responsive_slider_defaults' );
function market_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'left',
		'location_vertical'               => 'bottom',
		'posts_num'                       => '3',
		'slideshow_arrows'                => 1,
		'slideshow_excerpt_show'          => 0,
		'slideshow_height'                => '450',
		'slideshow_pager'                 => 0,
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '820',
	);

	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}
