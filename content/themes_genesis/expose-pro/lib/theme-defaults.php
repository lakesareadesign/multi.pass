<?php

//* Expose Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'expose_theme_defaults' );
function expose_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'prev-next';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

//* Expose Theme Setup
add_action( 'after_switch_theme', 'expose_theme_setting_defaults' );
function expose_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'prev-next',
			'site_layout'               => 'full-width-content',
		) );
		
	} else {
	
		genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'prev-next',
			'site_layout'               => 'full-width-content',
		) );
		
	}

	update_option( 'posts_per_page', 6 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'expose_social_default_styles' );
function expose_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#000000',
		'border_radius'          => 48,
		'icon_color'             => '#000000',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 48,
		);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}