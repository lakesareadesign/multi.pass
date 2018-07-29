<?php

/**
 * Init WDS Sitemaps Dashboard Widget
 */
class Smartcrawl_Sitemaps_Dashboard_Widget {

	/**
	 * Static instance
	 *
	 * @var Smartcrawl_Sitemaps_Dashboard_Widget
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
	 * Dashboard Widget
	 */
	public function dashboard_widget() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return false;
		}
		wp_add_dashboard_widget( 'wds_sitemaps_dashboard_widget', __( 'Sitemaps - SmartCrawl', 'wds' ), array(
			&$this,
			'widget',
		) );
	}

	/**
	 * Widget
	 */
	public function widget() {
		$sitemap = get_option( 'wds_sitemap_options' );
		$opts = get_option( 'wds_sitemap_dashboard' );
		$engines = get_option( 'wds_engine_notification' );

		$date = ! empty( $opts['time'] ) ? date( get_option( 'date_format' ), $opts['time'] ) : false;
		$time = ! empty( $opts['time'] ) ? date( get_option( 'time_format' ), $opts['time'] ) : false;

		$datetime = ( $date && $time )
			? sprintf( __( 'It was last updated on %1$s, at %2$s.', 'wds' ), $date, $time )
			: __( "Your sitemap hasn't been updated recently.", 'wds' );
		$update_sitemap = __( 'Update sitemap now', 'wds' );
		$update_engines = __( 'Force search engines notification', 'wds' );
		$working = __( 'Updating...', 'wds' );
		$done_msg = __( 'Done updating the sitemap, please hold on...', 'wds' );

		$sitemap_url = smartcrawl_get_sitemap_url();

		include SMARTCRAWL_PLUGIN_DIR . 'admin/templates/sitemaps-dashboard-widget.php';

	}

}