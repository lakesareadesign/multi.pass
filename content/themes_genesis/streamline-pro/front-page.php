<?php
/**
 * This file adds the Home Page to the Streamline Pro Theme.
 *
 * @author StudioPress
 * @package Streamline Pro
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'streamline_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function streamline_home_genesis_meta() {

	if ( is_active_sidebar( 'home-featured-1' ) || is_active_sidebar( 'home-featured-2' ) || is_active_sidebar( 'home-featured-3' ) ) {
	
		//* Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
	
		// Add streamline-pro-home body class
		add_filter( 'body_class', 'streamline_body_class' );
	
		// Add homepage widgets
		add_action( 'genesis_before_content_sidebar_wrap', 'streamline_homepage_widgets' );

	}
}

function streamline_body_class( $classes ) {

	$classes[] = 'streamline-pro-home';
	return $classes;
	
}

function streamline_homepage_widgets() {

	if ( is_active_sidebar( 'home-featured-1' ) || is_active_sidebar( 'home-featured-2' ) || is_active_sidebar( 'home-featured-3' ) ) {

		echo '<div class="home-featured">';
	
		genesis_widget_area( 'home-featured-1', array(
			'before' => '<div class="home-featured-1 widget-area">',
			'after'  => '</div>',
		) );
		
		genesis_widget_area( 'home-featured-2', array(
			'before' => '<div class="home-featured-2 widget-area">',
			'after'  => '</div>',
		) );
		
		genesis_widget_area( 'home-featured-3', array(
			'before' => '<div class="home-featured-3 widget-area">',
			'after'  => '</div>',
		) );

		echo '</div><!-- end #home-featured -->';	

	}

}

genesis();
