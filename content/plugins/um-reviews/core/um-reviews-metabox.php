<?php

class UM_Reviews_Metabox {

	function __construct() {

		add_action( 'load-post.php', array(&$this, 'add_metabox'), 9 );
		add_action( 'load-post-new.php', array(&$this, 'add_metabox'), 9 );
		
	}
	
	/***
	***	@Init the metaboxes
	***/
	function add_metabox() {
		global $current_screen;
		
		if( $current_screen->id == 'um_review'){
			add_action( 'add_meta_boxes', array(&$this, 'add_metabox_form'), 1 );
			add_action( 'save_post', array(&$this, 'save_metabox_form'), 10, 2 );
		}

	}
	
	/***
	***	@add form metabox
	***/
	function add_metabox_form() {

		add_meta_box('um-admin-reviews-review', __('This Review','um-reviews'), array(&$this, 'load_metabox_form'), 'um_review', 'side', 'default');
		
	}
	
	/***
	***	@load a form metabox
	***/
	function load_metabox_form( $object, $box ) {
		global $ultimatemember, $post, $um_reviews;
		$metabox = new UM_Admin_Metabox();
		$box['id'] = str_replace('um-admin-reviews-','', $box['id']);
		include_once um_reviews_path . 'admin/templates/'. $box['id'] . '.php';
		wp_nonce_field( basename( __FILE__ ), 'um_admin_metabox_reviews_form_nonce' );
	}
	
	/***
	***	@save form metabox
	***/
	function save_metabox_form( $post_id, $post ) {
		global $wpdb, $um_reviews;

		// validate nonce
		if ( !isset( $_POST['um_admin_metabox_reviews_form_nonce'] ) || !wp_verify_nonce( $_POST['um_admin_metabox_reviews_form_nonce'], basename( __FILE__ ) ) ) return $post_id;

		// validate post type
		if ( $post->post_type != 'um_review' ) return $post_id;
		
		// validate user
		$post_type = get_post_type_object( $post->post_type );
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) return $post_id;

		// update reviews
		$status = get_post_meta( $post_id, '_status', true );
		if ( $status == 0 && $_POST['_status'] == 1 ) {
			$um_reviews->api->publish_review( $post_id );
		}
		
		if ( $status == 1 && $_POST['_status'] == 0 ) {
			$um_reviews->api->undo_review( $post_id );
		}

		update_post_meta( $post_id, '_flagged', $_POST['_flagged'] );
		update_post_meta( $post_id, '_status', $_POST['_status'] );
		
		$rating = get_post_meta( $post_id, '_rating', true );
		
		if ( $_POST['rating'] != $rating ) {
			$um_reviews->api->adjust_rating( $post_id, $rating, $_POST['rating'] );
		}
		
	}

}