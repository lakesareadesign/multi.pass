<?php

class UM_Social_Login_Admin {

	function __construct() {
	
		$this->slug = 'ultimatemember';
		$this->pagehook = 'toplevel_page_ultimatemember';
		
		add_action('um_extend_admin_menu',  array(&$this, 'um_extend_admin_menu'), 100);

		add_action('admin_menu', array(&$this, 'prepare_metabox'), 20);
	
	}
	
	/***
	***	@prepare metabox
	***/
	function prepare_metabox() {
		
		add_action('load-'.$this->pagehook, array(&$this, 'load_metabox'));
		
	}
	
	/***
	***	@load metabox
	***/
	function load_metabox() {
		global $ultimatemember;
		
		wp_register_script('um-chart', 'https://www.google.com/jsapi');
		wp_enqueue_script('um-chart');

		add_meta_box('um-metaboxes-social', __('Social Signups','um-social-login'), array(&$this, 'metabox_content'), $this->pagehook, 'normal', 'core');

	}
	
	/***
	***	@metabox content
	***/
	function metabox_content() {
		global $ultimatemember, $um_social_login;
		include_once um_social_login_path . 'admin/templates/metabox.php';
	}
	
	/***
	***	@extends the admin menu
	***/
	function um_extend_admin_menu() {
	
		add_submenu_page( $this->slug, __('Social Login', $this->slug), __('Social Login', $this->slug), 'manage_options', 'edit.php?post_type=um_social_login', '', '' );
		
	}

}