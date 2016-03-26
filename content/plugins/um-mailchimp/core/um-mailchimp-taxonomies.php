<?php

class UM_Mailchimp_Taxonomies {

	function __construct() {
	
		add_action('init',  array(&$this, 'create_taxonomies'), 2);
	
	}
	
	/***
	***	@Create a mailchimp post type
	***/
	function create_taxonomies() {
	
		register_post_type( 'um_mailchimp', array(
				'labels' => array(
					'name' => __( 'MailChimp' ),
					'singular_name' => __( 'MailChimp' ),
					'add_new' => __( 'Add New List' ),
					'add_new_item' => __('Add New List' ),
					'edit_item' => __('Edit List'),
					'not_found' => __('You did not create any MailChimp lists yet'),
					'not_found_in_trash' => __('Nothing found in Trash'),
					'search_items' => __('Search MailChimp lists')
				),
				'show_ui' => true,
				'show_in_menu' => false,
				'public' => false,
				'supports' => array('title')
			)
		);
		
	}

}