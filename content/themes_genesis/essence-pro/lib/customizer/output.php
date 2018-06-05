<?php
/**
 * Essence Pro.
 *
 * This file adds the required CSS to the front end to the Essence Pro Theme.
 *
 * @package Essence_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/essence/
 */

add_action( 'wp_enqueue_scripts', 'essence_css', 99 );
/**
 * Checks the settings for the link color and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function essence_css() {

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_link = get_theme_mod( 'essence_link_color', essence_customizer_get_default_link_color() );

	$intro_paragraph = get_theme_mod( 'essence-use-paragraph-styling', 1 );

	$css = '';

	$css .= ( $intro_paragraph ) ? sprintf(
		'

		.single .content .entry-content > p:first-of-type {
			font-size: 26px;
			font-size: 2.6rem;
			letter-spacing: -0.7px;
		}

		'
	) : '';

	$css .= ( essence_customizer_get_default_link_color() !== $color_link ) ? sprintf(
		'

		a,
		h6,
		.entry-title a:focus,
		.entry-title a:hover,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.off-screen-menu .genesis-nav-menu a:focus,
		.off-screen-menu .genesis-nav-menu a:hover,
		.off-screen-menu .current-menu-item > a,
		.sidebar .featured-content .entry-title a,
		.site-footer .current-menu-item > a,
		.site-footer .genesis-nav-menu a:focus,
		.site-footer .genesis-nav-menu a:hover,		
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover {
			color: %1$s;
		}

		a.button.text,
		a.more-link.button.text,
		button.text,
		input[type="button"].text,
		input[type="reset"].text,
		input[type="submit"].text,
		.more-link,
		.pagination a:focus,
		.pagination a:hover,
		.pagination .active a {
			border-color: %1$s;
			color: %1$s;
		}

		button,
		button.primary,
		input[type="button"],
		input[type="button"].primary,
		input[type="reset"],
		input[type="reset"].primary,
		input[type="submit"],
		input[type="submit"].primary,
		.footer-cta::before,
		.button,
		.button.primary,
		.error404 .site-inner::before,
		.sidebar .enews-widget input[type="submit"],
		.page .site-inner::before,
		.single .site-inner::before	{
			background-color: %1$s;
		}

		@media only screen and (max-width: 1023px) {
			.genesis-responsive-menu .genesis-nav-menu a:focus,
			.genesis-responsive-menu .genesis-nav-menu a:hover {
				color: %1$s;
			}
		}

		', $color_link
	) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
