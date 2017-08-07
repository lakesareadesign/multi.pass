<?php
/*
 * 	Template Part - Name
 *
 *	The template used to display the name using 
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

if( 'true' == $atts['name'] ) {
	
	$output = '<span class="testimonial-name">'.get_the_title().'</span>';		
	
	return apply_filters( 'bne_testimonials_name', $output, $atts );
}