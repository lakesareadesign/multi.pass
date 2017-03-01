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
			load_muplugin_textdomain( 'wds', dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		} else {
			load_plugin_textdomain( 'wds', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		require_once ( WDS_PLUGIN_DIR . 'core/core-wpabstraction.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/class_wds_model.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/class_wds_model_redirection.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/class_wds_model_user.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/core.php' );
		require_once ( WDS_PLUGIN_DIR . 'core/class_wds_logger.php' );

		require_once (WDS_PLUGIN_DIR . 'core/class_wds_settings.php');

		global $wds_options;
		$wds_options = get_wds_options();

		// Dashboard Shared UI Library
		require_once( WDS_PLUGIN_DIR . 'admin/shared-ui/plugin-ui.php');

		require_once(WDS_PLUGIN_DIR . 'core/class_wds_controller_sitemap.php');

		if( is_admin() ) {
			require_once ( WDS_PLUGIN_DIR . 'admin/admin.php' );
		}
		else {
			require_once ( WDS_PLUGIN_DIR . 'front.php' );
		}

	}

}

// instantiate the Init class
$WDS_Init = new WDS_Init();