<?php
/**
 * Executive Pro.
 *
 * This defines the helper functions for use in the Executive Pro Theme.
 *
 * @package Executive
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/executive/
 */

/**
 * Get default link color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 3.2.0
 *
 * @return string Hex color code for link color.
 */
function executive_customizer_get_default_link_color() {
	return '#64c9ea';
}

/**
 * Get default accent color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 3.2.0
 *
 * @return string Hex color code for accent color.
 */
function executive_customizer_get_default_accent_color() {
	return '#64c9ea';
}

/**
 * Get default hover color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 3.2.0
 *
 * @return string Hex color code for hover color.
 */
function executive_customizer_get_default_hover_color() {
	return '#6bd5f1';
}

/**
 * Calculate color contrast.
 *
 * @since 3.2.0
 */
function executive_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#000000' : '#ffffff';

}

/**
 * Calculate color brightness.
 *
 * @since 3.2.0
 */
function executive_color_brightness( $color, $change ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$red   = max( 0, min( 255, $red + $change ) );
	$green = max( 0, min( 255, $green + $change ) );
	$blue  = max( 0, min( 255, $blue + $change ) );

	return '#'.dechex( $red ).dechex( $green ).dechex( $blue );

}

/**
 * Change color brightness.
 *
 * @since 3.2.0
 */
function executive_change_brightness( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? executive_color_brightness( '#000000', 80 ) : executive_color_brightness( '#ffffff', -50 );

}
