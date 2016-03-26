<?php
/**
 * This file adds the Landing page template to the Showcase Pro Theme.
 *
 * @author JT Grauke
 * @package Showcase Pro Theme
 * @subpackage Customizations
 */

/*
Template Name: Full Width
*/

//* Force full-width-content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Add full-width body class to the head
add_filter( 'body_class', 'showcase_add_body_class' );
function showcase_add_body_class( $classes ) {

	$classes[] = 'full-width';
	return $classes;

}

//* Run the Genesis loop
genesis();
