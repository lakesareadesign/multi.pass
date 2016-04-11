<?php

/**
 * @author: Hoang Ngo
 */
class WD_Scan_Module extends WD_Module_Abstract {
	private $controllers = array();

	private static $_instance;

	public static function get_instance() {
		if ( ! is_object( self::$_instance ) ) {
			self::$_instance = new WD_Scan_Module();
		}

		return self::$_instance;
	}


	public function __construct() {
		parent::__construct();
		$this->controllers['scan']          = new WD_Scan_Controller();
		$this->controllers['scan_schedule'] = new WD_Schedule_Scan_Controller();
		$this->controllers['resolve']       = new WD_Resolve_Controller();
		$this->controllers['debug']         = new WD_Debug_Controller();
		$this->controllers['notification']  = new WD_Notification_Controller();
	}

	public function get_controller( $controller ) {
		return isset( $this->controllers[ $controller ] ) ? $this->controllers[ $controller ] : null;
	}
	/**
	 * Find a controller instance
	 * @param $controller
	 *
	 * @return null
	 * @since 1.0.4
	 */
	public static function find_controller( $controller ) {
		$module = self::get_instance();
		return isset( $module->controllers[ $controller ] ) ? $module->controllers[ $controller ] : null;
	}
}