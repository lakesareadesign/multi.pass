<?php
/**
 * Kreativ Pro.
 *
 * This file adds the required CSS to the front end to the Kreativ Pro Theme.
 *
 * @package Kreativ
 * @author  ThemeSquare
 * @license GPL-2.0+
 * @link    http://themesquare.com/themes/kreativ/
 */

add_action( 'wp_enqueue_scripts', 'kreativ_styles', 12 );
/**
 * Checks the settings for the link color color, accent color, and header.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function kreativ_styles() {

	// Get theme name.
	$theme = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'kreativ-pro';

	// Get default accent color.
	$default = kreativ_customizer_default_accent_color();

	// Get theme accent color.
	$color_accent = get_theme_mod( 'kreativ_accent_color', $default );

	// Sections with background images.
	$bgimages = apply_filters( 'kreativ_images', array( '1' ) );

	// Get saved background image for each section.
	$sections = array();
	foreach ( $bgimages as $bgimage ) {
		$sections[ $bgimage ]['image'] = preg_replace( '/^https?:/', '', get_option( 'kreativ-image-' . $bgimage, sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $bgimage ) ) );
	}

	// Add background image to each section.
	$css = '';
	foreach ( $sections as $section => $section_id ) {
		$background = $section_id['image'] ? sprintf( 'background-image: url(%s);', $section_id['image'] ) : '';
		if ( is_front_page() ) {
			$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.front-page-%s { %s }', $section, $background ) : '';
		}
	}

	// Add theme accent color.
	$css .= ( $default !== $color_accent ) ? sprintf( '

		a,
		.entry-title a:hover,
		.entry-title a:focus,
		.genesis-nav-menu a:hover,
		.entry-meta a:hover,
		.comment-list .comment-time a:hover,
		.sidebar li:before,
		.sidebar li a:hover,
		.site-footer a:hover,
		.site-topbar a:hover,
		.nav-footer .genesis-nav-menu a:hover,
		.featured-portfolio .entry .entry-title a:hover {
			color: %1$s;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.button,
		.more-link,
		.archive-pagination li a:hover,
		.archive-pagination li a:focus,
		.archive-pagination .active a,
		.content .entry .entry-header > a:after,
		.footer-widgets .enews-widget input[type="submit"],
		.gallery-item .gallery-icon > a:after,
		.portfolio-content .entry-thumbnail:after,
		.portfolio-filter a.active,
		.portfolio-filter a:hover,
		.featured-portfolio .entry .entry-thumbnail:after,
		.genesis-pro-portfolio .entry .portfolio-featured-image:after {
			background-color: %1$s;
		}

	', $color_accent ) : '';

	// Enqueue inline styles.
	if ( $css ) {
		wp_add_inline_style( $theme, $css );
	}

	// Add theme accent color.
	$css_front  = '';
	$css_front .= ( $default !== $color_accent ) ? sprintf( '

		.front-page-2 .widget:nth-of-type(n+2) i,
		.front-page-4 .widget:nth-of-type(n+2) a:hover {
			color: %1$s;
		}

		.front-page .featured-content .entry > a:after {
			background-color: %1$s;
		}

		', $color_accent ) : '';

	// Enqueue inline styles for front page.
	if ( $css_front ) {
		wp_add_inline_style( 'kreativ-front-css', $css_front );
	}

}
