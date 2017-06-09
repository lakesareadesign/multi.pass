<?php

class WDS_Front
{

	public function __construct()
	{

		$this->init();

	}

	private function init () {

		global $wds_options;

		require_once ( WDS_PLUGIN_DIR . 'tools/redirect.php' );


		if( ! empty( $wds_options['autolinks'] ) ) {
			require_once ( WDS_PLUGIN_DIR . 'tools/autolinks.php' );
		}
		if( WDS_Settings::get_option('sitemap') ) {
			require_once ( WDS_PLUGIN_DIR . 'tools/sitemaps.php' );
			require_once ( WDS_PLUGIN_DIR . 'admin/settings.php' );
			require_once ( WDS_PLUGIN_DIR . 'admin/settings/sitemap.php' ); // This is to propagate defaults without admin visiting the dashboard.
		}
		if( ! empty( $wds_options['onpage'] ) ) {
			require_once ( WDS_PLUGIN_DIR . 'tools/onpage.php' );

			require_once (WDS_PLUGIN_DIR . 'tools/class_wds_opengraph_printer.php');
			if (class_exists('Wds_OpenGraph_Printer')) {
				Wds_OpenGraph_Printer::run();
			}
		}

		if( defined( 'WDS_EXPERIMENTAL_FEATURES_ON' ) && WDS_EXPERIMENTAL_FEATURES_ON ) {
			require_once ( WDS_PLUGIN_DIR . 'tools/video_sitemaps.php' );
		}

	}

}

$WDS_Front = new WDS_Front();