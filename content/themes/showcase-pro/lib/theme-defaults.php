<?php

//* Showcase Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'showcase_theme_defaults' );
function showcase_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 140;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignnon';
	$defaults['image_size']                = 'showcase_archive';
	$defaults['posts_nav']                 = 'prev-next';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

//* Showcase Theme Setup
add_action( 'after_switch_theme', 'showcase_theme_setting_defaults' );
function showcase_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,
			'content_archive'           => 'full',
			'content_archive_limit'     => 140,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignnone',
			'image_size'                => 'showcase_archive',
			'posts_nav'                 => 'prev-next',
			'site_layout'               => 'full-width-content',
		) );

	}

	update_option( 'posts_per_page', 3 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'digital_social_default_styles' );
function digital_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#333333',
		'background_color_hover' => '#333333',
		'border_color'           => '#333333',
		'border_color_hover'     => '#333333',
		'border_radius'          => 48,
		'border_width'           => 0,
		'icon_color'             => '#999999',
		'icon_color_hover'       => '#EEEEEE',
		'size'                   => 36,
		);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
