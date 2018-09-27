<?php
/**
 * Breakthrough Pro.
 *
 * This defines the helper functions for use in the Breakthrough Pro Theme.
 *
 * @package Breakthrough_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/breakthrough/
 */

/**
 * Gets the default link color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for link color.
 */
function breakthrough_customizer_get_primary_color() {

	return '#4a4f9b';

}

/**
 * Gets the default accent color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function breakthrough_customizer_get_secondary_color() {

	return '#d2414b';

}

/**
 * Get the default image for the header section.
 *
 * @return string header image for the top of pages
 *
 * @since 1.0.0
 */
function breakthrough_get_default_page_header_image() {

	$default_image_url = get_theme_mod( 'breakthrough_default_image', breakthrough_get_default_front_page_image_1() );
	$image_id          = attachment_url_to_postid( $default_image_url );
	$image_alt         = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

	return '<img src="' . $default_image_url . '" alt="' . $image_alt . '" class="breakthrough-single-image post-image" />';

}

/**
 * Get the the hero title.
 *
 * @return string hero title text
 *
 * @since 1.0.0
 */
function breakthrough_get_default_hero_title_text() {

	return 'Break through the noise in the market.';

}

/**
 * Get the default button text for the hero section.
 *
 * @return string hero button text
 *
 * @since 1.0.0
 */
function breakthrough_get_default_hero_button_text() {

	return 'See our case studies';

}

/**
 * Get the default image for the front-page-1 section.
 *
 * @return string front-page-1 image for the front-page hero
 *
 * @since 1.0.0
 */
function breakthrough_get_default_front_page_image_1() {

	return get_stylesheet_directory_uri() . '/images/default.jpg';

}

/**
 * Get the default image for the front-page-2 section.
 *
 * @return string front-page-2 image for the front-page-2 section
 *
 * @since 1.0.0
 */
function breakthrough_get_default_front_page_image_2() {

	return get_stylesheet_directory_uri() . '/images/front_page_2.jpg';

}

/**
 * Get the default image for the front-page-3 section.
 *
 * @return string front-page-3 image for the front-page-3 section
 *
 * @since 1.0.0
 */
function breakthrough_get_default_front_page_image_3() {

	return get_stylesheet_directory_uri() . '/images/front_page_3.jpg';

}

/**
 * Get the default image for the footer section.
 *
 * @return string footer image for the bottom of pages
 *
 * @since 1.0.0
 */
function breakthrough_get_default_page_footer_image() {

	return get_stylesheet_directory_uri() . '/images/footer_default.jpg';

}

/**
 * Gets default post image settings for Customizer.
 *
 * @since 1.0.0
 *
 * @return int 1 for true to show the image.
 */
function breakthrough_customizer_get_default_post_image_setting() {

	return 1;

}

/**
 * Gets default page image settings for Customizer.
 *
 * @since 1.0.0
 *
 * @return int 1 for true to show the image.
 */
function breakthrough_customizer_get_default_page_image_setting() {

	return 1;

}

/**
 * Gets default portfolio entry image settings for Customizer.
 *
 * @since 1.0.0
 *
 * @return int 1 for true to show the image.
 */
function breakthrough_customizer_get_default_portfolio_image_setting() {

	return 1;

}

/**
 * Gets default color overlay setting for Customizer.
 *
 * @since 1.0.0
 *
 * @return int 1 for true to show the overlay.
 */
function breakthrough_customizer_get_default_color_overlay_setting() {

	return 1;

}

/**
 * Calculates if white or black would contrast more with the provided color.
 *
 * @since 1.0.0
 *
 * @param string $color A color in hex format.
 * @return string The hex code for the most contrasting color: dark grey or white.
 */
function breakthrough_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#000000' : '#ffffff';

}

/**
 * Generates a lighter or darker color from a starting color.
 * Used to generate complementary hover tints from user-chosen colors.
 *
 * @since 1.0.0
 *
 * @param string $color A color in hex format.
 * @param int    $change The amount to reduce or increase brightness by.
 * @return string Hex code for the adjusted color brightness.
 */
