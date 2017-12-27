<?php
/**
 * Academy Pro.
 *
 * This file adds the front page to the Academy Pro Theme.
 *
 * @package Academy
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/academy/
 */

add_action( 'genesis_meta', 'academy_front_page_genesis_meta' );
/**
 * Adds widget support for homepage. If no widgets active, displays the default loop.
 *
 * @since 1.0.0
 */
function academy_front_page_genesis_meta() {

	// Screen reader text.
	add_action( 'genesis_before_loop', 'academy_print_screen_reader' );

	// Outputs hero if set to visible.
	$hero = get_theme_mod( 'academy-show-hero-section', true );
	if ( $hero ) {
		add_action( 'genesis_before_content_sidebar_wrap', 'academy_do_front_page_hero' );
	}

	// Adds the front-page body class.
	add_filter( 'body_class', 'academy_front_body_class' );

	// Enqueues scripts.
	add_action( 'wp_enqueue_scripts', 'academy_enqueue_front_script_styles' );

	// Widgetized.
	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) || is_active_sidebar( 'front-page-6' ) ) {

		// Forces full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Removes breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Removes the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Adds front page widgets.
		add_action( 'genesis_loop', 'academy_front_page_widgets' );

		// Removes structural wrap from site-inner.
		add_theme_support( 'genesis-structural-wraps', array(
			'header',
			'menu-primary',
			'menu-secondary',
			'footer-widgets',
			'footer',
		) );

	}

}

/**
 * Defines the front page scripts and styles.
 *
 * @since 1.0.0
 */
function academy_enqueue_front_script_styles() {

	wp_enqueue_style( 'academy-front-styles', get_stylesheet_directory_uri() . '/css/style-front.css', array(), CHILD_THEME_VERSION );

}

/**
 * Defines the front-page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function academy_front_body_class( $classes ) {

	$classes[] = 'front-page';

	return $classes;

}

// Adds markup for front page widgets.
function academy_front_page_widgets() {

	if ( is_active_sidebar( 'front-page-1' ) ) {
		academy_do_widget( 'front-page-1' );
	}

	if ( is_active_sidebar( 'front-page-2' ) ) {
		academy_do_widget( 'front-page-2' );
	}

	if ( is_active_sidebar( 'front-page-3' ) ) {
		academy_do_widget( 'front-page-3' );
	}

	if ( is_active_sidebar( 'front-page-4' ) ) {
		academy_do_widget( 'front-page-4' );
	}

	if ( is_active_sidebar( 'front-page-5' ) ) {
		academy_do_widget( 'front-page-5' );
	}

	if ( is_active_sidebar( 'front-page-6' ) ) {
		academy_do_widget( 'front-page-6' );
	}

}

/**
 * Adds hero section to the front page.
 *
 * @since 1.0.0
 */
function academy_do_front_page_hero() {

	get_template_part( '/lib/templates/hero', 'section' );

}

/**
 * Helper function to handle outputting widget markup and classes.
 *
 * @param string $id The id of the widget area.
 *
 * @since 1.0.0
 */
function academy_do_widget( $id ) {

	$count = academy_count_widgets( $id );
	$columns = ( 'front-page-4' === $id ) ? academy_alternate_widget_area_class( $id ) : academy_widget_area_class( $id );

	genesis_widget_area( $id, array(
		'before' => "<div id=\"$id\" class=\"$id\"><div class=\"flexible-widgets widget-area $columns\"><div class=\"wrap\">",
		'after'  => "</div></div></div>",
	) );

}

/**
 * Function to output the accessible screen reader header for the content.
 *
 * @return string HTML string to output.
 *
 * @since 1.0.0
 */
function academy_print_screen_reader() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'academy-pro' ) . '</h2>';

}

// Runs the Genesis loop.
genesis();
