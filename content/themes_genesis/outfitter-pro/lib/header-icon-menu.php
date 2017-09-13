<?php
/**
 * Outfitter Pro.
 *
 * This file sets up the header icon menu with custom markup.
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

add_action( 'genesis_meta', 'outfitter_setup_header_icons' );
/**
 * Sets up the header icon menu markup, if any.
 *
 * @return void
 *
 * @since 1.0.0
 */
function outfitter_setup_header_icons() {

	$cart   = get_theme_mod( 'outfitter_header_cart', outfitter_customizer_get_default_cart_setting() );
	$search = get_theme_mod( 'outfitter_header_search', outfitter_customizer_get_default_search_setting() );
	$more   = ( is_active_sidebar( 'off-screen-content' ) || has_nav_menu( 'off-screen' ) );

	// Exits early if no icons to output.
	if ( ! $search && ! $more ) {
		return;
	}

	// Outputs the header navigation container markup.
	add_action( 'genesis_header', 'outfitter_header_nav_markup_open', 10 );

	// Outputs the header icons markup.
	add_action( 'genesis_header', 'outfitter_header_icons_markup_open', 11 );

	if ( $cart && class_exists( 'WooCommerce' ) && current_theme_supports( 'woocommerce' ) ) {
		add_action( 'genesis_header', 'outfitter_do_woocommerce_cart_icon', 12 );
	}

	if ( $search ) {
		add_action( 'genesis_header', 'outfitter_do_header_search_icon', 12 );
		add_action( 'genesis_header', 'outfitter_do_header_search_form', 14 );
	}

	if ( $more ) {
		add_action( 'genesis_header', 'outfitter_do_off_screen_icon', 12 );
	}

	add_action( 'genesis_header', 'outfitter_header_icons_markup_close', 12 );
	add_action( 'genesis_header', 'outfitter_header_nav_markup_close', 13 );

}

/**
 * Outputs the header icon navigation markup.
 *
 * @since 1.0.0
 */
function outfitter_header_nav_markup_open() {

	genesis_markup( array(
		'context' => 'nav-container',
		'open'   => '<div %s>',
	) );

}

/**
 * Outputs the header icon navigation markup closing tags.
 *
 * @since 1.0.0
 */
function outfitter_header_nav_markup_close() {

	genesis_markup( array(
		'context' => 'nav-container',
		'open'   => '</div>',
	) );

}

/**
 * Outputs the header icon navigation markup.
 *
 * @since 1.0.0
 */
function outfitter_header_icons_markup_open() {

	genesis_markup( array(
		'context' => 'nav-header-icons',
		'open'   => '<nav itemscope="" %s>',
	) );

	genesis_markup( array(
		'context' => 'menu-header-icons',
		'open'   => '<ul %s>',
	) );

}

/**
 * Outputs the header icon navigation markup closing tags.
 *
 * @since 1.0.0
 */
function outfitter_header_icons_markup_close() {

	genesis_markup( array(
		'context' => 'menu-header-icons',
		'close'   => '</ul>',
	) );

	genesis_markup( array(
		'context' => 'nav-header-icons',
		'close'   => '</nav>',
	) );

}

/**
 * Adds appropriate attributes to the header icon navigation element.
 *
 * @since 1.0.0
 */
add_filter( 'genesis_attr_nav-header-icons', 'outfitter_header_icons_nav_attr' );
function outfitter_header_icons_nav_attr( $attr ) {

	$attr['itemtype']   = 'https://schema.org/SiteNavigationElement';
	$attr['id']         = 'genesis-nav-header-icons';
	$attr['aria-label'] = __( 'Additional navigation', 'outfitter-pro' );

	return $attr;

}

/**
 * Adds appropriate attributes to the header icon menu element.
 *
 * @since 1.0.0
 */
add_filter( 'genesis_attr_menu-header-icons', 'outfitter_header_icons_menu_attr' );
function outfitter_header_icons_menu_attr( $attr ) {

	$attr['id']    = 'menu-header-icons-navigation';
	$attr['class'] = $attr['class'] . ' menu genesis-nav-menu';

	return $attr;

}
