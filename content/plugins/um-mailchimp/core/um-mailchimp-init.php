<?php

class UM_Mailchimp_API {

	function __construct() {

		$this->plugin_inactive = false;
		
		add_action('init', array(&$this, 'plugin_check'), 1);
		
		add_action('init', array(&$this, 'init'), 1);

	}
	
	/***
	***	@Check plugin requirements
	***/
	function plugin_check(){
		
		if ( !class_exists('UM_API') ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-mailchimp'), um_mailchimp_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_mailchimp_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-mailchimp'), um_mailchimp_extension) );
			$this->plugin_inactive = true;
		
		}
		
	}
	
	/***
	***	@Add notice
	***/
	function add_notice( $msg ) {
		
		if ( !is_admin() ) return;
		
		echo '<div class="error"><p>' . $msg . '</p></div>';
		
	}
	
	/***
	***	@Init
	***/
	function init() {
		
		if ( $this->plugin_inactive ) return;
		
		require_once um_mailchimp_path . 'lib/um-mailchimp-api.php';
		
		require_once um_mailchimp_path . 'core/um-mailchimp-taxonomies.php';
		require_once um_mailchimp_path . 'core/um-mailchimp-admin.php';
		require_once um_mailchimp_path . 'core/um-mailchimp-notices.php';
		require_once um_mailchimp_path . 'core/um-mailchimp-metabox.php';
		require_once um_mailchimp_path . 'core/um-mailchimp-cols.php';
		require_once um_mailchimp_path . 'core/um-mailchimp-func.php';
		
		require_once um_mailchimp_path . 'core/actions/um-mailchimp-account.php';
		require_once um_mailchimp_path . 'core/actions/um-mailchimp-fields.php';
		
		require_once um_mailchimp_path . 'core/filters/um-mailchimp-account.php';
		require_once um_mailchimp_path . 'core/filters/um-mailchimp-settings.php';
		require_once um_mailchimp_path . 'core/filters/um-mailchimp-fields.php';
		
		$this->taxonomies = new UM_Mailchimp_Taxonomies();
		$this->admin = new UM_Mailchimp_Admin();
		$this->notices = new UM_Mailchimp_Notices();
		$this->metabox = new UM_Mailchimp_Metabox();
		$this->cols = new UM_Mailchimp_Cols();
		$this->api = new UM_Mailchimp_Func();

	}
	
}

$um_mailchimp = new UM_Mailchimp_API();