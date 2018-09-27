<?php
/**
 * Breakthrough Pro
 *
 * This file handles the logic and templating for outputting the Hero Section on the Front Page in the Breakthrough Pro Theme.
 *
 * @package Breakthrough_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/breakthrough
 */

// Sets up hero section content.
$title       = get_theme_mod( 'breakthrough_hero_title_text', breakthrough_get_default_hero_title_text() );
$button_text = get_theme_mod( 'breakthrough_hero_button_text', breakthrough_get_default_hero_button_text() );
$button_url  = get_theme_mod( 'breakthrough_hero_button_url', '#' );
$hero_image  = get_theme_mod( 'breakthrough_front_page_image_1', breakthrough_get_default_front_page_image_1() );
$hero        = get_theme_mod( 'breakthrough_show_hero_section', true );

if ( $hero ) {

	if ( $title || is_active_sidebar( 'hero-section' ) ) {

		// Opens the hero-section markup.
		genesis_markup(
			array(
				'open'    => '<div %s><div class="wrap">',
				'context' => 'hero-section',
			)
		);

		if ( $title ) {
				echo '<h2 class="hero-title">' . $title . '</h2>';
		}

		if ( $button_text ) {
				echo '<a href="' . $button_url . '" class="button button-hero">' . $button_text . '</a>';
		}

		$front_page_image_1 = get_theme_mod( 'breakthrough_front_page_image_1', breakthrough_get_default_front_page_image_1() );

		if ( $front_page_image_1 ) {
			$image_id  = attachment_url_to_postid( $front_page_image_1 );
			$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			echo '<div class="full-width-image"><img src="' . $front_page_image_1 . '" alt="' . $image_alt . '" /></div>';
		}

		// Closes the hero-section markup.
		genesis_markup(
			array(
				'close'   => '</div></div>',
				'context' => 'hero-section',
			)
		);

	}
}
