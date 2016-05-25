<?php

//* Minimum Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'minimum_theme_defaults' );
function minimum_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* Minimum Theme Setup
add_action( 'after_switch_theme', 'minimum_theme_setting_defaults' );
function minimum_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
		
	}

	update_option( 'posts_per_page', 6 );
	
	flush_rewrite_rules( false );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'minimum_social_default_styles' );
function minimum_social_default_styles( $defaults ) {

	$args = array(
		'size'                   => 100,
		'border_radius'          => 100,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'background_color'       => '#333333',
		'background_color_hover' => '#0ebfe9',
		'alignment'              => 'aligncenter',
	);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}