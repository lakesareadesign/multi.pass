<?php

/**
 * @author: Hoang Ngo
 */
class WD_Module_Manager {
	/**
	 * Store $module object
	 * @var array
	 */
	private $_modules = array();

	/**
	 * Register an module to list
	 *
	 * @param WD_Module_Abstract $module
	 */
	public function attach( WD_Module_Abstract $module ) {
		$this->_modules[ get_class( $module ) ] = $module;
	}

	/**
	 * remove an module out of list
	 *
	 * @param WD_Module_Abstract $module
	 */
	public function detach( WD_Module_Abstract $module ) {
		if ( isset( $this->_modules[ get_class( $module ) ] ) ) {
			unset( $this->_modules[ get_class( $module ) ] );
		}
	}

	/**
	 * @param $module
	 *
	 * @return mixed
	 */
	public function get_module_instance( $module ) {
		if ( isset( $this->_modules[ $module ] ) ) {
			return $this->_modules[ $module ];
		}
	}
}