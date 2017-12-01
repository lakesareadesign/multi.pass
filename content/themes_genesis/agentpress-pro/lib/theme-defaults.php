<?php
/**
 * AgentPress Pro.
 *
 * This file adds the default theme settings to the AgentPress Pro Theme.
 *
 * @package AgentPress
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/agencypress/
 */

add_filter( 'genesis_theme_settings_defaults', 'agentpress_theme_defaults' );
/**
* Updates theme settings on reset.
*
* @since 3.1.0
*/
function agentpress_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;	
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'agentpress_theme_setting_defaults' );
/**
* Updates theme settings on activation.
*
* @since 3.1.0
*/
function agentpress_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'image_alignment'           => 'alignleft',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 6 );

}
