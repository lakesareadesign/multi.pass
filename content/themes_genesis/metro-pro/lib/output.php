<?php
/**
 * Metro Pro.
 *
 * This file adds the required CSS to the front end to the Metro Pro Theme.
 *
 * @package Metro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/metro/
 */

add_action( 'wp_enqueue_scripts', 'metro_css' );
/**
 * Checks the settings for the link color and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 2.2.0
 */
function metro_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_link   = get_theme_mod( 'metro_link_color', metro_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'metro_accent_color', metro_customizer_get_default_accent_color() );

	$css = '';

	$css .= ( metro_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		a,
		.entry-content a,
		.entry-title a:focus,
		.entry-title a:hover,
		.genesis-nav-menu > .right > a:focus,
		.genesis-nav-menu > .right > a:hover {
			color: %1$s;
		}
		', $color_link ) : '';

	$css .= ( metro_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		a.social-buttons:focus,
		a.social-buttons:hover,
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
		.content .entry-meta .entry-comments-link a,
		.entry-content .button:focus,
		.entry-content .button:hover,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.nav-primary .sub-menu a:focus,
		.nav-primary .sub-menu a:hover,
		.nav-secondary .sub-menu a:focus,
		.nav-secondary .sub-menu a:hover,
		.sidebar .enews-widget input[type="submit"],
		.site-title a,
		.site-title a:focus,
		.site-title a:hover {
			background-color: %1$s;
			color: %2$s;
		}

		', $color_accent, metro_color_contrast( $color_accent ), metro_change_brightness( $color_accent ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
