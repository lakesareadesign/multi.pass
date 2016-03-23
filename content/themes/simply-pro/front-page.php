<?php
/**
 * BloomBlogShop
 *
 * @package      BloomBlogShop
 * @since        1.0.0
 * @copyright    Copyright (c) 2015
 * @license      GPL-2.0+
 */

/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function jt_home_genesis_meta() {

	if ( is_active_sidebar( 'featured' ) || is_active_sidebar( 'home-middle-1' ) || is_active_sidebar( 'home-middle-2' ) || is_active_sidebar( 'home-middle-3' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'jt_home_loop_helper' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
	}
}
// add_action( 'genesis_meta', 'jt_home_genesis_meta' );

function jt_home_loop_helper() {

	if ( is_active_sidebar( 'featured' ) ) {
		echo '<div class="featured">';
		dynamic_sidebar( 'featured' );
		echo '</div>';
	}

	echo '<div class="home-middle">';

	if ( is_active_sidebar( 'home-middle-1' ) ) {
		echo '<div class="home-middle-widget-area one-third first">';
		dynamic_sidebar( 'home-middle-1' );
		echo '</div>';
	}

	if ( is_active_sidebar( 'home-middle-2' ) ) {
		echo '<div class="home-middle-widget-area one-third">';
		dynamic_sidebar( 'home-middle-2' );
		echo '</div>';
	}

	if ( is_active_sidebar( 'home-middle-3' ) ) {
		echo '<div class="home-middle-widget-area one-third">';
		dynamic_sidebar( 'home-middle-3' );
		echo '</div>';
	}

	echo '</div>';

}

genesis();