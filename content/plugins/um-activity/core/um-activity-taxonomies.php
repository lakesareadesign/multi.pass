<?php

class UM_Activiy_Taxonomies {

	function __construct() {
	
		add_action('init',  array(&$this, 'create_post_type'), 2);
	
	}
	
	/***
	***	@creates a post type
	***/
	function create_post_type() {
	
		register_post_type( 'um_activity', array(
				'labels' => array(
					'name' => __( 'Social Activity' ),
					'singular_name' => __( 'Social Activity' ),
					'add_new' => __( 'Add New Post' ),
					'add_new_item' => __('Add New Post' ),
					'edit_item' => __('Edit Post'),
					'not_found' => __('No wall posts have been added yet'),
					'not_found_in_trash' => __('Nothing found in Trash'),
					'search_items' => __('Search Posts')
				),
				'public' => false,
				'supports' => array('editor'),
				'taxonomies' => array('um_hashtag'),
				'show_ui' => true,
				'show_in_menu' => false,
			
			)
		);
		
		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = array(
			'name'                       => _x( 'Hashtags', 'taxonomy general name' ),
			'singular_name'              => _x( 'Hashtag', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Hashtags' ),
			'popular_items'              => __( 'Popular Hashtags' ),
			'all_items'                  => __( 'All Hashtags' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Hashtag' ),
			'update_item'                => __( 'Update Hashtag' ),
			'add_new_item'               => __( 'Add New Hashtag' ),
			'new_item_name'              => __( 'New Hashtag Name' ),
			'separate_items_with_commas' => __( 'Separate hashtags with commas' ),
			'add_or_remove_items'        => __( 'Add or remove hashtags' ),
			'choose_from_most_used'      => __( 'Choose from the most used hashtags' ),
			'not_found'                  => __( 'No hashtags found.' ),
			'menu_name'                  => __( 'Hashtags' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => false,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => false,
			'rewrite'               => array( 'slug' => 'hashtag' ),
			'show_in_menu' 			=> false,
		);

		register_taxonomy( 'um_hashtag', 'um_activity', $args );
		
	}

}