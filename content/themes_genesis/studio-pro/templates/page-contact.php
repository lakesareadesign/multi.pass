<?php
/**
 * Template Name: Contact Page
 *
 * This file adds the contact page template to the Studio Pro
 * theme.
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

/**
 * Display full width Google Map.
 */
function studio_map_shortcode() {
	if ( shortcode_exists( 'ank_google_map' ) ) {
		echo do_shortcode( '[ank_google_map]' );
	}
}
add_action( 'genesis_before_footer', 'studio_map_shortcode', 0 );

// Get site-header.
genesis();
