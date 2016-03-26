<?php
/**
 * Home Page Template
 *
 * @package    BrunchPro\Templates
 * @subpackage Genesis
 * @author     Robert Neu
 * @copyright  Copyright (c) 2016, Shay Bocks
 * @license    GPL-2.0+
 * @link       http://www.shaybocks.com/brunch-pro/
 * @since      1.0.0
 */

add_action( 'genesis_before_loop', 'brunch_pro_home_maybe_remove_loop' );
add_action( 'genesis_before_content_sidebar_wrap', 'brunch_pro_home_top' );
add_action( 'genesis_loop', 'brunch_pro_home_middle', 10 );
add_action( 'genesis_loop', 'brunch_pro_home_bottom', 15 );

/**
 * Remove the default loop if the home middle or home bottom widget areas are
 * active.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_home_maybe_remove_loop() {
	if ( is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-bottom' ) ) {
		remove_action( 'genesis_loop', 'genesis_do_loop' );
	}
}

/**
 * Display the Home Top widgeted section.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_home_top() {
	genesis_widget_area( 'home-top', array(
		'before' => '<div class="home-top">',
		'after'  => '</div> <!-- end .home-top -->',
	) );
}

/**
 * Display the Home Middle widgeted section.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_home_middle() {
	genesis_widget_area( 'home-middle', array(
		'before' => '<div class="widget-area home-middle">',
		'after'  => '</div> <!-- end .home-middle -->',
	) );
}

/**
 * Display the Home Bottom widgeted section.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_home_bottom() {
	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="widget-area home-bottom">',
		'after'  => '</div> <!-- end .home-bottom -->',
	) );
}

genesis();
