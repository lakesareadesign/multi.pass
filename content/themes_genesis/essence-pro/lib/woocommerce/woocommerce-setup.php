<?php
/**
 * Essence Pro.
 *
 * This file adds the required WooCommerce setup functions to the Essence Pro Theme.
 *
 * @package Essence_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/essence/
 */

// Adds product gallery support.
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
add_theme_support( 'wc-product-gallery-zoom' );

add_action( 'wp_enqueue_scripts', 'essence_products_match_height', 99 );
/**
 * Prints an inline script to the footer to keep products the same height.
 *
 * @since 1.0.0
 */
function essence_products_match_height() {

	// If WooCommerce isn't active or not on a WooCommerce page, exits early.
	if ( ! class_exists( 'WooCommerce' ) || ! is_shop() && ! is_woocommerce() && ! is_cart() ) {
		return;
	}

	wp_add_inline_script(
		'essence-match-height',
		"jQuery(document).ready( function() { jQuery( '.product .woocommerce-LoopProduct-link' ).matchHeight(); });"
	);

}

add_action( 'essence_entry_header', 'essence_shop_titles' );
/**
 * Relocates the Shop titles.
 *
 * @since  1.0.0
 */
function essence_shop_titles() {

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	// Removes single WooCommerce product titles.
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

	// Removes the WooCommerce Shop title.
	add_filter( 'woocommerce_show_page_title', '__return_false' );

	if ( is_shop() ) {

		// Defines the WooCommerce Shop title.
		genesis_markup(
			array(
				'open'    => '<h1 %s>',
				'close'   => '</h1>',
				'content' => get_the_title( wc_get_page_id( 'shop' ) ),
				'context' => 'archive-title',
			)
		);

	}

}

// Removes product archive descriptions.
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description' );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description' );

add_action( 'genesis_meta', 'essence_remove_post_meta', 11 );
/**
 * Removes Genesis post meta and half-width-entries
 * body class from WooCommerce pages.
 *
 * @since 1.0.0
 */
function essence_remove_post_meta() {

	if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
		remove_action( 'essence_entry_header', 'genesis_post_info' );
		remove_filter( 'body_class', 'essence_half_width_entry_class' );
		add_filter( 'genesis_term_intro_text_output', 'essence_intro_text_filter', 10, 1 );
	}

}

/**
 * Shows the Genesis Archive Description, if set.
 * Otherwise, show the default WordPress Archive Description.
 *
 * @since 1.0.0
 *
 * @param string $intro_text The archive description text.
 * @return string The modified archive description text.
 */
function essence_intro_text_filter( $intro_text ) {

	if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {

		// Adds product archive descriptions.
		$intro_text             = get_term_meta( get_queried_object_id(), 'intro_text', true );
		$wp_archive_description = get_the_archive_description();

		if ( ! $intro_text ) {
			return $wp_archive_description;
		} else {
			return '<p>' . $intro_text . '</p>';
		}

	}

}

add_filter( 'woocommerce_style_smallscreen_breakpoint', 'essence_woocommerce_breakpoint' );
/**
 * Modifies the WooCommerce breakpoints.
 *
 * @since 1.0.0
 */
function essence_woocommerce_breakpoint() {

	$current = genesis_site_layout();
	$layouts = array(
		'content-sidebar',
		'sidebar-content',
	);

	if ( in_array( $current, $layouts, true ) ) {
		return '1400px';
	} else {
		return '1023px';
	}

}

add_filter( 'genesiswooc_default_products_per_page', 'essence_default_products_per_page' );
/**
 * Sets the default products per page value.
 *
 * @since 1.0.0
 *
 * @return int Number of products to show per page.
 */
function essence_default_products_per_page() {

	return 6; // 6 products per page.

}

add_filter( 'loop_shop_columns', 'essence_product_archive_columns' );
/**
 * Changes number of products in a row to 3.
 *
 * @since 1.0.0
 *
 * @return int Number of products to show per row.
 */
function essence_product_archive_columns() {

	return 3; // 3 products per row.

}

add_filter( 'woocommerce_pagination_args', 'essence_woocommerce_pagination' );
/**
 * Updates the next and previous arrows to the default Genesis style.
 *
 * @since 1.0.0
 *
 * @param array $args The previous and next text arguments.
 * @return array New next and previous text arguments.
 */
function essence_woocommerce_pagination( $args ) {

	$args['prev_text'] = sprintf( '&laquo; %s', __( 'Previous Page', 'essence-pro' ) );
	$args['next_text'] = sprintf( '%s &raquo;', __( 'Next Page', 'essence-pro' ) );

	return $args;

}

add_action( 'after_switch_theme', 'essence_woocommerce_image_dimensions_after_theme_setup', 1 );
/**
 * Defines WooCommerce image sizes on theme activation.
 *
 * @since 1.0.0
 */
function essence_woocommerce_image_dimensions_after_theme_setup() {

	global $pagenow;

	// Checks conditionally to see if we're activating the current theme and that WooCommerce is installed.
	if ( ! isset( $_GET['activated'] ) || 'themes.php' !== $pagenow || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	essence_update_woocommerce_image_dimensions();

}

add_action( 'activated_plugin', 'essence_woocommerce_image_dimensions_after_woo_activation', 10, 2 );
/**
 * Defines the WooCommerce image sizes on WooCommerce activation.
 *
 * @since 1.0.0
 *
 * @param string $plugin The path of the plugin being activated.
 */
function essence_woocommerce_image_dimensions_after_woo_activation( $plugin ) {

	// Checks to see if WooCommerce is being activated.
	if ( 'woocommerce/woocommerce.php' !== $plugin ) {
		return;
	}

	essence_update_woocommerce_image_dimensions();

}

/**
 * Updates WooCommerce image dimensions.
 *
 * @since 1.0.0
 */
function essence_update_woocommerce_image_dimensions() {

	// Updates image size options.
	update_option( 'woocommerce_single_image_width', 690 );    // Single product image.
	update_option( 'woocommerce_thumbnail_image_width', 500 ); // Catalog image.

	// Updates image cropping option.
	update_option( 'woocommerce_thumbnail_cropping', '1:1' );

}

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'essence_gallery_image_thumbnail' );
/**
 * Filters the WooCommerce gallery image dimensions.
 *
 * @since 1.0.0
 *
 * @param array $size The gallery image size and crop arguments.
 * @return array The modified gallery image size and crop arguments.
 */
function essence_gallery_image_thumbnail( $size ) {

	$size = array(
		'width'  => 180,
		'height' => 180,
		'crop'   => 1,
	);

	return $size;

}


// Relocates price to above shop title.
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
