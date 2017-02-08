<?php
/**
 * Executive Pro.
 *
 * This file adds the default theme settings to the Executive Pro Theme.
 *
 * @package Executive
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/executive/
 */

add_filter( 'genesis_theme_settings_defaults', 'executive_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 3.0.1
 */
function executive_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'executive_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 3.0.1
 */
function executive_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,
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
				'posts_num'                       => '3',
				'slideshow_excerpt_content_limit' => '100',
				'slideshow_excerpt_content'       => 'full',
				'slideshow_excerpt_width'         => '30',
				'slideshow_height'                => '445',
				'slideshow_more_text'             => __( 'Continue Reading&hellip;', 'executive-pro' ),
				'slideshow_title_show'            => 1,
				'slideshow_width'                 => '1140',
			), GENESIS_RESPONSIVE_SLIDER_SETTINGS_FIELD );

		}

	}

	update_option( 'posts_per_page', 6 );

	flush_rewrite_rules( false );

}

add_filter( 'genesis_responsive_slider_settings_defaults', 'executive_responsive_slider_defaults' );
/**
 * Updates Genesis Responsive Slider settings on activation.
 *
 * @since 3.0.1
 */
function executive_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'left',
		'location_vertical'               => 'top',
		'posts_num'                       => '3',
		'slideshow_excerpt_content_limit' => '100',
		'slideshow_excerpt_content'       => 'full',
		'slideshow_excerpt_width'         => '30',
		'slideshow_height'                => '445',
		'slideshow_more_text'             => __( 'Continue Reading&hellip;', 'executive-pro' ),
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '1140',
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;
}
