<?php
/**
 * Daily Dish Pro.
 *
 * This file adds the required CSS to the front end to the Daily Dish Pro Theme.
 *
 * @package Daily Dish Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/daily-dish/
 */

add_action( 'wp_enqueue_scripts', 'daily_dish_css' );
/**
 * Checks the settings for the link color, and accent color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.1.0
 */
function daily_dish_css() {

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_link   = get_theme_mod( 'daily_dish_link_color', daily_dish_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'daily_dish_accent_color', daily_dish_customizer_get_default_accent_color() );

	$css = '';

	$css .= ( daily_dish_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		a,
		p.entry-meta a:focus,
		p.entry-meta a:hover,
		.breadcrumb a:focus,
		.breadcrumb a:hover,
		.entry-title a:focus,
		.entry-title a:hover,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.nav-primary .genesis-nav-menu .sub-menu a:focus,
		.nav-primary .genesis-nav-menu .sub-menu a:hover,
		.nav-secondary .genesis-nav-menu .sub-menu a:focus,
		.nav-secondary .genesis-nav-menu .sub-menu a:hover,
		.nav-secondary .genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.nav-secondary .genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.nav-secondary .genesis-nav-menu a:focus,
		.nav-secondary .genesis-nav-menu a:hover,
		.site-footer a:focus,
		.site-footer a:hover {
			color: %1$s;
		}

		@media only screen and ( max-width: 768px ) {
			.genesis-responsive-menu .genesis-nav-menu a:focus,
			.genesis-responsive-menu .genesis-nav-menu a:hover,
			.genesis-responsive-menu .genesis-nav-menu .sub-menu .menu-item a:focus,
			.genesis-responsive-menu .genesis-nav-menu .sub-menu .menu-item a:hover,
			.menu-toggle:focus,
			.menu-toggle:hover,
			.nav-primary .sub-menu-toggle:focus,
			.nav-primary .sub-menu-toggle:hover,
			.sub-menu-toggle:focus,
			.sub-menu-toggle:hover,
			#genesis-mobile-nav-primary:focus,
			#genesis-mobile-nav-primary:hover {
				color: %1$s;
			}
		}

		', $color_link ) : '';

	$css .= ( daily_dish_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		button:focus,
		button:hover,
		button.secondary,
		input[type="button"].secondary,
		input[type="button"]:focus,
		input[type="button"]:hover,
		input[type="reset"]:focus,
		input[type="reset"]:hover,
		input[type="reset"].secondary,
		input[type="submit"]:focus,
		input[type="submit"]:hover,
		input[type="submit"].secondary,
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.archive-pagination .active a,
		.button:focus,
		.button:hover,
		.button.secondary,
		.entry-content .button:focus,
		.entry-content .button:hover,
		.enews-widget input[type="submit"]:focus,
		.enews-widget input[type="submit"]:hover {
			background-color: %1$s;
			color: %2$s;
		}

		.nav-primary .genesis-nav-menu .sub-menu a:focus,
		.nav-primary .genesis-nav-menu .sub-menu a:hover,
		.nav-primary .genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.nav-primary .genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.nav-secondary .genesis-nav-menu a:focus,
		.nav-secondary .genesis-nav-menu a:hover,
		.nav-secondary .genesis-nav-menu .current-menu-item > a,
		.nav-secondary .genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.nav-secondary .genesis-nav-menu .sub-menu .current-menu-item > a:hover {
			color: %1$s;
		}

		@media only screen and ( max-width: 768px ) {
			.nav-secondary.genesis-responsive-menu .genesis-nav-menu .sub-menu .menu-item a:focus,
			.nav-secondary.genesis-responsive-menu .genesis-nav-menu .sub-menu .menu-item a:hover,
			.nav-secondary .sub-menu-toggle:focus,
			.nav-secondary .sub-menu-toggle:hover,
			#genesis-mobile-nav-secondary:focus,
			#genesis-mobile-nav-secondary:hover {
				color: %1$s;
			}
		}
		', $color_accent, daily_dish_color_contrast( $color_accent ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
