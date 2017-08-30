<?php
/**
 * Studio Pro.
 *
 * This file adds customizer output to the Studio Pro theme.
 *
 * @package      Studio Pro
 * @link         https://seothemes.com/studio-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Output customizer inline styles.
add_action( 'wp_enqueue_scripts', 'studio_customizer_output', 100 );

/**
 * Customizer inline styles.
 *
 * Checks the settings for the colors defined in the settings.
 * If any of these value are set the appropriate CSS is output.
 *
 * @var array $studio_colors Global theme colors.
 */
function studio_customizer_output() {

	// Set in includes/customize.php.
	global $studio_colors;

	/**
	 * Loop though each color in the global array of theme colors
	 * and create a new variable for each. This is just a shorthand
	 * way of creating multiple variables that we can reuse. The
	 * benefit of using a foreach loop over creating each variable
	 * manually is that we can just declare the colors once in the
	 * `$studio_colors` array, and they can be used in multiple ways.
	 */
	foreach ( $studio_colors as $id => $hex ) {
		${"$id"} = get_theme_mod( "studio_{$id}_color",  $hex );
	}

	// Ensure $css var is empty.
	$css = '';

	/**
	 * Build the CSS.
	 *
	 * We need to concatenate each one of our colors to the $css
	 * variable, but first check if the color has been changed by
	 * the user from the theme customizer. If the theme mod is not
	 * equal to the default color then the string is appended to $css.
	 */
	$css .= ( $studio_colors['gradient_left'] !== $gradient_left || $studio_colors['gradient_right'] !== $gradient_right ) ? "
		.overlay:after,
		button.gradient,
		input[type='button'].gradient,
		input[type='reset'].gradient,
		input[type='submit'].gradient,
		.button.gradient,
		.footer-widgets .enews-widget input[type='submit'],
		.front-page-3 .image:after,
		.front-page-5 .widget-title:after,
		.pricing-table .featured button,
		.pricing-table .featured .button {
			background: {$gradient_left};
			background: -moz-linear-gradient(left, {$gradient_left} 0%, {$gradient_right} 100%);
			background: -webkit-linear-gradient(left, {$gradient_left} 0%, {$gradient_right}  100%);
			background: linear-gradient(to right, {$gradient_left} 0%, {$gradient_right}  100%);
		}
		.front-page-2 i,
		.nav-primary a:hover,
		.nav-primary a:focus,
		.nav-primary .current-menu-item > a,
		.nav-primary .sub-menu .current-menu-item > a:hover,
		.nav-primary .sub-menu .current-menu-item > a:focus {
			background: {$gradient_left};
			background: -moz-linear-gradient(left, {$gradient_left} 0%, {$gradient_right} 100%);
			background: -webkit-linear-gradient(left, {$gradient_left} 0%, {$gradient_right}  100%);
			background: linear-gradient(to right, {$gradient_left} 0%, {$gradient_right}  100%);
			-webkit-background-clip: text;
			background-clip: text;
			-webkit-text-fill-color: transparent;
			text-fill-color: transparent;
		}
	" : '';

	$css .= ( $studio_colors['button'] !== $button ) ? sprintf( '
		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		button.secondary:hover,
		.button.secondary:hover,
		button.secondary:focus,
		.button.secondary:focus,
		.archive-pagination a:hover,
		.archive-pagination a:focus,
		.archive-pagination .active a,
		.woocommerce a.button:hover,
		.woocommerce a.button:focus,
		.woocommerce a.button,
		.woocommerce a.button.alt:hover,
		.woocommerce a.button.alt:focus,
		.woocommerce a.button.alt,
		.woocommerce button.button:hover,
		.woocommerce button.button:focus,
		.woocommerce button.button,
		.woocommerce button.button.alt:hover,
		.woocommerce button.button.alt:focus,
		.woocommerce button.button.alt,
		.woocommerce input.button:hover,
		.woocommerce input.button:focus,
		.woocommerce input.button,
		.woocommerce input.button.alt:hover,
		.woocommerce input.button.alt:focus,
		.woocommerce input.button.alt,
		.woocommerce input[type="submit"]:hover,
		.woocommerce input[type="submit"]:focus,
		.woocommerce input[type="submit"],
		.woocommerce span.onsale,
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce #respond input#submit.alt:focus,
		.woocommerce #respond input#submit.alt,
		.woocommerce input.button[type=submit]:focus,
		.woocommerce input.button[type=submit],
		.woocommerce input.button[type=submit]:hover,
		.woocommerce.widget_price_filter .ui-slidui-slider-handle,
		.woocommerce.widget_price_filter .ui-slidui-slider-range {
			background-color: %1$s;
		}
	', $button ) : '';

	// Style handle is the name of the theme.
	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	// Output CSS if not empty.
	if ( ! empty( $css ) ) {

		// Add the inline styles, also minify CSS first.
		wp_add_inline_style( $handle, studio_minify_css( $css ) );
	}

}
