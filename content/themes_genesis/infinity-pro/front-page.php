<?php
/**
 * Infinity Pro.
 *
 * This file adds the front page to the Infinity Pro Theme.
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */

add_action( 'genesis_meta', 'infinity_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 * @since 1.0.0
 */
function infinity_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) || is_active_sidebar( 'front-page-6' ) || is_active_sidebar( 'front-page-7' ) ) {

		// Enqueue scripts.
		add_action( 'wp_enqueue_scripts', 'infinity_enqueue_front_script_styles', 1 );
		function infinity_enqueue_front_script_styles() {

			wp_enqueue_script( 'infinity-front-scripts', get_stylesheet_directory_uri() . '/js/front-page.js', array( 'jquery', 'infinity-responsive-menu' ), CHILD_THEME_VERSION, true );

			wp_enqueue_style( 'infinity-front-styles', get_stylesheet_directory_uri() . '/css/style-front.css' );

		}

		// Add front-page body class.
		add_filter( 'body_class', 'infinity_body_class' );
		function infinity_body_class( $classes ) {

			$classes[] = 'front-page';

			return $classes;

		}

		// Force full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Remove breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Remove the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Remove site footer widgets.
		remove_theme_support( 'genesis-footer-widgets' );

		// Add front page widgets.
		add_action( 'genesis_loop', 'infinity_front_page_widgets' );

	}

}

// Add markup for front page widgets.
function infinity_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'infinity-pro' ) . '</h2>';

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1"><div class="image-section widget-area fadeup-effect"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2"><div class="solid-section flexible-widgets widget-area fadeup-effect' . infinity_widget_area_class( 'front-page-2' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3"><div class="image-section flexible-widgets widget-area fadeup-effect' . infinity_widget_area_class( 'front-page-3' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4"><div class="solid-section flexible-widgets widget-area fadeup-effect' . infinity_widget_area_class( 'front-page-4' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-5', array(
		'before' => '<div id="front-page-5" class="front-page-5"><div class="image-section flexible-widgets widget-area fadeup-effect' . infinity_widget_area_class( 'front-page-5' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	// Add entry-title filter.
	add_filter( 'genesis_featured_page_title', 'infinity_title' );

	// Add team-member class.
	add_filter( 'genesis_attr_entry', 'infinity_widget_entry_open' );

	genesis_widget_area( 'front-page-6', array(
		'before' => '<div id="front-page-6" class="front-page-6"><div class="solid-section flexible-widgets widget-area fadeup-effect' . infinity_widget_area_class( 'front-page-6' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	// Remove entry-title filter.
	add_filter( 'genesis_featured_page_title', 'infinity_title' );

	// Remove team-member class.
	remove_filter( 'genesis_attr_entry', 'infinity_widget_entry_open' );

	genesis_widget_area( 'front-page-7', array(
		'before' => '<div id="front-page-7" class="front-page-7"><div class="image-section flexible-widgets widget-area fadeup-effect' . infinity_widget_area_class( 'front-page-7' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

// Modify the entry title text.
function infinity_title( $title ) {

	if ( genesis_get_custom_field( 'team_title' ) ) {
		$title = '<span class="team-name">' . $title . '</span><span class="team-title">' . genesis_get_custom_field( 'team_title' ) . '</span>';
	} else {
		$title = '<span class="team-name">' . $title . '</span>';
	}

	return $title;

}

// Modify featred page entry classes.
function infinity_widget_entry_open( $attributes ) {

	if( is_page() ) {
		$attributes['class'] = $attributes['class'] . ' ' . 'team-member';
	}

	return $attributes;

}

// Run the Genesis loop.
genesis();
