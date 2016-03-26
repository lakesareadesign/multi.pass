<?php

//* Whitespace Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'whitespace_theme_defaults' );
function whitespace_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 150;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = '';
	$defaults['image_size']                = 'entry-image';
	$defaults['posts_nav']                 = 'prev-next';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

//* Whitespace Theme Setup
add_action( 'after_switch_theme', 'whitespace_theme_setting_defaults' );
function whitespace_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,
			'content_archive'           => 'full',
			'content_archive_limit'     => 150,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => '',
			'image_size'                => 'entry-image',
			'posts_nav'                 => 'prev-next',
			'site_layout'               => 'full-width-content',
		) );
		
		if ( function_exists( 'GenesisResponsiveSliderInit' ) ) {
		
			genesis_update_settings( array(
				'location_horizontal'             => 'left',
				'location_vertical'               => 'top',
				'posts_num'                       => '5',
				'slideshow_arrows'                => 1,
				'slideshow_excerpt_content_limit' => '100',
				'slideshow_excerpt_content'       => 'full',
				'slideshow_excerpt_width'         => '40',
				'slideshow_excerpt_show'          => 1,
				'slideshow_height'                => '580',
				'slideshow_more_text'             => __( 'Continue Reading&hellip;', 'ranmaker-default' ),
				'slideshow_pager'                 => 0,
				'slideshow_title_show'            => 1,
				'slideshow_width'                 => '1200',
			), GENESIS_RESPONSIVE_SLIDER_SETTINGS_FIELD );
		
		}
	
	} else {
	
		_genesis_update_settings( array(
			'blog_cat_num'              => 6,
			'content_archive'           => 'full',
			'content_archive_limit'     => 150,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => '',
			'image_size'                => 'entry-image',
			'posts_nav'                 => 'prev-next',
			'site_layout'               => 'full-width-content',
		) );
		
		if ( function_exists( 'GenesisResponsiveSliderInit' ) ) {
				
			_genesis_update_settings( array(
				'location_horizontal'             => 'left',
				'location_vertical'               => 'top',
				'posts_num'                       => '5',
				'slideshow_arrows'                => 1,
				'slideshow_excerpt_content_limit' => '100',
				'slideshow_excerpt_content'       => 'full',
				'slideshow_excerpt_width'         => '40',
				'slideshow_excerpt_show'          => 1,
				'slideshow_height'                => '400',
				'slideshow_more_text'             => __( 'Continue Reading&hellip;', 'ranmaker-default' ),
				'slideshow_pager'                 => 0,
				'slideshow_title_show'            => 1,
				'slideshow_width'                 => '1200',
			), GENESIS_RESPONSIVE_SLIDER_SETTINGS_FIELD );
		
		}
	
	}

	update_option( 'posts_per_page', 6 );

}

//* Set Genesis Responsive Slider defaults
add_filter( 'genesis_responsive_slider_settings_defaults', 'rainmaker_responsive_slider_defaults' );
function rainmaker_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'left',
		'location_vertical'               => 'top',
		'posts_num'                       => '5',
		'slideshow_arrows'                => 1,
		'slideshow_excerpt_content_limit' => '100',
		'slideshow_excerpt_content'       => 'full',
		'slideshow_excerpt_width'         => '40',
		'slideshow_excerpt_show'          => 1,
		'slideshow_height'                => '400',
		'slideshow_more_text'             => __( 'Continue Reading&hellip;', 'ranmaker-default' ),
		'slideshow_pager'                 => 0,
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '1200',
	);

	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'whitespace_social_default_styles' );
function whitespace_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#00a99d',
		'background_color_hover' => '#00baad',
		'border_radius'          => 3,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 60,
		);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}
