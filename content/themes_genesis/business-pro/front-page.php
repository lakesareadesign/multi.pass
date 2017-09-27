<?php
/**
 * Business Pro.
 *
 * This file adds the front page to the Business Pro Theme.
 *
 * @package Business Pro
 * @author  SeoThemes
 * @license GPL-2.0+
 * @link    https://seothemes.com/themes/business-pro/
 */

// Force full-width-content layout.
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove default page header.
remove_action( 'genesis_after_header', 'business_page_header_open', 20 );
remove_action( 'genesis_after_header', 'business_page_header_title', 24 );
remove_action( 'genesis_after_header', 'business_page_header_close', 28 );

add_action( 'genesis_before_content_sidebar_wrap', 'business_front_page' );
 /**
  * Front page widgets.
  *
  * @return void
  */
function business_front_page() {

	// If any widget areas are active, do custom front page.
	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) || is_active_sidebar( 'front-page-6' ) ) {

		// Remove site-inner wrap.
		add_filter( 'genesis_structural_wrap-site-inner', '__return_empty_string' );

		// Get custom header markup.
		ob_start();
		the_custom_header_markup();
		$custom_header = ob_get_clean();

		// Display Front Page 1 widget area.
		genesis_widget_area( 'front-page-1', array(
			'before' => '<div class="front-page-1 page-header" role="banner">' . $custom_header . '<div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Display Front Page 2 widget area.
		genesis_widget_area( 'front-page-2', array(
			'before' => '<div class="front-page-2 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Display Front Page 3 widget area.
		genesis_widget_area( 'front-page-3', array(
			'before' => '<div class="front-page-3 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Display Front Page 4 widget area.
		genesis_widget_area( 'front-page-4', array(
			'before' => '<div class="front-page-4 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Display Front Page 5 widget area.
		genesis_widget_area( 'front-page-5', array(
			'before' => '<div class="front-page-5 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Display Front Page 6 widget area.
		genesis_widget_area( 'front-page-6', array(
			'before' => '<div class="front-page-6 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Remove main section if page has no content.
		if ( is_empty_content( get_post()->post_content ) ) {

			add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );
			add_filter( 'genesis_markup_content', '__return_null' );
			remove_action( 'genesis_loop', 'genesis_do_loop' );

		}
	}

}

// Run Genesis.
genesis();
