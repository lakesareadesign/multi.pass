<?php
/**
 * Agency Pro.
 *
 * This file adds the default theme settings to the Agency Pro Theme.
 *
 * @package Agency
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/agency/
 */

add_filter( 'genesis_theme_settings_defaults', 'agency_theme_defaults' );
/**
* Updates theme settings on reset.
*
* @since 3.1.0
*/
function agency_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 10;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'agency_theme_setting_defaults' );
/**
* Updates theme settings on activation.
*
* @since 3.1.0
*/
function agency_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 10,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 10 );

}

add_filter( 'simple_social_default_styles', 'agency_social_default_styles' );
/**
* Updates Simple Social Icon settings on activation.
*
* @since 3.1.0
*/
function agency_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#f9f9f9',
		'background_color_hover' => '#f9f9f9',
		'border_radius'          => 3,
		'icon_color'             => '#aaaaaa',
		'icon_color_hover'       => '#222222',
		'size'                   => 36,
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
