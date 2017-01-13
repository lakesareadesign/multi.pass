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
	 * @param $class
	 */
	public function autoload_52( $class ) {
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

	public function autoload_53( $class ) {
		$parts = explode( '\\', $class );
		if ( $parts[0] != 'WP_Defender' ) {
			return;
		}
		//the namespace struct should be plugin_slug/module/component/classname
		//or it can be plugin_slug/Component/Classname

		if ( count( $parts ) == 3 ) {
			//todo later, when we convert the whole project to 5.3
		} else {
			$path = array(
				'app',
				'module',
				$parts[1] . '-module',
				$parts[2]
			);
			$path = implode( DIRECTORY_SEPARATOR, $path ) . '/' . implode( DIRECTORY_SEPARATOR, array_slice( $parts, 3 ) ) . '.php';
			$path = wp_defender()->get_plugin_path() . str_replace( '_', '-', strtolower( $path ) );
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}
	}

	/**
	 * Require for register class inside a module
	 *
	 * @param $class
	 *
	 * @return mixed
	 */
	public function autoload( $class ) {
		if ( strpos( $class, "\\" ) !== false ) {
			//this is namespace loading
			$this->autoload_53( $class );
		} else {
			$this->autoload_52( $class );
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