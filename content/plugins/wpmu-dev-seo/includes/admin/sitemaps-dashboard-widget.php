<?php

/**
 * Init WDS Sitemaps Dashboard Widget
 */
class WDS_Sitemaps_Dashboard_Widget
{

	/**
	 * Init plugin
	 *
	 * @return  void
	 */
	public function __construct () {

		$this->init();

	}

	/**
	 * Init
	 *
	 * @return  void
	 */
	private function init () {
		add_action( 'wp_dashboard_setup', array( &$this, 'dashboard_widget' ) );
	}

	/**
	 * Dashboard Widget
	 */
	public function dashboard_widget () {
		if ( ! current_user_can( 'edit_posts' ) ) return false;
		wp_add_dashboard_widget( 'wds_sitemaps_dashboard_widget', __( 'Sitemaps', 'wds' ), array( &$this, 'widget' ) );
	}

	/**
	 * Widget
	 */
	public function widget () {
		$sitemap = get_option('wds_sitemap_options');
		$opts    = get_option('wds_sitemap_dashboard');
		$engines = get_option('wds_engine_notification');

		$date = @$opts['time'] ? date(get_option('date_format'), $opts['time']) : false;
		$time = @$opts['time'] ? date(get_option('time_format'), $opts['time']) : false;

		$datetime       = ($date && $time) ? sprintf(__('It was last updated on %s, at %s.', 'wds'), $date, $time) : __("Your sitemap hasn't been updated recently.", 'wds');
		$update_sitemap = __('Update sitemap now', 'wds');
		$update_engines = __('Force search engines notification', 'wds');
		$working = __('Updating...', 'wds');
		$done_msg = __('Done updating the sitemap, please hold on...', 'wds');

		$sitemap_url = wds_get_sitemap_url();

		include WDS_PLUGIN_DIR . 'admin/templates/sitemaps-dashboard-widget.php';

	}

}

// instantiate the Sitemaps Dashboard Widget class
$WDS_Sitemaps_Dashboard_Widget = new WDS_Sitemaps_Dashboard_Widget();