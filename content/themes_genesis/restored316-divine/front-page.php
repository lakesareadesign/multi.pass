<?php
/**
 * Divine.
 *
 * @package      Divine
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 3/11/2015
 * @license      GPL-2.0+
 */

//* This theme contains intellectual property owned by Restored 316 LLC, including trademarks, copyrights, proprietary information, and other intellectual property. You may not modify, publish, transmit, participate in the transfer or sale of, create derivative works from, distribute, reproduce or perform, or in any way exploit in any format whatsoever any of this theme or intellectual property, in whole or in part, without our prior written consent.
 
add_action( 'genesis_meta', 'divine_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function divine_home_genesis_meta() {

	if ( is_active_sidebar( 'home-slider' ) || is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-triple-bottom' ) || is_active_sidebar( 'home-double-bottom' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'divine_home_sections' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
		add_filter( 'body_class', 'divine_add_home_body_class' );

	}
	
}

function divine_home_sections() {

	genesis_widget_area( 'home-slider', array(
		'before' => '<div class="home-slider widget-area">',
		'after'  => '</div>',
	) );

	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top widget-area">',
		'after'  => '</div>',
	) );
	
	if ( is_active_sidebar( 'home-triple-bottom' ) || is_active_sidebar( 'home-double-bottom' ) ) {

		echo '<div class="home-bottom">';

		genesis_widget_area( 'home-triple-bottom', array(
			'before' => '<div class="home-triple-bottom widget-area">',
			'after'  => '</div>',
		) );
		
		genesis_widget_area( 'home-double-bottom', array(
			'before' => '<div class="home-double-bottom widget-area">',
			'after'  => '</div>',
		) );

		echo '</div>';
	
	}
	
}

//* Add body class to home page		
function divine_add_home_body_class( $classes ) {

	$classes[] = 'divine-home';
	return $classes;
	
}

genesis();
