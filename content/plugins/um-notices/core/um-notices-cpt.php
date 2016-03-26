<?php

class UM_Notices_CPT {

	function __construct() {
	
		add_action('init',  array(&$this, 'create_cpt'), 2);
	
	}
	
	/***
	***	@creates needed cpt
	***/
	function create_cpt() {
	
		register_post_type( 'um_notice', array(
				'labels' => array(
					'name' => __( 'Notices' ),
					'singular_name' => __( 'Notice' ),
					'add_new' => __( 'Add New Notice' ),
					'add_new_item' => __('Add New Notice' ),
					'edit_item' => __('Edit Notice'),
					'not_found' => __('You did not create any notices yet'),
					'not_found_in_trash' => __('Nothing found in Trash'),
					'search_items' => __('Search Notices')
				),
				'show_ui' => true,
				'show_in_menu' => false,
				'public' => false,
				'supports' => array('title', 'editor')
			)
		);
		
	}

}