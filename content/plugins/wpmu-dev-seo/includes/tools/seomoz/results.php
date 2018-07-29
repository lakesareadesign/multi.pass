<?php

/**
 * Init WDS SEOMoz Results
 */
class Smartcrawl_Seomoz_Results extends Smartcrawl_Renderable {

	/**
	 * Static instance
	 *
	 * @var Smartcrawl_Seomoz_Results
	 */
	private static $_instance;

	/**
	 * State flag
	 *
	 * @var bool
	 */
	private $_is_running = false;

	public function __construct() {
	}

	/**
	 * Boot the hooking part
	 */
	public static function run() {
		self::get()->init();
	}

	/**
	 * Init
	 *
	 * @return  void
	 */
	private function init() {
		if ( $this->_is_running ) {
			return;
		}

		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );

		$this->_is_running = true;
	}

	/**
	 * Static instance getter
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
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
					__( 'Moz URL Metrics - SmartCrawl', 'wds' ),
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
		?>
		<div class="wpmud"><?php $this->display_urlmetrics( $post ); ?></div>
		<?php
	}

	public function display_urlmetrics( $post ) {
		$smartcrawl_options = Smartcrawl_Settings::get_options();
		if ( empty( $smartcrawl_options['access-id'] ) || empty( $smartcrawl_options['secret-key'] ) ) {
			$this->_render( 'notice', array(
				'class'   => 'wds-notice-error',
				'message' => esc_html__( 'Moz credentials not properly set up.', 'wds' ),
			) );

			return;
		}
		$page = preg_replace( '!http(s)?:\/\/!', '', get_permalink( $post->ID ) );
		$seomozapi = new SEOMozAPI( $smartcrawl_options['access-id'], $smartcrawl_options['secret-key'] );
		$urlmetrics = $seomozapi->urlmetrics( $page );

		if ( is_object( $urlmetrics ) && $seomozapi->is_response_valid( $urlmetrics ) ) {
			$this->_render( 'urlmetrics-metabox', array(
				'urlmetrics' => $urlmetrics,
				'page'       => str_replace( '/', '%252F', $page ),
			) );
		} else {
			$error = isset( $urlmetrics->error_message ) ? $urlmetrics->error_message : '';
			$message = sprintf(
				"%s<br/><span class='wds-small-text'>%s</span>",
				esc_html__( 'Unable to retrieve data from the Moz API.', 'wds' ),
				$error
			);

			$this->_render( 'notice', array(
				'class'   => 'wds-notice-error',
				'message' => $message,
			) );
		}
	}

	protected function _get_view_defaults() {
		return array();
	}
}