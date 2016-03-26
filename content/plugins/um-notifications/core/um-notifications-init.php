<?php

class UM_Notifications_API {

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
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-notifications'), um_notifications_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_notifications_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-notifications'), um_notifications_extension) );
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

		// Required classes
		require_once um_notifications_path . 'core/um-notifications-setup.php';
		require_once um_notifications_path . 'core/um-notifications-shortcode.php';
		require_once um_notifications_path . 'core/um-notifications-api.php';
		require_once um_notifications_path . 'core/um-notifications-enqueue.php';
		
		$this->api = new UM_Notifications_Main_API();
		$this->setup = new UM_Notifications_Setup();
		$this->shortcode = new UM_Notifications_Shortcode();
		$this->enqueue = new UM_Notifications_Enqueue();
		
		// Actions
		require_once um_notifications_path . 'core/actions/um-notifications-log-comment.php';
		require_once um_notifications_path . 'core/actions/um-notifications-log-review.php';
		require_once um_notifications_path . 'core/actions/um-notifications-log-mycred.php';
		require_once um_notifications_path . 'core/actions/um-notifications-log-profile.php';
		require_once um_notifications_path . 'core/actions/um-notifications-log-bbpress.php';
		require_once um_notifications_path . 'core/actions/um-notifications-log-user.php';
		require_once um_notifications_path . 'core/actions/um-notifications-ajax.php';
		require_once um_notifications_path . 'core/actions/um-notifications-footer.php';
		require_once um_notifications_path . 'core/actions/um-notifications-account.php';
		
		// Filters
		require_once um_notifications_path . 'core/filters/um-notifications-settings.php';
		require_once um_notifications_path . 'core/filters/um-notifications-account.php';
		
	}
}

$um_notifications = new UM_Notifications_API();