<?php
/**
 * This file adds the Custom Archives to the Elegance Theme.
 *
 * @package      Elegance
 * @link         http://stephaniehellwig.com/
 * @author       Stephanie Hellwig
 * @copyright    Copyright (c) 2016, Stephanie Hellwlig, Released 06/04/2016
 * @license      GPL-2.0+
 */

//* Adds a CSS class to the body element
add_filter( 'body_class', 'elegance_archives_body_class' );
function elegance_archives_body_class( $classes ) {

	$classes[] = 'posts-archive';
	return $classes;

}

//* Display as Columns
add_filter( 'post_class', 'elegance_grid_post_class' );
function elegance_grid_post_class( $classes ) {

	if ( is_main_query() ) { // conditional to ensure that column classes do not apply to Featured widgets
	
		$columns = 3; // Set the number of columns here

		$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
		$classes[] = $column_classes[$columns];
		global $wp_query;

		if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % $columns )
			$classes[] = 'first';

	}

	return $classes;

}

//* Remove the post image (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

//* Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//* Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

/** Force Content sidebar layout */
add_filter( 'genesis_pre_get_option_site_layout', 'elegance_do_layout' );
function elegance_do_layout( $opt ) {

    if ( is_archive() ) { // Modify the conditions to apply the layout to here
        $opt = 'content-sidebar'; // You can change this to any Genesis layout
        return $opt;
    }
    
}

//* Add the featured image before post title
add_action( 'genesis_entry_header', 'elegance_archive_grid', 9 );
function elegance_archive_grid() {

    if ( $image = genesis_get_image( 'format=url&size=blog-square-featured' ) ) {
        printf( '<div class="elegance-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );

    }

}

//* Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();