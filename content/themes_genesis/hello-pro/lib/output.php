<?php
/**
 * Hello Pro Theme Front Page Images
 *
 * This file adds the required CSS to the front end to the Hello Pro Theme
 *
 * @package Hello Pro
 * @author  BrandiD
 * @license GPL-2.0+
 * @link    https://thebrandid.com
 */

add_action( 'wp_enqueue_scripts', 'hellopro_homepage_css_output' );
/**
 * Checks the settings for the home page sections.
 * If any of these value are set the appropriate CSS is output.
 *
 * @since 2.2.3
 */
function hellopro_homepage_css_output() {

	 $css = '';
	 $handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	if ( is_front_page() ) {
		$handle = 'home-styles';
	}

	if ( is_front_page() ) {

		$opts = apply_filters( 'hellopro_images', array( '1', '2', '3', '4' ) );

		$settings = array();

		foreach ( $opts as $opt ) {

			$settings[ $opt ]['image'] = preg_replace( '/^https?:/', '', get_theme_mod( $opt .'-hellopro-image', '' ) );
			// $settings[ $opt ]['image'] = preg_replace( '/^https?:/', '', get_theme_mod( $opt .'-hellopro-image', sprintf( '%s/images/bg-%s.jpg', CHILD_THEME_URI, $opt ) ) );
			$settings[ $opt ]['image-hellopro-image-position-x'] = get_theme_mod( $opt .'-hellopro-image-position-x' );
			$settings[ $opt ]['image-hellopro-image-position-y'] = get_theme_mod( $opt .'-hellopro-image-position-y' );

		}

		foreach ( $settings as $section => $value ) {

			$background_pos_x = $value['image-hellopro-image-position-x'] ? $value['image-hellopro-image-position-x'] : 'center' ;
			$background_pos_y = $value['image-hellopro-image-position-y'] ? $value['image-hellopro-image-position-y'] : 'center' ;
			$background = $value['image'] ? sprintf( 'background: url(%s) %s %s %s/%s;', $value['image'], 'no-repeat', $background_pos_x, $background_pos_y, 'cover' ) : '';
			if ( 1 === $section  ) {

				$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.home-welcome-container { %s }', $background ) : '';

			} elseif ( 2 === $section ) {

				$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.home-cta { %s }',  $background ) : '';

			} elseif ( 3 === $section ) {

				$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.home-statement { %s }',  $background ) : '';

			} elseif ( 4 === $section ) {

				$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.home-testimonial { %s }',  $background ) : '';

			}
		}
	}

	$color_link = get_theme_mod( 'hello_pro_link_color', hello_pro_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'hello_pro_accent_color', hello_pro_customizer_get_default_accent_color() );
	$css .= ( hello_pro_customizer_get_default_link_color() !== $color_link ) ? sprintf( '
	a,
	.home-features > .wrap > .widget .textwidget > h3 > span,
	.home-testimonial .social-proof-slider-wrap .testimonial-item .testimonial-text .author .author-name,
	.content .entry-header .entry-meta .entry-comments-link a,
	.footer-widgets a:hover,
	.footer-widgets a:focus,
	.genesis-nav-menu a:focus,
	.genesis-nav-menu a:hover,
	.genesis-nav-menu .current-menu-item > a,
	.genesis-nav-menu .sub-menu .current-menu-item > a:focus,
	.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
	.genesis-nav-menu .current-menu-parent > a,
	.menu-toggle:focus,
	.menu-toggle:hover,
	.sub-menu-toggle:focus,
	.sub-menu-toggle:hover,
	a:hover,
	.entry-meta a,
	.entry-meta a:hover,
	.entry-meta a:focus,
	.footer-widgets .entry-title a:hover,
	.site-footer a:hover,
	.site-footer a:focus  {
		color: %s;
	}

	.home-portfolio ul.display-posts-listing > li:hover a > img {
	    border-color: %s;
	}

	', $color_link, $color_link ) : '';

	$css .= ( hello_pro_customizer_get_default_link_color() !== $color_link ) ? sprintf( '


	.archive-pagination li a,
	a.button,
	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.sidebar .enews-widget input[type="submit"],
	.sidebar-primary .widget input[type="submit"],
	.sidebar-primary .widget .button  {
		background-color: %s;
	}

	', $color_link ) : '';

	$css .= ( hello_pro_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

	.archive-pagination li a:hover,
	.archive-pagination li a:focus,
	.archive-pagination li.active a,
	.button:hover,
	.button:focus,
	a.button:hover,
	a.button:focus,
	button:hover,
	button:focus,
	input:hover[type="button"],
	input:hover[type="reset"],
	input:hover[type="submit"],
	input:focus[type="button"],
	input:focus[type="reset"],
	input:focus[type="submit"],
	.sidebar-primary .widget .button:focus,
	.sidebar-primary .widget .button:hover,
	.sidebar .enews-widget input[type="submit"]:focus,
	.sidebar .enews-widget input[type="submit"]:hover  {
		background-color: %s;
		color: %s;
	}
	', $color_accent, hello_pro_color_contrast( $color_accent ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}
}
