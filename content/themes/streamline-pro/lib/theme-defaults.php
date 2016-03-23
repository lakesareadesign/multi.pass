<?php

//* Streamline Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'streamline_theme_defaults' );
function streamline_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['image_size']                = 'post-image';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* Streamline Theme Setup
add_action( 'after_switch_theme', 'streamline_theme_setting_defaults' );
function streamline_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignleft',
			'image_size'                => 'post-image',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 3 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'streamline_social_default_styles' );
function streamline_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignright',
		'background_color'       => '#cccccc',
		'background_color_hover' => '#333333',
		'border_radius'          => 3,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 48,
		);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}