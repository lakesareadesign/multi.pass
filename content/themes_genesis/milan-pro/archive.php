<?php
/**
 * This file adds customizations to Archive templates (monthly, category, author, tag, etc.) on the Milan Pro Theme.
 *
 * @author Themetry
 * @package Milan
 * @subpackage Customizations
 */

//* Enqueue Masonry
add_action( 'wp_enqueue_scripts', 'milan_archive_js' );
function milan_archive_js() {
	wp_enqueue_script( 'masonry' );
}

//* Wrap Masonry in its own div
add_action( 'genesis_loop', 'milan_open_archive_div', 1 );
function milan_open_archive_div() {
	echo '<div id="article-wrap" class="grid">';
}

add_action( 'genesis_after_endwhile', 'milan_close_archive_div', 1 );
function milan_close_archive_div() {
	echo '</div>';
}

//* Wrap each entry in its own div with post thumbnail
add_action( 'genesis_entry_header', 'milan_open_article_entry_div', 1 );
function milan_open_article_entry_div() {
	echo '<div class="grid-wrap">';
	the_post_thumbnail( 'square' );
}

add_action( 'genesis_entry_footer', 'milan_close_article_entry_div', -1 );
function milan_close_article_entry_div() {
	echo '</div>';
}

//* Swap title with date
add_action( 'genesis_before_loop', 'milan_swap_title_info' );
function milan_swap_title_info() {
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12);
	add_action( 'genesis_entry_header', 'genesis_post_info', 9 );
}

//* Remove entry content
add_action( 'genesis_before_loop', 'milan_remove_archive_content' );
function milan_remove_archive_content() {
	remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
}

//* Run the Genesis function
genesis();
