<?php
/**
 * Infinity Pro.
 *
 * This file adds the required CSS to the front end to the Infinity Pro Theme.
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */

add_action( 'wp_enqueue_scripts', 'infinity_css' );
/**
 * Checks the settings for the link color color, accent color, and header.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function infinity_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_accent = get_theme_mod( 'infinity_accent_color', infinity_customizer_get_default_accent_color() );

	$opts = apply_filters( 'infinity_images', array( '1', '3', '5', '7' ) );

	$settings = array();

	foreach( $opts as $opt ) {
		$settings[$opt]['image'] = preg_replace( '/^https?:/', '', get_option( $opt .'-infinity-image', sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $opt ) ) );
	}

	$css = '';

	foreach ( $settings as $section => $value ) {

		$background = $value['image'] ? sprintf( 'background-image: url(%s);', $value['image'] ) : '';

		if ( is_front_page() ) {
			$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.front-page-%s { %s }', $section, $background ) : '';
		}

	}

	$css .= ( infinity_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		a,
		.entry-title a:focus,
		.entry-title a:hover,
		.featured-content .entry-meta a:focus,
		.featured-content .entry-meta a:hover,
		.front-page .genesis-nav-menu a:focus,
		.front-page .genesis-nav-menu a:hover,
		.front-page .offscreen-content-icon button:focus,
		.front-page .offscreen-content-icon button:hover,
		.front-page .white .genesis-nav-menu a:focus,
		.front-page .white .genesis-nav-menu a:hover,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.genesis-responsive-menu .genesis-nav-menu a:focus,
		.genesis-responsive-menu .genesis-nav-menu a:hover,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.offscreen-content button:hover,
		.offscreen-content-icon button:hover,
		.site-footer a:focus,
		.site-footer a:hover,
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover {
			color: %1$s;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="select"],
		input[type="submit"],
		.button,
		.enews-widget input:hover[type="submit"],
		.front-page-1 a.button,
		.front-page-3 a.button,
		.front-page-5 a.button,
		.front-page-7 a.button,
		.footer-widgets .button:hover {
			background-color: %1$s;
			color: %2$s;
		}

		', $color_accent, infinity_color_contrast( $color_accent ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
