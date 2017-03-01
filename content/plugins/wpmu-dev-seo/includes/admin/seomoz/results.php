<?php

/**
 * Init WDS SEOMoz Results
 */
class WDS_Seomoz_Results
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

		require_once ( WDS_PLUGIN_DIR . 'admin/seomoz/api.php' );

		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );

	}

	/**
	 * Adds a box to the main column on the Post and Page edit screens
	 */
	public function add_meta_boxes() {

		$show = user_can_see_urlmetrics_metabox();
		foreach( get_post_types() as $post_type ) {
			if ($show) {
				add_meta_box(
					'wds_seomoz_urlmetrics',
					__( 'SEOmoz URL Metrics' , 'wds'),
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
	public function urlmetrics_box($post) {

		global $wds_options;

		$page       = str_replace( '/', '%252F', untrailingslashit( str_replace( 'http://', '', get_permalink( $post->ID ) ) ) );
		$seomozapi  = new SEOMozAPI( $wds_options['access-id'], $wds_options['secret-key'] );
		$urlmetrics = $seomozapi->urlmetrics( $page );

		include WDS_PLUGIN_DIR . 'admin/templates/urlmetrics-metabox.php';

	}

}

// instantiate the SEOMoz Results class
$WDS_Seomoz_Results = new WDS_Seomoz_Results();
