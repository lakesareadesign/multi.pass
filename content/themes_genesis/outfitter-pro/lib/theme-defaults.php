<?php
/**
 * Outfitter Pro.
 *
 * This file adds the default theme settings to the Outfitter Pro Theme.
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

add_filter( 'genesis_theme_settings_defaults', 'outfitter_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 1.0.0
 */
function outfitter_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 9;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 500;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_size']                = 'featured-image';
	$defaults['image_alignment']           = 'aligncenter';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

add_action( 'after_switch_theme', 'outfitter_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 1.0.0
 */
function outfitter_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 9,
			'content_archive'           => 'full',
			'content_archive_limit'     => 500,
			'content_archive_thumbnail' => 1,
			'image_size'                => 'featured-image',
			'image_alignment '          => 'aligncenter',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'full-width-content',
		) );

	} 

	update_option( 'posts_per_page', 9 );

}
