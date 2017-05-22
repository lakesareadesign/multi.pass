<?php 
/**
 * Slush Pro.
 *
 * This file adds the quote post format template to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

global $post;

$content = get_the_content(); 
$title = get_the_title();
$permalink = get_permalink();
$like_counter = ( get_post_meta( $post->ID, 'zp_like', true ) > 0 ) ? get_post_meta( $post->ID, 'zp_like', true ) : 0;
$like = '<span class="zp_like_holder ' . $post->ID . '"><i class="fa fa-heart ' . $post->ID . '"></i><em class="like_counter">(' . $like_counter . ')</em></span>';

echo '<div class="content_container">';
	printf( '<div %s>', genesis_attr( 'entry-content' ) );
		echo '<h2>' . $content . '</h2>';
		echo '<p class="quote_author"><a href="' . $permalink . '" title="Permanent Link to ' . $title . '">' . $title . '</a>' . $like . '</p>';
	echo '</div>';
echo '</di>';
