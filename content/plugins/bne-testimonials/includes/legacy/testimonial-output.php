<?Php
/*
 *	Legacy Testimonial Output and Structures
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2017, Kerry Kline
 * 	@link		http://www.bnecreative.com
 * 	@package	BNE Testimonials
 *
 *	Prior to v2.0, Testimonials used a customizable filter set
 *	to output the data. This allowed devs to re-arrange and customize
 *	how the testimonials are displayed. With v2.0+ we have removed all
 *	of this in favor martching with the Pro version. To prevent confusion and
 *	disruption of customizations, we have moved these functions here
 *	and can only be called using the legacy shortcode variants and
 *	widgets.
 *
 *	Legacy Shortcodes using this structure:
 *	[bne_testimonials_list]
 *	[bne_testimonials_slider]
 *
 *
 *	Users should use the new Shortcode variants:
 *	[bne_testimonials display="list"]
 *	[bne_testimonials display="slider"]
 *
*/
	



/*
 *	Testimonial Options Array
 *	Pulls in all options into a single array to use throughout
 *
 *	@Note 	Prior to v2.0, this was inside the shortcodes
 *	@Note 	Options are called using $options['option_name']
 *
 *	@updated 	v2.0
 * 
*/
function bne_testimonials_options_array( $image_style, $lightbox_rel, $image, $name, $rating ) {
	$testimonial_id = get_the_ID();
	$thumbnail_id = get_post_thumbnail_id( $testimonial_id );
	$featured_image_class = 'bne-testimonial-featured-image '.$image_style;

	// Build Array
	$options = array(
		'testimonial_id'	=> 	$testimonial_id,
		'lightbox_rel' 		=> 	$lightbox_rel,
		'lightbox_url' 		=> 	wp_get_attachment_url( $thumbnail_id ),
		'lightbox_title' 	=> 	the_title_attribute( 'echo=0' ),
		'featured_image' 	=> 	get_the_post_thumbnail( $testimonial_id, 'thumbnail', array( 'class' => $featured_image_class, 'alt' => the_title_attribute( 'echo=0' ) ) ),
		'image' 			=> 	$image,
		'name' 				=> 	$name,
		'tagline'			=> 	sanitize_text_field( get_post_meta( $testimonial_id, 'tagline', true ) ),
		'website_url'		=> 	esc_url( get_post_meta( $testimonial_id, 'website-url', true ) ),
		'show_rating'		=>	$rating,
		'rating'			=>	get_post_meta( $testimonial_id, 'rating', true )
	);

	return $options;

}



/*
 *	Single Testimonial Structure
 *
 *	@since 		v1.6
 *	@updated 	v2.0
*/
function bne_testimonials_single_structure( $options ) {

	// Empty String
	$output = '';

	// Testimonial Thumbnail
	if ( $options['image'] != 'false' ) {
		$output .= bne_testimonials_featured_image( $options );
	}

	// Testimonial Title
	if ( $options['name'] != 'false' ) {
		$output .= bne_testimonials_title( $options );
	}

	// Testimonial Details
	if ( $options['tagline'] || $options['website_url'] || $options['show_rating'] ) {
		$output .= bne_testimonials_details( $options );
	}

	// Testimonial Content
	$output .= bne_testimonials_the_content( $options );

	return apply_filters( 'bne_testimonials_single_structure', $output, $options );
}




/*
 *	Testimonial Featured Image
 *
 *	@since 		v1.6
 *	@updated 	v2.0
*/
function bne_testimonials_featured_image( $options ) {

	// If Lightbox Rel is set, apply it to the featured image
	if ( $options['lightbox_rel'] ) {
		$output = '<a href="'.$options['lightbox_url'].'" class="'.$options['lightbox_rel'].'" rel="'.$options['lightbox_rel'].'" title="'.$options['lightbox_title'].'">';
			$output .= $options['featured_image'];
		$output .= '</a>';
	}

	// No Lightbox Rel is set, only display the featured image (normal)
	else {
		$output = $options['featured_image'];
	}

	return apply_filters( 'bne_testimonials_featured_image', $output, $options );
}



/*
 *	Testimonial Heading
 *
 *	@since	v1.6.0
*/
function bne_testimonials_title( $options ) {

	$output = '<h3 class="bne-testimonial-heading">'.get_the_title().'</h3>';

	return apply_filters( 'bne_testimonials_title', $output, $options );
}




/*
 *	Testimonial Details
 *
 *	@since		v1.6
 *	@updated	v2.0
*/
function bne_testimonials_details( $options ) {

	$output = '<div class="bne-testimonial-details">';

		// Tagline and Website URL
		if( $options['tagline'] && $options['website_url'] ) {
			$output .= '<span class="bne-testimonial-website-url"><a href="'.$options['website_url'].'" target="_blank" title="'.$options['tagline'].'">'.$options['tagline'].'</a></span>';

		// Tagline Only
		} elseif( $options['tagline'] ) {
			$output .= '<span class="bne-testimonial-tagline">'.$options['tagline'].'</span>';

		// Website URL only
		} elseif( $options['website_url'] ) {
			$output .= '<span class="bne-testimonial-website-url"><a href="'.$options['website_url'].'" target="_blank">'.$options['website_url'].'</a></span>';
		}
				
	$output .= '</div><!-- bne-testimonial-details (end) -->';

	return apply_filters( 'bne_testimonials_details', $output, $options );
}



/*
 *	Testimonial Content
 *
 *	@since 		v1.1
 *	@updated	v2.0
*/
function bne_testimonials_the_content( $options ) {

	// Format the Content
	$get_content = wpautop( do_shortcode( get_the_content() ) );

	$output = '<div class="bne-testimonial-description">'.$get_content.'</div>';

	return apply_filters( 'bne_testimonials_the_content', $output, $options );
}