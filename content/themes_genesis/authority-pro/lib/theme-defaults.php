<?php
/**
 * Authority Pro.
 *
 * This file adds the default theme settings to the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

add_filter( 'genesis_theme_settings_defaults', 'authority_theme_defaults' );
/**
 * Updates theme settings on reset.
 *
 * @since 1.0.0
 *
 * @param array $defaults Default theme settings.
 * @return array Modified defaults.
 */
function authority_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 200;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'aligncenter';
	$defaults['image_size']                = 'blog-featured-image';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'authority_theme_setting_defaults' );
/**
 * Updates theme settings on activation.
 *
 * @since 1.0.0
 */
function authority_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,
			'content_archive'           => 'full',
			'content_archive_limit'     => 200,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'aligncenter',
			'image_size'                => 'blog-featured-image',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 6 );

}
