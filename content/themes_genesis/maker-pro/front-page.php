<?php
/**
 * This file adds the Front Page to the Maker Pro Theme.
 *
 * @author JT Grauke
 * @package Maker Pro
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'maker_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function maker_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4') || is_active_sidebar( 'front-page-5') || is_active_sidebar( 'front-page-6') || is_active_sidebar( 'front-page-7') || is_active_sidebar( 'front-page-8') || is_active_sidebar( 'front-page-9') || is_active_sidebar( 'front-page-10') ) {

		//* Enqueue scripts
		add_action( 'wp_enqueue_scripts', 'maker_enqueue_script' );
		function maker_enqueue_script() {

			wp_enqueue_style( 'maker-front-styles', get_stylesheet_directory_uri() . '/style-front.css', array(), CHILD_THEME_VERSION );

		}

		//* Add front-page body class
		add_filter( 'body_class', 'maker_body_class' );
		function maker_body_class( $classes ) {

			$classes[] = 'front-page';
			return $classes;

		}

		//* Force full width content layout
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Add widgets on front page
		add_action( 'genesis_after_header', 'maker_front_page_widgets' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Remove .site-inner
		add_filter( 'genesis_markup_site-inner', '__return_null' );
		add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
		add_filter( 'genesis_markup_content', '__return_null' );
		add_theme_support( 'genesis-structural-wraps', array( 'header', 'footer-widgets', 'footer' ) );

	}

}

//* Add widgets on front page
function maker_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'maker' ) . '</h2>';

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div class="front-page-1"><div class="wrap"><div class="two-thirds only widget-area">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div class="front-page-2 flexible-widget-area"><div class="flexible-widgets widget-area' . maker_widget_area_class( 'front-page-2' ) . '">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div class="front-page-3"><div class="wrap"><div class="three-fourths only widget-area">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div class="front-page-4"><div class="wrap"><div class="widget-area">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-5', array(
		'before' => '<div class="front-page-5"><div class="widget-area">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-6', array(
		'before' => '<div class="front-page-6"><div class="wrap"><div class="widget-area">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-7', array(
		'before' => '<div class="front-page-7 flexible-widget-area"><div class="wrap"><div class="flexible-widgets widget-area' . maker_widget_area_class( 'front-page-7' ) . '">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-8', array(
		'before' => '<div class="front-page-8"><div class="wrap"><div class="flexible-widgets widget-area">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-9', array(
		'before' => '<div class="front-page-9"><div class="wrap"><div class="three-fourths only widget-area">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-10', array(
		'before' => '<div class="front-page-10"><div class="widget-area">',
		'after'  => '</div></div>',
	) );

}

//* Run the Genesis function
genesis();
