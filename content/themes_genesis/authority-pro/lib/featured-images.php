<?php
/**
 * Authority Pro
 *
 * This file handles the logic for outputting the featured images in the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

// Adds class for featured images.
add_filter( 'body_class', 'authority_add_featured_image_class' );

// Removes the default post image.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );

// Filters the archive image markup.
add_filter( 'genesis_markup_entry-image-link_open', 'authority_custom_archive_image_open' );
add_filter( 'genesis_markup_entry-image-link_close', 'authority_custom_archive_image_close' );

add_action( 'genesis_before_content_sidebar_wrap', 'authority_featured_image', 1 );
/**
 * Adds featured image above the entry content.
 *
 * @since 1.0.0
 */
function authority_featured_image() {

	$add_single_image = get_theme_mod( 'authority_single_image_setting', authority_customizer_get_default_image_setting() );

	$image = genesis_get_image(
		array(
			'format'  => 'html',
			'size'    => 'single-featured-image',
			'context' => '',
			'attr'    => array(
				'alt'   => the_title_attribute( 'echo=0' ),
				'class' => 'authority-single-image',
			),
		)
	);

	if ( $add_single_image && $image && is_singular( 'post' ) ) {
		printf( '<div class="authority-featured-image">%s</div>', $image );
	}

}

/**
 * Outputs a featured-image class to the body tag.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes array.
 * @return array $classes Updated class array.
 */
function authority_add_featured_image_class( $classes ) {

	$add_single_image = get_theme_mod( 'authority_single_image_setting', authority_customizer_get_default_image_setting() );

	if ( $add_single_image && is_singular( 'post' ) && genesis_get_image() ) {
		$classes[] = 'has-featured-image';
	}

	if ( is_page_template( 'page_blog.php' ) || is_archive() || is_home() ) {
		$classes[] = 'has-featured-images';
	}

	return $classes;

}

/**
 * Opens image wrapper.
 *
 * @since 1.0.0
 *
 * @param string $open_html The opening HTML for the image link.
 * @return string The complete opening HTML.
 */
function authority_custom_archive_image_open( $open_html ) {

	$alignment = genesis_get_option( 'image_alignment' );

	if ( ! empty( $alignment ) ) {
		return '<div class="authority-featured-image authority-image-' . $alignment . '">' . $open_html;
	}

	return '<div class="authority-featured-image">' . $open_html;

}

/**
 * Closes image wrapper.
 *
 * @since 1.0.0
 *
 * @param string $close_html The closing HTML for the image link.
 * @return string The complete closing HTML.
 */
function authority_custom_archive_image_close( $close_html ) {

	return $close_html . '</div>';

}

/**
 * Gets default post image settings for Customizer.
 *
 * @since 1.0.0
 *
 * @return int 1 for true, in order to show the image.
 */
function authority_customizer_get_default_image_setting() {

	return 1;

}
