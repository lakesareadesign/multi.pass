<?php
/*
 * 	Template Part - Website
 *
 *	The template used to display the website using 
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

if( 'true' == $atts['website'] ) {
	
	$website = esc_url( get_post_meta( get_the_id(), 'website-url', true ) );
	
	$output = '<span class="testimonial-website"><a href="'.$website.'" target="_blank" rel="nofollow">'.$website.'</a></span>';
	
	return apply_filters( 'bne_testimonials_website', $output, $atts );
}

