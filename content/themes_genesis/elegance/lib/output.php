<?php

/**
 * This file adds the required CSS for the Customizer for the Elegance Theme.
 *
 * @package      Elegance
 * @subpackage   Customizations
 * @link         http://stephaniehellwig.com/themes
 * @author       Stephanie Hellwig
 * @copyright    Copyright (c) 2016, Stephanie Hellwig, Released 06/04/2016
 * @license      GPL-2.0+
 */

add_action( 'wp_enqueue_scripts', 'elegance_css' );
/**
* Checks the settings for the link color color, primary color, and header
* If any of these value are set the appropriate CSS is output
*
* @since 1.0.0
*/
function elegance_css() {

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_text 		= get_theme_mod( 'elegance_text_color', elegance_customizer_get_default_text_color() );
	$color_links 		= get_theme_mod( 'elegance_links_color', elegance_customizer_get_default_links_color() );
	$color_titles 		= get_theme_mod( 'elegance_titles_color', elegance_customizer_get_default_titles_color() );
	$color_accent 		= get_theme_mod( 'elegance_accent_color', elegance_customizer_get_default_accent_color() );
	$color_primary 		= get_theme_mod( 'elegance_primary_color', elegance_customizer_get_default_primary_color() );
	$color_line 		= get_theme_mod( 'elegance_line_color', elegance_customizer_get_default_line_color() );
	$color_navigation 	= get_theme_mod( 'elegance_navigation_color', elegance_customizer_get_default_navigation_color() );
	$color_crtext 		= get_theme_mod( 'elegance_crtext_color', elegance_customizer_get_default_crtext_color() );
	$color_crlinkhvr 	= get_theme_mod( 'elegance_crlinkhvr_color', elegance_customizer_get_default_crlinkhvr_color() );

	$css = '';

	$css .= ( elegance_customizer_get_default_text_color() !== $color_text ) ? sprintf( '

		body,
        .enews-widget,
        .widget-above-content .enews-widget,
		input, select, textarea,
        .content {
			color: %1$s;
		}
		
		*::-moz-placeholder {
			color: %1$s;
		}
			
		', $color_text ) : '';
		
	$css .= ( elegance_customizer_get_default_links_color() !== $color_links ) ? sprintf( '

		.site-footer a:hover,
		a,
		.genesis-nav-menu a:hover, 
		.genesis-nav-menu .current-menu-item > a,
		.entry-title a:hover {
			color: %1$s;
		}
		
		', $color_links ) : '';
		
	$css .= ( elegance_customizer_get_default_titles_color() !== $color_titles ) ? sprintf( '
		
		.comment-respond h3,
		.entry-comments h3,
		.entry-pings h3,
		.widget-title,
		.widgettitle
		h1, h2, h3, h4, h5, h6,
		.entry-title a, .sidebar .widget-title a {
			color: %1$s;
		}
		
		', $color_titles ) : '';
		
	$css .= ( elegance_customizer_get_default_navigation_color() !== $color_navigation ) ? sprintf( '

		.genesis-nav-menu a {
			color: %1$s;
		}
		
		', $color_navigation ) : '';
	
	$css .= ( elegance_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		h3, .site-title a, .site-title a:hover,
		blockquote::before,
		blockquote::after,
		.testimonial_rotator_quote::before {
			color: %1$s;
		}
		
		button, input[type="button"], input[type="reset"], input[type="submit"], .button, .entry-content .button,
		.archive-pagination li a:hover,
		.archive-pagination li.active a,
		.nav-primary .sub-menu a:hover,
		.widget-above-header .enews-widget input#subbutton,
		.sidebar .enews-widget input#subbutton,
		.nav-secondary .sub-menu a:hover,
		.after-entry .enews-widget input[type="submit"] {
			background-color: %1$s;
		}
		
		', $color_accent ) : '';
		
	$css .= ( elegance_customizer_get_default_primary_color() !== $color_primary ) ? sprintf( '
	
		button:hover,
		input:hover[type="button"],
		input:hover[type="reset"],
		input:hover[type="submit"],
		.button:hover,
		.entry-content .button:hover,
		.widget-above-header,
		.site-footer,
		.sidebar .enews-widget input:hover[type="submit"],
		.after-entry .enews-widget input:hover[type="submit"] {
			background-color: %1$s !important;
		}
		', $color_primary ) : '';
		
	$css .= ( elegance_customizer_get_default_line_color() !== $color_line ) ? sprintf( '

		.nav-primary,
		.nav-secondary,
		blockquote,
		.comment-respond h3,
		.entry-comments h3,
		.entry-pings h3,
		.widget-title,
		.widgettitle,
		.after-entry,
		.title-area {
			border-color: %1$s !important;
		}
		
		', $color_line ) : '';
	
	$css .= ( elegance_customizer_get_default_crtext_color() !== $color_crtext ) ? sprintf( '

		.site-footer,
		.site-footer a,
		.widget-above-header .textwidget,
		.widget-above-header p {
			color: %1$s;
		}
			
		', $color_crtext ) : '';
		
	$css .= ( elegance_customizer_get_default_crlinkhvr_color() !== $color_crlinkhvr ) ? sprintf( '

		.site-footer a:hover {
			color: %1$s ;
		}
			
		', $color_crlinkhvr ) : '';
		
	if( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}
