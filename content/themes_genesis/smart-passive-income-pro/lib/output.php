<?php
/**
 * Smart Passive Income Pro.
 *
 * This file adds the required CSS to the front end to the Smart Passive Income Pro.
 *
 * @package Smart Passive Income Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

add_action( 'wp_enqueue_scripts', 'spi_css' );
/**
 * Checks the settings for the link color, and secondary color.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function spi_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_primary = get_theme_mod( 'spi_primary_color', spi_customizer_get_default_primary_color() );
	$color_secondary = get_theme_mod( 'spi_secondary_color', spi_customizer_get_default_secondary_color() );
	$bg_front_page_2 = preg_replace( '/^https?:/', '', get_theme_mod( 'spi_front_page_2_bg_image', spi_customizer_get_default_front_page_2_image() ) );
	$bg_front_page_3 = get_theme_mod( 'spi_home_widget_3_background', spi_customizer_get_default_front_page_3_color() );

	$css = '';

	$css .= ( spi_customizer_get_default_primary_color() !== $color_primary ) ? sprintf( '

		a,
		.spi-customized .entry-title a:focus,
		.spi-customized .entry-title a:hover,
		.spi-customized .menu-toggle:focus,
		.spi-customized .menu-toggle:hover,
		.spi-customized .sub-menu-toggle:focus,
		.spi-customized .sub-menu-toggle:hover,
		.spi-customized.woocommerce ul.products li.product h3:hover,
		.spi-customized.woocommerce ul.products li.product .price {
			color: %1$s;
		}

		.spi-customized button,
		.spi-customized input[type="button"],
		.spi-customized input[type="reset"],
		.spi-customized input[type="submit"],
		.spi-customized .archive-pagination a:focus,
		.spi-customized .archive-pagination a:hover,
		.spi-customized .archive-pagination .active a,
		.spi-customized .color .more-link,
		.spi-customized .site-container a.button,
		.spi-customized.archive .content .entry-comments-link,
		.spi-customized.page-template-page_blog .content .entry-comments-link,
		.spi-customized.single .content .entry-comments-link {
			background-color: %1$s;
		}

		.spi-customized.archive .content .entry-comments-link:after,
		.spi-customized.page-template-page_blog .content .entry-comments-link:after,
		.spi-customized.single .content .entry-comments-link:after {
			border-left-color: %1$s;
		}

		.spi-customized button,
		.spi-customized input[type="button"],
		.spi-customized input[type="reset"],
		.spi-customized input[type="submit"],
		.spi-customized .color .more-link,
		.spi-customized .site-container a.button,
		.spi-customized.archive .content p.entry-meta .entry-comments-link > a,
		.spi-customized.page-template-page_blog .content p.entry-meta .entry-comments-link > a,
		.spi-customized.single .content p.entry-meta .entry-comments-link > a {
			color: %2$s;
		}
		', $color_primary, spi_color_contrast( $color_primary ) ) : '';

	// Hover color for primary.
	$css .= (  spi_customizer_get_default_primary_color() !== $color_primary ) ? sprintf( '

		.spi-customized button:focus,
		.spi-customized button:hover,
		.spi-customized input:focus[type="button"],
		.spi-customized input:focus[type="reset"],
		.spi-customized input:focus[type="submit"],
		.spi-customized input:hover[type="button"],
		.spi-customized input:hover[type="reset"],
		.spi-customized input:hover[type="submit"],
		.spi-customized .color .more-link:focus,
		.spi-customized .color .more-link:hover,
		.spi-customized .site-container a.button:focus,
		.spi-customized .site-container a.button:hover {
			background-color: %1$s;
			color: %2$s;
		}

		', spi_color_brightness( $color_primary, '+', 20 ), spi_color_contrast( $color_primary ) ) : '';

	// If white is the background.
	$css .= ( spi_customizer_get_default_secondary_color() === '#ffffff' || spi_customizer_get_default_front_page_3_color() === '#ffffff' ) ? sprintf( '

		body.spi-customized .site-container .color a.button,
		body.spi-customized .site-container .color input[type="button"],
		body.spi-customized .site-container .color input[type="reset"],
		body.spi-customized .site-container .color input[type="submit"],
		body.spi-customized .site-container .color .more-link {
			background-color: %s;
		}

		body.spi-customized .site-container .color a.button:focus,
		body.spi-customized .site-container .color a.button:hover,
		body.spi-customized .site-container .color input[type="button"]:focus,
		body.spi-customized .site-container .color input[type="button"]:hover,
		body.spi-customized .site-container .color input[type="reset"]:focus,
		body.spi-customized .site-container .color input[type="reset"]:hover,
		body.spi-customized .site-container .color input[type="submit"]:focus,
		body.spi-customized .site-container .color input[type="submit"]:hover,
		body.spi-customized .site-container .color .more-link:focus,
		body.spi-customized .site-container .color .more-link:hover {
			background-color: %s;
		}

	', '#ebebeb', spi_color_brightness( '#ebebeb', '-', 20 ) ) : '';

	$css .= ( spi_customizer_get_default_secondary_color() !== $color_secondary ) ? sprintf( '

		.spi-customized .after-entry .widget-title,
		.spi-customized .footer-banner,
		.spi-customized .front-page-1,
		.spi-customized .genesis-nav-menu .sub-menu,
		.spi-customized .nav-primary,
		.spi-customized .nav-primary .genesis-nav-menu > li:hover:before,
		.spi-customized .nav-primary .genesis-nav-menu > li.current-menu-item:before,
		.spi-customized .nav-primary .genesis-nav-menu li.current-menu-item a,
		.spi-customized .sidebar .enews-widget .widget-title,
		.spi-customized .site-container button.sub-menu-toggle.sub-menu-toggle:focus,
		.spi-customized .site-container button.sub-menu-toggle.sub-menu-toggle:hover,
		.spi-customized .site-container .nav-primary .genesis-nav-menu > li a:focus,
		.spi-customized .site-container .nav-primary .genesis-nav-menu > li a:hover {
			background-color: %1$s;
		}

		.spi-customized .after-entry .widget-title,
		.spi-customized .after-entry .widget-title a,
		.spi-customized .after-entry .widget-title a:focus,
		.spi-customized .after-entry .widget-title a:hover,
		.spi-customized .color,
		.spi-customized .color a,
		.spi-customized .color p.entry-meta a,
		.spi-customized .color p.entry-meta,
		.spi-customized .color .entry-title a,
		.spi-customized .color .menu a,
		.spi-customized .color .menu li:after,
		.spi-customized .color.widget-full .menu a,
		.spi-customized .genesis-nav-menu .sub-menu a,
		.spi-customized .genesis-nav-menu .sub-menu a:hover,
		.spi-customized .nav-primary .genesis-nav-menu a,
		.spi-customized .nav-primary .genesis-nav-menu > li:hover:before,
		.spi-customized .nav-primary .genesis-nav-menu > li.current-menu-item:before,
		.spi-customized .sidebar .enews-widget .widget-title,
		.spi-customized .site-container button.sub-menu-toggle,
		.spi-customized .site-container .nav-primary .genesis-nav-menu > li a:focus,
		.spi-customized .site-container .nav-primary .genesis-nav-menu > li a:hover {
			color: %2$s;
		}

		.spi-customized .site-container .nav-primary .sub-menu-toggle,
        .spi-customized .site-container .nav-primary .sub-menu-toggle:focus,
        .spi-customized .site-container .nav-primary .sub-menu-toggle:hover {
			background-color: %3$s !important;
			color: %2$s !important;
		}

		.spi-customized .genesis-nav-menu .sub-menu a {
			border-color: %3$s;
		}

		', $color_secondary, spi_color_contrast( $color_secondary ), spi_color_brightness( $color_secondary, '-', 20 ) ) : '';

	// Hover color for secondary.
	$css .= ( spi_customizer_get_default_secondary_color() !== $color_secondary ) ? sprintf( '

		.spi-customized .site-container .nav-primary .genesis-nav-menu > li .sub-menu a:hover {
			background-color: %s;
			color: %s;
		}
		', spi_color_brightness( $color_secondary, '-', 20 ), spi_color_contrast( $color_secondary ) ) : '';

	// Background image for the Front Page 2 Widget area.
	$css .= ( '' !== $bg_front_page_2 ) ? sprintf( '
		.spi-customized .front-page-2 {
			background-image: url( %s );
		}
		', $bg_front_page_2 ) : '';

	// Background color for the Front Page 3 Widget areas.
	$css .= ( spi_customizer_get_default_front_page_3_color() !== $bg_front_page_3 ) ? sprintf( '

		.spi-customized .front-page-3-a,
		.spi-customized .front-page-3-b {
			background-color: %1$s;
			color: %2$s;
		}

		.spi-customized .front-page-3-a a,
		.spi-customized .front-page-3-a a:focus,
		.spi-customized .front-page-3-a a:hover,
		.spi-customized .front-page-3-a p.entry-meta,
		.spi-customized .front-page-3-a p.entry-meta a,
		.spi-customized .front-page-3-a p.entry-meta a:focus,
		.spi-customized .front-page-3-a p.entry-meta a:hover,
		.spi-customized .front-page-3-a .entry-title a,
		.spi-customized .front-page-3-a .entry-title a:focus,
		.spi-customized .front-page-3-a .entry-title a:hover,
		.spi-customized .front-page-3-b a,
		.spi-customized .front-page-3-b a:focus,
		.spi-customized .front-page-3-b a:hover,
		.spi-customized .front-page-3-b p.entry-meta,
		.spi-customized .front-page-3-b p.entry-meta a,
		.spi-customized .front-page-3-b p.entry-meta a:focus,
		.spi-customized .front-page-3-b p.entry-meta a:hover,
		.spi-customized .front-page-3-b .entry-title a,
		.spi-customized .front-page-3-b .entry-title a:hover,
		.spi-customized .front-page-3-b .entry-title a:focus {
			color: %2$s;
		}

		', $bg_front_page_3, spi_color_contrast( $bg_front_page_3 ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

	// Add targeting class to body tag if user has changed default values.
	if ( spi_customizer_get_default_secondary_color() !== $color_secondary || spi_customizer_get_default_primary_color() !== $color_primary || spi_customizer_get_default_front_page_2_image() !== $bg_front_page_2 || spi_customizer_get_default_front_page_3_color() !== $bg_front_page_3 ) {
		add_filter( 'body_class', 'spi_customizer_body_class' );
	}

}

// Add customizer class for targeting custom elements.
function spi_customizer_body_class( $classes ) {

	$classes[] = 'spi-customized';
	
	return $classes;

}
