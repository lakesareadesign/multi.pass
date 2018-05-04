<?php
/**
 * Authority Pro
 *
 * This file handles the logic and templating for outputting the Hero Section on the Front Page in the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

// Sets up portrait section data.
$title            = get_theme_mod( 'authority-hero-title-text', authority_get_default_hero_title_text() );
$description      = get_theme_mod( 'authority-hero-description-text', authority_get_default_hero_desc_text() );
$portrait_caption = get_theme_mod( 'authority-hero-caption-text', authority_get_default_hero_caption_text() );
$portrait_url     = get_theme_mod( 'authority-hero-portrait-image', authority_get_default_portrait_image() );
$portrait_id      = attachment_url_to_postid( $portrait_url );
$portrait_alt     = get_post_meta( $portrait_id, '_wp_attachment_image_alt', true );

// Sets up classes.
$classes = array(
	'columns' => '',
	'left'    => 'hero-section-column left',
	'right'   => 'hero-section-column right',
);

$hero_widget_active = is_active_sidebar( 'hero-section' );

if ( $portrait_url || $hero_widget_active ) {
	$classes['columns'] = 'has-columns';
	$classes['left']   .= ' one-half first';
	$classes['right']  .= ' one-half';
}

// Sets up logo section data.
$logo_header    = get_theme_mod( 'authority-hero-logo-heading', authority_get_default_hero_logo_heading() );
$logo_image_ids = get_theme_mod( 'authority-hero-logos-images', array() );

// Prepares logo data if images are set.
$logos = array();
if ( array_filter( $logo_image_ids ) ) {
	foreach ( $logo_image_ids as $id ) {
		$logos[ $id ]['src'] = wp_get_attachment_image_src( $id, 'full' );
		$logos[ $id ]['alt'] = get_post_meta( $id, '_wp_attachment_image_alt', true );
	}
}

echo '<div class="wrap hero-section ' . esc_attr( $classes['columns'] ) . '">';

if ( $title || $description || is_active_sidebar( 'hero-section' ) ) {

	echo '<div class="' . esc_attr( $classes['left'] ) . '">';

	if ( $title ) {
		echo '<h2 class="hero-title">' . $title . '</h2>';
	}

	if ( $description ) {
		echo '<p class="hero-description">' . $description . '</p>';
	}

	if ( $portrait_url ) {
		genesis_widget_area( 'hero-section', array(
			'before' => '<div class="hero-email">',
			'after'  => '</div>',
		) );
	}

	echo '</div>';

}

if ( $portrait_url ) {

	echo '<div class="' . esc_attr( $classes['right'] ) . '">
		<img class="hero-portrait" src="' . esc_url( $portrait_url ) . '" alt="' . $portrait_alt . '" />';

	if ( $portrait_caption ) {
		echo '<div class="hero-portrait-caption">' . $portrait_caption . '</div>';
	}

	echo '</div>';

} elseif ( $hero_widget_active ) {

	echo '<div class="' . esc_attr( $classes['right'] ) . '">';

	genesis_widget_area( 'hero-section', array(
		'before' => '<div class="hero-email">',
		'after'  => '</div>',
	) );

	echo '</div>';

}

if ( $logos ) {

	if ( $logo_header ) {
		echo '<div class="hero-logos-header">' . $logo_header . '</div>';
	}

	echo '<div class="hero-section-logos wrap">';

	foreach ( $logos as $logo ) {

		$logo_image = esc_url( $logo['src'][0] );
		$logo_alt   = esc_html( $logo['alt'] );

		if ( $logo_image ) {
			echo '<img class="hero-section-logo" src="' . $logo_image . '" alt="' . $logo_alt . '" />';
		}

	}

	echo '</div>';

}

echo '</div>';
