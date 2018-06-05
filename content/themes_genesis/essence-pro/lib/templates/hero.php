<?php
/**
 * Essence Pro
 *
 * This file handles the logic and templating for outputting the Hero Section on the Front Page in the Essence Pro Theme.
 *
 * @package Essence
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/essence/
 */

// Sets up hero section content.
$title       = get_theme_mod( 'essence-hero-title-text', essence_get_default_hero_title_text() );
$description = get_theme_mod( 'essence-hero-description-text', essence_get_default_hero_desc_text() );
$bg_image    = get_theme_mod( 'essence-hero-background-image', essence_get_default_hero_background_image() );
$hero        = get_theme_mod( 'essence-show-hero-section', true );

if ( $hero ) {

	if ( $title || $description || is_active_sidebar( 'hero-section' ) ) {

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

		if ( $description ) {
			echo '<p class="hero-description">' . $description . '</p>';
		}

		// Adds the hero-section widget area.
		if ( is_active_sidebar( 'hero-section' ) ) {
			genesis_widget_area(
				'hero-section', array(
					'before' => '<div class="hero-email">',
					'after'  => '</div>',
				)
			);
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
