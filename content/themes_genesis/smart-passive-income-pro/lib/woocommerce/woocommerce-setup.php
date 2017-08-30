<?php
/**
 * Smart Passive Income Pro.
 *
 * This file adds required WooCommerce setup functions to the Smart Passive Income Pro Theme.
 *
 * @package Smart Passive Income Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Add product gallery support.
if ( class_exists( 'WooCommerce' ) ) {

	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-zoom' );

}

add_action( 'wp_enqueue_scripts', 'spi_products_match_height', 99 );
/**
 * Print an inline script to the footer to keep products the same height.
 *
 * @since 1.1.1
 */
function spi_products_match_height() {

	// If WooCommerce isn't active or not on a WooCommerce page, exit early.
	if ( ! class_exists( 'WooCommerce' ) || ( ! is_shop() && ! is_woocommerce() && ! is_cart() ) ) {
		return;
	}

	wp_enqueue_script( 'spi-match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_add_inline_script( 'spi-match-height', "jQuery(document).ready( function() { jQuery( '.product .woocommerce-LoopProduct-link').matchHeight(); });" );

}

add_filter( 'woocommerce_style_smallscreen_breakpoint', 'spi_woocommerce_breakpoint' );
/**
 * Modify the WooCommerce breakpoints.
 *
 * @since 1.1.0
 */
function spi_woocommerce_breakpoint() {

	$current = genesis_site_layout();
	$layouts = array(
		'content-sidebar',
		'sidebar-content',
	);

	if ( in_array( $current, $layouts ) ) {
		return '1300px';
	} else {
		return '880px';
	}

}

add_filter( 'genesiswooc_default_products_per_page', 'spi_default_products_per_page' );
/**
 * Set the shop default products per page count.
 *
 * @since 1.1.0
 *
 * @return int Number of products per page.
 */
function spi_default_products_per_page( $count ) {
	return 8;
}

add_filter( 'woocommerce_pagination_args', 	'spi_woocommerce_pagination' );
/**
 * Update the next and previous arrows to the default Genesis style.
 *
 * @since 1.1.0
 *
 * @return string New next and previous text string.
 */
function spi_woocommerce_pagination( $args ) {

	$args['prev_text'] = sprintf( '&laquo; %s', __( 'Previous Page', 'smart-passive-income-pro' ) );
	$args['next_text'] = sprintf( '%s &raquo;', __( 'Next Page', 'smart-passive-income-pro' ) );

	return $args;

}

add_action( 'after_switch_theme', 'spi_woocommerce_image_dimensions_after_theme_setup', 1 );
/**
* Define WooCommerce image sizes on activation.
*
* @since 1.1.0
*/
function spi_woocommerce_image_dimensions_after_theme_setup() {

	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	spi_update_woocommerce_image_dimensions();

}

add_action( 'activated_plugin', 'spi_woocommerce_image_dimensions_after_woo_activation', 10, 2 );
/**
 * Define WooCommerce image sizes on activation of the WooCommerce plugin.
 *
 * @since 1.1.0
 */
function spi_woocommerce_image_dimensions_after_woo_activation( $plugin ) {

	// Conditional check to see if we're activating WooCommerce.
	if ( $plugin !== 'woocommerce/woocommerce.php' ) {
		return;
	}

	spi_update_woocommerce_image_dimensions();

}

/**
 * Function to update the WooCommerce image dimensions.
 *
 * @since 1.1.0
 */
function spi_update_woocommerce_image_dimensions() {

	$catalog = array(
		'width'  => '540', // px
		'height' => '540', // px
		'crop'   => 1,     // true
	);
	$single = array(
		'width'  => '800', // px
		'height' => '800', // px
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
