<?php
/**
 * Wellness Pro.
 *
 * This file adds the required CSS to the front end to the Wellness Pro Theme.
 *
 * @package Wellness
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/wellness/
 */

add_action( 'wp_enqueue_scripts', 'wellness_css' );
/**
 * Checks the settings for the link color, and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function wellness_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_link = get_theme_mod( 'wellness_link_color', wellness_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'wellness_accent_color', wellness_customizer_get_default_accent_color() );
	$opts = apply_filters( 'wellness_images', array( '1', '3', '5' ) );

	$settings = array();

	foreach( $opts as $opt ){
		$settings[$opt]['image'] = preg_replace( '/^https?:/', '', get_option( $opt .'-wellness-image', sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $opt ) ) );
	}

	$css = '';

	foreach ( $settings as $section => $value ) {

		$background = $value['image'] ? sprintf( 'background-image: url(%s);', $value['image'] ) : '';

		if( is_front_page() ) {
			$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.front-page-%s { %s }', $section, $background ) : '';
		}

	}

	$css .= ( wellness_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		a,
		.accent-color,
		.book-author .book-author-link:focus,
		.book-author .book-author-link:hover,
		.entry-header .entry-meta .entry-author-link:focus,
		.entry-header .entry-meta .entry-author-link:hover,
		.entry-title a:focus,
		.entry-title a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.genesis-responsive-menu .genesis-nav-menu .menu-item a:focus,
		.genesis-responsive-menu .genesis-nav-menu .menu-item a:hover,
		.menu-toggle:hover,
		.menu-toggle:focus,
		.sub-menu-toggle:hover,
		.sub-menu-toggle:focus {
			color: %1$s;
		}

		.archive-pagination .active a,
		.archive-pagination a:focus,
		.archive-pagination a:hover,
		.sidebar .enews-widget input[type="submit"] {
			background-color: %1$s;
			color: %2$s;
		}

		', $color_link, wellness_color_contrast( $color_link ) ) : '';

	$css .= ( wellness_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		.footer-widgets a:focus,
		.footer-widgets a:hover,
		.genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.genesis-nav-menu .sub-menu a:focus,
		.genesis-nav-menu .sub-menu a:hover,
		.site-footer a:focus,
		.site-footer a:hover {
			color: %1$s;
		}

		button:focus,
		button:hover,
		input:focus[type="button"],
		input:focus[type="reset"],
		input:focus[type="submit"],
		input:hover[type="button"],
		input:hover[type="reset"],
		input:hover[type="submit"],
		.button:focus,
		.button:hover,
		.entry-content .button:focus,
		.entry-content .button:hover,
		.featured-content .book-featured-text-banner {
			background-color: %1$s;
			color: %2$s;
		}

		.button:focus:after,
		.button:focus:before,
		.button:hover:after,
		.button:hover:before,
		.genesis-nav-menu > .highlight a {
			border-bottom-color: %1$s;
			border-top-color: %1$s;
		}

		', $color_accent, wellness_color_contrast( $color_accent ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
