<?php

/*
 * 	BNE Testimonials Wordpress Plugin
 *	Custom Taxonomy
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2013-2015, Kerry Kline
 * 	@link		http://www.bnecreative.com
 *
 *	@updated: February 7, 2015
*/



function bne_testimonials_taxonomy() {

	// Taxonomy Labels
	$labels = array(
		'name'                       => __( 'Testimonial Categories', 'bne-testimonials' ),
		'singular_name'              => __( 'Category', 'bne-testimonials' ),
		'search_items'               => __( 'Search Categories', 'bne-testimonials' ),
		'popular_items'              => __( 'Popular Categories', 'bne-testimonials' ),
		'all_items'                  => __( 'All Categories', 'bne-testimonials' ),
		'parent_item'                => __( 'Parent Category', 'bne-testimonials' ),
		'parent_item_colon'          => __( 'Parent: Category', 'bne-testimonials' ),
		'edit_item'                  => __( 'Edit Category', 'bne-testimonials' ),
		'view_item'                  => __( 'View Category', 'bne-testimonials' ),
		'update_item'                => __( 'Update Category', 'bne-testimonials' ),
		'add_new_item'               => __( 'Add New Category', 'bne-testimonials' ),
		'new_item_name'              => __( 'New Category Name', 'bne-testimonials' ),
		'add_or_remove_items'        => __( 'Add or remove Categories', 'bne-testimonials' ),
		'choose_from_most_used'      => __( 'Choose from the most used Categories', 'bne-testimonials' ),
		'separate_items_with_commas' => __( 'Separate Categories with commas', 'bne-testimonials' ),
		'menu_name'                  => __( 'Categories', 'bne-testimonials' ),
	);

	// Linked Custom Post Type
	$cpts = array('bne_testimonials');

	// Taxonomy Arguments
	$args = array(
	    'labels'             => $labels,
	    'hierarchical'       => true,
	    'description'        => '',
	    'public'             => true,
	    'show_ui'            => true,
	    'show_tagcloud'      => false,
	    'show_in_nav_menus'  => false,
	    'show_admin_column'  => true,
	    'query_var'          => true,
	    'rewrite'            => false,
	);
	register_taxonomy( 'bne-testimonials-taxonomy', $cpts, $args );

}
add_action( 'init', 'bne_testimonials_taxonomy' );