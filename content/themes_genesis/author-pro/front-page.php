<?php
/**
 * This file adds the Home Page to the Author Pro Theme.
 *
 * @author StudioPress
 * @package Author
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'author_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function author_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) ) {

		//* Add front-page body class
		add_filter( 'body_class', 'author_body_class' );
		function author_body_class( $classes ) {
		
   			$classes[] = 'front-page';
  			return $classes;
  			
		}

		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		
		//* Add front page 1 widget
		add_action( 'genesis_after_header', 'author_front_page_1_widget', 5 );

		//* Add the rest of front page widgets
		add_action( 'genesis_loop', 'author_front_page_widgets' );
		
	}

}

//* Add markup for front page widgets
function author_front_page_1_widget() {

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div class="featured-widget-area"><div class="wrap"><div id="front-page-1" class="front-page-1"><div class="flexible-widgets widget-area' . author_widget_area_class( 'front-page-1' ) . '">',
		'after'  => '</div></div></div></div>',
	) );

}

function author_front_page_widgets() {

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2"><div class="flexible-widgets widget-area' . author_widget_area_class( 'front-page-2' ) . '">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3"><div class="flexible-widgets widget-area' . author_widget_area_class( 'front-page-3' ) . '">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4"><div class="flexible-widgets widget-area' . author_widget_area_class( 'front-page-4' ) . '">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-5', array(
		'before' => '<div id="front-page-5" class="front-page-5"><div class="flexible-widgets widget-area' . author_widget_area_class( 'front-page-5' ) . '">',
		'after'  => '</div></div>',
	) );

}

genesis();
