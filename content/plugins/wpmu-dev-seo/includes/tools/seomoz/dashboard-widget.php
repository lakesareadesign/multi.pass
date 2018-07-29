<?php

/**
 * Init WDS SEOMoz Dashboard Widget
 */
class Smartcrawl_Seomoz_Dashboard_Widget {

	/**
	 * Static instance
	 *
	 * @var Smartcrawl_Seomoz_Dashboard_Widget
	 */
	private static $_instance;

	/**
	 * State flag
	 *
	 * @var bool
	 */
	private $_is_running = false;

	public function __construct() {
	}

	/**
	 * Boot the hooking part
	 */
	public static function run() {
		self::get()->init();
	}

	/**
	 * Init
	 *
	 * @return  void
	 */
	private function init() {
		if ( $this->_is_running ) {
			return;
		}

		add_action( 'wp_dashboard_setup', array( &$this, 'dashboard_widget' ) );

		$this->_is_running = true;
	}

	/**
	 * Static instance getter
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Widget
	 */
	public static function widget() {
		$renderer = new Smartcrawl_Seomoz_Dashboard_Widget_Renderer();
		$renderer->render();
	}

	/**
	 * Dashboard Widget
	 */
	public function dashboard_widget() {

		if ( ! current_user_can( 'edit_posts' ) ) {
			return false;
		}
		wp_add_dashboard_widget( 'wds_seomoz_dashboard_widget', __( 'Moz - SmartCrawl', 'wds' ), array(
			&$this,
			'widget',
		) );

	}

}