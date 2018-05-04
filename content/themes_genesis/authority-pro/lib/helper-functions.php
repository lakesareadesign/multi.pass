<?php
/**
 * Authority Pro.
 *
 * This defines the helper functions for use in the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

/**
 * Gets the default primary color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for primary color.
 */
function authority_customizer_get_default_primary_color() {

	return '#000cff';

}

/**
 * Gets default top banner section text.
 *
 * @since 1.0.0
 *
 * @return string Text to use in the top banner.
 */
function authority_get_default_top_banner_text() {

	return __( 'Check out my fresh new course on building and growing an online audience — 25&#37; OFF Today Only!', 'authority-pro' );

}

/**
 * Gets default hero section title.
 *
 * @since 1.0.0
 *
 * @return string Text to use in the title.
 */
function authority_get_default_hero_title_text() {

	return __( 'Hey, I’m Kelly. I’ll teach you how to grow your audience and build an online business.', 'authority-pro' );

}

/**
 * Gets default hero section description.
 *
 * @since 1.0.0
 *
 * @return string Text to use in the description.
 */
function authority_get_default_hero_desc_text() {

	return __( 'Get instant free access to my weekly newsletter where I share my best tips about online marketing, personal branding, and entrepreneurship.', 'authority-pro' );

}

/**
 * Gets default hero caption text.
 *
 * @since 1.0.0
 *
 * @return string Text to use as a caption for the portrait image.
 */
function authority_get_default_hero_caption_text() {

	return __( 'Kelly Taylor, Entrepreuner', 'authority-pro' );

}

/**
 * Gets default logos header text.
 *
 * @since 1.0.0
 *
 * @return string Text to use as a header for the hero logo images.
 */
function authority_get_default_hero_logo_heading() {

	return __( 'As Featured In:', 'authority-pro' );

}

/**
 * Gets the default image URL for the hero section.
 *
 * @since 1.0.0
 *
 * @return string Image URL for the image tag.
 */
function authority_get_default_portrait_image() {

	return get_stylesheet_directory_uri() . '/images/home-hero.jpg';

}

/**
 * Calculates if white or black would contrast more with the provided color.
 *
 * @since 1.0.0
 *
 * @param string $color A color in hex format.
 * @return string The hex code for the most contrasting color: black or white.
 */
function authority_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#000000' : '#ffffff';

}

/**
 * Generate a lighter or darker color from a starting color.
 * Used to generate complementary hover tints from user-chosen colors.
 *
 * @since 1.0.0
 *
 * @param string $color A color in hex format.
 * @param string $op The operation to apply: '+' for lighter, '-' for darker.
 * @param int    $change The amount to reduce or increase brightness by.
 * @return string Hex code for the adjusted color brightness.
 */
function authority_color_brightness( $color, $op, $change ) {

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

	$newhex  = '#';
	$newhex .= strlen( dechex( $red ) ) === 1 ? '0' . dechex( $red ) : dechex( $red );
	$newhex .= strlen( dechex( $green ) ) === 1 ? '0' . dechex( $green ) : dechex( $green );
	$newhex .= strlen( dechex( $blue ) ) === 1 ? '0' . dechex( $blue ) : dechex( $blue );

	// Forces darken if brighten color is the same as color inputted.
	if ( $newhex === $hexcolor && '+' === $op ) {
		$newhex = '#111111';
	}

	return $newhex;

}
