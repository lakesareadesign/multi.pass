<?php
/**
 * Kreativ Pro.
 *
 * This file adds the required custom CSS to the Kreativ Pro Theme's WooCommerce stylesheet.
 *
 * @package Kreativ
 * @author  ThemeSquare
 * @license GPL-2.0+
 * @link    http://themesquare.com/themes/kreativ/
 */

add_filter( 'woocommerce_enqueue_styles', 'kreativ_woocommerce_styles' );
/**
 * Enqueue custom WooCommerce styles when WooCommerce active.
 *
 * @since 1.1.0
 */
function kreativ_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['kreativ-woocommerce-styles'] = array(
		'src'     => get_stylesheet_directory_uri() . '/lib/woocommerce/kreativ-woocommerce.css',
		'deps'    => '',
		'version' => CHILD_THEME_VERSION,
		'media'   => 'screen',
	);

	return $enqueue_styles;

}

add_action( 'wp_enqueue_scripts', 'kreativ_woocommerce_customizer_css', 12 );
/**
 * Add WooCommerce specific Customizer CSS.
 *
 * @return string Customizer CSS outputted to the custom WooCommerce stylesheet.
 */
function kreativ_woocommerce_customizer_css() {

	// If WooCommerce isn't installed, exit early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

		// Get default accent color.
	$default = kreativ_customizer_default_accent_color();

	// Get theme accent color.
	$color_accent = get_theme_mod( 'kreativ_accent_color', $default );

	$woo_css = ( $default !== $color_accent ) ? sprintf( '

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

		.woocommerce a.button,
		.woocommerce a.button.alt,
		.woocommerce button.button,
		.woocommerce button.button.alt,
		.woocommerce input.button,
		.woocommerce input.button.alt,
		.woocommerce input.button[type="submit"],
		.woocommerce #respond input#submit,
		.woocommerce #respond input#submit.alt,
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
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit.alt:focus,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-range {
			background-color: %1$s;
		}

		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}

	', $color_accent ) : '';

	if ( $woo_css ) {
		wp_add_inline_style( 'kreativ-woocommerce-styles', $woo_css );
	}

}
