<?php

//* Ambiance Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'ambiance_theme_defaults' );
function ambiance_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;	
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignleft';
	$defaults['image_size']                = 'entry-image';
	$defaults['posts_nav']                 = 'prev-next';

	return $defaults;

}

//* Ambiance Theme Setup
add_action( 'after_switch_theme', 'ambiance_theme_setting_defaults' );
function ambiance_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignleft',
			'image_size'                => 'entry-image',
			'posts_nav'                 => 'prev-next',
		) );
	
	} else {
	
		_genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignleft',
			'image_size'                => 'entry-image',
			'posts_nav'                 => 'prev-next',
		) );
	
	}

	update_option( 'posts_per_page', 6 );

}