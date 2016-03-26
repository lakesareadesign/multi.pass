<?php

class UM_Mailchimp_Admin {

	function __construct() {
	
		$this->slug = 'ultimatemember';
		$this->pagehook = 'toplevel_page_ultimatemember';
		
		add_action('um_extend_admin_menu',  array(&$this, 'um_extend_admin_menu'), 200);
		
		add_action('admin_enqueue_scripts',  array(&$this, 'admin_enqueue_scripts'), 9);
		
		add_filter('enter_title_here', array(&$this, 'enter_title_here') );
		
		add_action('admin_menu', array(&$this, 'prepare_metabox'), 20);
		
		add_action('um_admin_do_action__um_hide_mailchimp_notice', array(&$this, 'hide_notice') );
		
		add_action('um_admin_do_action__force_mailchimp_subscribe', array(&$this, 'force_mailchimp_subscribe') );
		add_action('um_admin_do_action__force_mailchimp_unsubscribe', array(&$this, 'force_mailchimp_unsubscribe') );
		add_action('um_admin_do_action__force_mailchimp_update', array(&$this, 'force_mailchimp_update') );
	
	}
	
	/***
	***	@force sync subscribe
	***/
	function force_mailchimp_subscribe() {
		global $um_mailchimp;
		if ( !is_admin() || !current_user_can('manage_options') ) die();
		$um_mailchimp->api->mailchimp_subscribe(true);
		exit( wp_redirect( remove_query_arg('um_adm_action') ) );
	}
	
	/***
	***	@force sync unsubscribe
	***/
	function force_mailchimp_unsubscribe() {
		global $um_mailchimp;
		if ( !is_admin() || !current_user_can('manage_options') ) die();
		$um_mailchimp->api->mailchimp_unsubscribe(true);
		exit( wp_redirect( remove_query_arg('um_adm_action') ) );
	}
	
	/***
	***	@force sync update
	***/
	function force_mailchimp_update() {
		global $um_mailchimp;
		if ( !is_admin() || !current_user_can('manage_options') ) die();
		$um_mailchimp->api->mailchimp_update(true);
		exit( wp_redirect( remove_query_arg('um_adm_action') ) );
	}
	
	/***
	***	@hide notice
	***/
	function hide_notice( $action ){
		if ( !is_admin() || !current_user_can('manage_options') ) die();
		update_option( $action, 1 );
		exit( wp_redirect( remove_query_arg('um_adm_action') ) );
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

		add_meta_box('um-metaboxes-mailchimp', '<span class="um-mailchimp-icon">' . __('MailChimp','um-mailchimp') . '</span>', array(&$this, 'metabox_content'), $this->pagehook, 'core', 'core');
		
	}
	
	/***
	***	@metabox content
	***/
	function metabox_content() {
		global $ultimatemember, $um_mailchimp;
		include_once um_mailchimp_path . 'admin/templates/metabox.php';
	}
	
	/***
	***	@custom title
	***/
	function enter_title_here( $title ){
		$screen = get_current_screen();
		if ( 'um_mailchimp' == $screen->post_type )
			$title = __('e.g. My First Mailing List','um-mailchimp');
		return $title;
	}
	
	/***
	***	@admin styles
	***/
	function admin_enqueue_scripts() {
		
		wp_register_style('um_admin_mailchimp', um_mailchimp_url . 'assets/css/um-admin-mailchimp.css' );
		wp_enqueue_style('um_admin_mailchimp');
		
	}
	
	/***
	***	@extends the admin menu
	***/
	function um_extend_admin_menu() {
	
		add_submenu_page( $this->slug, __('MailChimp','um-mailchimp'), __('MailChimp','um-mailchimp'), 'manage_options', 'edit.php?post_type=um_mailchimp', '', '' );
		
	}

}