<?php
/**
 * Initializes plugin front-end behavior
 *
 * @package wpmu-dev-seo
 */

/**
 * Frontend init class
 */
class Smartcrawl_Front {


	/**
	 * Constructor
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Initializing method
	 */
	private function init() {
		$smartcrawl_options = Smartcrawl_Settings::get_options();

		require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/redirect.php' );

		require_once( SMARTCRAWL_PLUGIN_DIR . 'core/class_wds_service.php' );
		if ( Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_SITE )->is_member() ) {
			if ( ! empty( $smartcrawl_options['autolinks'] ) ) {
				require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/autolinks.php' );
			}
		}
		if ( ! empty( $smartcrawl_options['sitemap'] ) ) {
			require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/sitemaps.php' );
			require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/settings.php' );
			require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/settings/sitemap.php' ); // This is to propagate defaults without admin visiting the dashboard.
		}
		if ( ! empty( $smartcrawl_options['onpage'] ) ) {
			require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/onpage.php' );
		}

		if ( ! empty( $smartcrawl_options['social'] ) ) {
			require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/class_wds_opengraph_printer.php' );
			if ( class_exists( 'Smartcrawl_OpenGraph_Printer' ) ) {
				Smartcrawl_OpenGraph_Printer::run();
			}
			require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/class_wds_twitter_printer.php' );
			if ( class_exists( 'Smartcrawl_Twitter_Printer' ) ) {
				Smartcrawl_Twitter_Printer::run();
			}
			require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/class_wds_pinterest_printer.php' );
			if ( class_exists( 'Smartcrawl_Pinterest_Printer' ) ) {
				Smartcrawl_Pinterest_Printer::run();
			}
			require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/class_wds_schema_printer.php' );
			if ( class_exists( 'Smartcrawl_Schema_Printer' ) ) {
				Smartcrawl_Schema_Printer::run();
			}
		}

		if ( defined( 'SMARTCRAWL_EXPERIMENTAL_FEATURES_ON' ) && SMARTCRAWL_EXPERIMENTAL_FEATURES_ON ) {
			if ( file_exists( SMARTCRAWL_PLUGIN_DIR . 'tools/video_sitemaps.php' ) ) {
				require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/video_sitemaps.php' );
			}
		}

	}

}

$Smartcrawl_Front = new Smartcrawl_Front();