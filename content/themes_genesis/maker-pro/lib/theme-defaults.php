<?php

//* Maker Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'maker_theme_defaults' );
function maker_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 140;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignnone';
	$defaults['image_size']                = 'maker_archive';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

//* Maker Theme Setup
add_action( 'after_switch_theme', 'maker_theme_setting_defaults' );
function maker_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,
			'content_archive'           => 'full',
			'content_archive_limit'     => 140,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignnone',
			'image_size'                => 'maker_archive',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'full-width-content',
		) );

	}

	update_option( 'posts_per_page', 9 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'maker_social_default_styles' );
function maker_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#ffffff',
		'border_color'           => '#ffffff',
		'border_color_hover'     => '#ffffff',
		'border_radius'          => 48,
		'border_width'           => 0,
		'icon_color'             => '#12302e',
		'icon_color_hover'       => '#999999',
		'size'                   => 36,
		);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
