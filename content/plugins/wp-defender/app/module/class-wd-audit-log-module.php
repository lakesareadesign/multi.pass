<?php

/**
 * @author: Hoang Ngo
 */
class WD_Audit_Log_Module extends WD_Module_Abstract {
	private $controllers = array();

	private static $_instance;

	public static function get_instance() {
		if ( ! is_object( self::$_instance ) ) {
			self::$_instance = new WD_Audit_Log_Module();
		}

		return self::$_instance;
	}

	public function __construct() {
		parent::__construct();
		$this->controllers['audit'] = new WD_Audit_Logging_Controller();
	}

	/**
	 * @param $controller
	 *
	 * @return null
	 */
	public function get_controller( $controller ) {
		return isset( $this->controllers[ $controller ] ) ? $this->controllers[ $controller ] : null;
	}

	/**
	 * Find a controller instance
	 *
	 * @param $controller
	 *
	 * @return null
	 * @since 1.0.2
	 */
	public static function find_controller( $controller ) {
		$module = self::get_instance();

		return isset( $module->controllers[ $controller ] ) ? $module->controllers[ $controller ] : null;
	}
}