<?php
/**
 * Interior Pro.
 *
 * This file adds the default theme settings to the Interior Pro Theme.
 *
 * @package Interior
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/interior/
 */

//* Interior Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'interior_theme_defaults' );
function interior_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 3;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'sidebar-content';

	return $defaults;

}

//* Interior Theme Setup
add_action( 'after_switch_theme', 'interior_theme_setting_defaults' );
function interior_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 3,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'sidebar-content',
		) );
		
	} 

	update_option( 'posts_per_page', 3 );

}
