<?php
/**
 * Authority Pro.
 *
 * This file adds the front page to the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

add_action( 'genesis_meta', 'authority_front_page_genesis_meta' );
/**
 * Adds widget support for homepage. If no widgets active, displays the default loop.
 *
 * @since 1.0.0
 */
function authority_front_page_genesis_meta() {

	// Screen reader text.
	add_action( 'genesis_before_loop', 'authority_print_screen_reader' );

	// Outputs hero if set to visible.
	$hero = get_theme_mod( 'authority-show-hero-section', true );

	if ( $hero ) {

		add_action( 'genesis_before_content_sidebar_wrap', 'authority_do_front_page_hero' );

		// Enqueues styles.
		add_action( 'wp_enqueue_scripts', 'authority_enqueue_hero_styles', 11 );

	}

	// Widgetized.
	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) ) {

		// Adds the front-page body class.
		add_filter( 'body_class', 'authority_body_class' );

		// Enqueues styles.
		add_action( 'wp_enqueue_scripts', 'authority_enqueue_front_styles', 10 );

		// Forces full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Removes breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Removes the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Adds front page widgets.
		add_action( 'genesis_loop', 'authority_front_page_widgets' );

	}

}

/**
 * Defines the front page hero scripts and styles.
 *
 * @since 1.0.0
 */
function authority_enqueue_hero_styles() {

	wp_enqueue_style( 'authority-hero-styles', get_stylesheet_directory_uri() . '/css/style-hero.css', array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'authority-hero-js', get_stylesheet_directory_uri() . '/js/hero.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

}

/**
 * Defines the front page widget scripts and styles.
 *
 * @since 1.0.0
 */
function authority_enqueue_front_styles() {

	wp_enqueue_style( 'authority-front-styles', get_stylesheet_directory_uri() . '/css/style-front.css', array(), CHILD_THEME_VERSION );
	wp_enqueue_script( 'authority-front-js', get_stylesheet_directory_uri() . '/js/front.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

}

/**
 * Defines the front-page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function authority_body_class( $classes ) {

	$classes[] = 'front-page';

	return $classes;

}

/**
 * Adds markup for front page hero and widgets areas.
 *
 * @since 1.0.0
 */
function authority_front_page_widgets() {

	if ( is_active_sidebar( 'front-page-1' ) ) {
		authority_do_widget( 'front-page-1' );
	}

	if ( is_active_sidebar( 'front-page-2' ) ) {
		authority_do_widget( 'front-page-2' );
	}

	if ( is_active_sidebar( 'front-page-3' ) ) {
		authority_do_widget( 'front-page-3' );
	}

	if ( is_active_sidebar( 'front-page-4' ) ) {
		authority_do_widget( 'front-page-4' );
	}

	if ( is_active_sidebar( 'front-page-5' ) ) {
		authority_do_widget( 'front-page-5' );
	}

}

/**
 * Adds hero section to the front page.
 *
 * @since 1.0.0
 */
function authority_do_front_page_hero() {

	get_template_part( '/lib/templates/hero', 'section' );

}

/**
 * Helper function to handle outputting widget markup and classes.
 *
 * @since 1.0.0
 *
 * @param string $id The id of the widget area.
 */
function authority_do_widget( $id ) {

	$count   = authority_count_widgets( $id );
	$columns = ( 'front-page-5' === $id ) ? authority_alternate_widget_area_class( $id ) : authority_widget_area_class( $id );
	$bg      = ( 1 === $count || 'front-page-5' === $id ) ? 'no-bg' : '';

	add_filter( 'the_title', 'authority_title' );

	genesis_widget_area(
		$id, array(
			'before' => "<div id=\"$id\" class=\"$id\"><div class=\"flexible-widgets widget-area $columns $bg\"><div class=\"wrap\">",
			'after'  => '</div></div></div>',
		)
	);

	remove_filter( 'the_title', 'authority_title', 15 );

}

/**
 * Function to output the accessible screen reader header for the content.
 *
 * @since 1.0.0
 */
function authority_print_screen_reader() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'authority-pro' ) . '</h2>';

}

// Runs the Genesis loop.
genesis();
