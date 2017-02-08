<?php
/**
 * Wellness Pro.
 *
 * This file adds the default theme settings to the Wellness Pro Theme.
 *
 * @package Wellness
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/wellness/
 */

add_filter( 'genesis_theme_settings_defaults', 'wellness_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 1.0.0
 */
function wellness_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignnone';
	$defaults['posts_nav']                 = 'prev-next';
	$defaults['image_size']                = 'featured-image-large';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

add_action( 'after_switch_theme', 'wellness_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 1.0.0
 */
function wellness_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignnone',
			'image_size'                => 'featured-image-large',
			'posts_nav'                 => 'prev-next',
			'site_layout'               => 'full-width-content',
		) );

	}

	update_option( 'posts_per_page', 6 );

}
