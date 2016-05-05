<?php

/*
 * 	BNE Testimonials Wordpress Plugin
 *	Shortcode List Function
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2013-2015, Kerry Kline
 * 	@link		http://www.bnecreative.com
 *
 *	@updated: February 7, 2015
*/



/* ===========================================================
 *	Shortcode to display Testimonials as a Post List
 *	Example: [bne_testimonials_list]
 *	Accepts param: post, image, name, image_style, class, lightbox_rel
 * ======================================================== */

function bne_testimonials_list_shortcode( $atts ) {

	extract(shortcode_atts(array(
		'post' 				=> '-1',		// Number of post
		'order' 			=> 'date',		// Display Post Order (date / rand / title)
		'order_direction'	=> 'DESC',		// Display the order ascending or descending
		'name' 				=> 'true',		// Post Title
		'image' 			=> 'true',		// Featured Image
		'image_style' 		=> 'square',	// Profile image styles ( circle / square / flat-circle / flat-square )
		'category' 			=> '',			// Category (Taxonomy)
		'class'				=> '',			// Add Custom Class
		'lightbox_rel'		=> ''			// Allows the use of a lightbox rel command on the featured image.
	),$atts));

	$query_args = array(
		'post_type' 		=> 'bne_testimonials',
		'order'				=> $order_direction,
		'orderby' 			=> $order,
		'posts_per_page'	=> $post,
		'taxonomy' 			=> 'bne-testimonials-taxonomy',
		'term' 				=> $category
	);


	// Setup the Query
	$bne_testimonials = new WP_Query( $query_args );
	if( $bne_testimonials->have_posts() ) {

		// BNE Element Wrapper
		$output = '<div class="bne-element-container '.$class.'">';

			// Above List Filter
			$output .= apply_filters('bne_testimonials_list_above', '');

			// Testimonial Wrapper
			$output .= '<div class="bne-testimonial-list-wrapper">';

				// The Loop
				while ( $bne_testimonials->have_posts() ) : $bne_testimonials->the_post();

					// Pull in Plugin Options
					$options = bne_testimonials_options_array( $image_style, $lightbox_rel, $image, $name );

					// Build Single Testimonial
					$output .= '<div class="single-bne-testimonial">';

						// Above Single List Filter
						$output .= apply_filters('bne_testimonials_list_single_above', '');

						// Single Testimonial Setup Function
						$output .= bne_testimonials_single_structure( $options );

						// Below Single List Filter
						$output .= apply_filters('bne_testimonials_list_single_below', '');

						$output .= '<div class="clear"></div>';

					$output .= '</div><!-- .single-bne-testimonial (end) -->';

				endwhile;
				// END Loop

			$output .= '</div><!-- .bne-testimonial-list-wrapper (end) -->';

			// Below List Filter
			$output .= apply_filters('bne_testimonials_list_below', '');

		$output .= '</div><!-- .bne-element-container (end) -->';
		$output .= '<div class="clear"></div>';

	// If No Testimonials, display warning message
	} else {
		$output = '<div class="bne-testimonial-warning">No testimonials were found.</div>';
	}

	wp_reset_postdata();
	return $output;

}
add_shortcode( 'bne_testimonials_list', 'bne_testimonials_list_shortcode' );