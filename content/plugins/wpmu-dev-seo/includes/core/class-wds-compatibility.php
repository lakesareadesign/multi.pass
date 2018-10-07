<?php

/**
 * Class Smartcrawl_Compatibility
 *
 * Fixes third-party compatibility issues
 */
class Smartcrawl_Compatibility {
	/**
	 * Singleton instance
	 *
	 * @var Smartcrawl_Compatibility
	 */
	private static $_instance;

	/**
	 * Currently running state flag
	 *
	 * @var bool
	 */
	private $_is_running = false;

	/**
	 * Constructor
	 */
	private function __construct() {
	}

	/**
	 * Boot controller listeners
	 *
	 * Do it only once, if they're already up do nothing
	 *
	 * @return bool Status
	 */
	public static function run() {
		$me = self::get();
		if ( $me->is_running() ) {
			return false;
		}

		return $me->_add_hooks();
	}

	/**
	 * Obtain instance without booting up
	 *
	 * @return Smartcrawl_Compatibility instance
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Check if we already have the actions bound
	 *
	 * @return bool Status
	 */
	public function is_running() {
		return $this->_is_running;
	}

	/**
	 * Bind listening actions
	 *
	 * @return bool
	 */
	private function _add_hooks() {
		add_action( 'init', array( $this, 'load_divi_in_ajax' ), - 10 );

		$this->_is_running = true;

		return true;
	}

	/**
	 * Divi doesn't usually load its shortcodes during ajax requests but we need these shortcodes in order to
	 * render an accurate preview.
	 *
	 * Force Divi to load during our requests.
	 */
	public function load_divi_in_ajax() {
		$data = isset( $_POST['_wds_nonce'] )
		        && (
			        wp_verify_nonce( $_POST['_wds_nonce'], 'wds-metabox-nonce' )
			        || wp_verify_nonce( $_POST['_wds_nonce'], 'wds-onpage-nonce' )
		        );

		if ( ! empty( $data ) && is_admin() && smartcrawl_is_switch_active( 'DOING_AJAX' ) ) {
			$_POST['et_load_builder_modules'] = '1';
		}
	}
}