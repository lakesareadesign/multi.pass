<?php
/**
 * eleven40 Pro.
 *
 * This file adds the default theme settings to the eleven40 Pro Theme.
 *
 * @package eleven40
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/eleven40/
 */

add_filter( 'genesis_theme_settings_defaults', 'eleven40_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 2.1.1
 */
function eleven40_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 5;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'sidebar-content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'eleven40_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 2.1.1
 */
function eleven40_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 5,
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'sidebar-content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 5 );

}

add_filter( 'simple_social_default_styles', 'eleven40_social_default_styles' );
/**
* Updates Simple Social Icon settings.
*
* @since 2.1.1
*/
function eleven40_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#333333',
		'background_color_hover' => '#555555',
		'border_radius'          => 3,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 36,
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
