<?php

/**
 * Post Header
 *
 */

$hide_hero = bbs_cf( 'bbs-hide-post-header' );

if ( $hide_hero == '' ) {
		add_action( 'genesis_after_header', 'bbs_single_post_header' );
}

function bbs_single_post_header() {

	if( has_post_thumbnail( ) ) {

		//* Remove the entry header markup (requires HTML5 theme support)
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

		//* Remove the entry title (requires HTML5 theme support)
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

		//* Remove the entry meta in the entry header (requires HTML5 theme support)
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

		//* Remove the post format image (requires HTML5 theme support)
		remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );

		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		echo '<div class="hero flexible-widget-area bg bg-scrim text-center" style="background-image: url(' . $image[0] . ');"><div class="wrap">';
		genesis_entry_header_markup_open();
	  	genesis_do_post_title();
		genesis_post_info();
		genesis_entry_header_markup_close();
		echo '</div></div>';
	}
}

genesis();
