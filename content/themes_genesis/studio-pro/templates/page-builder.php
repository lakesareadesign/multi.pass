<?php
/**
 * Template Name: Page Builder
 *
 * This file adds the page builder template to the Studio Pro
 * theme. It removes everything in between the header and footer
 * leaving a blank template perfect for page builder plugins.
 *
 * @package      Studio Pro
 * @link         https://seothemes.com/themes/studio-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Remove hero section.
remove_action( 'genesis_after_header', 'studio_hero', 99 );

// Remove before footer widget area.
remove_action( 'genesis_before_footer', 'studio_before_footer_widget_area', 5 );

// Get site-header.
get_header();

// Custom loop, remove all hooks except entry content.
if ( have_posts() ) :

	while ( have_posts() ) : the_post();

		do_action( 'genesis_entry_content' );

	endwhile; // End of post.

endif; // End loop.

// Get site-footer.
get_footer();
