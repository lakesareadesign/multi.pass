<?php
/**
 * This file adds the Home Page to the Outreach Pro Theme.
 *
 * @author StudioPress
 * @package Outreach Pro
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'outreach_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function outreach_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-bottom' ) ) {

		//* Force full-width-content layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		
		//* Add outreach-pro-home body class
		add_filter( 'body_class', 'outreach_body_class' );
		
		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		
		//* Add home top widgets
		add_action( 'genesis_loop', 'outreach_home_top_widgets' );

		//* Add home bottom widgets
		add_action( 'genesis_before_footer', 'outreach_home_bottom_widgets', 1 );

	}

}

function outreach_body_class( $classes ) {

	$classes[] = 'outreach-pro-home';
	return $classes;
	
}

function outreach_home_top_widgets() {

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );
	
}

function outreach_home_bottom_widgets() {
	
	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="home-bottom widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

genesis();
