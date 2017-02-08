<?php
/**
 * Executive Pro.
 *
 * This file adds the custom CSS to the Executive Pro Theme's custom WooCommerce stylesheet.
 *
 * @package Executive
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/executive/
 */

add_filter( 'woocommerce_enqueue_styles', 'executive_woocommerce_styles' );
/**
 * Enqueue the theme's custom WooCommerce styles to the WooCommerce plugin.
 *
 * @since 3.2.0
 *
 * @return array Required values for the theme's WooCommerce stylesheet.
 */
function executive_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['executive-woocommerce-styles'] = array(
		'src'     => get_stylesheet_directory_uri() . '/lib/woocommerce/executive-woocommerce.css',
		'deps'    => '',
		'version' => CHILD_THEME_VERSION,
		'media'   => 'screen',
	);

	return $enqueue_styles;

}

add_action( 'wp_enqueue_scripts', 'executive_woocommerce_css' );
/**
 * Add the themes's custom CSS to the WooCommerce stylesheet.
 *
 * @since 1.1.0
 */
function executive_woocommerce_css() {

	// If WooCommerce isn't installed, exit early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$color_link = get_theme_mod( 'executive_link_color', executive_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'executive_accent_color', executive_customizer_get_default_accent_color() );
	$color_hover  = get_theme_mod( 'executive_hover_color', executive_customizer_get_default_hover_color() );

	$woo_css = '';

	$woo_css .= ( executive_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce ul.products li.product h3:hover,
		.woocommerce ul.products li.product .price,
		.woocommerce .woocommerce-breadcrumb a:hover,
		.woocommerce .woocommerce-breadcrumb a:focus,
		.woocommerce .widget_layered_nav ul li.chosen a::before,
		.woocommerce .widget_layered_nav_filters ul li a::before {
			color: %s;
		}

	', $color_link ) : '';

	$woo_css .= ( executive_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		.woocommerce a.button,
		.woocommerce a.button.alt,
		.woocommerce button.button,
		.woocommerce button.button.alt,
		.woocommerce input.button,
		.woocommerce input.button.alt,
		.woocommerce input.button[type="submit"],
		.woocommerce span.onsale,
		.woocommerce #respond input#submit,
		.woocommerce #respond input#submit.alt,
		.woocommerce-error::before,
		.woocommerce-info::before,
		.woocommerce-message::before,
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

	', $color_accent, executive_color_contrast( $color_accent ) ) : '';

	$woo_css .= ( executive_customizer_get_default_hover_color() !== $color_hover ) ? sprintf( '

		.woocommerce a.button:hover,
		.woocommerce a.button:focus,
		.woocommerce a.button.alt:hover,
		.woocommerce a.button.alt:focus,
		.woocommerce button.button:hover,
		.woocommerce button.button:focus,
		.woocommerce button.button.alt:hover,
		.woocommerce button.button.alt:focus,
		.woocommerce input.button:hover,
		.woocommerce input.button:focus,
		.woocommerce input.button.alt:hover,
		.woocommerce input.button.alt:focus,
		.woocommerce input[type="submit"]:hover,
		.woocommerce input[type="submit"]:focus,
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce #respond input#submit.alt:focus {
			background-color: %1$s;
			color: %2$s;
		}

		', $color_hover, executive_color_contrast( $color_hover ) ) : '';

	if ( $woo_css ) {
		wp_add_inline_style( 'executive-woocommerce-styles', $woo_css );
	}

}
