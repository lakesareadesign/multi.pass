<?php
/**
 * This file adds the Home Page to the Cafe Pro Theme.
 *
 * @author StudioPress
 * @package Cafe
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'cafe_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function cafe_home_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) ) {

		//* Enqueue home script
		add_action( 'wp_enqueue_scripts', 'cafe_enqueue_cafe_script' );
		function cafe_enqueue_cafe_script() {

			wp_enqueue_script( 'home-script', get_bloginfo( 'stylesheet_directory' ) . '/js/home.js', array( 'jquery' ), '1.0.0' );

		}

		//* Add cafe-pro-home body class
		add_filter( 'body_class', 'cafe_body_class' );
		function cafe_body_class( $classes ) {
		
   			$classes[] = 'cafe-pro-home';
  			return $classes;
  			
		}

		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//* Remove primary navigation
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add bottom homepage widgets
		add_action( 'genesis_loop', 'cafe_homepage_widgets' );

	}
}

//* Add markup for bottom homepage widgets
function cafe_homepage_widgets() {

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1 solid-section"><div class="widget-area ' . cafe_widget_area_class( 'front-page-1' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );
	
	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2 image-section"><div class="widget-area ' . cafe_widget_area_class( 'front-page-2' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3 solid-section"><div class="widget-area ' . cafe_widget_area_class( 'front-page-3' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4 image-section"><div class="widget-area ' . cafe_widget_area_class( 'front-page-4' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

genesis();
