<?php
/**
 * This file adds all the settings for the home page of the Market theme.
 *
 * @package      Market
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 05/03/2016
 * @license      GPL-2.0+
 */

//* Add widget support for homepage. If no widgets active, display the default loop.
add_action( 'genesis_meta', 'market_front_page_genesis_meta' );
function market_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) ) {
	
		//* Enqueue scripts
		add_action( 'wp_enqueue_scripts', 'market_enqueue_market_script' );
		function market_enqueue_market_script() {

			wp_enqueue_style( 'market-front-styles', get_stylesheet_directory_uri() . '/style-front.css', array(), CHILD_THEME_VERSION );

		}


		//* Add body class
		add_filter( 'body_class', 'market_front_page_body_class' );
		
		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		
		//* Add widgets on front page
		add_action( 'genesis_before_content_sidebar_wrap', 'market_front_page_widgets' );
		
		$blog = get_option( 'market_blog_setting', 'true' );

		if ( $blog === 'true' ) {

			//* Add opening markup for blog section
			add_action( 'genesis_before_loop', 'market_front_page_blog_open' );

			//* Add closing markup for blog section
			add_action( 'genesis_after_loop', 'market_front_page_blog_close' );
			
			//* Remove the post info function
			remove_action( 'genesis_entry_header', 'genesis_post_info', 9 );
			
			//* Remove the post meta function
			remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
			
			//* Remove the post content
			remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
			
			//* Remove entry meta
			remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
			remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
			remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

		} else {

			//* Remove the default Genesis loop
			remove_action( 'genesis_loop', 'genesis_do_loop' );

		}

	}
}


//* Add body class to the head
function market_front_page_body_class( $classes ) {

	$classes[] = 'front-page';
	return $classes;

}

//* Add widgets on front page
function market_front_page_widgets() {

	if ( get_query_var( 'paged' ) >= 2 )
		return;

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . market_widget_area_class( 'front-page-1' ) . '">',
		'after'  => '</div></div></div>',
	) );
	
	genesis_widget_area( 'widget-above-content', array(
		'before' => '<div class="widget-above-content widget-area"><div class="wrap">',
		'after'  => '</div></div>',
    ) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . market_widget_area_class( 'front-page-2' ) . '">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . market_widget_area_class( 'front-page-3' ) . '">',
		'after'  => '</div></div></div>',
	) );
	
	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . market_widget_area_class( 'front-page-4' ) . '">',
		'after'  => '</div></div></div>',
	) );
	
	genesis_widget_area( 'front-page-5', array(
		'before' => '<div id="front-page-5" class="front-page-5"><div class="wrap"><div class="flexible-widgets widget-area fadeup-effect' . market_widget_area_class( 'front-page-5' ) . '">',
		'after'  => '</div></div></div>',
	) );

}

//* Add opening markup for blog section
function market_front_page_blog_open() {

	$blog_text = get_option( 'market_blog_text', __( 'the Blog', 'market' ) );
	
	if ( 'posts' == get_option( 'show_on_front' ) ) {

		echo '<div class="blog widget-area fadeup-effect"><div class="wrap">';

		if ( ! empty( $blog_text ) ) {

			echo '<h4 class="widgettitle widget-title center">latest from</h4>';
			echo '<h3>' . $blog_text . '</h3>';

		}

	}

}

//* Add closing markup for blog section
function market_front_page_blog_close() {

	if ( 'posts' == get_option( 'show_on_front' ) ) {

		echo '</div></div>';

	}

}


//* Run the default Genesis loop
genesis();
