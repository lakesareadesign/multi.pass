<?php

//* Lifestyle Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'lifestyle_theme_defaults' );
function lifestyle_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 5;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* Lifestyle Theme Setup
add_action( 'after_switch_theme', 'lifestyle_theme_setting_defaults' );
function lifestyle_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 5,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
		
	} else {
	
		_genesis_update_settings( array(
			'blog_cat_num'              => 5,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
		
	}

	update_option( 'posts_per_page', 5 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'lifestyle_social_default_styles' );
function lifestyle_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#eeeee8',
		'background_color_hover' => '#a5a5a3',
		'border_radius'          => 3,
		'icon_color'             => '#a5a5a3',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 32,
		);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}