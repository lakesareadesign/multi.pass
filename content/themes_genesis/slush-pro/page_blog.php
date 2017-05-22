<?php
/**
 * Slush Pro.
 *
 * This file adds the blog page template to the Slush Pro Theme.
 *
 * Template Name: Blog
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

// Removes the post image.
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

// Removes the Genesis loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Adds the blog loop.
add_action( 'genesis_loop', 'zp_blog_loop' );

// Runs the Genesis loop.
genesis();
