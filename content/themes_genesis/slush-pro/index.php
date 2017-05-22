<?php
/**
 * Slush Pro.
 *
 * This file adds the homepage to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

// Removes the post image.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

// Removes the default Genesis loop.
remove_action(	'genesis_loop', 'genesis_do_loop' );

// Adds the blog loop.
add_action(	'genesis_loop', 'zp_blog_loop' );

// Runs the Genesis loop.
genesis();
