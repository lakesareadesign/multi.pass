<?php
/*
 * 	Template Part - Single
 *
 *	The template used to display the single structure using 
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
	


/*
 *	Devs - Before Single Testimonial Filter
 *
 *	Allow devs to extend content before the single testimonial.
 *
*/
$output = apply_filters( 'bne_testimonials_single_before', '' );


// Author
$output .= '<div class="testimonial-author">';
	$output .= bne_testimonials_get_template( 'image', $atts );
	$output .= bne_testimonials_get_template( 'name', $atts );
	$output .= bne_testimonials_get_template( 'tagline-website', $atts );
$output .= '</div>';

// Message
$output .= '<div class="testimonial-content">';
	$output .= bne_testimonials_get_template( 'message', $atts );
$output .= '</div>';



/*
 *	Devs - After Single Testimonial Filter
 *
 *	Allow devs to extend content after the single testimonial.
 *
*/
$output .= apply_filters( 'bne_testimonials_single_after', '' );


return $output;