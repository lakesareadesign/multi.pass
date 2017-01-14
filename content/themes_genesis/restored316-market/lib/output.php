<?php

/**
 * This file adds the required CSS for the Customizer to the Market Theme.
 *
 * @package      Market
 * @subpackage   Customizations
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 05/03/2016
 * @license      GPL-2.0+
 */

add_action( 'wp_enqueue_scripts', 'market_css' );
/**
* Checks the settings for the link color color, primary color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function market_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_text = get_theme_mod( 'market_text_color', market_customizer_get_default_text_color() );
	$color_links = get_theme_mod( 'market_links_color', market_customizer_get_default_links_color() );
	$color_widgettitles = get_theme_mod( 'market_widgettitles_color', market_customizer_get_default_widgettitles_color() );
	$color_homeslider = get_theme_mod( 'market_homeslider_color', market_customizer_get_default_homeslider_color() );
	$color_hometitles = get_theme_mod( 'market_hometitles_color', market_customizer_get_default_hometitles_color() );
	$color_button = get_theme_mod( 'market_button_color', market_customizer_get_default_button_color() );
	$color_buttonborder = get_theme_mod( 'market_buttonborder_color', market_customizer_get_default_buttonborder_color() );
	$color_buttontext = get_theme_mod( 'market_buttontext_color', market_customizer_get_default_buttontext_color() );
	$color_buttonhover = get_theme_mod( 'market_buttonhover_color', market_customizer_get_default_buttonhover_color() );
	$color_buttonhoverborder = get_theme_mod( 'market_buttonhoverborder_color', market_customizer_get_default_buttonhoverborder_color() );
	$color_buttonhovertext = get_theme_mod( 'market_buttonhovertext_color', market_customizer_get_default_buttonhovertext_color() );
	$color_footer = get_theme_mod( 'market_footer_color', market_customizer_get_default_footer_color() );
	$color_footertext = get_theme_mod( 'market_footertext_color', market_customizer_get_default_footertext_color() );

	$css = '';

	$css .= ( market_customizer_get_default_text_color() !== $color_text ) ? sprintf( '

		body,
		h1, h2, h3, h4, h5, h6,
		.genesis-nav-menu a,
		.site-title a, .site-title a:hover,
		.entry-title a, .sidebar .widget-title a,
		.widget-above-content .enews-widget,
		input, select, textarea,
		.archive-pagination li a,
		.content #genesis-responsive-slider h2 a {
			color: %1$s;
		}
		
		*::-moz-placeholder {
			color: %1$s;
		}
			
		', $color_text ) : '';
		
	$css .= ( market_customizer_get_default_links_color() !== $color_links ) ? sprintf( '

		a,
		.genesis-nav-menu a:hover, 
		.genesis-nav-menu .current-menu-item > a,
		.entry-title a:hover,
		.content #genesis-responsive-slider h2 a:hover {
			color: %1$s;
		}
		
		.woocommerce .woocommerce-message,
		.woocommerce .woocommerce-info {
			border-top-color: %1$s !important;
		}
		
		.woocommerce .woocommerce-message::before,
		.woocommerce .woocommerce-info::before,
		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce ul.products li.product .price,
		.woocommerce form .form-row .required {
			color: %1$s !important;
		}
		
		', $color_links ) : '';
		
	$css .= ( market_customizer_get_default_widgettitles_color() !== $color_widgettitles ) ? sprintf( '

		.widget-title {
			color: %1$s;
		}
		
		', $color_widgettitles ) : '';
		
	$css .= ( market_customizer_get_default_homeslider_color() !== $color_homeslider ) ? sprintf( '

		.home-slider-overlay .secondary,
		.home-slider-overlay .widget-title {
			color: %1$s;
		}
		
		', $color_homeslider ) : '';
		
	$css .= ( market_customizer_get_default_hometitles_color() !== $color_hometitles ) ? sprintf( '

		.front-page .site-inner .widget-title,
		.front-page .widget-area h3 {
			color: %1$s !important;
		}
		', $color_hometitles ) : '';
		
	$css .= ( market_customizer_get_default_button_color() !== $color_button ) ? sprintf( '

		button, input[type="button"],
		input[type="reset"],
		input[type="submit"], .button,
		a.more-link,
		.more-from-category a {
			background-color: %1$s;
		}
		
		.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button {
			background-color: %1$s !important;
		}
		
		', $color_button ) : '';
	
	$css .= ( market_customizer_get_default_buttonborder_color() !== $color_buttonborder ) ? sprintf( '

		button, input[type="button"],
		input[type="reset"],
		input[type="submit"], .button,
		a.more-link,
		.more-from-category a {
			border-color: %1$s;
		}
		
		.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button {
			border-color: %1$s !important;
		}
		
		', $color_buttonborder ) : '';
		
	$css .= ( market_customizer_get_default_buttontext_color() !== $color_buttontext ) ? sprintf( '

		button, input[type="button"],
		input[type="reset"],
		input[type="submit"], .button,
		a.more-link,
		.more-from-category a {
			color: %1$s;
		}
		
		.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button {
			color: %1$s !important;
		}
		
		', $color_buttontext ) : '';
		
	$css .= ( market_customizer_get_default_buttonhover_color() !== $color_buttonhover ) ? sprintf( '

		button, input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover,
		.button:hover,
		a.more-link:hover,
		.more-from-category a:hover {
			background-color: %1$s;
		}
		
		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce input.button:hover {
			background-color: %1$s !important;
		}
		
		', $color_buttonhover ) : '';
		
		
	$css .= ( market_customizer_get_default_buttonhoverborder_color() !== $color_buttonhoverborder ) ? sprintf( '

		button, input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover,
		.button:hover,
		a.more-link:hover,
		.more-from-category a:hover {
			border-color: %1$s;
		}
		
		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce input.button:hover {
			border-color: %1$s !important;
		}
		
		', $color_buttonhoverborder ) : '';
		
	$css .= ( market_customizer_get_default_buttonhovertext_color() !== $color_buttonhovertext ) ? sprintf( '

		button, input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover,
		.button:hover,
		a.more-link:hover,
		.more-from-category a:hover {
			color: %1$s;
		}
		
		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce input.button:hover {
			color: %1$s !important;
		}
		
		', $color_buttonhovertext ) : '';
		
	$css .= ( market_customizer_get_default_footer_color() !== $color_footer ) ? sprintf( '

		.sidebar .enews-widget,
		.footer-widgets,
		.after-entry {
			background-color: %1$s;
		}
		
		.sidebar .enews-widget,
		.after-entry {
			outline-color: %1$s;
		}
		', $color_footer ) : '';
		
	$css .= ( market_customizer_get_default_footertext_color() !== $color_footertext ) ? sprintf( '

		.sidebar .enews-widget,
		.footer-widgets,
		.after-entry,
		.sidebar .enews-widget .widget-title,
		.footer-widgets .widget-title,
		.after-entry .widget-title {
			color: %1$s;
		}
		', $color_footertext ) : '';

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
