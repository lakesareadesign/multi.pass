<?php
/*
 * Plugin Name: BNE Testimonials
 * Version: 1.7.3
 * Plugin URI: http://www.bnecreative.com/blog/new-testimonial-plugin-for-wordpress/
 * Description: Adds a Custom Post Type to display Testimonials on any page, post, or sidebar. Display the testimonials as a list or slider powered by Flexslider. Shortcodes: [bne_testimonials_list] & [bne_testimonials_slider]. Includes corresponding widget options.
 * Author: Kerry Kline
 * Author URI: http://www.bnecreative.com
 * Requires at least: 3.8
 * License: GPL2

    Copyright 2013-2015  BNE Creative

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/


// Exit if accessed directly
if ( !defined('ABSPATH') ) exit;



/* ===========================================================
 *	Plugin Constants and Localization
 * ======================================================== */

define( 'BNE_TESTIMONIALS_VERSION', '1.7.3' );
define( 'BNE_TESTIMONIALS_DIR', dirname( __FILE__ ) );
define( 'BNE_TESTIMONIALS_URI', plugins_url( '', __FILE__ ) );
define( 'BNE_TESTIMONIALS_BASENAME', plugin_basename( __FILE__ ) );


/*
 * 	Load plugin textdomain for localization
 *
 * 	@since 1.0.0
*/
function bne_testimonials_textdomain() {
  load_plugin_textdomain( 'bne-testimonials', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'bne_testimonials_textdomain' );




/* ===========================================================
 *	Plugin Includes
 * ======================================================== */


// CPT Settings and Admin Plugin Functions
include_once( BNE_TESTIMONIALS_DIR . '/includes/cpt.php' );

// Taxonomy
include_once( BNE_TESTIMONIALS_DIR . '/includes/taxonomy.php' );

// Shortcodes
include_once( BNE_TESTIMONIALS_DIR . '/includes/shortcode-list.php' );
include_once( BNE_TESTIMONIALS_DIR . '/includes/shortcode-slider.php' );

// Widgets
include_once( BNE_TESTIMONIALS_DIR . '/includes/widget-slider.php' );
include_once( BNE_TESTIMONIALS_DIR . '/includes/widget-list.php' );

// Admin Help Page
include_once( BNE_TESTIMONIALS_DIR . '/includes/help.php' );




/* ===========================================================
 *	Scripts and Styles
 * ======================================================== */


/*
 *	Register Plugin CSS and JS
 *	@since v1.5
 *	@updated Feb 7 2015
*/
function bne_testimonials_register_scripts() {

	// Register the CSS
	wp_register_style( 'bne-testimonial-styles', BNE_TESTIMONIALS_URI . '/assets/css/bne-testimonials.css', '', BNE_TESTIMONIALS_VERSION, 'all' );

	// Register the JS
	wp_register_script( 'flexslider', BNE_TESTIMONIALS_URI . '/assets/js/flexslider.min-v2.2.2.js', array('jquery'), '2.2.2', true );

	// Load the plugin CSS
	wp_enqueue_style( 'bne-testimonial-styles' );

}
add_action( 'wp_enqueue_scripts', 'bne_testimonials_register_scripts' );



/* ===========================================================
 *	Testimonial Output Functions
 * ======================================================== */



/*
 *	Testimonial Options Array
 *	Pulls in all options into a single array to use throughout
 *
 *	@since v1.7.0
*/
function bne_testimonials_options_array( $image_style, $lightbox_rel, $image, $name ) {

	$testimonial_id = get_the_ID();
	$thumbnail_id = get_post_thumbnail_id( $testimonial_id );
	$featured_image_class = 'bne-testimonial-featured-image '.$image_style;

	$options = array(
		'testimonial_id'	=> $testimonial_id,
		'lightbox_rel' 		=> $lightbox_rel,
		'lightbox_url' 		=> wp_get_attachment_url( $thumbnail_id ),
		'lightbox_title' 	=> the_title_attribute( 'echo=0' ),
		'featured_image' 	=> get_the_post_thumbnail( $testimonial_id, 'thumbnail', array( 'class' => $featured_image_class, 'alt' => " " ) ),
		'image' 			=> $image,
		'name' 				=> $name,
		'tagline'			=> sanitize_text_field( get_post_meta( $testimonial_id, 'tagline', true ) ),
		'website_url'		=> esc_url( get_post_meta( $testimonial_id, 'website-url', true ) )
	);

	return $options;

}




/*
 *	Testimonial Single Structure and Layout Order
 *
 *	$options - Pulls in Array Options
 *
 *	@since v1.6
 *	@updated Dec 27 2013
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

	// Testimonial Tagline and Website URL
	if ( $options['tagline'] || $options['website_url'] ) {
		$output .= bne_testimonials_details( $options );
	}

	// Testimonial Content
	$output .= bne_testimonials_the_content( $options );

	return apply_filters( 'bne_testimonials_single_structure', $output, $options );
}



/*
 *	Testimonial Featured Image
 *	$options - Pulls in Array Options
 *
 *	@since v1.6
 *	@updated Jan 7 2015
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
 *	Testimonial Title
 *	$options - Pulls in Array Options
 *
 *	@since v1.6
 *	@updated Dec 20 2013
*/
function bne_testimonials_title( $options ) {

	$output = '<h3 class="bne-testimonial-heading">'.get_the_title().'</h3>';

	return apply_filters( 'bne_testimonials_title', $output, $options );
}



/*
 *	Testimonial Tagline and Website URL Ouput
 *	$options - Pulls in Array Options
 *
 *	@since v1.6
 *	@updated Feb 7 2015
*/
function bne_testimonials_details( $options ) {

	$output = '<div class="bne-testimonial-details">';

		// Tagline/Company Name and Website URL
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
 *	@since 		v1.1.0
 *	@updated	v1.7.0
*/
function bne_testimonials_the_content( $options ) {

	// Format the Content
	$get_content = wpautop( do_shortcode( get_the_content() ) );

	$output = '<div class="bne-testimonial-description">'.$get_content.'</div>';

	return apply_filters( 'bne_testimonials_the_content', $output, $options );
}