<?php
/**
 * General plugin initialization
 *
 * @package wpmu-dev-seo
 */

/**
 * Init WDS
 */
class Smartcrawl_Init {


	/**
	 * Init plugin
	 *
	 * @return  void
	 */
	public function __construct() {

		$this->init();

	}

	/**
	 * Init
	 *
	 * @return  void
	 */
	private function init() {

		/**
		 * Load textdomain.
		 */
		if ( defined( 'WPMU_PLUGIN_DIR' ) && file_exists( WPMU_PLUGIN_DIR . '/wpmu-dev-seo.php' ) ) {
			load_muplugin_textdomain( 'wds', dirname( SMARTCRAWL_PLUGIN_BASENAME ) . '/languages' );
		} else {
			load_plugin_textdomain( 'wds', false, dirname( SMARTCRAWL_PLUGIN_BASENAME ) . '/languages' );
		}

		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/core-wpabstraction.php' );
		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/class_wds_model.php' );
		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/class_wds_endpoint_resolver.php' );
		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/class_wds_model_redirection.php' );
		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/class_wds_model_user.php' );
		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/core.php' );
		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/class_wds_logger.php' );

		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/class_wds_settings.php' );

		$smartcrawl_options = Smartcrawl_Settings::get_options();

		// Dashboard Shared UI Library.
		require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/shared-ui/plugin-ui.php' );

		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/class_wds_controller_sitemap.php' );

		if ( ! class_exists( 'Smartcrawl_Controller_Cron' ) ) {
			require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_controller_cron.php' );
			Smartcrawl_Controller_Cron::get()->run();
		}

		if ( is_admin() ) {
			require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/admin.php' );
		} else {
			require_once( SMARTCRAWL_PLUGIN_DIR . 'front.php' );
		}

		// Boot up the hub controller.
		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/class_wds_controller_hub.php' );
		Smartcrawl_Controller_Hub::serve();
	}

}

// instantiate the Init class.
$Smartcrawl_Init = new Smartcrawl_Init();