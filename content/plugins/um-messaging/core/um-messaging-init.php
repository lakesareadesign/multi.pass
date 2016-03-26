<?php

class UM_Messaging_API {

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
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-messaging'), um_messaging_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_messaging_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-messaging'), um_messaging_extension) );
			$this->plugin_inactive = true;
		
		}
		
	}
	
	/***
	***	@Add notice
	***/
	function add_notice( $msg ) {
		
		if ( !is_admin() ) return;
		
		echo '<div class="error um-admin-notice"><p>' . $msg . '</p></div>';
		
	}
	
	/***
	***	@Init
	***/
	function init() {
		
		if ( $this->plugin_inactive ) return;

		// Required classes
		require_once um_messaging_path . 'core/um-messaging-setup.php';
		require_once um_messaging_path . 'core/um-messaging-api.php';
		require_once um_messaging_path . 'core/um-messaging-enqueue.php';
		require_once um_messaging_path . 'core/um-messaging-shortcode.php';
		
		$this->api = new UM_Messaging_Main_API();
		$this->setup = new UM_Messaging_Setup();
		$this->enqueue = new UM_Messaging_Enqueue();
		$this->shortcode = new UM_Messaging_Shortcode();
		
		// Actions
		require_once um_messaging_path . 'core/actions/um-messaging-profile.php';
		require_once um_messaging_path . 'core/actions/um-messaging-ajax.php';
		require_once um_messaging_path . 'core/actions/um-messaging-content.php';
		require_once um_messaging_path . 'core/actions/um-messaging-admin.php';
		require_once um_messaging_path . 'core/actions/um-messaging-privacy.php';
		require_once um_messaging_path . 'core/actions/um-messaging-notifications.php';
		require_once um_messaging_path . 'core/actions/um-messaging-account.php';
		require_once um_messaging_path . 'core/actions/um-messaging-members.php';
		
		// Filters
		require_once um_messaging_path . 'core/filters/um-messaging-tabs.php';
		require_once um_messaging_path . 'core/filters/um-messaging-permissions.php';
		require_once um_messaging_path . 'core/filters/um-messaging-settings.php';
		require_once um_messaging_path . 'core/filters/um-messaging-account.php';
		require_once um_messaging_path . 'core/filters/um-messaging-menu.php';
		
	}
}

$um_messaging = new UM_Messaging_API();