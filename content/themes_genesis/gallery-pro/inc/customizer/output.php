<?php
/*
 * Adds the required CSS to the front end.
 */

add_action( 'wp_enqueue_scripts', 'bbs_customizer_css' );
function bbs_customizer_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_accent = get_theme_mod( 'bbs_accent_color', bbs_get_default_color_accent() );

	$css = '';

	$css .= ( bbs_get_default_color_accent() !== $color_accent ) ? sprintf( '
		.entry-content a:not(.button),
		a:hover,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.entry-title a:hover,
		.button.white,
		.woocommerce-MyAccount-navigation li a:hover,
		.woocommerce-MyAccount-navigation li.is-active a {
		  color: %1$s;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		a.button,
		.button.outline:hover,
		.button.white:hover,
		.pagination a:hover,
		.button.light:hover,
		body.woocommerce-page nav.woocommerce-pagination ul li a,
		body.woocommerce-page nav.woocommerce-pagination ul li span,
		body.woocommerce-page #respond input#submit,
		body.woocommerce-page a.button,
		body.woocommerce-page button.button,
		body.woocommerce-page button.button.alt,
		body.woocommerce-page a.button.alt,
		body.woocommerce-page input.button,
		body.woocommerce-page input.button.alt,
		body.woocommerce-page input.button:disabled,
		body.woocommerce-page input.button:disabled[disabled],
		body.woocommerce-page nav.woocommerce-pagination ul li a:hover,
		body.woocommerce-page #respond input#submit:hover,
		body.woocommerce-page a.button:hover,
		body.woocommerce-page button.button:hover,
		body.woocommerce-page button.button.alt:hover,
		body.woocommerce-page a.button.alt:hover,
		body.woocommerce-page input.button:hover,
		body.woocommerce-page input.button.alt:hover,
		body.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover {
		  background-color: %1$s;
		}

		::-moz-selection { background-color: %1$s; }
		::selection { background-color: %1$s; }

		.button.outline,
		.button.outline:hover,
		body.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
		body.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.pagination li.active a,
		body.woocommerce-page nav.woocommerce-pagination ul li span.current {
		  box-shadow: inset 0 -1px 0 0 %1$s;
		}

		input:focus,
		select:focus,
		textarea:focus {
		  border-color: %1$s;
		}
		', $color_accent ) : '';

	if( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
