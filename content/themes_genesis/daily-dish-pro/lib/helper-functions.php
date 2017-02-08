<?php
/**
 * Daily Dish Pro
 *
 * This file adds the helper functions used elsewhere in the Daily Dish Pro theme.
 *
 * @package Daily Dish Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/daily-dish/
 */

/**
 * Get default link color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.1.0
 *
 * @return string Hex color code for link color.
 */
function daily_dish_customizer_get_default_link_color() {
	return '#e14d43';
}

/**
 * Get default accent color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.1.0
 *
 * @return string Hex color code for accent color.
 */
function daily_dish_customizer_get_default_accent_color() {
	return '#e14d43';
}

/**
 * Function to calculate the appropriate contrasting color against the passed hex value.
 *
 * @since  1.1.0
 *
 * @param  string $color Hex value of the intended background color.
 * @return string        Hex value of the appropriate contrasting color.
 */
function daily_dish_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#333333' : '#ffffff';

}

/**
 * Function to calculate the brightened hex value of the passed value.
 *
 * @since  1.1.0
 *
 * @param  string $color  Hex value of the starting color.
 * @param  int    $change Number (in percent) to increase the brightness.
 * @return string         Hex value of the brightened color.
 */
function daily_dish_color_brightness( $color, $change ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$red   = max( 0, min( 255, $red + $change ) );
	$green = max( 0, min( 255, $green + $change ) );
	$blue  = max( 0, min( 255, $blue + $change ) );

	return '#'.dechex( $red ).dechex( $green ).dechex( $blue );

}
