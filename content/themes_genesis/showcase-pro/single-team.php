<?php

/**
 * This file makes changes to the single page view of team members
 *
 * @package Showcase Pro
 * @author  JT Grauke
 * @link    http://my.studiopress.com/themes/showcase/
 * @license GPL2-0+
 */

//* Force Full Width
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the entry meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 8 );

//* Remove the author box
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Remove the entry meta
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();