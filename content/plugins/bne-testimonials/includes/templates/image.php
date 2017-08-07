<?php
/*
 * 	Template Part - Image
 *
 *	The template used to display the image using 
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


if( 'true' == $atts['image'] ) {
	
	return get_the_post_thumbnail( 
		get_the_id(),
		$atts['image_size'], 
		array( 
			'class' => 'testimonial-image testimonial-'.$atts['image_style'].' testimonial-crop-'.$atts['image_size'],
			'alt' => the_title_attribute( 'echo=0' )
		)
	);

}