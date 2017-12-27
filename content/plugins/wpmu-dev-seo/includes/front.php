<?php

class WDS_Front
{

	public function __construct()
	{

		$this->init();

	}

	private function init () {

		$wds_options = WDS_Settings::get_options();

		require_once ( WDS_PLUGIN_DIR . 'tools/redirect.php' );


		require_once(WDS_PLUGIN_DIR . 'core/class_wds_service.php');
		if (WDS_Service::get(WDS_Service::SERVICE_SITE)->is_member()) {
			if( ! empty( $wds_options['autolinks'] ) ) {
				require_once ( WDS_PLUGIN_DIR . 'tools/autolinks.php' );
			}
		}
		if( ! empty( $wds_options['sitemap'] ) ) {
			require_once ( WDS_PLUGIN_DIR . 'tools/sitemaps.php' );
			require_once ( WDS_PLUGIN_DIR . 'admin/settings.php' );
			require_once ( WDS_PLUGIN_DIR . 'admin/settings/sitemap.php' ); // This is to propagate defaults without admin visiting the dashboard.
		}
		if( ! empty( $wds_options['onpage'] ) ) {
			require_once ( WDS_PLUGIN_DIR . 'tools/onpage.php' );
		}

		if (!empty($wds_options['social'])) {
			require_once (WDS_PLUGIN_DIR . 'tools/class_wds_opengraph_printer.php');
			if (class_exists('WDS_OpenGraph_Printer')) {
				WDS_OpenGraph_Printer::run();
			}
			require_once(WDS_PLUGIN_DIR . 'tools/class_wds_twitter_printer.php');
			if (class_exists('WDS_Twitter_Printer')) {
				WDS_Twitter_Printer::run();
			}
			require_once(WDS_PLUGIN_DIR . 'tools/class_wds_pinterest_printer.php');
			if (class_exists('WDS_Pinterest_Printer')) {
				WDS_Pinterest_Printer::run();
			}
			require_once(WDS_PLUGIN_DIR . 'tools/class_wds_schema_printer.php');
			if (class_exists('WDS_Schema_Printer')) {
				WDS_Schema_Printer::run();
			}
		}

		if( defined( 'WDS_EXPERIMENTAL_FEATURES_ON' ) && WDS_EXPERIMENTAL_FEATURES_ON ) {
			require_once ( WDS_PLUGIN_DIR . 'tools/video_sitemaps.php' );
		}

	}

}

$WDS_Front = new WDS_Front();