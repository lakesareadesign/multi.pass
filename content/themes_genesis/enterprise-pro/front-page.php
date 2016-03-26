<?php
/**
 * This file adds the Home Page to the Enterprise Pro Theme.
 *
 * @author StudioPress
 * @package Enterprise Pro
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'enterprise_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function enterprise_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-bottom' ) ) {

		//* Force full-width-content layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//* Add enterprise-pro-home body class
		add_filter( 'body_class', 'enterprise_body_class' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add home top widgets
		add_action( 'genesis_after_header', 'enterprise_home_top_widgets' );
		
		//* Add home bottom widgets
		add_action( 'genesis_loop', 'enterprise_home_bottom_widgets' );

	}
}

function enterprise_body_class( $classes ) {

		$classes[] = 'enterprise-pro-home';
		return $classes;
		
}

function enterprise_home_top_widgets() {

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );
	
}

function enterprise_home_bottom_widgets() {
	
	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="home-bottom widget-area">',
		'after'  => '</div>',
	) );

}

genesis();
