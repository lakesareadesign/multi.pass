<?php
/**
 * Niche Pro.
 *
 * This file adds the customizer CSS to the front end of the Niche Pro Theme.
 *
 * @package Niche
 * @author  Bloom
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/niche/
 */

add_action( 'wp_enqueue_scripts', 'bloom_css' );
/**
 * Checks the settings for the colors
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function bloom_css() {

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_text         = get_theme_mod( 'bloom_text_color', bloom_customizer_get_default_text_color() );
	$color_link         = get_theme_mod( 'bloom_link_color', bloom_customizer_get_default_link_color() );
	$color_button       = get_theme_mod( 'bloom_button_color', bloom_customizer_get_default_button_color() );
	$color_light_accent = get_theme_mod( 'bloom_light_accent_color', bloom_customizer_get_default_light_accent_color() );
	$color_dark_accent  = get_theme_mod( 'bloom_dark_accent_color', bloom_customizer_get_default_dark_accent_color() );
	$color_border       = get_theme_mod( 'bloom_border_color', bloom_customizer_get_default_border_color() );

	$css = '';

	// Text Color.
	$css .= ( bloom_customizer_get_default_text_color() !== $color_link ) ? sprintf(
		'
		body,
		.widget_nav_menu a,
		.widget-title a,
		.genesis-nav-menu a,
		.pagination a,
		.featured-content article .post-info a,
		.content article .entry-meta a,
		.entry-title a,
		input,
		select,
		textarea,
		body.woocommerce-cart table.cart td.actions .coupon .input-text,
		.content a.count,
		.content a.count:hover,
		.content a.share,
		.content a.share:hover,
		.sharrre .share,
		.sharrre:hover .share,
		body.woocommerce-page nav.woocommerce-pagination ul li a,
		body.woocommerce-page nav.woocommerce-pagination ul li span,
		body.woocommerce-page .woocommerce-message::before,
		body.woocommerce-page .woocommerce-info::before,
		body.woocommerce-page div.product p.price,
		body.woocommerce-page div.product span.price,
		body.woocommerce-page ul.products li.product .price,
		body.woocommerce-page form .form-row .required,
		body.woocommerce .woocommerce-MyAccount-navigation li a,
		body.woocommerce .woocommerce-LoopProduct-link,
		button.menu-toggle:before {
			color: %1$s;
		}

		', $color_text
	) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

	// Link Color.
	$css .= ( bloom_customizer_get_default_link_color() !== $color_link ) ? sprintf(
		'
		.widget_nav_menu a:hover,
		.genesis-nav-menu a:hover,
		a {
			color: %1$s;
		}

		.content article .entry-meta a,
		.featured-content article .post-info a {
			border-color: %1$s;
		}

		', $color_link
	) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

	// Button Color.
	$css .= ( bloom_customizer_get_default_button_color() !== $color_button ) ? sprintf(
		'

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		a.button,
		body.woocommerce-page nav.woocommerce-pagination ul li a:hover,
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
		.bloom-instagram .widget_nav_menu a,
		.pagination li a:hover,
		.pagination li.active a,
		body.woocommerce-page nav.woocommerce-pagination ul li span.current {
			background-color: %1$s;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		a.button,
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
		.bloom-instagram .widget_nav_menu a  {
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
		body.woocommerce-page input.button.alt:hover,
		.bloom-instagram .widget_nav_menu a:hover,
		.pagination:not(.adjacent-entry-pagination) li a {
			color: %1$s;
		}

		', $color_button
	) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

	// Light Accent Color.
	$css .= ( bloom_customizer_get_default_light_accent_color() !== $color_link ) ? sprintf(
		'
		.card,
		.home-page-2,
		.bloom-instagram,
		.bloom-instagram .site-inner,
		.single .pagination,
		.between-posts-area,
		.sidebar .widget.featured-content,
		.sidebar .widget.highlight,
		.nav-primary {
			background-color: %1$s;
		}

		', $color_light_accent
	) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

	// Dark Accent Color.
	$css .= ( bloom_customizer_get_default_dark_accent_color() !== $color_link ) ? sprintf(
		'
		.footer-widgets,
		.footer-widgets .simple-social-icons ul li a,
		.footer-widgets .simple-social-icons ul li a:hover,
		.site-footer {
			background-color: %1$s !important;
		}

		', $color_dark_accent
	) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

	// Border Color.
	$css .= ( bloom_customizer_get_default_border_color() !== $color_border ) ? sprintf(
		'
		hr,
		.clear-line,
		input,
		select,
		textarea,
		body.woocommerce-cart table.cart td.actions .coupon .input-text,
		.gallery img,
		tbody,
		td,
		.genesis-nav-menu .search input[type="submit"]:focus,
		.screen-reader-shortcut:focus,
		.screen-reader-text:focus,
		.widget_search input[type="submit"]:focus,
		.content-sidebar .content,
		.sidebar-primary,
		.home-page-3 .shop-the-post,
		.bloom-index .featured-content,
		.bloom-instagram .content,
		.bloom-instagram .widgettitle,
		body.woocommerce div.product div.images .flex-control-thumbs li img.flex-active,
		.nav-primary .genesis-nav-menu li .sub-menu,
		.archive-description,
		.entry-content blockquote,
		.single .entry-content p.intro:after,
		.page .entry-content p.intro:after,
		.comment-respond,
		body.woocommerce #review_form #respond,
		body .woocommerce form.checkout_coupon,
		body .woocommerce form.login,
		body .woocommerce form.register,
		body .woocommerce-MyAccount-content form,
		.entry-comments ul.children,
		.sidebar .widget,
		.sidebar .widgettitle,
		.sidebar .widget-title  {
			border-color: %1$s;
		}

		body:not(.bloom-instagram):not(.bloom-index) .content article .entry-title a:after,
		.home-page-3 .featured-content article.has-post-thumbnail .entry-title a:after {
			background: %1$s;
		}

		', $color_border
	) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
