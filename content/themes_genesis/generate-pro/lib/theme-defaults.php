<?php

//* generate Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'generate_theme_defaults' );
function generate_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['image_size']                = 'blog';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* generate Theme Setup
add_action( 'after_switch_theme', 'generate_theme_setting_defaults' );
function generate_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignleft',
			'image_size'                => 'blog',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

		if ( function_exists( 'GenesisResponsiveSliderInit' ) ) {

			genesis_update_settings( array(
				'location_horizontal'             => 'left',
				'location_vertical'               => 'bottom',
				'posts_num'                       => '4',
				'slideshow_arrows'                => 0,
				'slideshow_excerpt_content_limit' => '100',
				'slideshow_excerpt_content'       => 'full',
				'slideshow_excerpt_width'         => '40',
				'slideshow_height'                => '460',
				'slideshow_more_text'             => __( 'Continue Reading', 'generate' ),
				'slideshow_pager'                 => 1,
				'slideshow_title_show'            => 1,
				'slideshow_width'                 => '1060',
			), GENESIS_RESPONSIVE_SLIDER_SETTINGS_FIELD );
		
		}

	}

	update_option( 'posts_per_page', 3 );

}

//* Set Genesis Responsive Slider defaults
add_filter( 'genesis_responsive_slider_settings_defaults', 'generate_responsive_slider_defaults' );
function generate_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'left',
		'location_vertical'               => 'bottom',
		'posts_num'                       => '4',
		'slideshow_arrows'                => 0,
		'slideshow_excerpt_content_limit' => '100',
		'slideshow_excerpt_content'       => 'full',
		'slideshow_excerpt_width'         => '40',
		'slideshow_height'                => '460',
		'slideshow_more_text'             => __( 'Continue Reading', 'generate' ),
		'slideshow_pager'                 => 1,
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '1060',
	);

	$args = wp_parse_args( $args, $defaults );
	
	return $args;
}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'generate_social_default_styles' );
function generate_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#ffffff',
		'background_color_hover' => '#ffffff',
		'border_radius'          => 3,
		'icon_color'             => '#222222',
		'icon_color_hover'       => '#999999',
		'size'                   => 36,
	);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}