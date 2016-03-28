<?php
/**
 * Interior Pro.
 *
 * This file adds the front page to the Interior Pro Theme.
 *
 * @package Interior
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/interior/
 */


add_action( 'genesis_meta', 'interior_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function interior_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) ) {

		//* Enqueue scripts
		add_action( 'wp_enqueue_scripts', 'interior_enqueue_front_script_styles' );
		function interior_enqueue_front_script_styles() {

			wp_enqueue_style( 'interior-front-styles', get_stylesheet_directory_uri() . '/style-front.css' );

		}

		//* Add front-page body class
		add_filter( 'body_class', 'interior_body_class' );
		function interior_body_class( $classes ) {

   			$classes[] = 'front-page';

  			return $classes;

		}

		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//* Remove After Header
		if ( is_active_sidebar( 'front-page-1' ) ) {
			remove_action( 'genesis_after_header', 'interior_open_after_header', 5 );
			remove_action( 'genesis_after_header', 'interior_close_after_header', 15 );
		}

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add homepage widgets
		add_action( 'genesis_loop', 'interior_front_page_widgets' );

	}

}

//* Add markup for front page widgets
function interior_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'interior' ) . '</h2>';

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1 after-header"><div class="flexible-widgets widget-area' . interior_widget_area_class( 'front-page-1' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2"><div class="flexible-widgets widget-area' . interior_widget_area_class( 'front-page-2' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3"><div class="flexible-widgets widget-area' . interior_widget_area_class( 'front-page-3' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

//* Run the Genesis loop
genesis();
