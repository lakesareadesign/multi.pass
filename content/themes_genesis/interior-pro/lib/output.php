<?php
/**
 * Interior Pro.
 *
 * This file adds the required CSS to the front end to the Interior Pro Theme.
 *
 * @package Interior
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/interior/
 */

add_action( 'wp_enqueue_scripts', 'interior_css' );
/**
* Checks the settings for the images and background colors for each image
* If any of these value are set the appropriate CSS is output
*
* @since 1.0
*/
function interior_css() {

	$handle = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_site_title = get_theme_mod( 'interior_site_title_color', interior_customizer_get_default_site_title_color() );
	$color_image = get_theme_mod( 'interior_image_color', interior_customizer_get_default_image_color() );
	$color_primary_link = get_theme_mod( 'interior_primary_link_color', interior_customizer_get_default_primary_link_color() );
	$color_button = get_theme_mod( 'interior_button_color', interior_customizer_get_default_button_color() );
	$color_before_footer = get_theme_mod( 'interior_before_footer_color', interior_customizer_get_default_before_footer_color() );
	
	$image_frontpage = preg_replace( '/^https?:/', '', get_option( 'front-page-interior-image', sprintf( '%s/images/bg-front-page.jpg', get_stylesheet_directory_uri() ) ) );
	$image_page = preg_replace( '/^https?:/', '', get_option( 'page-interior-image', sprintf( '%s/images/bg-page.jpg', get_stylesheet_directory_uri() ) ) );
	$image_post = preg_replace( '/^https?:/', '', get_option( 'post-interior-image', sprintf( '%s/images/bg-post.jpg', get_stylesheet_directory_uri() ) ) );

	$css = '';
	
	//* Calculate Color Contrast
	function interior_color_contrast( $color ) {
	
		$hexcolor = str_replace( '#', '', $color );

		$red   = hexdec( substr( $hexcolor, 0, 2 ) );
		$green = hexdec( substr( $hexcolor, 2, 2 ) );
		$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

		$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

		return ( $luminosity > 128 ) ? '#333333' : '#ffffff';

	}
	
	//* Calculate Color Brightness
	function interior_color_brightness( $color, $change ) {

		$hexcolor = str_replace( '#', '', $color );

		$red   = hexdec( substr( $hexcolor, 0, 2 ) );
		$green = hexdec( substr( $hexcolor, 2, 2 ) );
		$blue  = hexdec( substr( $hexcolor, 4, 2 ) );
	
		$red   = max( 0, min( 255, $red + $change ) );
		$green = max( 0, min( 255, $green + $change ) );  
		$blue  = max( 0, min( 255, $blue + $change ) );

		return '#'.dechex( $red ).dechex( $green ).dechex( $blue );

	}

	function interior_change_brightness( $color ) {

		$hexcolor = str_replace( '#', '', $color );

		$red   = hexdec( substr( $hexcolor, 0, 2 ) );
		$green = hexdec( substr( $hexcolor, 2, 2 ) );
		$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

		$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

		return ( $luminosity > 128 ) ? interior_color_brightness( '#333333', 20 ) : interior_color_brightness( '#ffffff', -50 );

	}

	//* Site Title Color
	$css .= ( interior_customizer_get_default_site_title_color() !== $color_site_title ) ? sprintf( '

		.site-header .site-title a,
		.site-header .site-title a:hover {
			background-color: %1$s;
			color: %2$s;
		}

		', $color_site_title, interior_color_contrast( $color_site_title ) ) : '';

	//* Hero Images and Overlay Color
	if ( is_front_page() ) {
		$image = $image_frontpage;
	} elseif ( is_single() || is_archive() ) {
		$image = $image_post;	
	} else {
		$image = $image_page;		
	}

	$background = $image ? sprintf( 'background-image: url(%s);', $image ) : '';
	$css .= ( ! empty( $background ) ) ? sprintf( '.after-header { %s }', $background ) : '';

	$css .= ( interior_customizer_get_default_image_color() !== $color_image ) ? sprintf( '

		.after-header,
		.after-header:after {
			background-color: %1$s;
		}

		.after-header,
		.after-header a {
			color: %2$s;
		}
		
		.after-header a:focus,
		.after-header a:hover {
			color: %3$s;
		}

		.after-header button:focus,
		.after-header button:hover,
		.after-header input:focus[type="button"],
		.after-header input:focus[type="reset"],
		.after-header input:focus[type="submit"],
		.after-header input:hover[type="button"],
		.after-header input:hover[type="reset"],
		.after-header input:hover[type="submit"],
		.site-container .after-header .button:focus,
		.site-container .after-header .button:hover {
			background-color: %2$s;
			color: %1$s;
		}

		', $color_image, interior_color_contrast( $color_image ), interior_change_brightness( $color_image ) ) : '';

	//* Primary Link Color
	$css .= ( interior_customizer_get_default_primary_link_color() !== $color_primary_link ) ? sprintf( '

		a,
		.archive-pagination .active a,
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.entry-title a:focus,
		.entry-title a:hover,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu li.current-menu-item > a,
		.js .site-header button:focus,
		.sidebar li a:focus,
		.sidebar li a:hover,
		.site-footer a:focus,
		.site-footer a:hover,
		.tweet-details a:focus,
		.tweet-details a:hover,
		.widget_nav_menu a:focus,
		.widget_nav_menu a:hover {
			color: %1$s;
		}

		', $color_primary_link ) : '';

	//* Button Color
	$css .= ( interior_customizer_get_default_button_color() !== $color_button ) ? sprintf( '

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.genesis-nav-menu .sub-menu li a,
		.site-container .button,
		.site-header .site-title a:focus {
			background-color: %1$s;
			color: %2$s;
		}

		.genesis-nav-menu .sub-menu:after,
		.genesis-nav-menu .sub-menu:before {
			border-bottom-color: %1$s;
		}

		', $color_button, interior_color_contrast( $color_button ) ) : '';

	//* Before Footer Color
	$css .= ( interior_customizer_get_default_before_footer_color() !== $color_before_footer ) ? sprintf( '

		.before-footer {
			background-color: %1$s;	
		}

		.before-footer,
		.before-footer a {
			color: %2$s;
		}

		.before-footer a:focus,
		.before-footer a:hover {
			color: %3$s;
		}

		.before-footer button:focus,
		.before-footer button:hover,
		.before-footer input:focus[type="button"],
		.before-footer input:focus[type="reset"],
		.before-footer input:focus[type="submit"],
		.before-footer input:hover[type="button"],
		.before-footer input:hover[type="reset"],
		.before-footer input:hover[type="submit"],
		.site-container .before-footer .button:focus,
		.site-container .before-footer .button:hover {
			background-color: %2$s;
			color: %1$s;
		}

		.before-footer .enews-widget input[type="email"],
		.before-footer .enews-widget input[type="email"]:focus {
			background-color: %1$s;
			border-color: %2$s;
			color: %2$s;
		}

		', $color_before_footer, interior_color_contrast( $color_before_footer ), interior_change_brightness( $color_before_footer ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}

}