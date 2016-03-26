<?php

class UM_Social_Login_Metabox {

	function __construct() {

		add_action( 'load-post.php', array(&$this, 'add_metabox'), 9 );
		add_action( 'load-post-new.php', array(&$this, 'add_metabox'), 9 );
		
	}
	
	/***
	***	@Init the metaboxes
	***/
	function add_metabox() {
		global $current_screen;
		
		if( $current_screen->id == 'um_form' ){
			add_action( 'save_post', array(&$this, 'set_social_login_form_id'), 10, 2 );
		}

		if( $current_screen->id == 'um_social_login' ){
			add_action( 'add_meta_boxes', array(&$this, 'add_metabox_form'), 1 );
			add_action( 'save_post', array(&$this, 'save_metabox_form'), 11, 2 );
		}

		

	}
	
	/***
	***	@add form metabox
	***/
	function add_metabox_form() {
		
		add_meta_box('um-admin-social-login-buttons', __('Options','um-social-login'), array(&$this, 'load_metabox_form'), 'um_social_login', 'normal', 'default');
		add_meta_box('um-admin-social-login-shortcode', __('Shortcode','um-social-login'), array(&$this, 'load_metabox_form'), 'um_social_login', 'side', 'default');

	}
	
	/***
	***	@load a form metabox
	***/
	function load_metabox_form( $object, $box ) {
		global $ultimatemember, $post, $um_social_login;
		$metabox = new UM_Admin_Metabox();
		$box['id'] = str_replace('um-admin-social-login-','', $box['id']);
		include_once um_social_login_path . 'admin/templates/'. $box['id'] . '.php';
		wp_nonce_field( basename( __FILE__ ), 'um_admin_metabox_social_login_form_nonce' );
	}
	
	/***
	***	@save form metabox
	***/
	function save_metabox_form( $post_id, $post ) {
		global $wpdb;


		// validate nonce
		if ( !isset( $_POST['um_admin_metabox_social_login_form_nonce'] ) || !wp_verify_nonce( $_POST['um_admin_metabox_social_login_form_nonce'], basename( __FILE__ ) ) ) return $post_id;

		

		// validate post type
		if ( $post->post_type != 'um_social_login' ) return $post_id;
		
		// validate user
		$post_type = get_post_type_object( $post->post_type );
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) return $post_id;

		// save
		foreach( $_POST as $k => $v ) {
			if (strstr($k, '_um_')){
				update_post_meta( $post_id, $k, $v);
			}
		}

	}

	/***
	*** @assign registration form as overlay fields
	***/
	function set_social_login_form_id( $post_id, $post ){
		global $wpdb;

		if( $post->post_type == 'um_form' ){
			
			if( isset( $_POST['_um_social_login_form'] ) && $_POST['_um_social_login_form'] > 0 ){
				$wpdb->query( $wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s ", $post_id, '_um_social_login_form') );
				update_option('um_social_login_form_installed', $post_id );
			}

		}
	}

}