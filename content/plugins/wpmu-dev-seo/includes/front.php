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

		Smartcrawl_Redirection_Front::serve();

		if ( Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_SITE )->is_member() ) {
			if ( ! empty( $smartcrawl_options['autolinks'] ) ) {
				Smartcrawl_Autolinks::get();
			}
		}
		if ( ! empty( $smartcrawl_options['onpage'] ) ) {
			Smartcrawl_OnPage::get()->run();
		}

		if ( ! empty( $smartcrawl_options['social'] ) ) {
			Smartcrawl_OpenGraph_Printer::run();
			Smartcrawl_Twitter_Printer::run();
			Smartcrawl_Pinterest_Printer::run();
			Smartcrawl_Schema_Printer::run();
		}

		if ( defined( 'SMARTCRAWL_EXPERIMENTAL_FEATURES_ON' ) && SMARTCRAWL_EXPERIMENTAL_FEATURES_ON ) {
			if ( file_exists( SMARTCRAWL_PLUGIN_DIR . 'tools/video_sitemaps.php' ) ) {
				require_once SMARTCRAWL_PLUGIN_DIR . 'tools/video_sitemaps.php';
			}
		}

		Smartcrawl_Compatibility::run();

		add_filter( 'the_content', array( $this, 'process_frontend_rendering' ), 999 );

	}

	public function process_frontend_rendering( $content ) {
		if ( ! isset( $_GET['wds-frontend-check'] ) ) { // phpcs:ignore -- Nonce not necessary
			return $content;
		}

		return '<div class="wds-frontend-content-check">' . $content . '</div>';
	}

}

$smartcrawl_front = new Smartcrawl_Front();