<?php

//* Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'bbs_theme_defaults' );
function bbs_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 150;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['image_size']                = 'rectangle-portrait';
	$defaults['posts_nav']                 = 'prev-next';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* Digital Theme Setup
add_action( 'after_switch_theme', 'bbs_theme_setting_defaults' );
function bbs_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,
			'content_archive'           => 'full',
			'content_archive_limit'     => 150,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignleft',
			'image_size'                => 'rectangle-portrait',
			'posts_nav'                 => 'prev-next',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 3 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'bbs_social_default_styles' );
function bbs_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#ffffff',
		'border_color'           => '#ffffff',
		'border_color_hover'     => '#ffffff',
		'border_radius'          => 3,
		'border_width'           => 0,
		'icon_color'             => '#333333',
		'icon_color_hover'       => '#999999',
		'size'                   => 25,
		);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