function breakthrough_color_brightness( $color, $change ) {

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
 * Convert hex to RGBA
 * Used to generate complementary drop shadows
 *
 * @since 1.0.0
 *
 * @param string $color A color in hex format.
 * @param int    $alpha The amount to reduce or increase brightness by.
 * @param bool   $array Whether to return an array. Used in images.php.
 * @return string|array RGBA code for the adjusted color brightness.
 */
function breakthrough_color_rgba( $color, $alpha, $array = false ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	if ( $array ) {
		return array(
			'r' => $red,
			'g' => $green,
			'b' => $blue,
			'a' => $alpha,
		);
	}

	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';

}

add_filter( 'body_class', 'breakthrough_half_width_entry_class' );
/**
 * Defines the half width entries body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Current classes.
 * @return array $classes Updated class array.
 */
function breakthrough_half_width_entry_class( $classes ) {

	$site_layout = genesis_site_layout();

	if ( 'full-width-content' === $site_layout && ( is_home() || is_category() || is_tag() || is_author() || is_search() || genesis_is_blog_template() ) ) {
		$classes[] = 'half-width-entries';
	}

	return $classes;

}

add_filter( 'genesis_attr_entry', 'breakthrough_entry_class', 10, 3 );
/**
 * Adds alignment post class.
 *
 * @since 1.0.0
 *
 * @param array $attributes Existing attributes for entry element.
 * @param array $context The widget.
 * @param array $args The attribute arguments.
 * @return array Amended attributes for entry element.
 */
function breakthrough_entry_class( $attributes, $context, $args ) {

	$alignment = genesis_get_option( 'image_alignment' );
	$thumbnail = genesis_get_option( 'content_archive_thumbnail' );
	$size      = genesis_get_option( 'image_size' );

	if ( ! empty( $alignment ) && ! empty( $thumbnail ) && ! isset( $args['params']['is_widget'] ) && ( is_home() || is_category() || is_tag() || is_author() || is_search() || genesis_is_blog_template() ) ) {
		$attributes['class'] = $attributes['class'] . ' entry-image-' . $alignment . '';
	}

	if ( ! empty( $size ) && ! empty( $thumbnail ) && ! isset( $args['params']['is_widget'] ) && ( is_home() || is_category() || is_tag() || is_author() || is_search() || genesis_is_blog_template() ) ) {
		$attributes['class'] = $attributes['class'] . ' entry-image-' . $size . '';
	}

	return $attributes;

}

/**
 * Check if post has a thumbnail or fallback thumbnail.
 *
 * Like `has_post_thumbnail()` but returns true if the post has a featured
 * image or an attached image, mirroring the behavior of `genesis_get_image()`.
 *
 * @since 1.0.0
 *
 * @param int    $post_id Optional. The post ID.
 * @param string $size Optional. The thumbnail size.
 * @return bool Whether the post has an image attached.
 */
function breakthrough_has_post_thumbnail( $post_id = null, $size = 'full' ) {

	if ( is_404() ) {
		return false;
	}

	$featured_image_url = genesis_get_image(
		array(
			'post_id' => $post_id,
			'format'  => 'url',
			'size'    => $size,
		)
	);

	return (bool) $featured_image_url;

}

/**
 * Get post thumbnail ID or fallback image ID.
 *
 * Like `get_post_thumbnail_id()` but returns the ID of the first-attached
 * image if the post has no featured image, mirroring the behavior of
 * `genesis_get_image()`.
 *
 * @since 1.0.0
 *
 * @param int $post_id Optional. The post ID.
 * @return int|string The thumbnail ID or an empty string.
 */
function breakthrough_get_post_thumbnail_id( $post_id = null ) {

	if ( is_404() ) {
		return '';
	}

	$featured_image_url = genesis_get_image(
		array(
			'post_id' => $post_id,
			'format'  => 'url',
		)
	);

	if ( $featured_image_url ) {
		return attachment_url_to_postid( $featured_image_url );
	}

	return '';

}
