<?php
/**
 * News Pro.
 *
 * This file adds the required CSS to the front end to the News Pro Theme.
 *
 * @package News
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/news/
 */

add_action( 'wp_enqueue_scripts', 'news_css' );
/**
 * Checks the settings for the link color and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 3.2.0
 */
function news_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_link   = get_theme_mod( 'news_link_color', news_customizer_get_default_link_color() );
	$color_footer_link   = get_theme_mod( 'news_footer_link_color', news_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'news_accent_color', news_customizer_get_default_accent_color() );

	$css = '';

	$css .= ( news_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		a,
		.entry-title a:focus,
		.entry-title a:hover {
			color: %1$s;
		}

		@media only screen and ( max-width: 1023px ) {
			.genesis-responsive-menu .genesis-nav-menu a:focus,
			.genesis-responsive-menu .genesis-nav-menu a:hover,
			.genesis-responsive-menu .genesis-nav-menu .menu-item.current-menu-item > a,
			.menu-toggle:focus,
			.menu-toggle:hover,
			.sub-menu-toggle:focus,
			.sub-menu-toggle:hover {
				color: %1$s;
			}
		}

		', $color_link ) : '';

	$css .= ( news_customizer_get_default_link_color() !== $color_footer_link ) ? sprintf( '

		.footer-widgets a:focus,
		.footer-widgets a:hover,
		.site-footer a:focus,
		.site-footer a:hover {
			color: %1$s;
		}

		', $color_footer_link ) : '';

	$css .= ( news_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

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
		.enews-widget input[type="submit"],
		.entry-content .button:focus,
		.entry-content .button:hover,
		.home-top .ui-tabs ul.ui-tabs-nav li.ui-tabs-active a {
			background-color: %1$s;
			color: %2$s;
		}
		', $color_accent, news_color_contrast( $color_accent ), news_change_brightness( $color_accent ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
