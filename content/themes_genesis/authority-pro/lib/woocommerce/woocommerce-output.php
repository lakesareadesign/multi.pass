<?php
/**
 * Authority Pro.
 *
 * This file adds the WooCommerce styles and the custom CSS to the Authority Pro Theme's custom WooCommerce stylesheet.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

add_filter( 'woocommerce_enqueue_styles', 'authority_woocommerce_styles' );
/**
 * Enqueues the theme's custom WooCommerce styles.
 *
 * @since 1.0.0
 *
 * @param array $enqueue_styles Existing enqueued WooCommerce styles.
 * @return array WooCommerce styles with the addition of the child theme file.
 */
function authority_woocommerce_styles( $enqueue_styles ) {

	$enqueue_styles['authority-woocommerce-styles'] = array(
		'deps'    => '',
		'media'   => 'screen',
		'src'     => get_stylesheet_directory_uri() . '/lib/woocommerce/authority-woocommerce.css',
		'version' => CHILD_THEME_VERSION,
	);

	return $enqueue_styles;

}

add_action( 'wp_enqueue_scripts', 'authority_woocommerce_css' );
/**
 * Adds the themes's custom CSS to the WooCommerce stylesheet.
 *
 * @since 1.0.0
 */
function authority_woocommerce_css() {

	// If WooCommerce isn't active, exits early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$color_primary = get_theme_mod( 'authority_primary_color', authority_customizer_get_default_primary_color() );

	$woo_css = '';

	$woo_css .= ( authority_customizer_get_default_primary_color() !== $color_primary ) ? sprintf( '

		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce ul.products li.product h3:hover,
		.woocommerce ul.products li.product .price,
		.woocommerce .woocommerce-breadcrumb a:hover,
		.woocommerce .woocommerce-breadcrumb a:focus,
		.woocommerce .widget_layered_nav ul li.chosen a::before,
		.woocommerce .widget_layered_nav_filters ul li a::before,
		.woocommerce .widget_rating_filter ul li.chosen a::before,
		.woocommerce .widget_rating_filter ul li.chosen a::before {
			color: %s;
		}

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
		.woocommerce #respond input#submit.alt {
			border-color: %1$s;
			color: %1$s;
		}

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
		.woocommerce nav.woocommerce-pagination ul li a:focus,
		.woocommerce nav.woocommerce-pagination ul li a:hover,
		.woocommerce nav.woocommerce-pagination ul li span.current,
		.woocommerce span.onsale,
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce #respond input#submit.alt:focus,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-range {
			background-color: %3$s;
			color: %2$s;
		}

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
			border-color: %3$s;
		}

		.woocommerce button.primary,
		.woocommerce input[type="button"].primary,
		.woocommerce input[type="reset"].primary,
		.woocommerce input[type="submit"].primary,
		.woocommerce .button.primary {
			background-color: %1$s;
			color: %2$s;
		}

		ul.woocommerce-error,
		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}

	', $color_primary, authority_color_contrast( $color_primary ), authority_color_brightness( $color_primary, '+', 20 ) ) : '';

	if ( $woo_css ) {
		wp_add_inline_style( 'authority-woocommerce-styles', $woo_css );
	}

}
