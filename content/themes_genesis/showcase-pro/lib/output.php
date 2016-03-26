<?php
/*
 * Adds the required CSS to the front end.
 */

add_action( 'wp_enqueue_scripts', 'showcase_css' );
/**
* Checks the settings for the link color color, accent color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function showcase_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_primary = get_theme_mod( 'showcase_primary_color', showcase_customizer_get_default_primary_color() );
	$color_accent = get_theme_mod( 'showcase_accent_color', showcase_customizer_get_default_accent_color() );
	$color_page_header = get_theme_mod( 'showcase_page_header_color', showcase_customizer_get_default_page_header_color() );

	$css = '';

	$css .= ( showcase_customizer_get_default_primary_color() !== $color_primary ) ? sprintf( '
		.bg-primary:after,
		.site-header,
		.button.secondary,
		.pagination li a:hover,
		.pagination li.active a {
			background-color: %1$s;
		}

		a,
		.icon,
		.pricing-table .plan h3,
		.button.minimal,
		.button.white {
			color: %1$s;
		}
		', $color_primary ) : '';


	$css .= ( showcase_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		.bg-secondary:after  {
			background-color: %1$s;
		}
		', $color_accent ) : '';

	$css .= ( showcase_customizer_get_default_page_header_color() !== $color_page_header ) ? sprintf( '

		.header-wrap.bg-primary:after,
		.site-header {
			background-color: %1$s;
		}
		', $color_page_header ) : '';

	if( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
