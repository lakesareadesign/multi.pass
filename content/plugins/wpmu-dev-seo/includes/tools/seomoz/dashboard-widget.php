<?php

/**
 * Init WDS SEOMoz Dashboard Widget
 */
class Smartcrawl_Seomoz_Dashboard_Widget {


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

		add_action( 'wp_dashboard_setup', array( &$this, 'dashboard_widget' ) );

	}

	/**
	 * Dashboard Widget
	 */
	public function dashboard_widget() {

		if ( ! current_user_can( 'edit_posts' ) ) { return false; }
		wp_add_dashboard_widget( 'wds_seomoz_dashboard_widget', __( 'Moz', 'wds' ), array( &$this, 'widget' ) );

	}

	/**
	 * Widget
	 */
	public static function widget() {
		$smartcrawl_options = Smartcrawl_Settings::get_options();

		if ( empty( $smartcrawl_options['access-id'] ) || empty( $smartcrawl_options['secret-key'] ) ) {
			_e( '<p>Moz credentials not properly set up.</p>', 'wds' );
			return;
		}

		$target_url = preg_replace( '!http(s)?:\/\/!', '', get_bloginfo( 'url' ) );
		$seomozapi = new SEOMozAPI( $smartcrawl_options['access-id'], $smartcrawl_options['secret-key'] );
		$urlmetrics = $seomozapi->urlmetrics( $target_url );

		$attribution = str_replace( '/', '%252F', untrailingslashit( $target_url ) );
		$attribution = "http://www.opensiteexplorer.org/links?site={$attribution}";

		if ( ! is_object( $urlmetrics ) ) {
			printf( __( 'Unable to retrieve data from the Moz API. Error: %s.' , 'wds' ), $urlmetrics );
			return;
		}

		include SMARTCRAWL_PLUGIN_DIR . 'admin/templates/seomoz-dashboard-widget.php';

	}

}

// instantiate the SEOMoz Dashboard Widget class
$Smartcrawl_Seomoz_Dashboard_Widget = new Smartcrawl_Seomoz_Dashboard_Widget();