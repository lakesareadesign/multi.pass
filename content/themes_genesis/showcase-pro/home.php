<?php
/**
 * Showcase Pro
 *
 * This file edits the posts page template in the Showcase Pro Theme.
 *
 * @package Showcase
 * @author  Bloom
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/showcase/
 */


// Add the with-page-header class
add_filter( 'body_class', 'showcase_home_page_header_body_class' );
function showcase_home_page_header_body_class( $classes ) {

    $posts_page_id = get_option('page_for_posts');
    
    if( has_post_thumbnail($posts_page_id) )
        $classes[] = 'with-page-header';

    return $classes;

}

// Add the Home Page Header
add_action( 'genesis_after_header', 'showcase_home_page_header', 8 );
function showcase_home_page_header() {
	$output = false;
    $posts_page_id = get_option('page_for_posts');
    $image = get_post_thumbnail_id( $posts_page_id );

    if( $image ) {

        // Remove the page title because we're going to add it later
        remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );

        // Remove the default page header
        remove_action( 'genesis_after_header', 'showcase_page_header', 8 );

        $image = wp_get_attachment_image_src( $image, 'showcase_hero' );
        $background_image_class = 'with-background-image';
        $title = get_the_title($posts_page_id);

        $output .= '<div class="page-header bg-primary with-background-image" style="background-image: url(' . $image[0] . ');"><div class="wrap">';
        $output .= '<div class="header-content"><h1>' . $title . '</h1></div>';
        $output .= '</div></div>';
    }

	if( $output )
		echo $output;
}

genesis();