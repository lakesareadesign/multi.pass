<?php
/**
 * Authority Pro.
 *
 * This file adds the pricing page template to the Authority Pro Theme.
 *
 * Template Name: Pricing
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */

add_filter( 'body_class', 'authority_add_body_class' );
/**
 * Adds the pricing page body class to the head.
 *
 * @since 1.0.0
 *
 * @param array $classes Current list of classes.
 * @return array New classes.
 */
function authority_add_body_class( $classes ) {

	$classes[] = 'pricing-page';

	return $classes;

}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Run the Genesis loop.
genesis();
