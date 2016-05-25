<?php

//* Milan Pro Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'milan_defaults' );
function milan_defaults( $defaults ) {

	$defaults['posts_nav']                 = 'older-newer';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

//* Milan Pro Theme Setup
add_action( 'after_switch_theme', 'milan_setting_defaults' );
function milan_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'posts_nav'                 => 'older-newer',
			'site_layout'               => 'content-sidebar',
		) );

	} else {

		_genesis_update_settings( array(
			'posts_nav'                 => 'older-newer',
			'site_layout'               => 'content-sidebar',
		) );
		
	}

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'milan_social_default_styles' );
function milan_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#000',
		'background_color_hover' => '#404040',
		'border_radius'          => 50,
		'icon_color'             => '#fff',
		'icon_color_hover'       => '#fff',
		'size'                   => 56,
	);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}
