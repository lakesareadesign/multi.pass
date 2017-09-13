<?php
/**
 * Outfitter Pro.
 *
 * This defines the helper functions for use in the Outfitter Pro Theme.
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

/**
 * Gets the default link color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for link color.
 */
function outfitter_customizer_get_default_link_color() {

	return '#548200';

}

/**
 * Gets the default accent color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function outfitter_customizer_get_default_accent_color() {

	return '#d14600';

}

/**
 * Gets default search icon settings for Customizer.
 *
 * @since 1.0.0
 *
 * @return int 1 for true, in order to show the icon.
 */
function outfitter_customizer_get_default_search_setting() {

	return 1;

}

/**
 * Gets default post image settings for Customizer.
 *
 * @since 1.0.0
 *
 * @return int 1 for true, in order to show the image.
 */
function outfitter_customizer_get_default_image_setting() {

	return 1;

}

/**
 * Outputs the header search form toggle button.
 *
 * @return string HTML output of the Show Search button.
 *
 * @since 1.0.0
 */
function outfitter_get_header_search_toggle() {

	return '<a href="#header-search-container" class="toggle-header-search"><span class="screen-reader-text">' . __( 'Show Search', 'outfitter-pro' ) . '</span> <span class="ionicons ion-android-search"></span></a>';

}

/**
 * Helper function that prints the header search icon.
 *
 * @since 1.0.0
 */
function outfitter_do_header_search_icon( ) {

	printf( '<li class="menu-item menu-item-has-toggle search-item">%s</li>', outfitter_get_header_search_toggle() );

}

/**
 * Outputs the off-screen button.
 *
 * @return string HTML output of the Show Off-Screen Content button.
 *
 * @since 1.0.0
 */
function outfitter_get_off_screen_toggle() {

	return '<a href="#" class="toggle-off-screen-widget-area"><span class="screen-reader-text">' . __( 'Show Off-screen Content', 'outfitter-pro' ) . '</span> <span class="ionicons ion-android-more-horizontal"></span></a>';

}

/**
 * Helper function to print the header more icon.
 *
 * @since 1.0.0
 */
function outfitter_do_off_screen_icon() {

	printf( '<li class="menu-item menu-item-has-toggle off-screen-item">%s</li>', outfitter_get_off_screen_toggle() );

}

/**
 * Outputs the header search form.
 *
 * @since 1.0.0
 */
function outfitter_do_header_search_form() {

	$button = '<a href="#" role="button" class="toggle-header-search close"><span class="screen-reader-text">' . __( 'Hide Search', 'outfitter-pro' ) . '</span><span class="ionicons ion-android-close"></span></a>';

	printf(
		'<div id="header-search-container" class="header-search-container">%s %s</div>',
		get_search_form( false ),
		$button
	);

}

/**
 * Closes wrapper.
 *
 * @since 1.0.0
 */
function outfitter_wrapper_open() {

	echo '<div class="wrapper">';

}

/**
 * Closes wrapper.
 *
 * @since 1.0.0
 */
function outfitter_wrapper_close() {

	echo '</div>';

}

/**
 * Opens image wrapper.
 *
 * @since 1.0.0
 */
function outfitter_custom_archive_image_open( $open_html ) {

	return '<div class="featured-image">' . $open_html;

}

/**
 * Closes image wrapper.
 *
 * @since 1.0.0
 */
function outfitter_custom_archive_image_close( $close_html ) {

	return $close_html . '</div>';

}

/**
 * Calculates color contrast.
 *
 * @since 1.0.0
 */
function outfitter_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#000000' : '#ffffff';

}

/**
 * Calculates color brightness.
 *
 * @since 1.0.0
 */
function outfitter_color_brightness( $color, $change ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$red   = max( 0, min( 255, $red + $change ) );
	$green = max( 0, min( 255, $green + $change ) );
	$blue  = max( 0, min( 255, $blue + $change ) );

	return '#' . dechex( $red ) . dechex( $green ) . dechex( $blue );

}

/**
 * Changes color brightness.
 *
 * @since 1.0.0
 */
function outfitter_change_brightness( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? outfitter_color_brightness( '#000000', 80 ) : outfitter_color_brightness( '#ffffff', -50 );

}
