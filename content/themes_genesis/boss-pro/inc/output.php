<?php
/**
 * Boss Pro
 *
 * This file adds the customizer CSS to the front end.
 *
 * @package Boss
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/boss/
 */

add_action( 'wp_enqueue_scripts', 'boss_css' );
/**
 * Checks the settings for the link color color, accent color, and header
 * If any of these value are set the appropriate CSS is output.
 *
 * @return void
 *
 * @since 1.0.0
 */
function boss_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_link = get_theme_mod( 'boss_link_color', boss_customizer_get_default_link_color() );
	$color_button = get_theme_mod( 'boss_button_color', boss_customizer_get_default_button_color() );
	$color_front_page_2 = get_theme_mod( 'boss_front_page_2_color', boss_customizer_get_default_front_page_2_color() );
	$color_light_accent = get_theme_mod( 'boss_light_accent_color', boss_customizer_get_default_light_accent_color() );
	$header_image = get_option( 'boss-header-image', sprintf( '%s/assets/images/logo_light.png', get_stylesheet_directory_uri() ) );

	// Light Header Image.
	$css = '';

	if ( is_front_page() ) {
		$css .= ( ! empty( $header_image ) ) ? sprintf( '
			body.with-page-header.header-image:not(.header-scroll) .site-title a {
				background-image: url(%1$s) !important;
			}
		', $header_image ) : '';
	}

	// Link Color.
	$css .= ( boss_customizer_get_default_link_color() !== $color_link ) ? sprintf( '
		a,
		.pricing-table .plan h3 {
			color: %1$s;
		}

		#gts-testimonials .lSSlideOuter .lSPager.lSpg>li.active a,
		#gts-testimonials .lSSlideOuter .lSPager.lSpg>li:hover a {
			background-color: %1$s;
		}

		input:focus,
		textarea:focus,
		body.woocommerce-cart table.cart td.actions .coupon .input-text:focus {
			border-color: %1$s;
		}

		', $color_link ) : '';

	// Button Color.
	$css .= ( boss_customizer_get_default_button_color() !== $color_button ) ? sprintf( '

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		a.button,
		.pagination li.active a,
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
			border-color: %1$s;
		}

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
		body.woocommerce-page input.button.alt:hover {
			background-color: transparent;
			color: %1$s;
		}

		', $color_button ) : '';

	// Front Page 2 Color.
	$css .= ( boss_customizer_get_default_front_page_2_color() !== $color_link ) ? sprintf( '
		.front-page-2,
		.front-page-2 .widget_text:before,
		.front-page-2 .widget_text:after {
			background-color: %1$s;
		}

		', $color_front_page_2 ) : '';

	// Light Accent Color.
	$css .= ( boss_customizer_get_default_light_accent_color() !== $color_link ) ? sprintf( '
		.card,
		.before-blog,
		.front-page-6,
		.sidebar .widget.featured-content {
			background-color: %1$s;
		}

		', $color_light_accent ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
