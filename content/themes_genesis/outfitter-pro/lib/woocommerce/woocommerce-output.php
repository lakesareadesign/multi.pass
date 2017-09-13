<?php
/**
 * Outfitter Pro.
 *
 * This file adds the WooCommerce styles and the custom CSS to the Outfitter Pro Theme's custom WooCommerce stylesheet.
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

add_filter( 'woocommerce_enqueue_styles', 'outfitter_woocommerce_styles' );
/**
 * Enqueues the theme's custom WooCommerce styles to the WooCommerce plugin.
 *
 * @since 1.0.0
 *
 * @return array Required values for the theme's WooCommerce stylesheet.
 */
function outfitter_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['outfitter-woocommerce-styles'] = array(
		'deps'    => '',
		'media'   => 'screen',
		'src'     => get_stylesheet_directory_uri() . '/lib/woocommerce/outfitter-woocommerce.css',
		'version' => CHILD_THEME_VERSION,
	);

	return $enqueue_styles;

}

add_action( 'wp_enqueue_scripts', 'outfitter_woocommerce_css' );
/**
 * Adds the themes's custom CSS to the WooCommerce stylesheet.
 *
 * @since 1.0.0
 */
function outfitter_woocommerce_css() {

	// If WooCommerce isn't active, exits early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$color_link = get_theme_mod( 'outfitter_link_color', outfitter_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'outfitter_accent_color', outfitter_customizer_get_default_accent_color() );

	$woo_css = '';

	$woo_css .= ( outfitter_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		.woocommerce ul.products li.product:hover .button:hover,
		.woocommerce ul.products li.product h3:hover,
		.woocommerce ul.products li.product .price,
		.woocommerce div.product span.price ins,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.woocommerce .woocommerce-breadcrumb a:focus,
		.woocommerce .woocommerce-breadcrumb a:hover,
		.woocommerce-error::before,
		.woocommerce-info::before,
		.woocommerce-message::before,
		.woocommerce .widget_layered_nav ul li.chosen a::before,
		.woocommerce .widget_layered_nav_filters ul li a::before,
		.woocommerce .widget_rating_filter ul li.chosen a::before,
		.woocommerce nav.woocommerce-pagination ul li a:focus,
		.woocommerce nav.woocommerce-pagination ul li a:hover,
		.woocommerce nav.woocommerce-pagination ul li span.current {
			color: %s;
		}

		.menu-item-has-toggle .cart-count,
		.woocommerce ul.products li.product .woocommerce-loop-product__title:before,
		.woocommerce ul.products li.product .price:after,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-range {
			background-color: %1$s;
			color: %2$s;
		}

		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}

		.woocommerce ul.products li.product .price .amount {
			color: %2$s;
		}

	', $color_link, outfitter_color_contrast( $color_link ) ) : '';

	$woo_css .= ( outfitter_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		.woocommerce span.onsale,
		.woocommerce ul.products li.product .onsale,
		.woocommerce a.button.checkout-button,
		.woocommerce a.button.checkout,
		.woocommerce form.cart button.single_add_to_cart_button,
		.woocommerce #place_order,
		.woocommerce ul.products li.product.sale .price:after {
			background-color: %1$s;
			color: %2$s;
		}

		.woocommerce div.product p.price ins {
			color: %1$s;
		}

	', $color_accent, outfitter_color_contrast( $color_accent ) ) : '';

	if ( $woo_css ) {
		wp_add_inline_style( 'outfitter-woocommerce-styles', $woo_css );
	}

}
