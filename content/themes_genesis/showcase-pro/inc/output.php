<?php
/**
 * Showcase Pro
 *
 * This file adds the customizer CSS to the front end.
 *
 * @package Showcase
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/showcase/
 */
 
add_action( 'wp_enqueue_scripts', 'showcase_css' );
/**
* Checks the settings for the link color color, accent color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function showcase_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_accent = get_theme_mod( 'showcase_accent_color', showcase_customizer_get_default_accent_color() );

	$css = '';

	$css .= ( showcase_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '
		a,
		.icon,
		.pricing-table .plan h3 {
			color: %1$s;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		a.button,
		.pagination a,
		body.woocommerce-page nav.woocommerce-pagination ul li a,
		body.woocommerce-page nav.woocommerce-pagination ul li span,
		body.woocommerce-page #respond input#submit,
		body.woocommerce-page a.button,
		body.woocommerce-page button.button,
		body.woocommerce-page button.button.alt,
		body.woocommerce-page a.button.alt,
		body.woocommerce-page input.button,
		body.woocommerce-page button.button.alt.disabled,
		body.woocommerce-page input.button.alt,
		body.woocommerce-page input.button:disabled,
		body.woocommerce-page input.button:disabled[disabled],
		button:hover,
		input:hover[type="button"],
		input:hover[type="reset"],
		input:hover[type="submit"],
		.button:hover,
		body.woocommerce-page #respond input#submit:hover,
		body.woocommerce-page a.button:hover,
		body.woocommerce-page button.button:hover,
		body.woocommerce-page button.button.alt:hover,
		body.woocommerce-page button.button.alt.disabled:hover,
		body.woocommerce-page a.button.alt:hover,
		body.woocommerce-page input.button:hover,
		body.woocommerce-page input.button.alt:hover,
		#gts-testimonials .lSSlideOuter .lSPager.lSpg>li.active a, 
		#gts-testimonials .lSSlideOuter .lSPager.lSpg>li:hover a,
		.pagination li a:hover,
		.pagination li.active a,
		body.woocommerce-page nav.woocommerce-pagination ul li span.current  {
			background-color: %1$s;
		}

		input:focus,
		textarea:focus,
		body.woocommerce-cart table.cart td.actions .coupon .input-text:focus {
			border-color: %1$s;
		}

		.pricing-table .plan.featured {
			box-shadow: 0 0 0 4px %1$s;
		}


		', $color_accent ) : '';

	if( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
