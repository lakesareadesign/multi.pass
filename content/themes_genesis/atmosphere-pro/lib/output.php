<?php
/**
 * Atmosphere Pro.
 *
 * This file adds the required CSS to the front end to the Atmosphere Pro Theme.
 *
 * @package Atmosphere
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/atmosphere/
 */

add_action( 'wp_enqueue_scripts', 'atmosphere_css' );
/**
 * Checks the settings for the link color color, accent color, and header.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function atmosphere_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_link   = get_theme_mod( 'atmosphere_link_color', atmosphere_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'atmosphere_accent_color', atmosphere_customizer_get_default_accent_color() );

	$css = '';

	$css .= ( atmosphere_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		a:focus,
		a:hover,
		.entry-title a:focus,
		.entry-title a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover {
			color: %1$s;
		}

		@media only screen and (max-width: 1024px) {

			.genesis-responsive-menu.nav-primary li.highlight > a:hover,
			.genesis-responsive-menu.nav-primary li.menu-item.highlight > a:focus {
				color: %1$s;
			}

		}
		', $color_link ) : '';

	$css .= ( atmosphere_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		button:focus,
		button:hover,
		input:focus[type="button"],
		input:hover[type="button"],
		input:focus[type="reset"],
		input:hover[type="reset"],
		input:focus[type="submit"],
		input:hover[type="submit"],
		.button:focus,
		.button:hover,
		.content .widget .textwidget a.button:focus,
		.content .widget .textwidget a.button:hover,
		.entry-content a.button:focus,
		.entry-content a.button:hover,
		.entry-content a.more-link:focus,
		.entry-content a.more-link:hover,
		.nav-primary li.highlight > a:focus,
		.nav-primary li.highlight > a:hover {
			border-color: %1$s;
		}

		.footer-widgets button,
		.footer-widgets input[type="button"],
		.footer-widgets input[type="reset"],
		.footer-widgets input[type="submit"],
		.footer-widgets .button,
		.footer-widgets .entry-content a.more-link,
		.no-image .content .front-page-1 .widget a.button,
		.no-image .front-page-1 button,
		.no-image .front-page-1 input[type="button"],
		.no-image .front-page-1 input[type="reset"],
		.no-image .front-page-1 input[type="submit"],
		.no-image .front-page-1 .entry-content a.button,
		.no-image .front-page-1 .entry-content a.more-link,
		.no-image .front-page-1 .entry-content a.more-link {
			border-color: %2$s;
		}

		button:focus,
		button:hover,
		input:focus[type="button"],
		input:hover[type="button"],
		input:focus[type="reset"],
		input:hover[type="reset"],
		input:focus[type="submit"],
		input:hover[type="submit"],
		.button:focus,
		.button:hover,
		.content .widget .textwidget a.button:focus,
		.content .widget .textwidget a.button:hover,
		.entry-content a.button:focus,
		.entry-content a.button:hover,
		.entry-content a.more-link:focus,
		.entry-content a.more-link:hover,
		.footer-widgets,
		.nav-primary li.highlight > a:focus,
		.nav-primary li.highlight > a:hover,
		.no-image .front-page-1 {
			background-color: %1$s;
			color: %2$s;
		}

		.footer-widgets button,
		.footer-widgets input[type="button"],
		.footer-widgets input[type="reset"],
		.footer-widgets input[type="submit"],
		.footer-widgets p,
		.footer-widgets .button,
		.footer-widgets .entry-content a.more-link,
		.footer-widgets .widget-title,
		.footer-widgets .wrap .entry-title a,
		.footer-widgets .wrap a,
		.no-image .content .front-page-1 .widget a.button,
		.no-image .front-page-1 button,
		.no-image .front-page-1 input[type="button"],
		.no-image .front-page-1 input[type="reset"],
		.no-image .front-page-1 input[type="submit"],
		.no-image .front-page-1 p,
		.no-image .front-page-1 .entry-content a.button,
		.no-image .front-page-1 .entry-content a.more-link,
		.no-image .front-page-1 .entry-content a.more-link,
		.no-image .front-page-1 .widget-title,
		.no-image .front-page-1 .wrap .entry-title a,
		.no-image .front-page-1 .wrap a {
			color: %2$s;
		}

		.footer-widgets button:focus,
		.footer-widgets button:hover,
		.footer-widgets input:focus[type="button"],
		.footer-widgets input:hover[type="button"],
		.footer-widgets input:focus[type="reset"],
		.footer-widgets input:hover[type="reset"],
		.footer-widgets input:focus[type="submit"],
		.footer-widgets input:hover[type="submit"],
		.footer-widgets .button:focus,
		.footer-widgets .button:hover,
		.footer-widgets .entry-content a.more-link:focus,
		.footer-widgets .entry-content a.more-link:hover,
		.no-image .content .front-page-1 .widget a.button:focus,
		.no-image .content .front-page-1 .widget a.button:hover,
		.no-image .front-page-1 button:focus,
		.no-image .front-page-1 button:hover,
		.no-image .front-page-1 input:focus[type="button"],
		.no-image .front-page-1 input:hover[type="button"],
		.no-image .front-page-1 input:focus[type="reset"],
		.no-image .front-page-1 input:hover[type="reset"],
		.no-image .front-page-1 input:focus[type="submit"],
		.no-image .front-page-1 input:hover[type="submit"],
		.no-image .front-page-1 .entry-content a.button:focus,
		.no-image .front-page-1 .entry-content a.button:hover,
		.no-image .front-page-1 .entry-content a.more-link:focus,
		.no-image .front-page-1 .entry-content a.more-link:hover {
			background-color: %2$s;
			color: %3$s;
		}
		', $color_accent, atmosphere_color_contrast( $color_accent ), atmosphere_change_brightness( $color_accent ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
