<?php
/*
 *	Main Shortcode Display
 *
 * 	@author		Kerry Kline
 * 	@link		http://www.bnecreative.com
 *	@package	BNE Testimonials
 *	@since		v2.0
 *
*/

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



/*
 * 	Template Part
 *
 *	Returns the template part needed to display in the testimonial.
 *
 *	$part		string			The filename of the template part.
 *	$atts		string|array	Any needed attributes to pass.
 *	$return		string			Either return or echo the part.
 *	$wrapper	string			The wrapping container - div, h1, h3, h4, p, etc.
 *
 *	@since v2.0
 *
*/
function bne_testimonials_get_template( $part, $atts, $api = null, $return = 'return', $wrapper = null ) {
	return include( BNE_TESTIMONIALS_DIR . "/includes/templates/$part.php" );
}




/*
 *	Shortcode
 *	
 *	@since		v2.0
 *
*/
function bne_testimonials_shortcode( $atts ) {
	$atts = shortcode_atts( array(

		
		/*
		 *	Testimonial Query Arguments
		 *	These control what is pulled from the database.
		 *
		*/		
		'post'				=> 	'',				// (depreciated) (-1) Query this numer of testimonials. 
		'limit'				=>	'-1',			// (-1) Query this numer of testimonials. (replaces "post")
		'id'				=> 	'',				// ('') Query only this testimonial post ID.
		'category'			=>	'',				// ('') Query only this category of testimonials.
		'order'				=>	'desc',			// (desc) Direction of testimonials. Options: asc or desc
		'orderby'			=>	'date',			// (date) Order of testimonials. Options: name, date, rand, etc


		/*
		 *	Display Arguments
		 *	These control structure and style of the testimonials.
		 *
		*/		
		'layout'			=>	'list',			// (list) Options: list, slider
		'theme'				=>	'default',		// (default) Options: default, simple
		'image_style'		=>	'square',		// (square) Options: circle, square, flat-circle, flat-square
		'image_size'		=>	'thumbnail',	// (thumbnail) Options: Any WP crop sizes


		/*
		 *	Theme Content Arguments
		 *	These control what information is displayed within the testimonial.
		 *
		*/		
		'name'				=>	'true',			// (true) Show/Hide the testimonial name. Options: ture or false
		'image'				=>	'true',			// (true) Show/Hide the testimonial image. Options: ture or false
		'tagline'			=>	'true',			// (true) Show/Hide the testimonial tagline. Options: ture or false
		'website'			=>	'true',			// (true) Show/Hide the testimonial website. Options: ture or false


		/*
		 *	Slider Layout Only Arguments
		 *	These control how slider is displayed
		 *
		*/
		'nav' 				=>	'true',			// (true) Flexslider: controlNav
		'arrows' 			=>	'true',			// (true) Flexslider: directionNav
		'pause' 			=>	'true',			// (true) Flexslider: pauseOnHover
		'animation' 		=>	'slide',		// (slide) Flexslider: animation
		'animation_speed'	=>	'700',			// (700) Flexslider: animationSpeed
		'smooth' 			=>	'true',			// (true) Flexslider: smoothHeight
		'speed'				=>	'7000',			// (7000) Flexsliser: slideshowSpeed

		/*
		 *	Other Arguments
		 *
		*/
		'class'				=>	'',				// ('') Adds custom css classnames to the testimonial wrapper.


	), $atts, 'bne_testimonials' );



	// Taxonomy Query Args
	$taxonomy_args = null;
	if( $atts['category'] ) {
		$taxonomy_args = array(
	        array(
	            'taxonomy' 	=> 	'bne-testimonials-taxonomy',
	            'field' 	=> 	'slug',
	            'terms' 	=> 	explode( ',', esc_html( $atts['category'] ) )
	        )
	    );
	}
	
	// Backwards compatibility - Replaced "post" with "limit"
	if( $atts['post'] ) { $atts['limit'] = $atts['post']; }

	// Post Query Args
	$query_args = array(
		'post_type' 		=>	'bne_testimonials',
		'page_id'			=> 	$atts['id'],
		'order'				=> 	$atts['order'],
		'orderby' 			=> 	$atts['orderby'],
		'posts_per_page'	=> 	$atts['limit'],
		
		// Taxonomy Query
	    'tax_query' 		=> 	$taxonomy_args
	);
	

	
	// Single Testimonial Resets
	if( $atts['id'] ) { 
		$atts['layout'] = 'single';
	}
	

	// Begin the query
	$bne_testimonials_query = new WP_Query( $query_args );
	if( $bne_testimonials_query->have_posts() ) {

		$wrapper_id = rand(1,1000);
				
		// Category class
		$category = ($atts['category']) ? str_replace(',', '-', esc_html( $atts['category'] ) ) : 'all';
		$category = sanitize_title_with_dashes( $category );

		
		// Open Wrapper
		$output = '<div class="bne-testimonial-wrapper testimonial-wrapper-id-'.$wrapper_id.' testimonial-layout-'.$atts['layout'].' testimonial-theme-'.$atts['theme'].' testimonial-left testimonial-arrangement-1 testimonial-category-'.$category.' '.$atts['class'].' clearfix">';

				
				/*
				 *	Devs - Before Testimonial Filter
				 *
				 *	Allow devs to extend content before the testimonial.
				 *
				*/
				$output .= apply_filters( 'bne_testimonials_before', '' );



				/*
				 *	Slider Layout
				 *
				 *	If using the slider layout, output the
				 *	necessary scripts and structure.
				 *
				*/
				if( 'slider' == $atts['layout'] ) {
					
					// Enqueue Flexslider script
					wp_enqueue_script( 'flexslider' );
					
					// Assign a random ID each slider instance
					$random_id = rand( 1,1000 );
			
					// Init Flexslider
					wp_add_inline_script( 'flexslider', 
						'jQuery(document).ready(function($){
							$(window).load(function() {
								$("#bne-slider-id-'.$random_id.' .bne-testimonial-slider").flexslider({
									animation: "'.$atts['animation'].'",
									animationSpeed: '.$atts['animation_speed'].',
									smoothHeight: '.$atts['smooth'].',
									pauseOnHover: '.$atts['pause'].',
									controlNav: '.$atts['nav'].',
									directionNav: '.$atts['arrows'].',
									slideshowSpeed: '.$atts['speed'].'
								});
							});
						});'
					);

					// Slider Wrapper
					$output .= '<div id="bne-slider-id-'.$random_id.'" class="bne-testimonial-slider-wrapper">';
						$output .= '<div class="slides-inner">';
							$output .= '<div class="bne-testimonial-slider bne-flexslider">';
								$output .= '<ul class="slides">';
					
									// Begin Testimonial Loop!
									while( $bne_testimonials_query->have_posts() ) : $bne_testimonials_query->the_post();
											
											$output .= '<li id="testimonial-id-'.get_the_ID().'" class="testimonial-single">';
												$output .='<div class="flex-content">';
													$output .= bne_testimonials_get_template( 'single', $atts );
													$output .= '<div class="clear"></div>';	
												$output .= '</div>';
											$output .= '</li>';										
									
									endwhile; // END the Loop!
							
								$output .= '</ul> <!-- .slides (end) -->';
							$output .= '</div> <!-- .bne-testimonial-slider (end) -->';
						$output .= '</div> <!-- .slides-inner (end) -->';
					$output .= '</div> <!-- .bne-testimonial-slider-wrapper (end) -->';
	
				}


				/*
				 *	List / Default Layout
				 *
				 *	If using the list layout or no layout, output the
				 *	necessary structure.
				 *
				*/
				else {
					
					// Begin Testimonial Loop!
					while( $bne_testimonials_query->have_posts() ) : $bne_testimonials_query->the_post();
						
						$output .= '<div id="testimonial-id-'.get_the_ID().'" class="testimonial-single clearfix">';
							$output .= bne_testimonials_get_template( 'single', $atts );	
							$output .= '<div class="clear"></div>';	
						$output .= '</div>';
					
					endwhile; // END the Loop!
				
				}


				/*
				 *	Devs - After Testimonial Filter
				 *
				 *	Allow devs to extend content after the testimonial.
				 *
				*/
				$output .= apply_filters( 'bne_testimonials_after', '' );


		// Close the wrapper!
		$output .= '</div><!-- .bne-testimonials-wrapper (end) -->';

	} else {
		$output = '<div class="bne-testimonial-warning">'.__('No testimonials were found.', 'bne-testimonials').'</div>';
	}

	// Reset Query and Return output
	wp_reset_postdata();
	return $output;
	
}
add_shortcode( 'bne_testimonials', 'bne_testimonials_shortcode' );