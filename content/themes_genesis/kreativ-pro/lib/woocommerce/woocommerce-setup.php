<?php
/**
 * Kreativ Pro.
 *
 * This file adds the required settings updates to the WooCommerce Plugin for the Kreativ Pro Theme.
 *
 * @package Kreativ
 * @author  ThemeSquare
 * @license GPL-2.0+
 * @link    http://themesquare.com/themes/kreativ/
 */

add_filter( 'genesiswooc_default_products_per_page', 'kreativ_default_products_per_page' );
/**
 * Set the shop default products per page count.
 *
 * @since 1.1.0
 *
 * @return int Number of products per page.
 */
function kreativ_default_products_per_page() {

	return 8;

}

add_action( 'wp_enqueue_scripts', 'kreativ_products_match_height', 99 );
/**
 * Print an inline script to the footer to keep products the same height.
 *
 * @since 1.1.0
 */
function kreativ_products_match_height() {

	// If WooCommerce isn't installed, exit early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	wp_add_inline_script( 'kreativ-match-height', "jQuery(document).ready( function() { jQuery( '.product .woocommerce-LoopProduct-link').matchHeight(); });" );

}

add_filter( 'woocommerce_pagination_args', 'kreativ_woocommerce_pagination' );
/**
 * Update the next and previous arrows to the default Genesis style.
 *
 * @param array $args The previous and next text arguments.
 * @since 1.1.0
 *
 * @return string New next and previous text string.
 */
function kreativ_woocommerce_pagination( $args ) {

	$args['prev_text'] = sprintf( '&laquo; %s', __( 'Previous Page', 'kreativ-pro' ) );
	$args['next_text'] = sprintf( '%s &raquo;', __( 'Next Page', 'kreativ-pro' ) );

	return $args;

}

add_filter( 'woocommerce_style_smallscreen_breakpoint', 'kreativ_woocommerce_breakpoint' );
/**
 * Modify the WooCommerce breakpoints.
 *
 * @since 1.1.0
 */
function kreativ_woocommerce_breakpoint() {

	$current = genesis_site_layout();

	$layouts = array(
		'content-sidebar',
		'sidebar-content',
		'sidebar-content-sidebar',
		'sidebar-sidebar-content',
		'content-content-sidebar',
	);

	if ( in_array( $current, $layouts, true ) ) {
		return '1200px';
	} else {
		return '860px';
	}

}

add_action( 'after_switch_theme', 'kreativ_woocommerce_image_dimensions_after_theme_setup', 1 );
/**
 * Define the WooCommerce image sizes after theme activation.
 *
 * @since 1.1.0
 */
function kreativ_woocommerce_image_dimensions_after_theme_setup() {

	global $pagenow;

	// Conditional check to see if we're activating the current theme and that WooCommerce is installed.
	if ( ! isset( $_GET['activated'] ) || 'themes.php' !== $pagenow || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	kreativ_update_woocommerce_image_dimensions();

}

add_action( 'activated_plugin', 'kreativ_woocommerce_image_dimensions_after_woo_activation', 10, 2 );
/**
 * Define WooCommerce image sizes on activation of the WooCommerce plugin.
 *
 * @since 1.1.0
 *
 * @param string $plugin The path of the plugin being activated.
 */
function kreativ_woocommerce_image_dimensions_after_woo_activation( $plugin ) {

	// Conditional check to see if we're activating WooCommerce.
	if ( 'woocommerce/woocommerce.php' !== $plugin ) {
		return;
	}

	kreativ_update_woocommerce_image_dimensions();

}

/**
 * Update the WooCommerce image dimensions.
 *
 * @since 1.1.0
 */
function kreativ_update_woocommerce_image_dimensions() {

	$catalog   = array(
		'width'  => '570', // px.
		'height' => '390', // px.
		'crop'   => 1,     // true.
	);
	$single    = array(
		'width'  => '650', // px.
		'height' => '650', // px.
		'crop'   => 1,     // true.
	);
	$thumbnail = array(
		'width'  => '150', // px.
		'height' => '150', // px.
		'crop'   => 1,     // true.
	);

	// Image sizes.
	update_option( 'shop_catalog_image_size', $catalog );     // Product category thumbs.
	update_option( 'shop_single_image_size', $single );       // Single product image.
	update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs.

}

add_action( 'after_setup_theme', 'kreativ_woocommerce_gallery_support' );
/**
 * Add WooCommerce gallery support.
 *
 * @since 1.0.0
 */
function kreativ_woocommerce_gallery_support() {
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
