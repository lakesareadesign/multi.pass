<?php
/*
 *	Local strings
 *
 * 	@author		Kerry Kline
 * 	@link		http://www.bnecreative.com
 *	@package	BNE Testimonials
 *
*/

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



/*
 * 	Setup user-read text strings. This function allows
 * 	to have all of the plugin's common localized text
 * 	strings in once place.
 *
 * 	@since 		v1.7.1
 * 	@updated 	v2.0
 *
*/
function bne_testimonials_setup_locals ( ) {
		
	$locals = array (

		// CPT Admin
		'cpt_post_title'			=> 	__( 'Enter the person\'s name here', 'bne-testimonials' ),
		'cpt_thumb_title'			=> 	__( 'Set Testimonial Thumbnail', 'bne-testimonials' ),
		'cpt_thumb_description'		=> 	__( 'Add an optional featured image for this testimonial.', 'bne-testimonials' ),
		'cpt_details_title'			=> 	__( 'Testimonial Details', 'bne-testimonials' ),
		
		// Tagline
		'cpt_tagline_title'			=>	__( 'Tagline', 'bne-testimonials' ),
		'cpt_tagline_description'	=>	__( 'Enter a tagline or company name of this testimonial. This field is also used as the website anchor text if a url is entered below. Example: "Owner of Cat\'s Town" or "Best Delivery Service in Town".', 'bne-testimonials' ),
		
		// Website
		'cpt_website_title'			=>	__( 'Website URL', 'bne-testimonials' ),
		'cpt_website_description'	=>	__( 'Enter a URL that applies to this testimonial.', 'bne-testimonials' ),
	);

	// Return with framework's filter applied
	return apply_filters( 'bne_testimonials_setup_locals', $locals );
}





/*
 * Return user read text string.
 *
 * @since 1.7.1
 *
 * @param string $id Key for $locals array
 * @return string $text Localized and filtered text string
*/
function bne_testimonials_get_local( $id ) {

	$text = null;
	$locals = bne_testimonials_setup_locals();

	// Set text string
	if ( isset( $locals[$id] ) ) {
		$text = $locals[$id];
	}

	return $text;
}