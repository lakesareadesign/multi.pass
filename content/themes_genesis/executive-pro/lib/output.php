<?php
/**
 * Executive Pro.
 *
 * This file adds the required CSS to the front end to the Executive Pro Theme.
 *
 * @package Executive
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/executive/
 */

add_action( 'wp_enqueue_scripts', 'executive_css' );
/**
 * Checks the settings for the link color and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 3.2.0
 */
function executive_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$background_color = get_background_color();
	$color_link   = get_theme_mod( 'executive_link_color', executive_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'executive_accent_color', executive_customizer_get_default_accent_color() );
	$color_hover  = get_theme_mod( 'executive_hover_color', executive_customizer_get_default_hover_color() );

	$css = '';

	$css .= ( executive_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		a,
		.entry-title a:focus,
		.entry-title a:hover,
		.footer-widgets .entry-title a:focus,
		.footer-widgets .entry-title a:hover,
		.menu-toggle,
		.nav-secondary .genesis-nav-menu .current-menu-item > a,
		.sub-menu-toggle {
			color: %1$s;
		}

		@media only screen and ( max-width: 767px ) {
			.genesis-responsive-menu .genesis-nav-menu a:focus,
			.genesis-responsive-menu .genesis-nav-menu a:hover {
				color: %1$s;
			}
		}

		', $color_link ) : '';

	$css .= ( executive_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.after-entry .enews-widget input[type="submit"],
		.archive-pagination li a,
		.button,
		.content .entry-header .entry-meta .entry-comments-link,
		.entry-content .button,
		.genesis-nav-menu .current-menu-item > a,
		.sidebar .enews-widget input[type="submit"] {
			background-color: %1$s;
			color: %2$s;
		}

		.footer-widgets a,
		.footer-widgets .entry-title a:focus,
		.footer-widgets .entry-title a:hover {
			color: %1$s;
		}

		.content .entry-header .entry-meta .entry-comments-link a,
		.content .entry-header .entry-meta .entry-comments-link a::before {
			color: %2$s;
		}

		', $color_accent, executive_color_contrast( $color_accent ) ) : '';

	$css .= ( executive_customizer_get_default_hover_color() !== $color_hover ) ? sprintf( '

		button:focus,
		button:hover,
		input:focus[type="button"],
		input:focus[type="reset"],
		input:focus[type="submit"],
		input:hover[type="button"],
		input:hover[type="reset"],
		input:hover[type="submit"],
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.archive-pagination li.active a,
		.button:focus,
		.button:hover,
		.entry-content .button:focus,
		.entry-content .button:hover,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover {
			background-color: %1$s;
			color: %2$s;
		}

		', $color_hover, executive_color_contrast( $color_hover ) ) : '';

	$css .= ( $background_color !== '' ) ? sprintf( '
		.genesis-nav-menu a,
		.nav-secondary .genesis-nav-menu li.current-menu-item a:focus,
		.nav-secondary .genesis-nav-menu li.current-menu-item a:hover,
		.site-footer p,
		.site-footer a,
		.site-title a,
		.site-title a:focus,
		.site-title a:hover {
			color: %1$s;
		}

		.nav-secondary .genesis-nav-menu a:focus,
		.nav-secondary .genesis-nav-menu a:hover,
		.nav-secondary .genesis-nav-menu li.current-menu-item > a,
		.nav-secondary .genesis-nav-menu li:focus,
		.nav-secondary .genesis-nav-menu li:hover {
			color: %2$s;
		}

		', executive_color_contrast( $background_color ), executive_change_brightness( $background_color ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
