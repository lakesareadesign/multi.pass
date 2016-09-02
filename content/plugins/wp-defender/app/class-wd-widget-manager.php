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
		if ( ! is_admin() ) {
			//we dont need this to load on frontend
			return;
		}

		$widgets = array(
			'WD_Backup_Widget',
			'WD_Blacklist_Widget',
			'WD_Performance_Widget',
			'WD_Audit_Log_Widget',
			'WD_Hardener_Widget',
			'WD_Scan_Widget'
		);

		foreach ( $widgets as $widget ) {
			if ( class_exists( $widget ) ) {
				$this->_widgets[ $widget ] = new $widget;
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