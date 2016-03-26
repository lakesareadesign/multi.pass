<?php

class UM_Mailchimp_Metabox {

	function __construct() {

		add_action( 'load-post.php', array(&$this, 'add_metabox'), 9 );
		add_action( 'load-post-new.php', array(&$this, 'add_metabox'), 9 );
		
	}
	
	/***
	***	@Init the metaboxes
	***/
	function add_metabox() {
		global $current_screen;
		
		if( $current_screen->id == 'um_mailchimp'){
			add_action( 'add_meta_boxes', array(&$this, 'add_metabox_form'), 1 );
			add_action( 'save_post', array(&$this, 'save_metabox_form'), 10, 2 );
		}

	}
	
	/***
	***	@add form metabox
	***/
	function add_metabox_form() {
		
		add_meta_box('um-admin-mailchimp-list', __('Setup List','um-mailchimp'), array(&$this, 'load_metabox_form'), 'um_mailchimp', 'normal', 'default');
		
		if ( isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' ) {
			add_meta_box('um-admin-mailchimp-merge', __('Merge User Meta','um-mailchimp'), array(&$this, 'load_metabox_form'), 'um_mailchimp', 'normal', 'default');
		}
		
	}
	
	/***
	***	@load a form metabox
	***/
	function load_metabox_form( $object, $box ) {
		global $ultimatemember, $post, $um_mailchimp;
		$metabox = new UM_Admin_Metabox();
		$box['id'] = str_replace('um-admin-mailchimp-','', $box['id']);
		include_once um_mailchimp_path . 'admin/templates/'. $box['id'] . '.php';
		wp_nonce_field( basename( __FILE__ ), 'um_admin_metabox_mailchimp_form_nonce' );
	}
	
	/***
	***	@save form metabox
	***/
	function save_metabox_form( $post_id, $post ) {
		global $wpdb;

		// validate nonce
		if ( !isset( $_POST['um_admin_metabox_mailchimp_form_nonce'] ) || !wp_verify_nonce( $_POST['um_admin_metabox_mailchimp_form_nonce'], basename( __FILE__ ) ) ) return $post_id;

		// validate post type
		if ( $post->post_type != 'um_mailchimp' ) return $post_id;
		
		// validate user
		$post_type = get_post_type_object( $post->post_type );
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) return $post_id;

		// save
		delete_post_meta( $post_id, '_um_roles' );

		foreach( $_POST as $k => $v ) {
			if (strstr($k, '_um_')){
				update_post_meta( $post_id, $k, $v);
			}
		}

	}

}