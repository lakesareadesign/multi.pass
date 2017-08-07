<?php
/*
 * 	Template Part - Tagline with Website URL
 *
 *	The template used to display the combined tagline
 *	and website using bne_testimonials_get_template( $part, $atts ). 
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

// Tagline
$tagline = get_post_meta( get_the_id(), 'tagline', true );

// Website
$website = esc_url( get_post_meta( get_the_id(), 'website-url', true ) );


$output = '';

// If Both Tagline and Website
if( ( 'true' == $atts['tagline'] && 'true' == $atts['website'] ) && ( $tagline && $website ) ) {
	$output .= '<span class="testimonial-website"><a href="'.$website.'" target="_blank" title="'.$tagline.'" rel="nofollow">'.$tagline.'</a></span>';

// Tagline Only
} elseif( 'true' == $atts['tagline'] && $tagline ) {
	$output .= '<span class="testimonial-tagline">'.$tagline.'</span>';

// Website URL only
} elseif( 'true' == $atts['website'] && $website ) {
	$output .= '<span class="testimonial-website"><a href="'.$website.'" target="_blank" rel="nofollow">'.$website.'</a></span>';
}

return apply_filters( 'bne_testimonials_tagline_and_website', $output, $atts );