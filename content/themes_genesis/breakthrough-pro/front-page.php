<?php
/**
 * Breakthrough Pro.
 *
 * This file adds the front page to the Breakthrough Pro Theme.
 *
 * @package Breakthrough_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/breakthrough
 */

add_action( 'genesis_meta', 'breakthrough_front_page_genesis_meta' );
/**
 * Adds widget support for homepage. If no widgets active, displays the default loop.
 *
 * @since 1.0.0
 */
function breakthrough_front_page_genesis_meta() {

	// Outputs hero if set to visible.
	$hero = get_theme_mod( 'breakthrough_show_hero_section', true );
	if ( $hero ) {
		add_action( 'genesis_before_content_sidebar_wrap', 'breakthrough_do_front_page_hero' );

		// Adds the front-page body class.
		add_filter( 'body_class', 'breakthrough_body_class' );
	}

	// Enqueues scripts.
	add_action( 'wp_enqueue_scripts', 'breakthrough_enqueue_front_script_styles' );

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) || is_active_sidebar( 'front-page-6' ) ) {

		// Adds the front-page body class.
		add_filter( 'body_class', 'breakthrough_body_class' );

		// Adds screen reader text.
		add_action( 'genesis_before_loop', 'breakthrough_print_screen_reader' );

		// Forces full width content layout.
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		// Removes breadcrumbs.
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Removes the default Genesis loop.
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Removes the half-width-entries body class.
		remove_filter( 'body_class', 'breakthrough_half_width_entry_class' );

		// Removes rel links in the head when loop is not present.
		remove_action( 'wp_head', 'genesis_paged_rel' );

		// Adds front page widgets.
		add_action( 'genesis_loop', 'breakthrough_front_page_widgets' );

	}

}

/**
 * Defines the front page widget scripts and styles.
 *
 * @since 1.0.0
 */
function breakthrough_enqueue_front_script_styles() {

	wp_enqueue_style( 'breakthrough-front-styles', get_stylesheet_directory_uri() . '/style-front.css', null, CHILD_THEME_VERSION );

}

/**
 * Defines the front-page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function breakthrough_body_class( $classes ) {

	$classes[] = 'front-page';
	return $classes;

}

/**
 * Function to output the accessible screen reader heading for the content.
 *
 * @since 1.0.0
 */
function breakthrough_print_screen_reader() {

	echo '<h2 class="screen-reader-text">' . esc_html__( 'Main Content', 'breakthrough-pro' ) . '</h2>';

}

/**
 * Adds markup for front page hero area.
 *
 * @since 1.0.0
 */
function breakthrough_do_front_page_hero() {

	get_template_part( '/lib/templates/hero', 'section' );

}

/**
 * Adds markup for front page widgets areas.
 *
 * @since 1.0.0
 */
function breakthrough_front_page_widgets() {

	if ( is_active_sidebar( 'front-page-1' ) ) {
		breakthrough_do_widget( 'front-page-1' );
	}

	if ( is_active_sidebar( 'front-page-2' ) ) {
		breakthrough_do_widget( 'front-page-2' );
	}

	if ( is_active_sidebar( 'front-page-3' ) ) {
		breakthrough_do_widget( 'front-page-3' );
	}

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) ) {

		$front_page_image_2 = get_theme_mod( 'breakthrough_front_page_image_2', breakthrough_get_default_front_page_image_2() );

		if ( $front_page_image_2 ) {
			$image_id  = attachment_url_to_postid( $front_page_image_2 );
			$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			echo '<div class="full-width-image"><img src="' . $front_page_image_2 . '" alt="' . $image_alt . '" /></div>';
		}

	}

	if ( is_active_sidebar( 'front-page-4' ) ) {
		breakthrough_do_widget( 'front-page-4' );
	}

	if ( is_active_sidebar( 'front-page-5' ) ) {
		breakthrough_do_widget( 'front-page-5' );
	}

	if ( is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) ) {

		$front_page_image_3 = get_theme_mod( 'breakthrough_front_page_image_3', breakthrough_get_default_front_page_image_3() );

		if ( $front_page_image_3 ) {
			$image_id  = attachment_url_to_postid( $front_page_image_3 );
			$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			echo '<div class="full-width-image"><img src="' . $front_page_image_3 . '" alt="' . $image_alt . '" /></div>';
		}

	}

	if ( is_active_sidebar( 'front-page-6' ) ) {
		breakthrough_do_widget( 'front-page-6' );
	}

}

/**
 * Helper function to handle outputting widget markup and classes.
 *
 * @param string $id The id of the widget area.
 *
 * @since 1.0.0
 */
function breakthrough_do_widget( $id ) {

	$count   = breakthrough_count_widgets( $id );
	$columns = ( 'front-page-4' === $id ) || ( 'front-page-6' === $id ) ? breakthrough_alternate_widget_area_class( $id ) : breakthrough_widget_area_class( $id );

	genesis_widget_area(
		$id, array(
			'before' => "<div id=\"$id\" class=\"$id\"><div class=\"flexible-widgets widget-area $columns\"><div class=\"wrap\">",
			'after'  => '</div></div></div>',
		)
	);

}

// Runs the Genesis loop.
genesis();
