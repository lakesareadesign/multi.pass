<?php
/**
 * Breakthrough Pro.
 *
 * This file adds the required CSS to the front end to the Breakthrough Pro Theme.
 *
 * @package Breakthrough_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/breakthrough/
 */

add_action( 'wp_enqueue_scripts', 'breakthrough_css', 99 );
/**
 * Checks the settings for the link color and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function breakthrough_css() {

	$handle          = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';
	$color_primary   = get_theme_mod( 'breakthrough_primary_color', breakthrough_customizer_get_primary_color() );
	$color_secondary = get_theme_mod( 'breakthrough_secondary_color', breakthrough_customizer_get_secondary_color() );

	$intro_paragraph = get_theme_mod( 'breakthrough_use_paragraph_styling', 1 );

	$css       = '';
	$front_css = '';

	$css .= ( $intro_paragraph ) ? sprintf(
		'

		.single .content .entry-content > p:first-of-type {
			font-size: 26px;
			font-size: 2.6rem;
			letter-spacing: -0.7px;
		}

		'
	) : '';

	$css .= ( breakthrough_customizer_get_primary_color() !== $color_primary ) ? sprintf(
		'

		cite,
		h4,
		h5,
		p.entry-meta a,
		.entry-title a:focus,
		.entry-title a:hover,
		.footer-widgets .widget .widget-title,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.genesis-responsive-menu .genesis-nav-menu a:focus,
		.genesis-responsive-menu .genesis-nav-menu a:hover,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.nav-primary .genesis-nav-menu .sub-menu a:focus,
		.nav-primary .genesis-nav-menu .sub-menu a:hover,
		.nav-primary .genesis-nav-menu .sub-menu .current-menu-item > a,
		.nav-primary .genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.nav-primary .genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.portfolio .entry-header .entry-meta a,
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover,
		.widget-title {
			color: %1$s;
		}

		.sidebar .enews-widget,
		.sidebar .enews-widget .widget-title {
			color: %3$s;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.archive-pagination a:focus,
		.archive-pagination a:hover,
		.archive-pagination .active a,
		.button,
		.message.primary,
		.sidebar .widget.enews-widget {
			background-color: %1$s;
			color: %3$s;
		}

		.message.primary a {
			color: %3$s;
		}

		a.button:focus,
		a.button:hover,
		button:focus,
		button:hover,
		input:focus[type="button"],
		input:hover[type="button"],
		input:focus[type="reset"],
		input:hover[type="reset"],
		input:focus[type="submit"],
		input:hover[type="submit"],
		.button:focus,
		.button:hover {
			background-color: %2$s;
			box-shadow: 0 2px 10px 0 %4$s;
			color: %3$s;
		}

		input:focus,
		textarea:focus {
			border-color: %1$s;
			box-shadow: 0 3px 7px 0 %4$s;
			outline: none;
		}

		body,
		.pricing-table .featured {
			border-color: %1$s;
		}

		.nav-primary .genesis-nav-menu a:focus,
		.nav-primary .genesis-nav-menu a:hover,
		.nav-primary .genesis-nav-menu .current-menu-item > a {
			border-bottom-color: %1$s;
			color: %1$s;
		}

		input[type="button"].text,
		input[type="reset"].text,
		input[type="submit"].text {
			border-color: %1$s;
			color: %1$s;
		}

		',
		$color_primary,
		breakthrough_color_brightness( $color_primary, 20 ),
		breakthrough_color_contrast( $color_primary ),
		breakthrough_color_rgba( $color_primary, .30 )
	) : '';

	$css .= ( breakthrough_customizer_get_secondary_color() !== $color_secondary ) ? sprintf(
		'

		a {
			color: %1$s;
		}

		a:focus,
		a:hover {
			color: %2$s;
		}

		a.more-link,
		.view-all-portfolio a {
			border-color: %1$s;
			color: %1$s;
		}

		a.more-link:focus,
		a.more-link:hover,
		.view-all-portfolio a:focus,
		.view-all-portfolio a:hover  {
			border-color: %2$s;
			color: %2$s;
		}

		.button-hero,
		button.button-hero,
		button.primary,
		input[type="button"].button-hero,
		input[type="button"].primary,
		input[type="reset"].button-hero,
		input[type="reset"].primary,
		input[type="submit"].button-hero,
		input[type="submit"].primary,
		.button.button-hero,
		.button.primary,
		.enews-widget input[type="submit"],
		.message.secondary,
		.sidebar .enews-widget input[type="submit"] {
			background-color: %1$s;
			color: %3$s;
		}

		.button.button-hero:focus,
		.button.button-hero:hover,
		button.button-hero:focus,
		button.button-hero:hover,
		button.primary:focus,
		button.primary:hover,
		input[type="button"].button-hero:focus,
		input[type="button"].button-hero:hover,
		input[type="button"].primary:focus,
		input[type="button"].primary:hover,
		input[type="reset"].button-hero:focus,
		input[type="reset"].button-hero:hover,
		input[type="reset"].primary:focus,
		input[type="reset"].primary:hover,
		input[type="submit"].button-hero:focus,
		input[type="submit"].button-hero:hover,
		input[type="submit"].primary:focus,
		input[type="submit"].primary:hover,
		.button.primary:focus,
		.button.primary:hover,
		.enews-widget input[type="submit"]:focus,
		.enews-widget input[type="submit"]:hover {
			background-color: %2$s;
			box-shadow: 0 2px 10px 0 %4$s;
			color: %3$s;
		}

		a.button.text {
			background-color: #fff;
			border-bottom: 2px solid %1$s;
			color: %1$s;
		}

		a.button.text:focus,
		a.button.text:hover {
			background-color: #fff;
			border-bottom-color: %2$s;
			color: %2$s;
		}

		.message.secondary a {
			color: %3$s;
		}

		',
		$color_secondary,
		breakthrough_color_brightness( $color_secondary, 20 ),
		breakthrough_color_contrast( $color_secondary ),
		breakthrough_color_rgba( $color_secondary, .30 )
	) : '';

	$css .= ( breakthrough_customizer_get_secondary_color() !== $color_secondary && breakthrough_color_contrast( $color_secondary ) === '#000000' ) ? sprintf(
		'

		button.button-hero::after,
		input[type="button"].button-hero::after,
		input[type="reset"].button-hero::after,
		input[type="submit"].button-hero::after,
		.button-hero::after {
			background: url(%1$s/images/hero-arrow-black.svg) no-repeat center right;
		}',
		CHILD_URL
	) : '';

	$add_image_overlay = get_theme_mod( 'breakthrough_color_overlay_setting', breakthrough_customizer_get_default_color_overlay_setting() );

	if ( ! $add_image_overlay ) {
		$css .=
		'
		.full-width-image img,
		.breakthrough-featured-image img,
		.portfolio-featured-image img {
			filter: none;
		}';
	}

	$front_css .= ( breakthrough_customizer_get_primary_color() !== $color_primary ) ? sprintf(
		'
			.flexible-widgets.widget-full blockquote::before {
				color: %1$s;
			}
		', $color_primary
	) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

	if ( $front_css ) {
		wp_add_inline_style( 'breakthrough-front-styles', $front_css );
	}

}
