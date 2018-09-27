<?php
/**
 * Breakthrough Pro.
 *
 * This file adds the WooCommerce styles and the custom CSS to the Breakthrough Pro Theme's custom WooCommerce stylesheet.
 *
 * @package Breakthrough_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/breakthrough/
 */

add_filter( 'woocommerce_enqueue_styles', 'breakthrough_woocommerce_styles' );
/**
 * Enqueues the theme's custom WooCommerce styles to the WooCommerce plugin.
 *
 * @param array $enqueue_styles The WooCommerce styles to enqueue.
 * @since 1.0.0
 *
 * @return array Modified WooCommerce styles to enqueue.
 */
function breakthrough_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['breakthrough-woocommerce-styles'] = array(
		'deps'    => '',
		'media'   => 'screen',
		'src'     => get_stylesheet_directory_uri() . '/lib/woocommerce/breakthrough-woocommerce.css',
		'version' => CHILD_THEME_VERSION,
	);

	return $enqueue_styles;

}

add_action( 'wp_enqueue_scripts', 'breakthrough_woocommerce_css' );
/**
 * Adds the themes's custom CSS to the WooCommerce stylesheet.
 *
 * @since 1.0.0
 */
function breakthrough_woocommerce_css() {

	// If WooCommerce isn't active, exits early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$color_primary   = get_theme_mod( 'breakthrough_primary_color', breakthrough_customizer_get_primary_color() );
	$color_secondary = get_theme_mod( 'breakthrough_secondary_color', breakthrough_customizer_get_secondary_color() );

	$woo_css = '';

	$woo_css .= ( breakthrough_customizer_get_primary_color() !== $color_primary ) ? sprintf(
		'

		.woocommerce ul.products li.product h3:hover,
		.woocommerce ul.products li.product .price {
			color: %1$s;
		}

		.woocommerce span.onsale,
		.woocommerce nav.woocommerce-pagination ul li a:focus,
		.woocommerce nav.woocommerce-pagination ul li a:hover,
		.woocommerce nav.woocommerce-pagination ul li span.current {
			background-color: %1$s;
			color: %3$s;
		}

		.woocommerce .woocommerce-tabs a.button,
		.woocommerce .woocommerce-product-details__short-description a.button {
			background-color: %1$s;
			color: %3$s;
		}

		.woocommerce .woocommerce-tabs a.button:focus,
		.woocommerce .woocommerce-tabs a.button:hover,
		.woocommerce .woocommerce-product-details__short-description a.button:focus,
		.woocommerce .woocommerce-product-details__short-description a.button:hover {
			background-color: %2$s;
			color: %3$s;
		}
	',
		$color_primary,
		breakthrough_color_brightness( $color_primary, 20 ),
		breakthrough_color_contrast( $color_primary )
	) : '';

	$woo_css .= ( breakthrough_customizer_get_secondary_color() !== $color_secondary ) ? sprintf(
		'

		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce .woocommerce-breadcrumb a:hover,
		.woocommerce .woocommerce-breadcrumb a:focus,
		.woocommerce .widget_layered_nav ul li.chosen a::before,
		.woocommerce .widget_layered_nav_filters ul li a::before,
		.woocommerce .widget_rating_filter ul li.chosen a::before {
			color: %2$s;
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
		.woocommerce .button.button-hero {
			background-color: %1$s;
			color: %3$s;
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
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit.alt:focus,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce .button.button-hero:focus,
		.woocommerce .button.button-hero:hover {
			background-color: %2$s;
			color: %3$s;
		}

		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-range {
			background-color: %2$s;
			color: %3$s;
		}

		ul.woocommerce-error,
		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}

		.woocommerce .woocommerce-tabs a.button.text,
		.woocommerce .woocommerce-product-details__short-description a.button.text {
			background-color: #fff;
			border-bottom: 2px solid %1$s;
			color: %1$s;
		}

		.woocommerce .woocommerce-tabs a.button.text:focus,
		.woocommerce .woocommerce-tabs a.button.text:hover,
		.woocommerce .woocommerce-product-details__short-description a.button.text:focus,
		.woocommerce .woocommerce-product-details__short-description a.button.text:hover {
			background-color: #fff;
			border-bottom: %2$s;
			color: %2$s;
		}

		.woocommerce .woocommerce-tabs a.button.primary,
		.woocommerce .woocommerce-product-details__short-description a.button.primary {
			background-color: %1$s;
			color: %3$s;
		}

		.woocommerce .woocommerce-tabs a.button.primary:focus,
		.woocommerce .woocommerce-tabs a.button.primary:hover,
		.woocommerce .woocommerce-product-details__short-description a.button.primary:focus,
		.woocommerce .woocommerce-product-details__short-description a.button.primary:hover {
			background-color: %2$s;
			color: %3$s;
		}

		.woocommerce .enews-widget input[type="submit"]:focus,
		.woocommerce .enews-widget input[type="submit"]:hover {
			background-color: %2$s;
			color: %3$s;
		}
	',
		$color_secondary,
		breakthrough_color_brightness( $color_secondary, 20 ),
		breakthrough_color_contrast( $color_secondary )
	) : '';

	if ( $woo_css ) {
		wp_add_inline_style( 'breakthrough-woocommerce-styles', $woo_css );
	}

}
