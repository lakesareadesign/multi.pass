<?php

/**
 * Init WDS SEOMoz Results
 */
class Smartcrawl_Seomoz_Results {


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

		require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/seomoz/api.php' );

		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );

	}

	/**
	 * Adds a box to the main column on the Post and Page edit screens
	 */
	public function add_meta_boxes() {

		$show = user_can_see_urlmetrics_metabox();
		foreach ( get_post_types() as $post_type ) {
			if ( $show ) {
				add_meta_box(
					'wds_seomoz_urlmetrics',
					__( 'SEOmoz URL Metrics' , 'wds' ),
					array( &$this, 'urlmetrics_box' ),
					$post_type,
					'normal',
					'high'
				);
			}
		}

	}

	/**
	 * Prints the box content
	 */
	public function urlmetrics_box( $post ) {

		$smartcrawl_options = Smartcrawl_Settings::get_options();

		$page       = str_replace( '/', '%252F', untrailingslashit( str_replace( 'http://', '', get_permalink( $post->ID ) ) ) );
		$seomozapi  = new SEOMozAPI( $smartcrawl_options['access-id'], $smartcrawl_options['secret-key'] );
		$urlmetrics = $seomozapi->urlmetrics( $page );

		include SMARTCRAWL_PLUGIN_DIR . 'admin/templates/urlmetrics-metabox.php';

	}

}

// instantiate the SEOMoz Results class
$Smartcrawl_Seomoz_Results = new Smartcrawl_Seomoz_Results();
