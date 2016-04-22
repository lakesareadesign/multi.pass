<?php

//* Digital Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'digital_theme_defaults' );
function digital_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 160;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignright';
	$defaults['image_size']                = 'front-page-featured';
	$defaults['posts_nav']                 = 'prev-next';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

//* Digital Theme Setup
add_action( 'after_switch_theme', 'digital_theme_setting_defaults' );
function digital_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 160,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignright',
			'image_size'                => 'front-page-featured',
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
		'background_color'       => '#232525',
		'background_color_hover' => '#ffffff',
		'border_color'           => '#ffffff',
		'border_color_hover'     => '#ffffff',
		'border_radius'          => 36,
		'border_width'           => 1,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#232525',
		'size'                   => 36,
		);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
