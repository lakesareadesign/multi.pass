<?php

class UM_reCAPTCHA_API {

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
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-recaptcha'), um_recaptcha_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_recaptcha_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-recaptcha'), um_recaptcha_extension) );
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
		
		// Requires classes
		require_once um_recaptcha_path . 'core/um-recaptcha-enqueue.php';
		require_once um_recaptcha_path . 'core/um-recaptcha-notices.php';
		
		$this->enqueue = new UM_reCAPTCHA_Enqueue();
		$this->notices = new UM_reCAPTCHA_Notices();
		
		// Actions
		require_once um_recaptcha_path . 'core/actions/um-recaptcha-form.php';
		require_once um_recaptcha_path . 'core/actions/um-recaptcha-admin.php';
		
		// Filters
		require_once um_recaptcha_path . 'core/filters/um-recaptcha-settings.php';

	}
	
	/***
	***	@Captcha allowed
	***/
	function captcha_allowed( $args ) {
		$enable = false;
		
		$your_sitekey = um_get_option('g_recaptcha_sitekey');
		$your_secret = um_get_option('g_recaptcha_secretkey');
		$recaptcha = um_get_option('g_recaptcha_status');
		
		if ( $recaptcha )
			$enable = true;
		
		if ( isset( $args['g_recaptcha_status'] ) && $args['g_recaptcha_status'] )
			$enable = true;
		
		if ( isset( $args['g_recaptcha_status'] ) && !$args['g_recaptcha_status'] )
			$enable = false;
		
		if ( !$your_sitekey || !$your_secret )
			$enable = false;
		
		if ( $enable == false )
			return false;
		
		return true;
	}
	
}

$um_recaptcha = new UM_reCAPTCHA_API();