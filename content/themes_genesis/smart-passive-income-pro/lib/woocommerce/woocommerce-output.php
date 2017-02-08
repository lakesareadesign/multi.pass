<?php
/**
 * Smart Passive Income Pro.
 *
 * This file adds the customized CSS for WooCommerce to the Smart Passive Income Pro Theme.
 *
 * @package Smart Passive Income Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

add_filter( 'woocommerce_enqueue_styles', 'spi_woocommerce_styles' );
/**
 * Add the custom stylesheet for WooCommerce.
 *
 * @since 1.1.0
 *
 * @return array Values for including the stylsheet.
 */
function spi_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['spi-woocommerce-styles'] = array(
		'src'     => get_stylesheet_directory_uri() . '/lib/woocommerce/spi-woocommerce.css',
		'deps'    => '',
		'version' => CHILD_THEME_VERSION,
		'media'   => 'screen',
	);

	return $enqueue_styles;

}

add_action( 'wp_enqueue_scripts', 'spi_woocommerce_customizer_css' );
/**
 * Enqueue the custom CSS to the theme's WooCommerce stylesheet
 * only if the primary and/or secondary colors ar modified.
 *
 * @since 1.0.0
 */
function spi_woocommerce_customizer_css() {

	// If WooCommerce isn't installed, exit early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$color_primary = get_theme_mod( 'spi_primary_color', spi_customizer_get_default_primary_color() );
	$color_secondary = get_theme_mod( 'spi_secondary_color', spi_customizer_get_default_secondary_color() );

	$woo_css = '';

	$woo_css .= ( spi_customizer_get_default_primary_color() !== $color_primary ) ? sprintf( '

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
		.woocommerce input[type="submit"],
		.woocommerce #respond input#submit,
		.woocommerce #respond input#submit.alt {
			color: %2$s;
		}

		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}

		.woocommerce a.button,
		.woocommerce a.button.alt,
		.woocommerce button.button,
		.woocommerce button.button.alt,
		.woocommerce input.button,
		.woocommerce input.button.alt,
		.woocommerce input.button[type="submit"],
		.woocommerce input[type="submit"],
		.woocommerce #respond input#submit,
		.woocommerce #respond input#submit.alt,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-range {
			background-color: %1$s;
		}

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
		.woocommerce input.button[type="submit"]:focus,
		.woocommerce input.button[type="submit"]:hover,
		.woocommerce input[type="submit"]:focus,
		.woocommerce input[type="submit"]:hover,
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit.alt:focus,
		.woocommerce #respond input#submit.alt:hover {
			background-color: %3$s;
			color: %2$s;
		}

	', $color_primary, spi_color_contrast( $color_primary ), spi_color_brightness( $color_primary, '+', 20 ) ) : '';

	$woo_css .= ( spi_customizer_get_default_secondary_color() !== $color_secondary ) ? sprintf( '

		.woocommerce span.onsale {
			background-color: %1$s;
			color: %2$s;
		}

	', $color_secondary, spi_color_contrast( $color_secondary ) ) : '';

	if ( $woo_css ) {
		wp_add_inline_style( 'spi-woocommerce-styles', $woo_css );
	}

}
