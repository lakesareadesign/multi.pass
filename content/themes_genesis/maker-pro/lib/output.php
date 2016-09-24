<?php
/*
 * Adds the required CSS to the front end.
 */

add_action( 'wp_enqueue_scripts', 'maker_css' );
/**
* Checks the settings for the primary color
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function maker_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_primary = get_theme_mod( 'maker_primary_color', maker_customizer_get_default_primary_color() );

	$css = '';

	$css .= ( maker_customizer_get_default_primary_color() !== $color_primary ) ? sprintf( '
		.button,
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.pagination li a:hover,
		.pagination li.active a {
			background-color: %1$s;
		}

		::-moz-selection {
			background-color: %1$s;
		}

		::selection {
			background-color: %1$s;
		}

		a,
		.icon,
		.button.minimal,
		.button.white,
		.pricing-table .plan h3,
		.button.minimal,
		.button.white,
		.genesis-nav-menu li a:hover,
		.genesis-nav-menu .menu-item a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.front-page .front-page-6 .widgettitle {
			color: %1$s;
		}

		input:focus,
		textarea:focus {
			border-color: %1$s;
		}

		', $color_primary ) : '';

	if( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
