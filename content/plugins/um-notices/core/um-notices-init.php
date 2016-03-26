<?php

class UM_Notices_API {

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
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-notices'), um_notices_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_notices_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-notices'), um_notices_extension) );
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
		
		require_once um_notices_path . 'core/um-notices-cpt.php';
		require_once um_notices_path . 'core/um-notices-admin.php';
		require_once um_notices_path . 'core/um-notices-metabox.php';
		require_once um_notices_path . 'core/um-notices-query.php';
		require_once um_notices_path . 'core/um-notices-enqueue.php';
		require_once um_notices_path . 'core/um-notices-cols.php';
		require_once um_notices_path . 'core/um-notices-shortcode.php';
		
		require_once um_notices_path . 'core/actions/um-notices-ajax.php';
		
		require_once um_notices_path . 'core/filters/um-notices-settings.php';
		
		$this->cpt = new UM_Notices_CPT();
		$this->admin = new UM_Notices_Admin();
		$this->metabox = new UM_Notices_Metabox();
		$this->query = new UM_Notices_Query();
		$this->enqueue = new UM_Notices_Enqueue();
		$this->cols = new UM_Notices_Cols();
		$this->shortcode = new UM_Notices_Shortcode();

	}
	
}

$um_notices = new UM_Notices_API();