<?php
/**
 * Daily Dish Pro.
 *
 * This file adds the default theme settings to the Daily Dish Pro Theme.
 *
 * @package Daily Dish Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/daily-dish/
 */

add_filter( 'genesis_theme_settings_defaults', 'daily_dish_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @param array $defaults Theme settings defaults.
 * @since 1.0.0
 *
 * @return array Modified theme defaults.
 */
function daily_dish_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 5;
	$defaults['content_archive_limit']     = 280;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['image_size']                = 'daily-dish-archive';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'daily_dish_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 1.0.0
 */
function daily_dish_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 5,
			'content_archive_limit'     => 280,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignleft',
			'image_size'                => 'daily-dish-archive',
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
				'slideshow_excerpt_width'         => '40',
				'slideshow_excerpt_show'          => 1,
				'slideshow_height'                => '400',
				'slideshow_more_text'             => __( 'Continue Reading&hellip;', 'daily-dish-pro' ),
				'slideshow_pager'                 => 1,
				'slideshow_title_show'            => 1,
				'slideshow_width'                 => '720',
			), GENESIS_RESPONSIVE_SLIDER_SETTINGS_FIELD );

		}

	}

	update_option( 'posts_per_page', 5 );

}

add_filter( 'genesis_responsive_slider_settings_defaults', 'daily_dish_responsive_slider_defaults' );
/**
 * Set Genesis Responsive Slider defaults.
 *
 * @param array $defaults Slider defaults.
 * @since 1.0.0
 *
 * @return array Modified defaults.
 */
function daily_dish_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'left',
		'location_vertical'               => 'top',
		'posts_num'                       => '5',
		'slideshow_arrows'                => 0,
		'slideshow_excerpt_content_limit' => '100',
		'slideshow_excerpt_content'       => 'full',
		'slideshow_excerpt_width'         => '40',
		'slideshow_excerpt_show'          => 1,
		'slideshow_height'                => '400',
		'slideshow_more_text'             => __( 'Continue Reading&hellip;', 'daily-dish-pro' ),
		'slideshow_pager'                 => 1,
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '720',
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}

add_filter( 'simple_social_default_styles', 'daily_dish_social_default_styles' );
/**
 * Set Simple Social Icon defaults.
 *
 * @param array $defaults Social style defaults.
 * @since 1.0.0
 *
 * @return array Modified social style defaults.
 */
function daily_dish_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#f5f5f5',
		'background_color_hover' => '#d9037f',
		'border_radius'          => 0,
		'icon_color'             => '#000000',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 36,
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
