<?php
/**
 * Breakthrough Pro.
 *
 * Adjust featured images.
 *
 * @package Breakthrough_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/breakthrough/
 */

/**
 * Adds featured image to single posts, pages, and portfolio items.
 *
 * @since 1.0.0
 */
function breakthrough_featured_image() {

	$featured_image      = breakthrough_get_default_page_header_image();
	$add_post_image      = get_theme_mod( 'breakthrough_post_image_setting', breakthrough_customizer_get_default_post_image_setting() );
	$add_page_image      = get_theme_mod( 'breakthrough_page_image_setting', breakthrough_customizer_get_default_page_image_setting() );
	$add_portfolio_image = get_theme_mod( 'breakthrough_portfolio_image_setting', breakthrough_customizer_get_default_portfolio_image_setting() );

	if ( is_404() && ! $add_page_image ) {
		return;
	}

	if ( is_singular( 'post' ) && ! $add_post_image ) {
		return;
	}

	if ( is_singular( 'page' ) && ! $add_page_image ) {
		return;
	}

	if ( is_singular( 'portfolio' ) && ! $add_portfolio_image ) {
		return;
	}

	$image_id = breakthrough_get_post_thumbnail_id();

	if ( $image_id ) {
		$image_alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		$featured_image = genesis_get_image(
			array(
				'format'  => 'html',
				'size'    => 'header-image',
				'context' => '',
				'attr'    => array(
					'alt'   => $image_alt,
					'class' => 'breakthrough-single-image post-image',
				),
			)
		);
	}

	if ( $featured_image && ( is_singular( array( 'post', 'page', 'portfolio' ) ) || is_404() ) ) {
		echo '<div class="full-width-image">' . $featured_image . '</div>';
	}

}

/**
 * Adds featured image body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function breakthrough_has_featured_image( $classes ) {

	$add_post_image      = get_theme_mod( 'breakthrough_post_image_setting', breakthrough_customizer_get_default_post_image_setting() );
	$add_page_image      = get_theme_mod( 'breakthrough_page_image_setting', breakthrough_customizer_get_default_page_image_setting() );
	$add_portfolio_image = get_theme_mod( 'breakthrough_portfolio_image_setting', breakthrough_customizer_get_default_portfolio_image_setting() );
	$has_default_image   = get_theme_mod( 'breakthrough_default_image', breakthrough_get_default_front_page_image_1() );

	if ( ! breakthrough_has_post_thumbnail() && ! $has_default_image ) {
		return $classes;
	}

	if ( is_singular( 'post' ) && $add_post_image ) {
		$classes[] = 'has-featured-image';
	}

	if ( ( is_singular( 'page' ) || is_404() ) && $add_page_image ) {
		$classes[] = 'has-featured-image';
	}

	if ( is_singular( 'portfolio' ) && $add_portfolio_image ) {
		$classes[] = 'has-featured-image';
	}

	if ( is_page_template( 'page_blog.php' ) || is_archive() || is_home() ) {
		$classes[] = 'has-featured-images'; // Note plural for archives.
	}

	return $classes;

}

// Move post image above post title.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );


add_filter( 'theme_mod_breakthrough_front_page_image_1', 'breakthrough_use_header_image_thumbnail' );
add_filter( 'theme_mod_breakthrough_front_page_image_2', 'breakthrough_use_header_image_thumbnail' );
add_filter( 'theme_mod_breakthrough_front_page_image_3', 'breakthrough_use_header_image_thumbnail' );
add_filter( 'theme_mod_breakthrough_default_image', 'breakthrough_use_header_image_thumbnail' );
add_filter( 'theme_mod_breakthrough_footer_image', 'breakthrough_use_header_image_thumbnail' );
/**
 * Use the header-image thumbnail for all custom theme images.
 *
 * Causes get_theme_mod( 'breakthrough_front_page_image_x' ) to return the
 * header-image thumbnail URL instead of the full-size image URL.
 *
 * Returns the $image_url unaltered if a default image from the breakthrough-pro
 * theme folder is in use, or if no header-image thumbnail exists.
 *
 * @param string $image_url The URL of the theme image.
 * @return string The header-image thumbnail URL of the theme image, if set.
 */
function breakthrough_use_header_image_thumbnail( $image_url ) {

	$has_custom_image = strpos( $image_url, 'breakthrough-pro' ) === false;

	if ( $has_custom_image && $image_url ) {
		$image_id               = attachment_url_to_postid( $image_url );
		$header_image_thumbnail = wp_get_attachment_image_src( $image_id, 'header-image' );

		if ( is_array( $header_image_thumbnail ) ) {
			return $header_image_thumbnail[0];
		}
	}

	return $image_url;

}

add_filter( 'genesis_get_image', 'breakthrough_wrap_featured_images', 10, 2 );
add_filter( 'genesis_markup_entry-image-link_content', 'breakthrough_wrap_featured_images', 10, 2 );
/**
 * Adds a wrapper to featured images output by Genesis Featured Post,
 * Genesis Featured Page, and Genesis Portfolio widgets, as well as
 * entry image links such as those used on archives.
 *
 * The wrapper is used to target images to style with a CSS filter.
 *
 * @since 1.0.0
 *
 * @param string $output The original HTML image output.
 * @param array  $args The arguments passed to genesis_get_image.
 * @return string The new HTML output including the wrapper div.
 */
function breakthrough_wrap_featured_images( $output, $args ) {

	if ( strpos( $output, '<img' ) === false ) {
		return $output;
	}

	$is_archive_thumbnail   = 'entry-image-link' === $args['context'];
	$is_post_or_page_widget = in_array( $args['context'], array( 'featured-post-widget', 'featured-page-widget' ), true );

	if ( $is_archive_thumbnail || $is_post_or_page_widget ) {
		$output = sprintf( '<div class="breakthrough-featured-image">%s</div>', $output );
	}

	return $output;

}

add_action( 'wp_footer', 'breakthrough_image_color_filter' );
/**
 * Add an inline element to color images with a CSS filter.
 *
 * The CSS filter targets this element for .full-width-image img,
 * .breakthrough-featured-image img, and .portfolio-featured-image img in
 * style.css.
 *
 * Uses feColorMatrix to apply the tint using the chosen Color 1.
 *
 * @since 1.0.0
 *
 * @see https://alistapart.com/article/finessing-fecolormatrix
 */
function breakthrough_image_color_filter() {

	$add_image_overlay = get_theme_mod( 'breakthrough_color_overlay_setting', breakthrough_customizer_get_default_color_overlay_setting() );

	if ( ! $add_image_overlay ) {
		return;
	}

	$color1 = get_theme_mod( 'breakthrough_primary_color', breakthrough_customizer_get_primary_color() );
	$rgba   = breakthrough_color_rgba( $color1, .3, true );

	printf(
		'<svg aria-hidden="true" style="width: 0; height: 0; display:block;">
			<filter id="breakthrough-overlay">
				<feColorMatrix
				type="matrix"
				values="%1$f 0 0 0 0
					0 %2$f 0 0 0
					0 0 %3$f 0 0
					0 0 0 .9 0 "></feColorMatrix>
			</filter>
		</svg>',
		.3 + $rgba['r'] / 255,
		.3 + $rgba['g'] / 255,
		.3 + $rgba['b'] / 255
	);

}
