<?php

//* The 411 Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'the_411_theme_defaults' );
function the_411_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 4;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

//* The 411 Theme Setup
add_action( 'after_switch_theme', 'the_411_theme_setting_defaults' );
function the_411_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 4,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'full-width-content',
		) );

	} else {

		_genesis_update_settings( array(
			'blog_cat_num'              => 4,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'full-width-content',
		) );

	}

	update_option( 'posts_per_page', 4 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'the_411_social_default_styles' );
function the_411_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#000000',
		'background_color_hover' => '#e5554e',
		'border_radius'          => 0,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 36,
		);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}