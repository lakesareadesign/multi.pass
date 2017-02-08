<?php
/**
 * Smart Passive Income Pro.
 *
 * This file adds helper functions used elsewhere in the Smart Passive Income Pro Theme.
 *
 * @package Smart Passive Income Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

/**
 * Get default link color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for primary color.
 */
function spi_customizer_get_default_primary_color() {
	return '#0e763c';
}

/**
 * Get default secondary color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for secondary color.
 */
function spi_customizer_get_default_secondary_color() {
	return '#b4151b';
}

/**
 * Get default background color of Front Page 3 for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for secondary color.
 */
function spi_customizer_get_default_front_page_3_color() {
	return '#3677aa';
}

/**
 * Get default background image of Front Page 2 for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string URL of default image.
 */
function spi_customizer_get_default_front_page_2_image() {
	return get_stylesheet_directory_uri() . '/images/front-page-2.jpg';
}

/**
 *
 * Calculate the color contrast.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex code for the color contrast.
 */
function spi_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );
	$red      = hexdec( substr( $hexcolor, 0, 2 ) );
	$green    = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue     = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#333333' : '#ffffff';

}

/**
 * Calculate the color brightness.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex code for the color brightness.
 */
function spi_color_brightness( $color, $op, $change ) {

	$hexcolor = str_replace( '#', '', $color );
	$red      = hexdec( substr( $hexcolor, 0, 2 ) );
	$green    = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue     = hexdec( substr( $hexcolor, 4, 2 ) );

	if ( '+' !== $op && isset( $op ) ) {
		$red   = max( 0, min( 255, $red - $change ) );
		$green = max( 0, min( 255, $green - $change ) );
		$blue  = max( 0, min( 255, $blue - $change ) );
	} else {
		$red   = max( 0, min( 255, $red + $change ) );
		$green = max( 0, min( 255, $green + $change ) );
		$blue  = max( 0, min( 255, $blue + $change ) );
	}

	$newhex = '#';
	$newhex .= strlen( dechex( $red ) ) === 1 ? '0'.dechex( $red ) : dechex( $red );
	$newhex .= strlen( dechex( $green ) ) === 1 ? '0'.dechex( $green ) : dechex( $green );
	$newhex .= strlen( dechex( $blue ) ) === 1 ? '0'.dechex( $blue ) : dechex( $blue );

	// Force darken if brighten color is the same as color inputted.
	if ( $newhex === $hexcolor && $op === '+' ) {

		$newhex = '#333333';

	}

	return $newhex;

}
