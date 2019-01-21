<?php
/**
 * Magazine Pro.
 *
 * This file adds theme helper functions for use elsewhere in Magazine Pro.
 *
 * @package Magazine
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    http://my.studiopress.com/themes/magazine/
 */

/**
 * Function to return the default accent color.
 *
 * @since 3.2.0
 *
 * @return string Hex value of the accent color.
 */
function magazine_get_default_accent_color() {
	return '#008285';
}

/**
 * Function to return the default accent color.
 *
 * @since 3.2.0
 *
 * @return string Hex value of the accent color.
 */
function magazine_get_default_link_color() {
	return '#008285';
}

/**
 * Generate a hex value that has appropriate contrast
 * against the inputted value.
 *
 * @since 3.2.0
 *
 * @return string Hex color code for contrasting color.
 */
function magazine_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );
	$red      = hexdec( substr( $hexcolor, 0, 2 ) );
	$green    = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue     = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#222222' : '#ffffff';

}
