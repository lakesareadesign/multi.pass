<?php

/**
 * Edits to the single page
 *
 * @package Showcase Pro
 * @author  JT Grauke
 * @link    http://my.studiopress.com/themes/showcase/
 * @license GPL2-0+
 */

//* Remove the entry meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 8 );

genesis();