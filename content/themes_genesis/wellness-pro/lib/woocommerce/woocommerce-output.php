<?php
/**
 * Wellness Pro.
 *
 * This file adds custom CSS to the Wellness Pro Theme's WooCommerce stylesheet.
 *
 * @package Wellness
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/wellness/
 */

add_filter( 'woocommerce_enqueue_styles', 'wellness_woocommerce_styles' );
/**
 * Enqueue the theme's custom WooCommerce stylesheet.
 *
 * @since 1.1.0
 *
 * @return array Values of the custom stylesheet with the source data.
 */
function wellness_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['wellness-woocommerce-styles'] = array(
		'src'     => get_stylesheet_directory_uri() . '/lib/woocommerce/wellness-woocommerce.css',
		'deps'    => '',
		'version' => CHILD_THEME_VERSION,
		'media'   => 'screen',
	);

	return $enqueue_styles;

}

add_action( 'wp_enqueue_scripts', 'wellness_woocommerce_customizer_css' );
/**
 * Add the custom CSS to the theme's WooCommerce stylsheet.
 *
 * @since 1.1.0
 */
function wellness_woocommerce_customizer_css() {

	// If WooCommerce isn't installed, exit early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$color_link = get_theme_mod( 'wellness_link_color', wellness_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'wellness_accent_color', wellness_customizer_get_default_accent_color() );

	$woo_css = '';

	$woo_css .= ( wellness_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce ul.products li.product h3:hover,
		.woocommerce ul.products li.product .price,
		.woocommerce .widget_layered_nav ul li.chosen a:before,
		.woocommerce .widget_layered_nav_filters ul li a:before,
		.woocommerce .woocommerce-breadcrumb a:hover,
		.woocommerce .woocommerce-breadcrumb a:focus {
			color: %1$s;
		}

		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-range {
			background-color: %1$s;
		}

		', $color_link ) : '';

	$woo_css .= ( wellness_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce-error:before,
		.woocommerce-info:before,
		.woocommerce-message:before {
			color: %1$s;
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
		.woocommerce input[type="submit"]:focus,
		.woocommerce input[type="submit"]:hover,
		.woocommerce span.onsale,
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit.alt:focus,
		.woocommerce #respond input#submit.alt:hover {
			background-color: %1$s;
			color: %2$s;
		}

		.woocommerce a.button:focus::after,
		.woocommerce a.button:focus::before,
		.woocommerce a.button:hover::after,
		.woocommerce a.button:hover::before,
		.woocommerce a.button.alt:focus::after,
		.woocommerce a.button.alt:focus::before,
		.woocommerce a.button.alt:hover::after,
		.woocommerce a.button.alt:hover::before,
		.woocommerce button.button:focus::after,
		.woocommerce button.button:focus::before,
		.woocommerce button.button:hover::after,
		.woocommerce button.button:hover::before,
		.woocommerce button.button.alt:focus::after,
		.woocommerce button.button.alt:focus::before,
		.woocommerce button.button.alt:hover::after,
		.woocommerce button.button.alt:hover::before,
		.woocommerce input.button:focus::after,
		.woocommerce input.button:focus::before,
		.woocommerce input.button:hover::after,
		.woocommerce input.button:hover::before,
		.woocommerce input.button.alt:focus::after,
		.woocommerce input.button.alt:focus::before,
		.woocommerce input.button.alt:hover::after,
		.woocommerce input.button.alt:hover::before,
		.woocommerce input.button[type="submit"]:focus::after,
		.woocommerce input.button[type="submit"]:focus::before,
		.woocommerce input.button[type="submit"]:hover::after,
		.woocommerce input.button[type="submit"]:hover::before,
		.woocommerce #respond input#submit:focus::after,
		.woocommerce #respond input#submit:focus::before,
		.woocommerce #respond input#submit:hover::after,
		.woocommerce #respond input#submit:hover::before,
		.woocommerce #respond input#submit.alt:focus::after,
		.woocommerce #respond input#submit.alt:focus::before,
		.woocommerce #respond input#submit.alt:hover::after,
		.woocommerce #respond input#submit.alt:hover::before {
			border-bottom-color: %1$s;
			border-top-color: %1$s;
		}

		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}

		', $color_accent, wellness_color_contrast( $color_accent ) ) : '';

	if ( $woo_css ) {
		wp_add_inline_style( 'wellness-woocommerce-styles', $woo_css );
	}

}
