<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AS3CF_Sidebar_Presenter Class
 *
 * This class handles the Pro sidebar.
 */
class AS3CF_Sidebar_Presenter {

	/**
	 * @var Amazon_S3_And_CloudFront_Pro
	 */
	private $as3cf;

	/**
	 * The registered tools
	 *
	 * @var array
	 */
	private $tools = array();

	/**
	 * AS3CF_Sidebar_Presenter constructor.
	 *
	 * @param Amazon_S3_And_CloudFront_Pro $as3cf
	 */
	public function __construct( $as3cf ) {
		$this->as3cf = $as3cf;
	}

	/**
	 * Init.
	 */
	public function init() {
		add_action( 'as3cf_after_settings', array( $this, 'render_sidebar' ) );

		// JS data
		add_filter( 'as3cfpro_js_nonces', array( $this, 'add_js_nonces' ) );

		// AJAX
		add_action( 'wp_ajax_as3cfpro_update_sidebar', array( $this, 'ajax_update_sidebar' ) );
	}

	/**
	 * Register a tool
	 *
	 * @param AS3CF_Tool $tool
	 *
	 * @return bool
	 */
	public function register_tool( AS3CF_Tool $tool ) {
		if ( array_key_exists( $tool->get_tool_key(), $this->tools ) ) {
			return false;
		}

		$this->tools[ $tool->get_tool_key() ] = $tool;

		$tool->priority( count( $this->tools ) )->init();

		return true;
	}

	/**
	 * Get tool.
	 *
	 * @param string $name
	 *
	 * @return bool|AS3CF_Tool
	 */
	public function get_tool( $name ) {
		if ( ! array_key_exists( $name, $this->tools ) ) {
			return false;
		}

		return $this->tools[ $name ];
	}

	/**
	 * Render the Pro sidebar with tools
	 */
	public function render_sidebar() {
		$this->as3cf->render_view( 'sidebar' );
	}

	/**
	 * Add the nonces to the Javascript
	 *
	 * @param array $js_nonces
	 *
	 * @return array
	 */
	public function add_js_nonces( $js_nonces ) {
		$js_nonces['update_sidebar'] = wp_create_nonce( 'update-sidebar' );

		return $js_nonces;
	}

	/**
	 * AJAX callback for updating the sidebar.
	 */
	public function ajax_update_sidebar() {
		check_ajax_referer( 'update-sidebar', 'nonce' );

		$tools        = array();
		$calling_tool = $this->as3cf->filter_input( 'tool', INPUT_POST, FILTER_SANITIZE_STRING ); // input var ok;

		foreach ( $this->tools as $name => $tool ) {
			$tools[ $name ]['block'] = $tool->get_sidebar_block();

			if ( $name === $calling_tool ) {
				// Only refresh notices for current tool
				$tools[ $name ]['notices'] = $tool->get_error_notices();
			}
		}

		wp_send_json_success( $tools );
	}

}