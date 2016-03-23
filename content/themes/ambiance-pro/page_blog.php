<?php

//* Template Name: Blog

//* Reposition the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'genesis_do_post_title', 13 );

//* Add Ambiance grid body class
add_filter( 'body_class', 'ambiance_grid_body_class' );
function ambiance_grid_body_class( $classes ) {

	$classes[] = 'ambiance-grid';
	return $classes;

}

//* Customize the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'ambiance_post_info', 12 );
function ambiance_post_info() {

	echo '<p class="entry-meta">' . do_shortcode( '[post_date]' ) . '</p>';
	
}

//* Remove entry content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//* Remove entry meta in entry footer
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Remove page navigation
remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav', 12 );

//* Run the Genesis loop
genesis();
