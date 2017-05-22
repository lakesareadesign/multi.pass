<?php
/**
 * Slush Pro.
 *
 * This file adds the gallery post format template to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

global $post;

echo '<div class="media_container">';
	echo zp_gallery( $post->ID, 'blog_gallery', 'zp_post_gallery' );
echo '</div>';

echo '<div class="content_container">';
	do_action( 'genesis_entry_header' );
	do_action( 'genesis_before_entry_content' );
	printf( '<div %s>', genesis_attr( 'entry-content' ) );
		do_action( 'genesis_entry_content' );
	echo '</div>'; // Ends .entry-content.
	do_action( 'genesis_after_entry_content' );
	do_action( 'genesis_entry_footer' );
echo '</div>';
