<?php
/**
 * Atmosphere Pro.
 *
 * This file adds setup functions for integrating the WooCommerce plugin
 * to the Atmosphere Pro Theme.
 *
 * @package Atmosphere
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/atmosphere/
 */

add_action( 'wp_enqueue_scripts', 'atmosphere_products_match_height', 99 );
/**
 * Print an inline script to the footer to keep products the same height.
 *
 * @since 1.1.1
 */
function atmosphere_products_match_height() {

	// If WooCommerce isn't active or not on a WooCommerce page, exit early.
	if ( ! class_exists( 'WooCommerce' ) || ( ! is_shop() && ! is_woocommerce() && ! is_cart() ) ) {
		return;
	}

	wp_enqueue_script( 'atmosphere-match-height', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_add_inline_script( 'atmosphere-match-height', "jQuery(document).ready( function() { jQuery( '.product .woocommerce-LoopProduct-link').matchHeight(); });" );

}

add_filter( 'woocommerce_style_smallscreen_breakpoint', 'atmosphere_woocommerce_breakpoint' );
/**
 * Modify the WooCommerce breakpoints.
 *
 * @since 1.1.0
 *
 * @return string Pixel width to apply WooCommerce mobile styles.
 */
function atmosphere_woocommerce_breakpoint() {
	return '800px';
}

add_filter( 'genesiswooc_default_products_per_page', 'atmosphere_default_products_per_page' );
/**
 * Set the default shop products per page count.
 *
 * @since 1.1.0
 *
 * @return int Number of products per page.
 */
function atmosphere_default_products_per_page( $count ) {
	return 6;
}

add_filter( 'loop_shop_columns', 'atmosphere_product_archive_columns' );
/**
 * Modify the default WooCommerce column count for product thumbnails.
 *
 * @since 1.1.0
 *
 * @return int Number of columns for product archives.
 */
function atmosphere_product_archive_columns() {
	return 3;
}

add_filter( 'woocommerce_pagination_args', 	'atmosphere_woocommerce_pagination' );
/**
 * Update the next and previous arrows to the default Genesis style.
 *
 * @since 1.1.0
 *
 * @return string New next and previous text string.
 */
function atmosphere_woocommerce_pagination( $args ) {

	$args['prev_text'] = sprintf( '&laquo; %s', __( 'Previous Page', 'atmosphere-pro' ) );
	$args['next_text'] = sprintf( '%s &raquo;', __( 'Next Page', 'atmosphere-pro' ) );

	return $args;

}

add_action( 'after_switch_theme', 'atmosphere_woocommerce_image_dimensions_after_theme_setup', 1 );
/**
 * Define WooCommerce image sizes on activation.
 *
 * @since 1.1.0
 */
function atmosphere_woocommerce_image_dimensions_after_theme_setup() {

	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	atmosphere_update_woocommerce_image_dimensions();

}

add_action( 'activated_plugin', 'atmosphere_woocommerce_image_dimensions_after_woo_activation', 10, 2 );
/**
* Define WooCommerce image sizes on activation of the WooCommerce plugin.
*
* @since 1.1.0
*/
function atmosphere_woocommerce_image_dimensions_after_woo_activation( $plugin ) {

	// Conditional check to see if we're activating WooCommerce.
	if ( $plugin !== 'woocommerce/woocommerce.php' ) {
		return;
	}

	atmosphere_update_woocommerce_image_dimensions();

}

/**
 * Update WooCommerce image dimensions.
 *
 * @since 1.1.0
 */
function atmosphere_update_woocommerce_image_dimensions() {

	$catalog = array(
		'width'  => '480', // px
		'height' => '480', // px
		'crop'   => 1,     // true
	);
	$single = array(
		'width'  => '650', // px
		'height' => '650', // px
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
