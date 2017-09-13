<?php
/**
 * Outfitter Pro.
 *
 * This file adds the page conditional body class to the Outfitter Pro Theme.
 *
 * @package Outfitter_Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/outfitter/
 */

add_filter( 'body_class', 'outfitter_setup_page_classes' );
/**
 * Conditionally add a class to control the content width.
 *
 * @param array $classes
 * @return array $classes
 *
 * @since 1.0.0
 */
function outfitter_setup_page_classes( $classes ) {

	$add_class = ( is_page_template( 'blog_page.php' ) || is_home() || is_front_page() ) ? false : true;

	if ( $add_class ) {
		$classes[] = 'full-width-narrow';
	}

	return $classes;

}

genesis();
