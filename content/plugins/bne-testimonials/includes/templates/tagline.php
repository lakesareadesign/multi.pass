<?php
/*
 * 	Template Part - Tagline
 *
 *	The template used to display the tagline using 
 *	bne_testimonials_get_template( $part, $atts ). 
 *
 * 	@author		Kerry Kline
 * 	@link		http://www.bnecreative.com
 *	@package	BNE Testimonials
 *
 *	$atts		Shortcode options and settings
 *	returns		$output back to the shortcode
 *
 *	@since 		v2.0
 *
*/

// Exit if accessed directly
if( !defined('ABSPATH') ) exit;

if( 'true' == $atts['tagline'] ) {
	
	$output = '<span class="testimonial-tagline">'.get_post_meta( get_the_id(), 'tagline', true ).'</span>';
	
	return apply_filters( 'bne_testimonials_tagline', $output, $atts );
}