<?php
/**
 * Outfitter Pro.
 *
 * This file adds the required WooCommerce setup functions to the Outfitter Pro Theme.
 *
 * @package Outfitter
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/outfitter/
 */

// Includes the customizer settings for the WooCommerce plugin.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-customize.php';

// Includes the customizer CSS for the WooCommerce plugin.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Includes notice to install Genesis Connect for WooCommerce.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// Includes functions for the WooCommerce plugin.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-functions.php';

// Adds product gallery support.
if ( class_exists( 'WooCommerce' ) ) {
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-zoom' );
}

add_filter( 'woocommerce_style_smallscreen_breakpoint', 'outfitter_woocommerce_breakpoint' );
/**
 * Modifies the WooCommerce breakpoints.
 *
 * @since 1.0.0
 */
function outfitter_woocommerce_breakpoint() {

	$current = genesis_site_layout();
	$layouts = array(
		'content-sidebar',
		'sidebar-content',
	);

	if ( in_array( $current, $layouts, true ) ) {
		return '1200px';
	} else {
		return '1023px';
	}

}

add_filter( 'genesiswooc_default_products_per_page', 'outfitter_default_products_per_page' );
/**
 * Sets the default products per page value.
 *
 * @since 1.0.0
 *
 * @return int Number of products to show per page.
 */
function outfitter_default_products_per_page() {

	return 12;

}

add_filter( 'loop_shop_columns', 'outfitter_product_archive_columns' );
/**
 * Modifies the default WooCommerce column count for product thumbnails.
 *
 * @since 1.0.0
 *
 * @return int Number of columns for product archives.
 */
function outfitter_product_archive_columns() {

	$current = genesis_site_layout();
	$layouts = array(
		'content-sidebar',
		'sidebar-content',
	);

	if ( in_array( $current, $layouts, true ) ) {
		return 3;
	} else {
		return 4;
	}

}

add_filter( 'woocommerce_pagination_args', 'outfitter_woocommerce_pagination' );
/**
 * Updates the next and previous arrows to the default Genesis style.
 *
 * @since 1.0.0
 *
 * @param array $args The pagination arguments.
 * @return array Arguments with modified next and previous text strings.
 */
function outfitter_woocommerce_pagination( $args ) {

	$args['prev_text'] = sprintf( '&laquo; %s', __( 'Previous Page', 'outfitter-pro' ) );
	$args['next_text'] = sprintf( '%s &raquo;', __( 'Next Page', 'outfitter-pro' ) );

	return $args;

}

add_action( 'after_switch_theme', 'outfitter_woocommerce_image_dimensions_after_theme_setup', 1 );
/**
 * Defines WooCommerce image sizes on theme activation.
 *
 * @since 1.0.0
 */
function outfitter_woocommerce_image_dimensions_after_theme_setup() {

	global $pagenow;

	// Checks conditionally to see if we're activating the current theme and that WooCommerce is installed.
	if ( ! isset( $_GET['activated'] ) || 'themes.php' !== $pagenow || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	outfitter_update_woocommerce_image_dimensions();

}

add_action( 'activated_plugin', 'outfitter_woocommerce_image_dimensions_after_woo_activation', 10, 2 );
/**
 * Defines the WooCommerce image sizes on WooCommerce activation.
 *
 * @since 1.0.0
 *
 * @param string $plugin The path of the plugin being activated.
 */
function outfitter_woocommerce_image_dimensions_after_woo_activation( $plugin ) {

	// Checks to see if WooCommerce is being activated.
	if ( 'woocommerce/woocommerce.php' !== $plugin ) {
		return;
	}

	outfitter_update_woocommerce_image_dimensions();

}

/**
 * Updates WooCommerce image dimensions.
 *
 * @since 1.0.0
 */
function outfitter_update_woocommerce_image_dimensions() {

	// Updates image size options.
	update_option( 'woocommerce_single_image_width', 1000 );   // Single product image.
	update_option( 'woocommerce_thumbnail_image_width', 860 ); // Catalog image.

	// Updates image cropping option.
	update_option( 'woocommerce_thumbnail_cropping', '1:1' );

}

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'outfitter_gallery_image_thumbnail' );
/**
 * Filters the WooCommerce gallery image dimensions.
 *
 * @since 1.0.2
 *
 * @param array $size The gallery image size and crop arguments.
 * @return array The modified gallery image size and crop arguments.
 */
function outfitter_gallery_image_thumbnail( $size ) {

	$size = array(
		'width'  => 200,
		'height' => 200,
		'crop'   => 1,
	);

	return $size;

}

add_filter( 'woocommerce_output_related_products_args', 'outfitter_related_products_args' );
/**
 * Changes number of related products on product page.
 *
 * @since 1.0.0
 *
 * @param array $args The numeric columns and posts_per_page arguments.
 * @return array The modified numeric columns and posts_per_page arguments.
 */
function outfitter_related_products_args( $args ) {

	$args['posts_per_page'] = 3; // 3 related products.
	$args['columns']        = 3; // Arranged in 3 columns.

	return $args;

}
