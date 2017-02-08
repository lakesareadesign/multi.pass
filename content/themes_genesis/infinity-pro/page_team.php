<?php

/**
 * Infinity Pro.
 *
 * This file adds the team page template to the Infinity Pro Theme.
 *
 * Template Name: Team
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link	http://my.studiopress.com/themes/infinity/
 */

// Add team page body class to the head.
add_filter( 'body_class', 'infinity_add_body_class' );
function infinity_add_body_class( $classes ) {

	$classes[] = 'team-page';

	return $classes;

}

// Conditionally remove loop.
add_action( 'genesis_before', 'infinity_conditionally_remove_loop' );
function infinity_conditionally_remove_loop () {

	if ( get_query_var( 'paged' ) >= 2 ) {
		remove_action('genesis_loop', 'genesis_do_loop');
	}

}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Add our custom loop.
add_action( 'genesis_loop', 'infinity_team_loop' );
function infinity_team_loop() {

	global $post;

	$args = array(
		'post_parent'    => $post->ID,
		'order'          => 'ASC',
		'orderby'        => 'menu_order',
		'post_type'      => 'page',
		'posts_per_page' => 8,
		'paged'          => get_query_var( 'paged' ),
	);

	global $wp_query;

	$loop = new WP_Query( $args );

	// Remove actions on entry.
	$hooks = array(
		'genesis_before_entry',
		'genesis_entry_header',
		'genesis_before_entry_content',
		'genesis_entry_content',
		'genesis_after_entry_content',
		'genesis_entry_footer',
		'genesis_after_entry',
	);

	foreach ( $hooks as $hook ) {
		remove_all_actions( $hook );
	}

	// Setup the team entry actions.
	add_filter( 'post_class' , 'infinity_team_class' );
	add_action( 'genesis_entry_content', 'infinity_page_team_image' );
	add_action( 'genesis_after_entry_content', 'genesis_entry_header_markup_open' , 5 );
	add_action( 'genesis_after_entry_content', 'genesis_entry_header_markup_close', 15 );
	add_action( 'genesis_after_entry_content', 'genesis_do_post_title' );
	add_action( 'genesis_after_entry_content', 'infinity_team_title' );

	if( !isset( $query_args ) ) {
		$query_args = array();
	}

	genesis_custom_loop( wp_parse_args( $query_args, $args ) );

	remove_filter( 'post_class' , 'infinity_team_class' );

}

// Add team member featured image.
function infinity_page_team_image() {

	$image = genesis_get_image( array(
		'format' => 'html',
		'size'   => 'team-member',
		'attr'   => array ( 'alt' => the_title_attribute( 'echo=0' ) ),
	) );

	if ( $image ) {
		printf( '<a href="%s" rel="bookmark">%s</a>', get_permalink(), $image );
	}

}

// Add team title field.
function infinity_team_title() {

	$title = '';

	if ( genesis_get_custom_field( 'team_title' ) ) {
		$title = '<p class="team-title">' . genesis_get_custom_field( 'team_title' ) . '</p>';
	}

	echo $title;

}

// Add one-fourth class to the page team entry.
function infinity_team_class( $classes ) {

	global $wp_query;

	$classes[] = 'one-fourth';

	if( 0 == $wp_query->current_post % 4 ) {
		$classes[] = 'first';
	}

	return $classes;

}

// Run the Genesis loop.
genesis();
