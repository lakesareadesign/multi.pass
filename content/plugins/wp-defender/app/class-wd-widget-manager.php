<?php

/**
 * @author: Hoang Ngo
 */
class WD_Widget_Manager extends WD_Component {
	protected $_widgets = array();

	/**
	 * Refers to the single instance of the class
	 *
	 * @access private
	 * @var object
	 */
	private static $_instance = null;

	/**
	 * Gets the single instance of the class
	 *
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new WD_Widget_Manager();
		}

		return self::$_instance;
	}

	/**
	 * Need to load all the widget in init, or some ajax funciton won't work
	 */
	public function prepare_widgets() {
		$files_mapped = wp_defender()->files_mapped;

		foreach ( $files_mapped as $file ) {
			//determine the class name
			$filename = pathinfo( $file, PATHINFO_FILENAME );
			if ( strpos( $filename, '-widget' ) != ( strlen( $filename ) - strlen( '-widget' ) ) ) {
				continue;
			}
			$parts = explode( '-', $filename );

			//remove the class part
			unset( $parts[0] );
			//part 1 usullay the prefix, so we remove to
			unset( $parts[1] );
			$parts = array_map( 'ucfirst', $parts );

			$class = str_replace( ' ', '_', 'WD_' . implode( ' ', $parts ) );
			if ( class_exists( $class ) ) {
				$this->_widgets[ $class ] = new $class;
			}
		}
	}

	/**
	 * @param $widget string
	 *
	 * @return mixed
	 */
	public function factory( $widget ) {
		if ( isset( $this->_widgets[ $widget ] ) ) {
			return $this->_widgets[ $widget ];
		}

		return null;
	}

	/**
	 * Display provided widget, if available
	 *
	 * @param $widget string
	 *
	 * @return null
	 */
	public function display( $widget ) {
		$object = $this->factory( $widget );
		if ( ! is_object( $object ) ) {
			return null;
		}

		return $object->display();
	}
}