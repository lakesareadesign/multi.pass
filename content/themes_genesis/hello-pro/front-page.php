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
 *
 */
function hello_pro_home_genesis_meta() {

	if ( is_active_sidebar( 'home-welcome' ) || is_active_sidebar( 'home-image' ) || is_active_sidebar( 'home-cta' ) || is_active_sidebar( 'home-features' ) || is_active_sidebar( 'home-headline' ) || is_active_sidebar( 'home-portfolio' ) || is_active_sidebar( 'home-testimonial' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'hello_pro_home_sections' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		add_filter( 'body_class', 'hello_pro_add_home_body_class' );

	}

}

function hello_pro_home_sections() {

	$minHeight = '380px';

	if ( is_active_sidebar( 'home-welcome' ) || is_active_sidebar( 'home-image' ) ) {

		echo '<div class="top"><div class="wrap">';

			if ( is_active_sidebar( 'home-welcome' ) ) {

				genesis_widget_area( 'home-welcome', array(
					'before' => '<div class="home-welcome widget-area">',
					'after'  => '</div>',
				) );
			}

			if ( is_active_sidebar( 'home-image' ) ) {
				genesis_widget_area( 'home-image', array(
					'before' => '<div class="home-image widget-area" style="height:' . $minHeight . ';">',
					'after'  => '</div>',
				) );
			}

		echo '</div></div>';
	}

	genesis_widget_area( 'home-cta', array(
		'before' => '<div class="home-cta widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-features', array(
		'before' => '<div class="home-features widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-headline', array(
		'before' => '<div class="home-headline widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	if ( is_active_sidebar( 'home-portfolio' ) || is_active_sidebar( 'home-testimonial' ) ) {

		echo '<div class="bottom"><div class="wrap">';

			if ( is_active_sidebar( 'home-portfolio' ) ) {
				genesis_widget_area( 'home-portfolio', array(
					'before' => '<div class="home-portfolio widget-area">',
					'after'  => '</div>',
				) );
			}

			if ( is_active_sidebar( 'home-testimonial' ) ) {
				genesis_widget_area( 'home-testimonial', array(
					'before' => '<div class="home-testimonial widget-area">',
					'after'  => '</div>',
				) );
			}

		echo '</div></div>';
	}
}

//* Add body class to home page
function hello_pro_add_home_body_class( $classes ) {

	$classes[] = 'hello-pro-home';
	return $classes;

}

genesis();
