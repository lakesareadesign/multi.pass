<?php

//* Going Green Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'going_green_theme_defaults' );
function going_green_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['image_size']                = 'featured-image';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* Going Green Theme Setup
add_action( 'after_switch_theme', 'going_green_theme_setting_defaults' );
function going_green_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignleft',
			'image_size'                => 'featured-image',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
		
	} else {
	
		_genesis_update_settings( array(
			'blog_cat_num'              => 3,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignleft',
			'image_size'                => 'featured-image',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
		
	}

	update_option( 'posts_per_page', 3 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'going_green_social_default_styles' );
function going_green_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#eae7e0',
		'background_color_hover' => '#984a23',
		'border_radius'          => 3,
		'icon_color'             => '#984a23',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 32,
	);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}