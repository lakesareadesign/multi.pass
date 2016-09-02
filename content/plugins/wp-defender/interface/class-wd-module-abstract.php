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
		$chunks = explode( '_', $class );
		$pos    = array_pop( $chunks );
		//build file name
		$file_name = 'class-' . str_replace( '_', '-', $class ) . '.php';
		switch ( strtolower( $pos ) ) {
			case 'controller':
				if ( is_file( $base_path . 'controller/' . $file_name ) ) {
					include_once $base_path . 'controller/' . $file_name;

					return;
				}
				break;
			case 'model':
				if ( is_file( $base_path . 'model/' . $file_name ) ) {
					include_once $base_path . 'model/' . $file_name;

					return;
				}
				break;
			case 'abstract':
				if ( is_file( $base_path . 'interface/' . $file_name ) ) {
					include_once $base_path . 'interface/' . $file_name;

					return;
				}
				break;
			case 'widget':
				if ( is_file( $base_path . 'widget/' . $file_name ) ) {
					include_once $base_path . 'widget/' . $file_name;

					return;
				}
				break;
			default:
				//looking in base
				if ( is_file( $base_path . '' . $file_name ) ) {
					include_once $base_path . '' . $file_name;

					return;
				} elseif ( is_file( $base_path . 'component/' . $file_name ) ) {
					include_once $base_path . 'component/' . $file_name;

					return;
				}
				break;
		}

		//if still here, means not our files, but need to check again in app folder
		if ( is_file( $base_path . '' . $file_name ) ) {
			include_once $base_path . '' . $file_name;

			return;
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