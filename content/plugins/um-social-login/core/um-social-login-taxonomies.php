<?php

class UM_Social_Login_Taxonomies {

	function __construct() {
	
		add_action('init',  array(&$this, 'create_taxonomies'), 2);
	
	}
	
	/***
	***	@Create a post type
	***/
	function create_taxonomies() {
	
		register_post_type( 'um_social_login', array(
				'labels' => array(
					'name' => __( 'Social Login Shortcodes' ),
					'singular_name' => __( 'Social Login Shortcode' ),
					'add_new' => __( 'Add New' ),
					'add_new_item' => __('Add New Social Login Shortcode' ),
					'edit_item' => __('Edit'),
					'not_found' => __('You did not create any social login shortcodes yet'),
					'not_found_in_trash' => __('Nothing found in Trash'),
					'search_items' => __('Search social login shortcodes')
				),
				'show_ui' => true,
				'show_in_menu' => false,
				'public' => false,
				'supports' => array('title')
			)
		);
		
	}

}