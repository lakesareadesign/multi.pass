<?php
/**
 * Essence Pro.
 *
 * This file adds the front page to the Essence Pro Theme.
 *
 * @package Essence
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/essence/
 */

add_action( 'genesis_meta', 'essence_front_page_genesis_meta' );
/**
 * Adds widget support for homepage. If no widgets active, displays the default loop.
 *
 * @since 1.0.0
 */
function essence_front_page_genesis_meta() {

	// Adds front page hero section.
	add_action( 'genesis_after_header', 'essence_do_front_page_hero', 13 );

	// Removes the page header-title markup.
	remove_action( 'genesis_after_header', 'essence_header_title_wrap', 90 );
	remove_action( 'genesis_after_header', 'essence_header_title_end_wrap', 98 );

	// Enqueues scripts.
	add_action( 'wp_enqueue_scripts', 'essence_enqueue_front_script_styles' );

	// Removes content skip link filter.
	remove_filter( 'genesis_skip_links_output', 'essence_content_skip_links_output' );

	// Widgetized.
	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) ) {

		// Adds the front-page body class.
		add_filter( 'body_class', 'essence_front_body_class' );

		// Removes the half-width-entries body class.
		remove_filter( 'body_class', 'essence_half_width_entry_class' );

		// Adds screen reader text.
		add_action( 'genesis_before_loop', 'essence_print_screen_reader' );

		// Forces full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Removes breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Removes the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Adds front page widgets.
		add_action( 'genesis_loop', 'essence_front_page_widgets' );

		// Removes structural wrap from site-inner.
		add_theme_support(
			'genesis-structural-wraps', array(
				'header',
				'menu-primary',
				'menu-secondary',
				'footer-widgets',
				'footer',
			)
		);

	}

}

/**
 * Defines the front page scripts and styles.
 *
 * @since 1.0.0
 */
function essence_enqueue_front_script_styles() {

	wp_enqueue_style(
		'essence-front-styles',
		get_stylesheet_directory_uri() . '/style-front.css',
		array(),
		CHILD_THEME_VERSION
	);

}

/**
 * Defines the front-page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function essence_front_body_class( $classes ) {

	$classes[] = 'front-page';
	return $classes;

}

/**
 * Defines function to output the accessible screen reader header for the content.
 *
 * @since 1.0.0
 */
function essence_print_screen_reader() {

	echo '<h3 class="screen-reader-text">' . __( 'Main Content', 'essence-pro' ) . '</h3>';

}

// Repositions the breadcrumbs.
remove_action( 'genesis_after_header', 'genesis_do_breadcrumbs', 90 );
add_action( 'genesis_after_header', 'genesis_do_breadcrumbs', 12 );

/**
 * Adds hero section to the front page.
 *
 * @since 1.0.0
 */
function essence_do_front_page_hero() {

	get_template_part( '/lib/templates/hero', 'section' );

}

/**
 * Adds markup for front page widgets.
 *
 * @since 1.0.0
 */
function essence_front_page_widgets() {

	if ( is_active_sidebar( 'front-page-1' ) ) {
		essence_do_widget( 'front-page-1' );
	}

	if ( is_active_sidebar( 'front-page-2' ) ) {
		essence_do_widget( 'front-page-2' );
	}

}

add_action( 'genesis_before_footer', 'essence_front_quote_widget', 15 );
/**
 * Adds the before footer widget area.
 *
 * @since 1.0.0
 */
function essence_front_quote_widget() {

	if ( is_active_sidebar( 'front-page-featured' ) ) {
		essence_do_widget( 'front-page-featured' );
	}

}

// Runs the Genesis loop.
genesis();
