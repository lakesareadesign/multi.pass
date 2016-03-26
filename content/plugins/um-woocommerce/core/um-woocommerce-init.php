<?php

class UM_WooCommerce_API {

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
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-woocommerce'), um_woocommerce_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !function_exists( 'wc_get_product' ) ) {
			
			$this->add_notice( sprintf(__('WooCommerce must be activated before you can use %s.','um-woocommerce'), um_woocommerce_extension ) );
			$this->plugin_inactive = true;
			
		} else if ( !version_compare( ultimatemember_version, um_woocommerce_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-woocommerce'), um_woocommerce_extension) );
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
		require_once um_woocommerce_path . 'core/um-woocommerce-api.php';
		require_once um_woocommerce_path . 'core/um-woocommerce-enqueue.php';
		
		$this->api = new UM_WooCommerce_Core();
		$this->enqueue = new UM_WooCommerce_Enqueue();
		
		// Actions
		require_once um_woocommerce_path . 'core/actions/um-woocommerce-account.php';
		require_once um_woocommerce_path . 'core/actions/um-woocommerce-ajax.php';
		require_once um_woocommerce_path . 'core/actions/um-woocommerce-tabs.php';
		require_once um_woocommerce_path . 'core/actions/um-woocommerce-admin.php';
		require_once um_woocommerce_path . 'core/actions/um-woocommerce-order.php';
		
		// Filters
		require_once um_woocommerce_path . 'core/filters/um-woocommerce-account.php';
		require_once um_woocommerce_path . 'core/filters/um-woocommerce-fields.php';
		require_once um_woocommerce_path . 'core/filters/um-woocommerce-reviews.php';
		require_once um_woocommerce_path . 'core/filters/um-woocommerce-tabs.php';
		require_once um_woocommerce_path . 'core/filters/um-woocommerce-permissions.php';
		require_once um_woocommerce_path . 'core/filters/um-woocommerce-settings.php';

	}
}

$um_woocommerce = new UM_WooCommerce_API();