<?php
/*
 * 	Legacy Shortcode Migration (Step 2 of 3)
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2018, Kerry Kline
 * 	@link		http://www.bnecreative.com
 *
 *	@since 		v2.8.2
 *
 *	@notice		As of v2.0 these shortcode are no longer maintained
 *				and are depreciated! they have been replaced with
 *				[bne_testimonials] which also displays the slider
 *				and masonry layouts. Please use that shortcode instead.
 *
 *	@note		This is the final step in depreciation. Legacy Shortcodes now
 *				convert to their new variants.
 *
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/* Legacy List Shortcode */
function bne_testimonials_list_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'post' 				=> 	'-1',		// Number of post
		'order' 			=> 	'date',		// Display Post Order (date / rand / title)
		'order_direction'	=> 	'DESC',		// Display the order ascending or descending
		'name' 				=> 	'true',		// Post Title
		'image' 			=> 	'true',		// Featured Image
		'image_style' 		=> 	'square',	// Profile image styles ( circle / square / flat-circle / flat-square )
		'category' 			=> 	'',			// Category (Taxonomy)
		'lightbox_rel'		=> 	'',			// Allows the use of a lightbox rel command on the featured image.
		'class'				=> 	'',			// Add Custom Class
		'id'				=> 	''

	), $atts, 'bne_testimonials_list' );

	$output = '';
	if( current_user_can('edit_pages') ) {
		$output .= '<div class="bne-testimonial-warning">Admin Notice (not public): This shortcode was depreciated on June 16, 2017 and will be removed in a future update. Please update this shortcode to use [bne_testimonials layout="list"].</div>';
	}

	$output .= '<!-- Legacy testimonial shortcode used and migrated to 2x -->';
	$output .= do_shortcode('[bne_testimonials layout="list" limit="'.$atts['post'].'" orderby="'.$atts['order'].'" order="'.$atts['order_direction'].'" name="'.$atts['name'].'" image="'.$atts['image'].'" image_style="'.$atts['image_style'].'" category="'.$atts['category'].'" class="'.$atts['class'].'" id="'.$atts['id'].'"]');
	
	return $output;
}
add_shortcode( 'bne_testimonials_list', 'bne_testimonials_list_shortcode' );


/* Legacy Slider Shortcode */
function bne_testimonials_slider_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'post' 				=> '-1',		// Number of post
		'order' 			=> 'date',		// Display Post Order (date / rand / title)
		'order_direction'	=> 'DESC',		// Display the order ascending or descending
		'category' 			=> '',			// The Testimonial Category
		'name' 				=> 'true',		// Post Title
		'image' 			=> 'true',		// Featured Image
		'image_style' 		=> 'square',	// Profile image styles ( circle / square / flat-circle / flat-square )
		'lightbox_rel'		=> '',			// Allows the use of a lightbox rel command on the featured image.
		'class'				=> '',			// Add Custom Class to this particular slider
		'nav' 				=> 'true',		// Flexslider: controlNav
		'arrows' 			=> 'true',		// Flexslider: directionNav
		'pause' 			=> 'true',		// Flexslider: pauseOnHover
		'animation' 		=> 'slide',		// Flexslider: animation
		'animation_speed'	=> '700',		// Flexslider: animationSpeed
		'smooth' 			=> 'true',		// Flexslider: smoothHeight
		'speed'				=> '7000'		// Flexsliser: slideshowSpeed
	), $atts, 'bne_testimonials_list' );

	$output = '';
	if( current_user_can('edit_pages') ) {
		$output .= '<div class="bne-testimonial-warning">Admin Notice (not public): This shortcode was depreciated on June 16, 2017 and will be removed in a future update. Please update this shortcode to use [bne_testimonials layout="slider"].</div>';
	}

	$output .= '<!-- Legacy testimonial shortcode used and migrated to 2x -->';
	$output .= do_shortcode('[bne_testimonials layout="slider" limit="'.$atts['post'].'" orderby="'.$atts['order'].'" order="'.$atts['order_direction'].'" name="'.$atts['name'].'" image="'.$atts['image'].'" image_style="'.$atts['image_style'].'" category="'.$atts['category'].'" class="'.$atts['class'].'" nav="'.$atts['nav'].'" arrows="'.$atts['arrows'].'" pause="'.$atts['pause'].'" animation="'.$atts['animation'].'" animation_speed="'.$atts['animation_speed'].'" smooth="'.$atts['smooth'].'" speed="'.$atts['speed'].'"]');
	return $output;
}
add_shortcode( 'bne_testimonials_slider', 'bne_testimonials_slider_shortcode' );