<?php
/**
 * Magazine Pro.
 *
 * This file adds the required custom CSS to the Magazine Pro Theme.
 *
 * @package Magazine
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    http://my.studiopress.com/themes/magazine/
 */

add_action( 'wp_enqueue_scripts', 'magazine_custom_css' );
/**
 * Check to see if there is a new value for the accent color, and if
 * so, print that value to the theme's main stylesheet.
 *
 * @since 3.2.0
 */
function magazine_custom_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_accent = get_theme_mod( 'magazine_accent_color', magazine_get_default_accent_color() );
	$color_link   = get_theme_mod( 'magazine_link_color', magazine_get_default_link_color() );

	$css = '';

	$css .= ( $color_accent !== magazine_get_default_accent_color() ) ? sprintf( '

		button:focus,
		button:hover,
		input[type="button"]:focus,
		input[type="button"]:hover,
		input[type="reset"]:focus,
		input[type="reset"]:hover,
		input[type="submit"]:focus,
		input[type="submit"]:hover,
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.archive-pagination li.active a,
		.button:focus,
		.button:hover,
		.entry-content .button:focus,
		.entry-content .button:hover,
		.home-middle a.more-link:focus,
		.home-middle a.more-link:hover,
		.home-top a.more-link:focus,
		.home-top a.more-link:hover,
		.js .content .home-middle a .entry-time,
		.js .content .home-top a .entry-time,
		.sidebar .tagcloud a:focus,
		.sidebar .tagcloud a:hover,
		.widget-area .enews-widget input[type="submit"] {
			background-color: %1$s;
			color: %2$s;
		}

		', $color_accent, magazine_color_contrast( $color_accent ) ) : '';

	$css .= ( magazine_get_default_link_color() !== $color_link ) ? sprintf( '

		a:focus,
		a:hover,
		.entry-content a,
		.entry-title a:focus,
		.entry-title a:hover,
		.nav-secondary .genesis-nav-menu a:focus,
		.nav-secondary .genesis-nav-menu a:hover,
		.nav-secondary .genesis-nav-menu .current-menu-item > a,
		.nav-secondary .genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.nav-secondary .genesis-nav-menu .sub-menu .current-menu-item > a:hover {
			color: %1$s;
		}
		', $color_link ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
