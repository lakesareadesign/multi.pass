<?php
/**
 * Smart Passive Income Pro.
 *
 * This file adds the front page template to the Smart Passive Income Pro.
 *
 * @package Smart Passive Income Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Function to initiate widgetized page render.
add_action( 'genesis_meta', 'spi_front_page_init' );
function spi_front_page_init() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3-a' ) || is_active_sidebar( 'front-page-3-b' ) || is_active_sidebar( 'front-page-4' ) ) {

		// Add front-page body class.
		add_filter( 'body_class', 'spi_body_class' );

		// Force full width.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Add the scripts and styles.
		add_action( 'wp_enqueue_scripts', 'spi_home_scripts_and_styles' );

		// Remove default loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add the widget areas.
		add_action( 'genesis_loop', 'spi_home_widget_loop' );

		// Modify the read more link.
		add_filter( 'get_the_content_limit', 'spi_content_limit_read_more_markup', 10, 3 );

	}

}

// Front page body class.
function spi_body_class( $classes ) {

	$classes[] = 'front-page';

	return $classes;

}

// Front page scripts and styles.
function spi_home_scripts_and_styles() {
	wp_enqueue_style( 'front-page-styles', get_stylesheet_directory_uri() . '/css/front-page.css', array(), CHILD_THEME_VERSION );
}

// Function to output active widget areas.
function spi_home_widget_loop() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'smart-passive-income-pro' ) . '</h2>';

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div class="flexible-widgets front-page-1 color' . spi_widget_area_class( 'front-page-1' ) . ' widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div class="flexible-widgets front-page-2 image' . spi_widget_area_class( 'front-page-2' ) . ' widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-3-a', array(
		'before' => '<div class="flexible-widgets front-page-3 front-page-3-a color' . spi_widget_area_class( 'front-page-3-a' ) . ' widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-3-b', array(
		'before' => '<div class="flexible-widgets front-page-3 front-page-3-b color' . spi_widget_area_class( 'front-page-3-b' ) . ' widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div class="flexible-widgets front-page-4' . spi_widget_area_class( 'front-page-4' ) . ' widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

// Modify the read more link.
function spi_content_limit_read_more_markup( $output, $content, $link ) {

	$output = sprintf( '<p>%s &#x02026;</p>%s', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;

}

genesis();
