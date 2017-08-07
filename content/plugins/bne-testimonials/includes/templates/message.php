<?php
/*
 * 	Template Part - message
 *
 *	The template used to display the message using 
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

$output = '<div class="testimonial-message">'.wpautop( do_shortcode( get_the_content() ) ).'</div>';	

return apply_filters( 'bne_testimonials_content', $output, $atts );