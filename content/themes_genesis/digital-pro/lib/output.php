<?php
/**
 * Digital Pro.
 *
 * This file adds the required CSS to the front end to the Digital Pro Theme.
 *
 * @package Digital
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/digital/
 */

add_action( 'wp_enqueue_scripts', 'digital_css' );
/**
* Checks the settings for the link color color, accent color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function digital_css() {

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_accent = get_theme_mod( 'digital_accent_color', digital_customizer_get_default_accent_color() );

	$css = '';

	$css .= ( digital_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.archive-pagination .active a,
		.button,
		.entry-content a.button,
		.footer-widgets-1,
		.textwidget a.button {
			background-color: %1$s;
		}

		a:focus,
		a:hover,
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.archive-pagination .active a,
		.home.front-page .widget a:focus,
		.home.front-page .widget a:hover,
		.pagination a:focus,
		.pagination a:hover {
				border-color: %1$s;
		}

		a:focus,
		a:hover,
		button:hover,
		button:focus,
		.content .entry-title a:hover,
		.content .entry-title a:focus,
		.footer-widgets a:focus,
		.footer-widgets a:hover,
		.front-page .front-page-3 a:focus,
		.front-page .front-page-3 a:hover,
		.front-page .front-page-2 ul.checkmark li:before,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.js nav button:focus,
		.js .menu-toggle:focus,
		.site-footer a:focus,
		.site-footer a:hover {
			color: %1$s;
		}
		', $color_accent ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
