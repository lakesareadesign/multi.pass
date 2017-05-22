<?php
/**
 * Slush Pro.
 *
 * This file adds the link post format template to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

$title = get_the_title();
$permalink = get_permalink();
$link = get_post_meta( $post->ID, 'zp_link_format', true );

echo '<div class="content_container">';
	printf( '<div %s>', genesis_attr( 'entry-content' ) );
	echo '<h2><a href="' . $link . '" title="' . $title . '" target="_blank">' . $title . '</a></h2>';
	echo apply_filters( 'content', get_the_content() );
	echo '</div>';
echo '</div>';
