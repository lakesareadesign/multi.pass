<?php
/**
 * Outfitter Pro.
 *
 * This file adds the front page to the Outfitter Pro Theme.
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

add_action( 'genesis_meta', 'outfitter_front_page_genesis_meta' );
/**
 * Adds widget support for homepage. If no widgets active, displays the default loop.
 *
 * @since 1.0.0
 */
function outfitter_front_page_genesis_meta() {
	
	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || ( class_exists( 'WooCommerce' ) && current_theme_supports( 'woocommerce' ) && get_posts('post_type=product&posts_per_page=1') ) ) {

		// Enqueues scripts.
		add_action( 'wp_enqueue_scripts', 'outfitter_enqueue_front_script_styles' );

		// Adds the front-page body class.
		add_filter( 'body_class', 'outfitter_body_class' );

		// Forces full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Removes breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Removes the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Adds front page widgets.
		add_action( 'genesis_loop', 'outfitter_front_page_widgets' );

	}

}

// Defines the front-page styles and scripts.
function outfitter_enqueue_front_script_styles() {

	wp_enqueue_style( 'outfitter-front-styles', get_stylesheet_directory_uri() . '/style-front.css' );
	wp_enqueue_script( 'jquery-masonry', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'outfitter-masonry-args', get_stylesheet_directory_uri() . '/js/masonry-args.js', array( 'jquery-masonry', 'jquery' ), '1.0.0', true );

}

// Defines the front-page body class.
function outfitter_body_class( $classes ) {

	$classes[] = 'front-page';
	return $classes;

}

// Adds markup for front page widgets.
function outfitter_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'outfitter-pro' ) . '</h2>';

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1"><div class="flexible-widgets widget-area clearfix' . outfitter_widget_area_class( 'front-page-1' ) . '">',
		'after'  => '</div></div>',
	) );

	if ( is_active_sidebar( 'front-page-2' ) ) {

		genesis_widget_area( 'front-page-2', array(
			'before' => '<div id="front-page-2" class="front-page-2"><div class="flexible-widgets widget-area clearfix' . outfitter_widget_area_class( 'front-page-2' ) . '">',
			'after'  => '</div></div>',
		) );

	} else {

		if( class_exists( 'WooCommerce' ) && current_theme_supports( 'woocommerce' ) && get_posts('post_type=product&posts_per_page=1') ) {

			echo '<div id="front-page-2" class="front-page-2"><div class="flexible-widgets widget-area clearfix"><div class="widget widget_text">' . do_shortcode('[recent_products per_page="9"]') . '</div></div></div>';

		}

	}

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3"><div class="flexible-widgets widget-area clearfix' . outfitter_widget_area_class( 'front-page-3' ) . '">',
		'after'  => '</div></div>',
	) );

}

// Runs the Genesis loop.
genesis();
