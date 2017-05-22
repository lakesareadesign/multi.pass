<?php
/**
 * Slush Pro.
 *
 * This file adds the image post format template to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

$content = get_the_content();
$title = get_the_title();
$permalink = get_permalink();
$image = genesis_get_image( array( 'format' => 'url', 'size' => genesis_get_option( 'image_size' ) ) );

echo '<div class="media_container">';
	if ( $image ) {
		printf( '<a href = "%s" rel = "bookmark"><img class = "post-image" src = "%s" alt="" /></a>', get_permalink(), $image );
	}
echo '</div>';

echo '<div class="content_container">';
	do_action( 'genesis_entry_header' );
	do_action( 'genesis_before_entry_content' );
	printf( '<div %s>', genesis_attr( 'entry-content' ) );
		do_action( 'genesis_entry_content' );
	echo '</div>'; // Ends .entry-content.
echo '</div>';
