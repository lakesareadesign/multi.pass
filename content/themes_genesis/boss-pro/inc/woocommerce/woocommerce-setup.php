<?php
/**
 * Boss Pro
 *
 * This file adds the required settings updates to the WooCommerce Plugin for the Boss Pro Theme.
 *
 * @package Boss
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/boss/
 */

add_action( 'wp_enqueue_scripts', 'boss_products_match_height', 99 );
/**
 * Print an inline script to the footer to keep products the same height.
 *
 * @return void
 *
 * @since 2.0.0
 */
function boss_products_match_height() {

	// If WooCommerce isn't installed, exit early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	wp_add_inline_script( 'showcase-match-height', "jQuery(document).ready( function() { jQuery( '.product .woocommerce-LoopProduct-link').matchHeight(); });" );

}

add_filter( 'woocommerce_style_smallscreen_breakpoint', 'boss_woocommerce_breakpoint' );
/**
 * Modify the WooCommerce breakpoints.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_woocommerce_breakpoint() {

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

add_filter( 'genesiswooc_default_products_per_page', 'boss_default_products_per_page' );
/**
 * Set the shop default products per page count.
 *
 * @param int $count
 * @return int Number of products per page.
 *
 * @since 1.0.0
 */
function boss_default_products_per_page( $count ) {
	return 8;
}

add_filter( 'woocommerce_pagination_args', 	'boss_woocommerce_pagination' );
/**
 * Update the next and previous arrows to the default Genesis style.
 *
 * @param array $args
 * @return array $args New next and previous text.
 *
 * @since 1.0.0
 */
function boss_woocommerce_pagination( $args ) {

	$args['prev_text'] = sprintf( '&laquo; %s', __( 'Previous Page', 'boss-pro' ) );
	$args['next_text'] = sprintf( '%s &raquo;', __( 'Next Page', 'boss-pro' ) );

	return $args;

}

add_action( 'after_switch_theme', 'boss_woocommerce_image_dimensions_after_theme_setup', 1 );
/**
 * Define the WooCommerce image sizes after theme activation.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_woocommerce_image_dimensions_after_theme_setup() {

	global $pagenow;

	// Conditional check to see if we're activating the current theme and that WooCommerce is installed.
	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	boss_update_woocommerce_image_dimensions();

}

add_action( 'activated_plugin', 'boss_woocommerce_image_dimensions_after_woo_activation', 10, 2 );
/**
 * Define WooCommerce image sizes on activation of the WooCommerce plugin.
 *
 * @param string $plugin
 * @return void
 *
 * @since 1.0.0
 */
function boss_woocommerce_image_dimensions_after_woo_activation( $plugin ) {

	// Conditional check to see if we're activating WooCommerce.
	if ( $plugin !== 'woocommerce/woocommerce.php' ) {
		return;
	}

	boss_update_woocommerce_image_dimensions();

}

/**
 * Update the WooCommerce image dimensions.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_update_woocommerce_image_dimensions() {

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

add_action( 'after_setup_theme', 'boss_woocommerce_gallery_setup' );
/**
 * Enable WooCommerce Gallery Features.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_woocommerce_gallery_setup() {

	if ( class_exists( 'WooCommerce' ) ) {

		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

	}

}
