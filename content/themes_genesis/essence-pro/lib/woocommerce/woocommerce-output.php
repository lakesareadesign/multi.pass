<?php
/**
 * Essence Pro.
 *
 * This file adds the WooCommerce styles and the custom CSS to the Essence Pro Theme's custom WooCommerce stylesheet.
 *
 * @package Essence_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/essence/
 */

add_filter( 'woocommerce_enqueue_styles', 'essence_woocommerce_styles' );
/**
 * Enqueues the theme's custom WooCommerce styles to the WooCommerce plugin.
 *
 * @param array $enqueue_styles The WooCommerce styles to enqueue.
 * @since 1.0.0
 *
 * @return array Modified WooCommerce styles to enqueue.
 */
function essence_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['essence-woocommerce-styles'] = array(
		'deps'    => '',
		'media'   => 'screen',
		'src'     => get_stylesheet_directory_uri() . '/lib/woocommerce/essence-woocommerce.css',
		'version' => CHILD_THEME_VERSION,
	);

	return $enqueue_styles;

}

add_action( 'wp_enqueue_scripts', 'essence_woocommerce_css' );
/**
 * Adds the themes's custom CSS to the WooCommerce stylesheet.
 *
 * @since 1.0.0
 */
function essence_woocommerce_css() {

	// If WooCommerce isn't active, exits early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$color_link = get_theme_mod( 'essence_link_color', essence_customizer_get_default_link_color() );

	$woo_css = '';

	$woo_css .= ( essence_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce-error::before,
		.woocommerce-info::before,
		.woocommerce-message::before,
		.woocommerce ul.products li.product h3:hover,
		.woocommerce ul.products li.product h2:hover,
		.woocommerce ul.products li.product .price,
		.woocommerce .woocommerce-breadcrumb a:hover,
		.woocommerce .woocommerce-breadcrumb a:focus,
		.woocommerce .widget_layered_nav ul li.chosen a::before,
		.woocommerce .widget_layered_nav_filters ul li a::before,
		.woocommerce .widget_rating_filter ul li.chosen a::before,
		.woocommerce .widget_rating_filter ul li.chosen a::before {
			color: %1$s;
		}

		.woocommerce a.button,
		.woocommerce a.button.alt,
		.woocommerce button.button,
		.woocommerce button.button.alt,
		.woocommerce input.button,
		.woocommerce input.button.alt,
		.woocommerce input[type="submit"],
		.woocommerce input.button[type="submit"],
		.woocommerce #respond input#submit,
		.woocommerce #respond input#submit.alt,
		.woocommerce span.onsale,
		.single-product.woocommerce .site-inner:before {
			background-color: %1$s;
		}

		.woocommerce nav.woocommerce-pagination ul li a:focus,
		.woocommerce nav.woocommerce-pagination ul li a:hover,
		.woocommerce nav.woocommerce-pagination ul li span.current {
			border-color: %1$s;
			color: %1$s;
		}

		ul.woocommerce-error,
		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}

	', $color_link ) : '';

	if ( $woo_css ) {
		wp_add_inline_style( 'essence-woocommerce-styles', $woo_css );
	}

}
