<?php

class UM_Reviews_Taxonomies {

	function __construct() {
	
		add_action('init',  array(&$this, 'create_post_type'), 2);
	
	}
	
	/***
	***	@creates a post type
	***/
	function create_post_type() {
	
		register_post_type( 'um_review', array(
				'labels' => array(
					'name' => __( 'User Reviews' ),
					'singular_name' => __( 'Review' ),
					'add_new' => __( 'Add New Review' ),
					'add_new_item' => __('Add New Review' ),
					'edit_item' => __('Edit Review'),
					'not_found' => __('No user reviews have been submitted yet'),
					'not_found_in_trash' => __('Nothing found in Trash'),
					'search_items' => __('Search Reviews')
				),
				'show_ui' => true,
				'show_in_menu' => false,
				'public' => false,
				'supports' => array('title', 'editor')
			)
		);
		
	}

}