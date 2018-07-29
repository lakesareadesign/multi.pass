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

		require_once SMARTCRAWL_PLUGIN_DIR . 'core/core-wpabstraction.php';
		require_once SMARTCRAWL_PLUGIN_DIR . 'core/core.php';

		// Dashboard Shared UI Library.
		require_once SMARTCRAWL_PLUGIN_DIR . 'admin/shared-ui/plugin-ui.php';

		Smartcrawl_Controller_Sitemap::serve();

		Smartcrawl_Controller_Cron::get()->run();

		if ( is_admin() ) {
			require_once SMARTCRAWL_PLUGIN_DIR . 'admin/admin.php';
		} else {
			require_once SMARTCRAWL_PLUGIN_DIR . 'front.php';
		}

		// Boot up the hub controller.
		Smartcrawl_Controller_Hub::serve();
	}

}

// instantiate the Init class.
$smartcrawl_init = new Smartcrawl_Init();