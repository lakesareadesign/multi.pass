<?php
/**
 * Studio Pro.
 *
 * This file adds the front page to the Studio Pro Theme.
 *
 * @package Studio Pro
 * @author  SeoThemes
 * @license GPL-2.0+
 * @link    https://seothemes.com/themes/studio-pro/
 */

// If any widget areas are active, do custom front page.
if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) || is_active_sidebar( 'front-page-5' ) || is_active_sidebar( 'front-page-6' ) ) {

	// Remove hero.
	remove_action( 'genesis_after_header', 'studio_hero', 99 );

	// Get header.
	get_header();

	// Display widget areas.
	genesis_widget_area( 'front-page-1', array(
		'before' => '<div class="front-page-1 hero-section overlay" role="banner">' . studio_custom_header_markup() . '<div class="wrap">',
		'after'  => '</div></div>',
	) );
	genesis_widget_area( 'front-page-2', array(
		'before' => '<div class="front-page-2 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );
	genesis_widget_area( 'front-page-3', array(
		'before' => '<div class="front-page-3 widget-area">',
		'after'  => '</div>',
	) );
	genesis_widget_area( 'front-page-4', array(
		'before' => '<div class="front-page-4 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );
	genesis_widget_area( 'front-page-5', array(
		'before' => '<div class="front-page-5 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );
	genesis_widget_area( 'front-page-6', array(
		'before' => '<div class="front-page-6 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	// Get footer.
	get_footer();

} else {

	// Do the default loop.
	genesis();

} // End if().
