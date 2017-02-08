<?php
/**
 * Metro Pro.
 *
 * This file adds the front page to the Metro Pro Theme.
 *
 * @package Metro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/metro/
 */

add_action( 'genesis_meta', 'metro_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 2.0.0
 */
function metro_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle-left' ) || is_active_sidebar( 'home-middle-right' ) || is_active_sidebar( 'home-bottom' ) ) {

		// Force content-sidebar layout setting.
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

		// Add metro-pro-home body class.
		add_filter( 'body_class', 'metro_body_class' );

		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets.
		add_action( 'genesis_loop', 'metro_homepage_widgets' );

	}
}

function metro_body_class( $classes ) {

	$classes[] = 'metro-pro-home';
	
	return $classes;

}

function metro_homepage_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'metro-pro' ) . '</h2>';

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );

	if ( is_active_sidebar( 'home-middle-left' ) || is_active_sidebar( 'home-middle-right' ) ) {

		echo '<div class="home-middle">';

		genesis_widget_area( 'home-middle-left', array(
			'before' => '<div class="home-middle-left widget-area">',
			'after'  => '</div>',
		) );

		genesis_widget_area( 'home-middle-right', array(
			'before' => '<div class="home-middle-right widget-area">',
			'after'  => '</div>',
		) );

		echo '</div>';

	}

	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="home-bottom widget-area">',
		'after'  => '</div>',
	) );

}

// Run the Genesis loop.
genesis();
