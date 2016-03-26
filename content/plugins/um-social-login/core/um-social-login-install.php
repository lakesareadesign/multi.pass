<?php

class UM_Social_Login_Install {

	function __construct() {
		
		add_action('init', array(&$this, 'setup'), 9);
		
		$this->core_form_meta = array(
			'_um_custom_fields' => 'a:5:{s:10:"user_login";a:15:{s:5:"title";s:8:"Username";s:7:"metakey";s:10:"user_login";s:4:"type";s:4:"text";s:5:"label";s:8:"Username";s:8:"required";i:1;s:6:"public";i:1;s:8:"editable";i:0;s:8:"validate";s:15:"unique_username";s:9:"min_chars";i:3;s:9:"max_chars";i:24;s:8:"position";s:1:"1";s:6:"in_row";s:9:"_um_row_1";s:10:"in_sub_row";s:1:"0";s:9:"in_column";s:1:"1";s:8:"in_group";s:0:"";}s:10:"first_name";a:12:{s:5:"title";s:10:"First Name";s:7:"metakey";s:10:"first_name";s:4:"type";s:4:"text";s:5:"label";s:10:"First Name";s:8:"required";i:0;s:6:"public";i:1;s:8:"editable";i:1;s:8:"position";s:1:"2";s:6:"in_row";s:9:"_um_row_1";s:10:"in_sub_row";s:1:"0";s:9:"in_column";s:1:"1";s:8:"in_group";s:0:"";}s:9:"last_name";a:12:{s:5:"title";s:9:"Last Name";s:7:"metakey";s:9:"last_name";s:4:"type";s:4:"text";s:5:"label";s:9:"Last Name";s:8:"required";i:0;s:6:"public";i:1;s:8:"editable";i:1;s:8:"position";s:1:"3";s:8:"in_group";s:0:"";s:6:"in_row";s:9:"_um_row_1";s:10:"in_sub_row";s:1:"0";s:9:"in_column";s:1:"1";}s:10:"user_email";a:13:{s:5:"title";s:14:"E-mail Address";s:7:"metakey";s:10:"user_email";s:4:"type";s:4:"text";s:5:"label";s:14:"E-mail Address";s:8:"required";i:0;s:6:"public";i:1;s:8:"editable";i:1;s:8:"validate";s:12:"unique_email";s:8:"position";s:1:"4";s:6:"in_row";s:9:"_um_row_1";s:10:"in_sub_row";s:1:"0";s:9:"in_column";s:1:"1";s:8:"in_group";s:0:"";}s:9:"_um_row_1";a:5:{s:4:"type";s:3:"row";s:2:"id";s:9:"_um_row_1";s:8:"sub_rows";s:1:"1";s:4:"cols";s:1:"1";s:6:"origin";s:9:"_um_row_1";}}',
			'_um_mode' => 'register',
			'_um_core' => 'social',
			'_um_register_use_globals' => 1,
		);
		
	}
	
	/***
	***	@setup
	***/
	function setup() {

		if ( !current_user_can('manage_options') ) return;
		
		$um_social_login_form_installed = get_option('um_social_login_form_installed');

		$has_form_installed = get_post_status( $um_social_login_form_installed );

		if ( in_array( $has_form_installed, array('publish','draft','trash') )  ) return;
		
		$user_id = get_current_user_id();
		
		$form = array(
			'post_type' 	  	=> 'um_form',
			'post_title'		=> __('Social Registration','um-social-login'),
			'post_status'		=> 'publish',
			'post_author'   	=> $user_id,
		);

		$form_id = wp_insert_post( $form );

		foreach( $this->core_form_meta as $key => $value ) {
			if ( $key == '_um_custom_fields' ) {
				$array = unserialize( $value );
				update_post_meta( $form_id, $key, $array );
			} else {
				update_post_meta($form_id, $key, $value);
			}
		}

		update_post_meta( $form_id, '_um_social_login_form', 1 );
		update_option('um_social_login_form_installed', $form_id);
		
	}
	
}