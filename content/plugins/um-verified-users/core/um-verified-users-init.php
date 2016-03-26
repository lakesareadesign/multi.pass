<?php

class UM_Verified_API {

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
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-verified'), um_verified_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_verified_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-verified'), um_verified_extension) );
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
		
		require_once um_verified_path . 'core/functions.php';
		
		require_once um_verified_path . 'core/um-verified-users-api.php';
		require_once um_verified_path . 'core/um-verified-users-enqueue.php';

		$this->api = new UM_Verified_API_Core();
		$this->enqueue = new UM_Verified_Enqueue();

		require_once um_verified_path . 'core/um-verified-users-filters.php';
		require_once um_verified_path . 'core/um-verified-users-actions.php';

	}
	
}

$um_verified = new UM_Verified_API();