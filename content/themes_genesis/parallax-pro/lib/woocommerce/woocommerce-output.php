<?php
/**
 * Parallax Pro.
 *
 * This file adds the customizer additions to the Parallax Pro Theme's WooCommerce stylesheet.
 *
 * @package Parallax
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/parallax/
 */

add_filter( 'woocommerce_enqueue_styles', 'parallax_woocommerce_styles' );
/**
 * Enqueue the theme's custom WooCommerce styles to the WooCommerce plugin.
 *
 * @since 1.3.0
 *
 * @return array Required values for the theme's WooCommerce stylesheet.
 */
function parallax_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['parallax-woocommerce-styles'] = array(
		'src'     => get_stylesheet_directory_uri() . '/lib/woocommerce/parallax-woocommerce.css',
		'deps'    => '',
		'version' => CHILD_THEME_VERSION,
		'media'   => 'screen',
	);

	return $enqueue_styles;

}

add_action( 'wp_enqueue_scripts', 'parallax_woocommerce_css' );
/**
 * Get the custom CSS and print it inline under the theme's main WooCommerce
 * stylesheet, but only if the value is different than the default.
 *
 * @since 1.3.0
 */
function parallax_woocommerce_css() {

	// If WooCommerce isn't installed, exit early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$accent_color = get_theme_mod( 'parallax_accent_color', parallax_get_default_accent_color() );
	$link_color   = get_theme_mod( 'parallax_link_color', parallax_get_default_accent_color() );
	$woo_css      = '';

	$woo_css .= ( parallax_get_default_accent_color() !== $accent_color ) ? sprintf( '

		.woocommerce a.button:focus,
		.woocommerce a.button:hover,
		.woocommerce a.button.alt:focus,
		.woocommerce a.button.alt:hover,
		.woocommerce button.button:focus,
		.woocommerce button.button:hover,
		.woocommerce button.button.alt:focus,
		.woocommerce button.button.alt:hover,
		.woocommerce input.button:focus,
		.woocommerce input.button:hover,
		.woocommerce input.button.alt:focus,
		.woocommerce input.button.alt:hover,
		.woocommerce input[type="submit"]:focus,
		.woocommerce input[type="submit"]:hover,
		.woocommerce span.onsale,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-range,
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit.alt:focus,
		.woocommerce #respond input#submit.alt:hover {
			background-color: %1$s;
			color: %2$s;
		}

		.woocommerce .footer-widgets a.button,
		.woocommerce .footer-widgets button,
		.woocommerce .footer-widgets input[type="button"],
		.woocommerce .footer-widgets input[type="reset"],
		.woocommerce .footer-widgets input[type="submit"] {
			border-color: %2$s;
			color: %2$s !important;
		}

		.woocommerce .footer-widgets a.button:focus,
		.woocommerce .footer-widgets a.button:hover,
		.woocommerce .footer-widgets button:focus,
		.woocommerce .footer-widgets button:hover,
		.woocommerce .footer-widgets input[type="button"]:focus,
		.woocommerce .footer-widgets input[type="button"]:hover,
		.woocommerce .footer-widgets input[type="reset"]:focus,
		.woocommerce .footer-widgets input[type="reset"]:hover,
		.woocommerce .footer-widgets input[type="submit"]:focus,
		.woocommerce .footer-widgets input[type="submit"]:hover {
			background-color: #fff;
			border-color: #fff;
			color: #000 !important;
		}

		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}

		', $accent_color, parallax_color_contrast( $accent_color ) ) : '';

	$woo_css .= ( parallax_get_default_accent_color() !== $link_color ) ? sprintf( '

		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.woocommerce ul.products li.product h3:hover,
		.woocommerce ul.products li.product .price,
		.woocommerce .widget_layered_nav ul li.chosen a::before,
		.woocommerce .widget_layered_nav_filters ul li a::before,
		.woocommerce .woocommerce-breadcrumb a:focus,
		.woocommerce .woocommerce-breadcrumb a:hover,
		.woocommerce-error::before,
		.woocommerce-info::before,
		.woocommerce-message::before {
			color: %1$s;
		}

		', $link_color ) : '';

	if ( $woo_css ) {
		wp_add_inline_style( 'parallax-woocommerce-styles', $woo_css );
	}

}
