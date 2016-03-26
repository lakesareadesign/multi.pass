<?php

class UM_Activity_API {

	function __construct() {

		$this->plugin_inactive = false;
		
		add_action('init', array(&$this, 'plugin_check'), 1);
		
		add_action('init', array(&$this, 'init'), 1);
		
		require_once um_activity_path . 'core/um-activity-widget.php';
		add_action( 'widgets_init', array(&$this, 'widgets_init' ) );
		
	}
	
	/***
	***	@Check plugin requirements
	***/
	function plugin_check(){
		
		if ( !class_exists('UM_API') ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-activity'), um_activity_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_activity_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-activity'), um_activity_extension) );
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
		require_once um_activity_path . 'core/um-activity-taxonomies.php';
		require_once um_activity_path . 'core/um-activity-admin.php';
		require_once um_activity_path . 'core/um-activity-cols.php';
		require_once um_activity_path . 'core/um-activity-api.php';
		require_once um_activity_path . 'core/um-activity-enqueue.php';
		require_once um_activity_path . 'core/um-activity-shortcode.php';
		require_once um_activity_path . 'core/um-activity-setup.php';
		
		$this->taxonomies = new UM_Activiy_Taxonomies();
		$this->setup = new UM_Activity_Setup();
		$this->admin = new UM_Activity_Admin();
		$this->cols = new UM_Activity_Cols();
		$this->api = new UM_Activity_API_Core();
		$this->enqueue = new UM_Activity_Enqueue();
		$this->shortcode = new UM_Activity_Shortcode();
		
		// Actions
		require_once um_activity_path . 'core/actions/um-activity-ajax.php';
		require_once um_activity_path . 'core/actions/um-activity-admin.php';
		require_once um_activity_path . 'core/actions/um-activity-webnotification.php';
		require_once um_activity_path . 'core/actions/um-activity-actions.php';
		require_once um_activity_path . 'core/actions/um-activity-footer.php';
		
		// Filters
		require_once um_activity_path . 'core/filters/um-activity-settings.php';
		require_once um_activity_path . 'core/filters/um-activity-privacy.php';
		require_once um_activity_path . 'core/filters/um-activity-comments.php';
		require_once um_activity_path . 'core/filters/um-activity-integrate-followers.php';
		
	}
	
	function widgets_init() {
		register_widget( 'um_activity_trending_tags' );
	}
	
}

$um_activity = new UM_Activity_API();