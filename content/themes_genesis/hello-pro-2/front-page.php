<?php
/**
 * This file adds the Home Page to the Hello Theme.
 *
 * @author brandiD
 * @package Hello
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'hello_pro_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 */
function hello_pro_home_genesis_meta() {

	if ( is_active_sidebar( 'home-welcome' ) || is_active_sidebar( 'home-intro' ) || is_active_sidebar( 'home-cta' ) || is_active_sidebar( 'home-features' ) || is_active_sidebar( 'home-statement' ) || is_active_sidebar( 'home-portfolio' ) || is_active_sidebar( 'home-testimonial' ) ) {

		// Set full-width layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Custom Loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'hello_pro_home_sections' );

		// Add custom body class
		add_filter( 'body_class', 'hello_pro_add_home_body_class' );

	}

}

function hello_pro_home_sections() {

	$section1img = get_theme_mod( '1-hellopro-image', '' );
	$section1Class = '';

	$section2img = get_theme_mod( '2-hellopro-image', '' );
	$section2Class = '';

	$section3img = get_theme_mod( '3-hellopro-image', '' );
	$section3Class = '';

	$section4img = get_theme_mod( '4-hellopro-image', '' );
	$section4Class = '';

	$hasImageClass = 'has-image';

	if ( $section1img !== '' ) {
		$section1Class = $hasImageClass;
	}
	if ( $section2img !== '' ) {
		$section2Class = $hasImageClass;
	}
	if ( $section3img !== '' ) {
		$section3Class = $hasImageClass;
	}
	if ( $section4img !== '' ) {
		$section4Class = $hasImageClass;
	}

	// Hero Image/Welcome
	if ( is_active_sidebar( 'home-welcome' ) ) {
		genesis_widget_area( 'home-welcome', array(
			'before' => '<div class="top home-welcome-container '.$section1Class.' "><div class="wrap"><div class="home-welcome widget-area">',
			'after'  => '</div></div></div>',
		) );
	}

	// Intro
	if ( is_active_sidebar( 'home-intro' ) ) {
		genesis_widget_area( 'home-intro', array(
			'before' => '<div class="home-intro widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}

	// CTA
	if ( is_active_sidebar( 'home-cta' ) ) {
		genesis_widget_area( 'home-cta', array(
			'before' => '<div class="home-cta widget-area '.$section2Class.' "><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}

	// Features
	if ( is_active_sidebar( 'home-features' ) ) {
		genesis_widget_area( 'home-features', array(
			'before' => '<div class="home-features widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}

	// Headline
	if ( is_active_sidebar( 'home-statement' ) ) {
		genesis_widget_area( 'home-statement', array(
			'before' => '<div class="home-statement widget-area '.$section3Class.' "><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}

	// Portfolio
	if ( is_active_sidebar( 'home-portfolio' ) ) {
		genesis_widget_area( 'home-portfolio', array(
			'before' => '<div class="home-portfolio widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}

	// Testimonial
	if ( is_active_sidebar( 'home-testimonial' ) ) {
		genesis_widget_area( 'home-testimonial', array(
			'before' => '<div class="home-testimonial widget-area '.$section4Class.' "><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}

}

// * Add body class to home page
function hello_pro_add_home_body_class( $classes ) {

	$classes[] = 'hello-pro-home';
	return $classes;

}

genesis();
