<?php
/**
 * Slush Pro.
 *
 * This file adds the masonry page template to the Slush Pro Theme.
 *
 * Template Name: Masonry
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

// Forces page to full width layout.
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Adds the template body class.
add_filter( 'body_class', 'zp_masonry_template_bodyclass' );
function zp_masonry_template_bodyclass( $classes ) {

	$classes[] = 'zp_masonry_template';
	return $classes;

}

// Removes breadcrumbs.
remove_action(  'genesis_before_content', 'genesis_do_breadcrumbs' );

// Removes the default Genesis loop.
remove_action(	'genesis_loop', 'genesis_do_loop' );

// Adds masonry custom loop.
add_action(	'genesis_loop', 'zp_masonry_template' );
function zp_masonry_template() {

	global $post;

	echo '<section class="layout_section"><div class="container">';

	while (  have_posts(  )  ) : the_post(  );

		$display_type = get_post_meta( $post->ID, 'display_type', true );
		$display_category = get_post_meta( $post->ID, 'display_category', true );
		$display_columns = get_post_meta( $post->ID, 'display_columns', true );
		$display_filter = get_post_meta( $post->ID, 'display_filter', true );
		$display_items = get_post_meta( $post->ID, 'display_items', true );
		$display_loadmore = get_post_meta( $post->ID, 'display_loadmore', true );

		// Adds the default values.
		$display_type = ( $display_type != '' ) ? $display_type : 'blog';
		$display_category = ( $display_category != '' ) ? $display_category : '';
		$display_columns = ( $display_columns != '' ) ? $display_columns : '3';
		$display_filter = ( $display_filter != '' ) ? $display_filter : 'true';
		$display_items = ( $display_items != '' ) ? $display_items : '-1';
		$display_loadmore = ( $display_loadmore != '' ) ? $display_loadmore : 'false';

		echo apply_filters( 'the_content', get_the_content() );

		if ( $display_type == 'blog' ) {
			echo zp_homeblog_output( $display_items, $display_columns, $display_filter, $display_category, $display_loadmore );
		} elseif ( $display_type == 'portfolio' ) {
			echo zp_portfolio_output( $display_items, $display_columns, $display_filter, $display_category, $display_loadmore );
		}

	endwhile;

	echo '</div></section>';

}

// Runs the Genesis loop.
genesis();
