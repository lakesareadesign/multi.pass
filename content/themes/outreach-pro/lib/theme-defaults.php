<?php

//* Outreach Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'outreach_theme_defaults' );
function outreach_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 5;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* Outreach Theme Setup
add_action( 'after_switch_theme', 'outreach_theme_setting_defaults' );
function outreach_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 5,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
		
		genesis_update_settings( array(
			'location_horizontal'             => 'left',
			'location_vertical'               => 'bottom',
			'posts_num'                       => '4',
			'slideshow_excerpt_content_limit' => '100',
			'slideshow_excerpt_content'       => 'full',
			'slideshow_excerpt_width'         => '35',
			'slideshow_height'                => '460',
			'slideshow_more_text'             => __( 'Continue Reading', 'outreach' ),
			'slideshow_title_show'            => 1,
			'slideshow_width'                 => '1140',
		), GENESIS_RESPONSIVE_SLIDER_SETTINGS_FIELD );
		
	} else {
		
		_genesis_update_settings( array(
			'blog_cat_num'              => 5,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
		
		_genesis_update_settings( array(
			'location_horizontal'             => 'left',
			'location_vertical'               => 'bottom',
			'posts_num'                       => '4',
			'slideshow_excerpt_content_limit' => '100',
			'slideshow_excerpt_content'       => 'full',
			'slideshow_excerpt_width'         => '35',
			'slideshow_height'                => '460',
			'slideshow_more_text'             => __( 'Continue Reading', 'outreach' ),
			'slideshow_title_show'            => 1,
			'slideshow_width'                 => '1140',
		), GENESIS_RESPONSIVE_SLIDER_SETTINGS_FIELD );

	}

	update_option( 'posts_per_page', 5 );

}

//* Set Genesis Responsive Slider defaults
add_filter( 'genesis_responsive_slider_settings_defaults', 'outreach_responsive_slider_defaults' );
function outreach_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'left',
		'location_vertical'               => 'bottom',
		'posts_num'                       => '4',
		'slideshow_excerpt_content_limit' => '100',
		'slideshow_excerpt_content'       => 'full',
		'slideshow_excerpt_width'         => '35',
		'slideshow_height'                => '460',
		'slideshow_more_text'             => __( 'Continue Reading', 'outreach' ),
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '1140',
	);

	$args = wp_parse_args( $args, $defaults );
	
	return $args;
}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'outreach_social_default_styles' );
function outreach_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignright',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#333333',
		'border_radius'          => 3,
		'icon_color'             => '#333333',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 36,
		);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}