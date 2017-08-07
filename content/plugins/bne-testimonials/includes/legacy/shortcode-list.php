<?php
/*
 * 	BNE Testimonials Wordpress Plugin
 *	Shortcode List
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2013-2017, Kerry Kline
 * 	@link		http://www.bnecreative.com
 *
 *	@since 		v1.0
 *	@updated	v2.0
 *
 *	@notice		As of v2.0. This shortcode is no longer maintained
 *				and is depreciated! It has been replaced with
 *				[bne_testimonials] which also displays the slider
 *				layout. Please use that shortcode instead.
 *
*/




/* ===========================================================
 *	Shortcode to display Testimonials as a Post List
 *	Example: [bne_testimonials_list]
 *	Accepts param: post, image, name, image_style, class, lightbox_rel
 * ======================================================== */
function bne_testimonials_list_shortcode( $atts ) {

	extract(shortcode_atts(array(
		'post' 				=> 	'-1',		// Number of post
		'order' 			=> 	'date',		// Display Post Order (date / rand / title)
		'order_direction'	=> 	'DESC',		// Display the order ascending or descending
		'name' 				=> 	'true',		// Post Title
		'image' 			=> 	'true',		// Featured Image
		'image_style' 		=> 	'square',	// Profile image styles ( circle / square / flat-circle / flat-square )
		'category' 			=> 	'',			// Category (Taxonomy)
		'lightbox_rel'		=> 	'',			// Allows the use of a lightbox rel command on the featured image.
		'class'				=> 	'',			// Add Custom Class
		'id'				=> 	''

	),$atts));

	$query_args = array(
		'post_type' 		=> 'bne_testimonials',
		'order'				=> $order_direction,
		'orderby' 			=> $order,
		'posts_per_page'	=> $post,
		'taxonomy' 			=> 'bne-testimonials-taxonomy',
		'term' 				=> $category,
		'page_id'			=> $id
	);


	// Setup the Query
	$bne_testimonials = new WP_Query( $query_args );
	if( $bne_testimonials->have_posts() ) {

		// BNE Element Wrapper
		$output = '<div class="bne-element-container '.$class.'">';

			// Above List Filter
			$output .= apply_filters('bne_testimonials_list_above', '');

			// Testimonial Wrapper
			$output .= '<div class="bne-testimonial-list-wrapper testimonials-v1x">';

				// The Loop
				while ( $bne_testimonials->have_posts() ) : $bne_testimonials->the_post();

					// Pull in Plugin Options
					$options = bne_testimonials_options_array( $image_style, $lightbox_rel, $image, $name, null );

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

			$output .= '<div class="clear"></div>';

		$output .= '</div><!-- .bne-element-container (end) -->';
		$output .= '<div class="clear"></div>';


	// If No Testimonials, display warning message
	} else {
		$output = '<div class="bne-testimonial-warning">'.__('No testimonials were found.', 'bne-testimonials').'</div>';
	}


	wp_reset_postdata();
	return $output;

}
add_shortcode( 'bne_testimonials_list', 'bne_testimonials_list_shortcode' );