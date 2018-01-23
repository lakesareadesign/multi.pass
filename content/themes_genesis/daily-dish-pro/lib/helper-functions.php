<?php
/**
 * Daily Dish Pro
 *
 * This file adds the helper functions used elsewhere in the Daily Dish Pro Theme.
 *
 * @package Daily Dish Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/daily-dish/
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
	return '#d9037f';
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
	return '#d9037f';
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
 * Get default search icon settings for Customizer.
 *
 * @since 1.0.0
 *
 * @return int 1 for true, in order to show the icon.
 */
function daily_dish_customizer_get_default_search_setting() {
	return 1;
}

/**
 * Output the header search form toggle button.
 *
 * @return string HTML output of the Show Search button.
 *
 * @since 1.0.0
 */
function daily_dish_get_header_search_toggle() {
	return sprintf( '<a href="#header-search-wrap" aria-controls="header-search-wrap" aria-expanded="false" role="button" class="toggle-header-search"><span class="screen-reader-text">%s</span><span class="ionicons ion-ios-search"></span></a>', __( 'Show Search', 'daily-dish-pro' ) );
}

/**
 * Output the header search form.
 *
 * @since 1.0.0
 */
function daily_dish_do_header_search_form() {

	$button = sprintf( '<a href="#" role="button" aria-expanded="false" aria-controls="header-search-wrap" class="toggle-header-search close"><span class="screen-reader-text">%s</span><span class="ionicons ion-ios-close-empty"></span></a>', __( 'Hide Search', 'daily-dish-pro' ) );

	printf(
		'<div id="header-search-wrap" class="header-search-wrap">%s %s</div>',
		get_search_form( false ),
		$button
	);

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

	return '#' . dechex( $red ) . dechex( $green ) . dechex( $blue );

}
