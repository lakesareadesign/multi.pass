<?php
/**
 * Atmosphere Pro.
 *
 * This file adds the Customizer additions to the Atmosphere Pro Theme for
 * the WooCommerce plugin.
 *
 * @package Atmosphere
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/atmosphere/
 */

add_filter( 'woocommerce_enqueue_styles', 'atmosphere_woocommerce_styles' );
/**
 * Add the theme's WooCommerce stylesheet to the WooCommerce plugin queue.
 *
 * @since 1.1.0
 *
 * @return array Values for the new custom stylesheet source data.
 */
function atmosphere_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['atmosphere-woocommerce-styles'] = array(
		'src'     => get_stylesheet_directory_uri() . '/lib/woocommerce/atmosphere-woocommerce.css',
		'deps'    => '',
		'version' => CHILD_THEME_VERSION,
		'media'   => 'screen',
	);

	return $enqueue_styles;

}

add_action( 'wp_enqueue_scripts', 'atmosphere_woocommerce_cusotmizer_css' );
/**
 * Check for customizer settings and output to CSS.
 *
 * @since 1.1.0
 */
function atmosphere_woocommerce_cusotmizer_css() {

	// If WooCommerce isn't installed, exit early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$color_link = get_theme_mod( 'atmosphere_link_color', atmosphere_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'atmosphere_accent_color', atmosphere_customizer_get_default_accent_color() );

	$woo_css = '';

	$woo_css .= ( atmosphere_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

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

		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-range {
			background-color: %1$s;
		}

		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}

		', $color_link ) : '';

	$woo_css .= ( atmosphere_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

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
				border-color: %1$s;
			}

		', $color_accent ) : '';

	if ( $woo_css ) {
		wp_add_inline_style( 'atmosphere-woocommerce-styles', $woo_css );
	}

}
