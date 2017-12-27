<?php

/**
 * Init WDS
 */
class WDS_Init
{

	/**
	 * Init plugin
	 *
	 * @return  void
	 */
	public function __construct()
	{

		$this->init();

	}

	/**
	 * Init
	 *
	 * @return  void
	 */
	private function init()
	{

		/**
		 * Load textdomain.
		 */
		if ( defined( 'WPMU_PLUGIN_DIR' ) && file_exists( WPMU_PLUGIN_DIR . '/wpmu-dev-seo.php' ) ) {
			load_muplugin_textdomain( 'wds', dirname(WDS_PLUGIN_BASENAME) . '/languages' );
		} else {
			load_plugin_textdomain( 'wds', false, dirname(WDS_PLUGIN_BASENAME) . '/languages' );
		}

		require_once ( WDS_PLUGIN_DIR . 'core/core-wpabstraction.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/class_wds_model.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/class_wds_endpoint_resolver.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/class_wds_model_redirection.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/class_wds_model_user.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/core.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/class_wds_logger.php' );

		require_once (WDS_PLUGIN_DIR . 'core/class_wds_settings.php');

		$wds_options = WDS_Settings::get_options();

		// Dashboard Shared UI Library
		require_once( WDS_PLUGIN_DIR . 'admin/shared-ui/plugin-ui.php');

		require_once(WDS_PLUGIN_DIR . 'core/class_wds_controller_sitemap.php');

		if (!class_exists('WDS_Controller_Cron')) {
			require_once(WDS_PLUGIN_DIR . '/core/class_wds_controller_cron.php');
			WDS_Controller_Cron::get()->run();
		}

		if( is_admin() ) {
			require_once ( WDS_PLUGIN_DIR . 'admin/admin.php' );
		}
		else {
			require_once ( WDS_PLUGIN_DIR . 'front.php' );
		}

		// Boot up the hub controller
		require_once (WDS_PLUGIN_DIR . 'core/class_wds_controller_hub.php');
		WDS_Controller_Hub::serve();
	}

}

// instantiate the Init class
$WDS_Init = new WDS_Init();