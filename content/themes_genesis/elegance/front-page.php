<?php
/**
 * This file adds all the settings for the front page of the Elegance theme.
 *
 * @package      Elegance
 * @link         http://stephaniehellwig.com/themes
 * @author       Stephanie Hellwig
 * @copyright    Copyright (c) 2016, Stephanie Hellwig, Released 06/04/2016
 * @license      GPL-2.0+
 */

//* Add widget support for homepage. If no widgets active, display the default loop.
add_action( 'genesis_meta', 'elegance_home_genesis_meta' );
function elegance_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle-left' ) || is_active_sidebar( 'home-middle-right' ) || is_active_sidebar( 'cta-widget' ) || is_active_sidebar( 'home-bottom' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Add elegance-home body class
		add_filter( 'body_class', 'elegance_body_class' );
		function elegance_body_class( $classes ) {
   			
   			$classes[] = 'elegance-home';
  			return $classes;
		
		}

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets
		add_action( 'genesis_loop', 'elegance_homepage_widgets' );

	}
}

function elegance_homepage_widgets() {

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );
		
	if ( is_active_sidebar( 'home-middle-left' ) || is_active_sidebar( 'home-middle-right' ) ) {

		echo '<div class="home-middle">';

		genesis_widget_area( 'home-middle-left', array(
			'before' => '<div class="home-middle-left widget-area">',
			'after'  => '</div>',
		) );

		genesis_widget_area( 'home-middle-right', array(
			'before' => '<div class="home-middle-right widget-area">',
			'after'  => '</div>',
		) );

		echo '</div>';
	
	}
	
	if ( is_active_sidebar( 'cta-widget' ) ) {

		echo '<div class="cta-widget">';

		genesis_widget_area( 'cta-widget', array(
			'before' => '<div class="cta widget-area">',
			'after'  => '</div>',
		) );

		echo '</div>';
		
	}
	
	if ( is_active_sidebar( 'home-bottom' ) ) {

		echo '<div class="home-bottom-full">';

		genesis_widget_area( 'home-bottom', array(
			'before' => '<div class="home-bottom widget-area">',
			'after'  => '</div>',
		) );

		echo '</div>';
	
	}

}

genesis();
