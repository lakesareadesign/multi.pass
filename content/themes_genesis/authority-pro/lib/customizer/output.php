<?php
/**
 * Authority Pro.
 *
 * This file adds the required CSS to the front end to the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

add_action( 'wp_enqueue_scripts', 'authority_css', 99 );
/**
 * Checks the settings for the link color and accent color.
 * If any of these values are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function authority_css() {

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_primary   = get_theme_mod( 'authority_primary_color', authority_customizer_get_default_primary_color() );
	$intro_paragraph = get_theme_mod( 'authority-use-paragraph-styling', 1 );

	$css       = '';
	$front_css = '';

	$front_css .= ( authority_customizer_get_default_primary_color() !== $color_primary ) ? sprintf(
		'
		.site-inner .widget_media_image::after,
		.site-inner .hero-section-column.right::after {
			background: %1$s;
		}

		.site-inner .hero-portrait-caption a:focus,
		.site-inner .hero-portrait-caption a:hover {
			color: %1$s;
		}
		', $color_primary
	) : '';

	$css .= ( 0 !== $intro_paragraph ) ? sprintf(
		'
		.single .content .entry-content > p:first-of-type {
			color: #111111;
			font-size: 20px;
			font-size: 2rem;
			font-style: italic;
			line-height: 1.7;
			margin: 0 0 35px;
		}
		'
	) : '';

	$css .= ( authority_customizer_get_default_primary_color() !== $color_primary ) ? sprintf(
		'
		a,
		h4,
		h5,
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.authority-subtitle,
		.button,
		.genesis-nav-menu .highlight a,
		.more-link,
		.entry-title a:focus,
		.entry-title a:hover,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.genesis-responsive-menu .genesis-nav-menu a:focus,
		.genesis-responsive-menu .genesis-nav-menu a:hover,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover {
			color: %1$s;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		.genesis-nav-menu .highlight a,
		.more-link {
			border-color: %1$s;
		}

		.enews-widget::after,
		.sidebar .enews-widget:nth-child(2n+1)::after {
			background: %1$s;
		}

		button.primary,
		input[type="button"].primary,
		input[type="reset"].primary,
		input[type="submit"].primary,
		.authority-top-banner,
		.button.primary,
		.more-link,
		.sidebar .enews-widget input[type="submit"],
		.enews-widget input[type="submit"] {
			background-color: %1$s;
			color: %3$s;
		}

		.authority-top-banner a,
		.authority-top-banner a:focus,
		.authority-top-banner a:hover,
		#authority-top-banner-close,
		#authority-top-banner-close:focus,
		#authority-top-banner-close:hover {
			color: %3$s;
		}

		.archive-pagination .pagination-next > a,
		.archive-pagination .pagination-previous > a,
		.menu-toggle,
		.sub-menu-toggle {
			border-color: %1$s;
			color: %1$s;
		}

		a.button:focus,
		a.button:hover,
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
		.archive-pagination .active a,
		.archive-pagination .pagination-next > a:focus,
		.archive-pagination .pagination-next > a:hover,
		.archive-pagination .pagination-previous > a:focus,
		.archive-pagination .pagination-previous > a:hover,
		.button:focus,
		.button:hover,
		.enews-widget input[type="submit"]:focus,
		.enews-widget input[type="submit"]:hover,
		.genesis-nav-menu .highlight a:focus,
		.genesis-nav-menu .highlight a:hover,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.more-link:focus,
		.more-link:hover,
		.sidebar .enews-widget input[type="submit"]:focus,
		.sidebar .enews-widget input[type="submit"]:hover,
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover {
			background-color: %2$s;
			border-color: %2$s;
			color: %3$s;
		}
		', $color_primary, authority_color_brightness( $color_primary, '+', 20 ), authority_color_contrast( $color_primary )
	) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

	if ( $front_css ) {
		wp_add_inline_style( $handle, $front_css );
	}

}
