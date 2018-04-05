<?php
/**
 * Kreativ Pro.
 *
 * This file adds the full width page template to the Kreativ Pro Theme.
 *
 * Template Name: Page Builder - Full Width
 *
 * @package Kreativ
 * @author  ThemeSquare
 * @license GPL-2.0+
 * @link    http://themesquare.com/themes/kreativ/
 */

// Add landing page body class to the head.
add_filter( 'body_class', 'kreativ_full_width_body_class' );
function kreativ_full_width_body_class( $classes ) {

	$classes[] = 'template-full-width';

	return $classes;

}

add_filter( 'genesis_attr_site-inner', 'kreativ_attributes_site_inner' );
/**
 * Add attributes for site-inner element.
 */
function kreativ_attributes_site_inner( $attributes ) {
	$attributes['role']     = 'main';
	$attributes['itemprop'] = 'mainContentOfPage';
	return $attributes;
}


// Display Header.
get_header();

// Display Content.
the_post();
the_content();

// Display Comments.
genesis_get_comments_template();

// Display Footer.
get_footer();
