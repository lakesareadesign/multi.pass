<?php
/**
 * Breakthrough Pro.
 *
 * This file adds the required WooCommerce setup functions to the Breakthrough Pro Theme.
 *
 * @package Breakthrough_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/breakthrough/
 */

// Adds product gallery support.
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
add_theme_support( 'wc-product-gallery-zoom' );

add_action( 'genesis_meta', 'breakthrough_single_product_titles' );
/**
 * Remove single product titles.
 *
 * @since 1.0.0
 */
function breakthrough_single_product_titles() {

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	// Removes single WooCommerce product titles.
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

}

add_action( 'wp_enqueue_scripts', 'breakthrough_products_match_height', 99 );
/**
 * Prints an inline script to the footer to keep products the same height.
 *
 * @since 1.0.0
 */
function breakthrough_products_match_height() {

	// If WooCommerce isn't active or not on a WooCommerce page, exits early.
	if ( ! class_exists( 'WooCommerce' ) || ! is_shop() && ! is_woocommerce() && ! is_cart() ) {
		return;
	}

	wp_enqueue_script( 'breakthrough-match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_add_inline_script( 'breakthrough-match-height', "jQuery(document).ready( function() { jQuery( '.product .woocommerce-LoopProduct-link').matchHeight(); });" );

}

add_filter( 'woocommerce_style_smallscreen_breakpoint', 'breakthrough_woocommerce_breakpoint' );
/**
 * Modifies the WooCommerce breakpoints.
 *
 * @since 1.0.0
 */
function breakthrough_woocommerce_breakpoint() {

	$current = genesis_site_layout();
	$layouts = array(
		'content-sidebar',
		'sidebar-content',
	);

	if ( in_array( $current, $layouts, true ) ) {
		return '1200px';
	} else {
		return '860px';
	}

}

add_filter( 'genesiswooc_default_products_per_page', 'breakthrough_default_products_per_page' );
/**
 * Sets the default products per page value.
 *
 * @since 1.0.0
 *
 * @return int Number of products to show per page.
 */
function breakthrough_default_products_per_page() {

	return 6;

}

add_filter( 'loop_shop_columns', 'breakthrough_product_archive_columns' );
/**
 * Change number of products in a row to 3.
 *
 * @since 1.0.0
 *
 * @return int Number of products to show per row.
 */
function breakthrough_product_archive_columns() {

	return 3; // 3 products per row.

}


add_filter( 'woocommerce_pagination_args', 'breakthrough_woocommerce_pagination' );
/**
 * Update the next and previous arrows to the default Genesis style.
 *
 * @param array $args The previous and next text arguments.
 * @since 1.0.0
 *
 * @return array New next and previous text arguments.
 */
function breakthrough_woocommerce_pagination( $args ) {

	$args['prev_text'] = sprintf( '&laquo; %s', __( 'Previous Page', 'breakthrough-pro' ) );
	$args['next_text'] = sprintf( '%s &raquo;', __( 'Next Page', 'breakthrough-pro' ) );

	return $args;

}

add_action( 'after_switch_theme', 'breakthrough_woocommerce_image_dimensions_after_theme_setup', 1 );
/**
 * Defines WooCommerce image sizes on theme activation.
 *
 * @since 1.0.0
 */
function breakthrough_woocommerce_image_dimensions_after_theme_setup() {

	global $pagenow;

	// Checks conditionally to see if we're activating the current theme and that WooCommerce is installed.
	if ( ! isset( $_GET['activated'] ) || 'themes.php' !== $pagenow || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	breakthrough_update_woocommerce_image_dimensions();

}

add_action( 'activated_plugin', 'breakthrough_woocommerce_image_dimensions_after_woo_activation', 10, 2 );
/**
 * Define the WooCommerce image sizes on WooCommerce activation.
 *
 * @since 1.0.0
 *
 * @param string $plugin The path of the plugin being activated.
 */
function breakthrough_woocommerce_image_dimensions_after_woo_activation( $plugin ) {

	// Checks to see if WooCommerce is being activated.
	if ( 'woocommerce/woocommerce.php' !== $plugin ) {
		return;
	}

	breakthrough_update_woocommerce_image_dimensions();

}

/**
 * Updates WooCommerce image dimensions.
 *
 * @since 1.0.0
 */
function breakthrough_update_woocommerce_image_dimensions() {

	// Updates image size options.
	update_option( 'woocommerce_single_image_width', 660 );    // Single product image.
	update_option( 'woocommerce_thumbnail_image_width', 500 ); // Catalog image.

	// Updates image cropping option.
	update_option( 'woocommerce_thumbnail_cropping', '1:1' );

}

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'breakthrough_gallery_image_thumbnail' );
/**
 * Filters the WooCommerce gallery image dimensions.
 *
 * @since 1.0.0
 *
 * @param array $size The gallery image size and crop arguments.
 * @return array The modified gallery image size and crop arguments.
 */
function breakthrough_gallery_image_thumbnail( $size ) {

	$size = array(
		'width'  => 180,
		'height' => 180,
		'crop'   => 1,
	);

	return $size;

}
