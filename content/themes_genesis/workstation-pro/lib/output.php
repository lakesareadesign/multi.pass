<?php
/**
 * Workstation Pro.
 *
 * This file adds the required CSS to the front end of the Workstation Pro Theme.
 *
 * @package Workstation
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/workstation/
 */

add_action( 'wp_enqueue_scripts', 'workstation_css' );
/**
 * Checks the settings for the images and background colors for each image.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 1.0.0
 */
function workstation_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_accent   = get_theme_mod( 'workstation_primary_color', workstation_customizer_get_default_accent_color() );
	$color_secondary = get_theme_mod( 'workstation_accent_color', workstation_customizer_get_default_secondary_accent_color() );
	$color_fp3    = get_theme_mod( 'workstation_front_page_3_color', workstation_customizer_get_default_front_page_3_color() );

	$opts = apply_filters( 'workstation_images', array( '1', '2' ) );

	$settings = array();

	foreach( $opts as $opt ){
		$settings[$opt]['image'] = preg_replace( '/^https?:/', '', get_option( $opt .'-workstation-image', sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $opt ) ) );
	}

	$css = '';

	foreach ( $settings as $section => $value ) {

		$background = $value['image'] ? sprintf( 'background-image: url(%s);', $value['image'] ) : '';

		if( is_front_page() ) {
			$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.image-section-%s { %s }', $section, $background ) : '';
		}

	}

	$css .= ( workstation_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		a,
		.add-black .after-header a:focus,
		.add-black .after-header a:hover,
		.author-box-title,
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.archive-pagination .active a,
		.archive-title,
		.entry-header .entry-meta,
		.entry-title a:focus,
		.entry-title a:hover,
		.featured-content .entry-meta,
		.flexible-widgets .featured-content .has-post-thumbnail .alignnone + .entry-header .entry-title a:focus,
		.flexible-widgets .featured-content .has-post-thumbnail .alignnone + .entry-header .entry-title a:hover,
		.footer-widgets a:focus,
		.footer-widgets a:hover,
		.front-page-3 a:focus,
		.front-page-3 a:hover,
		.genesis-nav-menu .sub-menu a:focus,
		.genesis-nav-menu .sub-menu a:hover,
		.nav-secondary .genesis-nav-menu .sub-menu a:focus,
		.nav-secondary .genesis-nav-menu .sub-menu a:hover,
		.nav-secondary .genesis-nav-menu .sub-menu .current-menu-item > a,
		.page-title,
		.site-footer a:focus,
		.site-footer a:hover,
		.widget li a:focus,
		.widget li a:hover,
		.widget-title {
			color: %1$s;
		}

		.after-header,
		.front-page-1,
		.genesis-nav-menu .sub-menu,
		.genesis-nav-menu > .current-menu-item > a,
		.genesis-nav-menu > li > a:focus,
		.genesis-nav-menu > li > a:hover {
			border-color: %1$s;
		}

		@media only screen and (max-width: 880px) {
			.genesis-responsive-menu .genesis-nav-menu .menu-item a:focus,
			.genesis-responsive-menu .genesis-nav-menu .menu-item a:hover,
			.menu-toggle:focus,
			.menu-toggle:hover,
			.sub-menu-toggle:focus,
			.sub-menu-toggle:hover {
				color: %1$s;
			}
		}
		', $color_accent ) : '';

	$css .= ( workstation_customizer_get_default_secondary_accent_color() !== $color_secondary ) ? sprintf( '

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.add-color .after-header,
		.add-color .site-header,
		.button,
		.widget .button {
			background-color: %1$s;
			color: %2$s;
		}
		', $color_accent, workstation_color_contrast( $color_secondary ), workstation_change_brightness( $color_secondary ) ) : '';

	$css .= ( workstation_customizer_get_default_front_page_3_color() !== $color_fp3 ) ? sprintf( '

		.front-page-3 {
			background-color: %1$s;
		}

		.front-page-3,
		.front-page-3 a,
		.front-page-3 .widget li a {
			color: %2$s;
		}

		.front-page-3 button:focus,
		.front-page-3 button:hover,
		.front-page-3 input:focus[type="button"],
		.front-page-3 input:focus[type="reset"],
		.front-page-3 input:focus[type="submit"],
		.front-page-3 input:hover[type="button"],
		.front-page-3 input:hover[type="reset"],
		.front-page-3 input:hover[type="submit"],
		.front-page-3 .button:focus,
		.front-page-3 .button:hover {
			background-color: %2$s;
			color: %1$s;
		}
		', $color_fp3, workstation_color_contrast( $color_fp3 ), workstation_change_brightness( $color_fp3 ) ) : '';

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
