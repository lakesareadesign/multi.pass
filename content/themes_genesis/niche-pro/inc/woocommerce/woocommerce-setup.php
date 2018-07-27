<?php
/**
 *
 * @package Niche
 * @author  Bloom
 * @license GPL-2.0+
 * @link    https://niche.designbybloom.co/
 */

add_action( 'wp_enqueue_scripts', 'bloom_products_match_height', 99 );
/**
 * Print an inline script to the footer to keep products the same height.
 *
 * @since 2.0.0
 */
function bloom_products_match_height() {

	// If WooCommerce isn't installed, exit early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	wp_add_inline_script( 'bloom-match-height', "jQuery(document).ready( function() { jQuery( '.product .woocommerce-LoopProduct-link').matchHeight(); });" );

}

add_filter( 'woocommerce_style_smallscreen_breakpoint', 'bloom_woocommerce_breakpoint' );
/**
 * Modify the WooCommerce breakpoints.
 *
 * @since 2.0.0
 */
function bloom_woocommerce_breakpoint() {

	$current = genesis_site_layout();
	$layouts = array(
		'content-sidebar',
		'sidebar-content',
	);

	if ( in_array( $current, $layouts ) ) {
		return '1200px';
	} else {
		return '880px';
	}

}

add_filter( 'genesiswooc_default_products_per_page', 'bloom_default_products_per_page' );
/**
 * Set the shop default products per page count.
 *
 * @since 2.0.0
 *
 * @return int Number of products per page.
 */
function bloom_default_products_per_page( $count ) {

	return 8;

}

add_filter( 'woocommerce_pagination_args', 	'bloom_woocommerce_pagination' );
/**
 * Update the next and previous arrows to the default Genesis style.
 *
 * @since 2.0.0
 *
 * @return string New next and previous text string.
 */
function bloom_woocommerce_pagination( $args ) {

	$args['prev_text'] = sprintf( '&laquo; %s', __( 'Previous Page', 'niche-pro' ) );
	$args['next_text'] = sprintf( '%s &raquo;', __( 'Next Page', 'niche-pro' ) );

	return $args;

}

add_action( 'after_switch_theme', 'bloom_woocommerce_image_dimensions_after_theme_setup', 1 );
/**
 * Define the WooCommerce image sizes after theme activation.
 *
 * @since 2.0.0
 */
function bloom_woocommerce_image_dimensions_after_theme_setup() {

	global $pagenow;

	// Conditional check to see if we're activating the current theme and that WooCommerce is installed.
	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	bloom_update_woocommerce_image_dimensions();

}

add_action( 'activated_plugin', 'bloom_woocommerce_image_dimensions_after_woo_activation', 10, 2 );
/**
* Define WooCommerce image sizes on activation of the WooCommerce plugin.
*
* @since 2.0.0
*/
function bloom_woocommerce_image_dimensions_after_woo_activation( $plugin ) {

	// Conditional check to see if we're activating WooCommerce.
	if ( $plugin !== 'woocommerce/woocommerce.php' ) {
		return;
	}

	bloom_update_woocommerce_image_dimensions();

}

/**
 * Update the WooCommerce image dimensions.
 *
 * @since 2.0.0
 */
function bloom_update_woocommerce_image_dimensions() {

	$catalog = array(
		'width'  => '550', // px
		'height' => '550', // px
		'crop'   => 1,     // true
	);
	$single = array(
		'width'  => '750', // px
		'height' => '750', // px
		'crop'   => 1,     // true
	);
	$thumbnail = array(
		'width'  => '180', // px
		'height' => '180', // px
		'crop'   => 1,     // true
	);

	// Image sizes.
	update_option( 'shop_catalog_image_size', $catalog );     // Product category thumbs.
	update_option( 'shop_single_image_size', $single );       // Single product image.
	update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs.

}

/**
 * Enable WooCommerce Gallery Features
 *
 * @since 3.0.0
 */
add_action( 'after_setup_theme', 'bloom_woocommerce_gallery_setup' );

function bloom_woocommerce_gallery_setup() {
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'bloom_loop_shop_per_page', 20 );

function bloom_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 2;
  return $cols;
}