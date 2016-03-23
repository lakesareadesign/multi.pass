<?php

/**
 * @author: Hoang Ngo
 */
abstract class WD_Module_Abstract {
	protected $module_path;

	public function __construct() {
		spl_autoload_register( array( &$this, 'autoload' ) );
	}

	/**
	 * Require for register class inside a module
	 *
	 * @param $class
	 *
	 * @return mixed
	 */
	public function autoload( $class ) {
		$base_path = $this->get_module_path();
		$class     = strtolower( $class );

		if ( substr( $class, 0, 3 ) != 'wd_' ) {
			return false;
		}
		//build file name
		$file_name = 'class-' . str_replace( '_', '-', $class ) . '.php';
		foreach ( wp_defender()->files_mapped as $mapped ) {
			if ( strpos( $mapped, $base_path ) === 0 && pathinfo( $mapped, PATHINFO_BASENAME ) == $file_name ) {
				include_once $mapped;
			}
		}
	}

	/**
	 * Guess the module path
	 * @return string
	 */
	public function get_module_path() {
		$class = get_class( $this );
		$parts = explode( '_', $class );
		//the first is perfix, remove
		unset( $parts[0] );
		//build
		$folder_name = strtolower( implode( '-', $parts ) );

		return wp_defender()->get_plugin_path() . 'app/module/' . $folder_name . '/';
	}

}