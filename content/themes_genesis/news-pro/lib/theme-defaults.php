<?php
/**
 * News Pro.
 *
 * This file adds the default theme settings to the News Pro Theme.
 *
 * @package News
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/news/
 */

add_filter( 'genesis_theme_settings_defaults', 'news_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 3.0.2
 */
function news_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 10;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'news_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 3.0.2
 */
function news_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 10,
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

		if ( function_exists( 'GenesisResponsiveSliderInit' ) ) {

			genesis_update_settings( array(
				'location_horizontal'             => 'left',
				'location_vertical'               => 'top',
				'posts_num'                       => '5',
				'slideshow_arrows'                => 0,
				'slideshow_excerpt_content_limit' => '100',
				'slideshow_excerpt_content'       => 'full',
				'slideshow_excerpt_width'         => '100',
				'slideshow_excerpt_show'          => 0,
				'slideshow_height'                => '400',
				'slideshow_more_text'             => __( 'Continue Reading&hellip;', 'news-pro' ),
				'slideshow_pager'                 => 1,
				'slideshow_title_show'            => 1,
				'slideshow_width'                 => '737',
			), GENESIS_RESPONSIVE_SLIDER_SETTINGS_FIELD );

		}

	}

	update_option( 'posts_per_page', 10 );

}

add_filter( 'genesis_responsive_slider_settings_defaults', 'news_responsive_slider_defaults' );
/**
 * Updates Genesis Responsive Slider settings on activation.
 *
 * @since 3.0.2
 */
function news_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'left',
		'location_vertical'               => 'top',
		'posts_num'                       => '5',
		'slideshow_arrows'                => 0,
		'slideshow_excerpt_content_limit' => '100',
		'slideshow_excerpt_content'       => 'full',
		'slideshow_excerpt_width'         => '100',
		'slideshow_excerpt_show'          => 0,
		'slideshow_height'                => '400',
		'slideshow_more_text'             => __( 'Continue Reading&hellip;', 'news-pro' ),
		'slideshow_pager'                 => 1,
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '737',
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;
}

add_filter( 'simple_social_default_styles', 'news_social_default_styles' );
/**
 * Updates Simple Social Icon settings on activation.
 *
 * @since 3.0.2
 */
function news_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#f6f5f2',
		'background_color_hover' => '#000000',
		'border_radius'          => 3,
		'icon_color'             => '#aaaaaa',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 36,
		);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
