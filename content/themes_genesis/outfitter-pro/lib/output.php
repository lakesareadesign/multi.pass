<?php
/**
 * Outfitter Pro.
 *
 * This file adds the required CSS to the front end to the Outfitter Pro Theme.
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

add_action( 'wp_enqueue_scripts', 'outfitter_css', 99 );
/**
 * Checks the settings for the link color and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function outfitter_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_link   = get_theme_mod( 'outfitter_link_color', outfitter_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'outfitter_accent_color', outfitter_customizer_get_default_accent_color() );

	$css = '';

	$css .= ( outfitter_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		a,
		button.close:focus,
		button.close:hover,
		.entry-title a:focus,
		.entry-title a:hover,
		.menu-item-has-toggle a:focus .ionicons:before,
		.menu-item-has-toggle a:hover .ionicons:before,
		.menu-toggle:focus,
		.menu-toggle:hover,
		.sub-menu-toggle:focus,
		.sub-menu-toggle:hover {
			color: %1$s;
		}

		p.entry-meta a:before,
		.off-screen-content .genesis-nav-menu a:before,
		.breadcrumb a:before,
		.genesis-nav-menu > .menu-item > a:before,
		.footer-widgets a:before,
		.site-footer a:before {
			background-color: %1$s;
			color: %2$s;
		}

		@media only screen and (max-width: 1023px) {
			.genesis-responsive-menu .genesis-nav-menu a:focus,
			.genesis-responsive-menu .genesis-nav-menu a:hover {
				color: %1$s;
			}
		}

		', $color_link, outfitter_color_contrast( $color_link ) ) : '';

	$css .= ( outfitter_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		button.primary,
		input[type="button"].primary,
		input[type="reset"].primary,
		input[type="submit"].primary,
		.button.primary,
		.sidebar .enews-widget input[type="submit"] {
			background-color: %1$s;
			color: %2$s;
		}

		', $color_accent, outfitter_color_contrast( $color_accent ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
