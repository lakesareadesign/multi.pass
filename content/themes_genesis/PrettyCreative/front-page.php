<?php
/**
 * This file adds the Home Page to the Pretty Creative Theme.
 *
 * @author Lindsey Riel
 * @package Pretty Creative
 */

add_action( 'genesis_meta', 'prettycreative_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function prettycreative_home_genesis_meta() {

	if ( is_active_sidebar( is_active_sidebar( 'home-subscribe-widget' ) || 'home-top' ) || is_active_sidebar( 'home-portfolio-widget' ) || is_active_sidebar( 'home-page-1' ) || is_active_sidebar( 'home-page-2' ) || is_active_sidebar( 'home-page-3' ) ) {


		//* Add prettycreative-home body class
		add_filter( 'body_class', 'prettycreative_body_class' );
		function prettycreative_body_class( $classes ) {
		
   			$classes[] = 'prettycreative-home';
  			return $classes;
  			
		}

		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add bottom homepage widgets
		add_action( 'genesis_loop', 'prettycreative_homepage_widgets' );

	}
}

//* Add homepage widgets
function prettycreative_homepage_widgets() {

	genesis_widget_area( 'home-subscribe-widget', array(
		'before' => '<div id="home-subscribe-widget" class="home-subscribe-widget"><div class="widget-area ' . prettycreative_widget_area_class( 'home-subscribe-widget' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'home-top', array(
		'before' => '<div id="home-top" class="home-top"><div class="widget-area ' . prettycreative_widget_area_class( 'home-top' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'home-portfolio-widget', array(
		'before' => '<div id="home-portfolio-widget" class="home-portfolio-widget"><div class="widget-area ' . prettycreative_widget_area_class( 'home-portfolio-widget' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	
	genesis_widget_area( 'home-page-1', array(
		'before' => '<div id="home-page-1" class="home-page-1"><div class="widget-area ' . prettycreative_widget_area_class( 'home-page-1' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'home-page-2', array(
		'before' => '<div id="home-page-2" class="home-page-2"><div class="widget-area ' . prettycreative_widget_area_class( 'home-page-2' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'home-page-3', array(
		'before' => '<div id="home-page-3" class="home-page-3"><div class="widget-area ' . prettycreative_widget_area_class( 'home-page-3' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );
}

genesis();
