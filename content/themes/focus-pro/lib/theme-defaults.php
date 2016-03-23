<?php

//* Focus Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'focus_theme_defaults' );
function focus_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* Focus Theme Setup
add_action( 'after_switch_theme', 'focus_theme_setting_defaults' );
function focus_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
	
	} else {
		
		_genesis_update_settings( array(
			'blog_cat_num'              => 3,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
		
	}

	update_option( 'posts_per_page', 4 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'focus_social_default_styles' );
function focus_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#999999',
		'background_color_hover' => '#000000',
		'border_radius'          => 0,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 36,
		);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}