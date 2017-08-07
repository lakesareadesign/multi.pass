<?php

namespace DeliciousBrains\WP_Offload_S3_Assets\Tools;

use AS3CF_Utils;
use DeliciousBrains\WP_Offload_S3\Pro\Background_Processes\Background_Tool_Process;
use DeliciousBrains\WP_Offload_S3\Pro\Background_Tool;

class Process_Assets extends Background_Tool {

	/**
	 * @var \Amazon_S3_And_CloudFront_Assets
	 */
	protected $as3cf;

	/**
	 * @var string
	 */
	protected $tool_key = 'process_assets';

	/**
	 * @var string
	 */
	protected $tab = 'assets';

	/**
	 * @var string
	 */
	protected $view = 'process-assets';

	/**
	 * Initialize the tool.
	 */
	public function init() {
		parent::init();

		// JS data
		add_filter( 'as3cfpro_js_nonces', array( $this, 'add_js_nonces' ) );
		add_action( "wp_ajax_as3cfpro_{$this->tool_key}_purge", array( $this, 'ajax_handle_purge' ) );
	}

	/**
	 * Add the nonces to the JavaScript.
	 *
	 * @param array $js_nonces
	 *
	 * @return array
	 */
	public function add_js_nonces( $js_nonces ) {
		$js_nonces['tools'][ $this->tool_key ] = $this->create_tool_nonces( array( 'start', 'purge' ) );

		return $js_nonces;
	}

	/**
	 * Get the sidebar notice details
	 *
	 * @return false|array
	 */
	protected function get_sidebar_block_args() {
		return array(
			'title'              => $this->get_title_text(),
			'more_info'          => $this->get_more_info_text(),
			'status_description' => $this->get_status_description(),
			'button'             => $this->get_button_text(),
			'is_queued'          => $this->is_queued(),
			'progress_percent'   => $this->get_progress(),
			'next_scan'          => $this->get_next_scan_text(),
			'scan_allowed'       => $this->scan_allowed(),
			'purge_allowed'      => $this->purge_allowed(),
		);
	}

	/**
	 * Get status.
	 *
	 * @return array
	 */
	public function get_status() {
		return array(
			'should_render' => $this->should_render(),
			'progress'      => $this->get_progress(),
			'is_queued'     => $this->is_queued(),
			'description'   => $this->get_status_description(),
			'next_scan'     => $this->get_next_scan_text(),
			'scan_allowed'  => $this->scan_allowed(),
			'purge_allowed' => $this->purge_allowed(),
		);
	}

	/**
	 * Get title text.
	 *
	 * @return string
	 */
	public function get_title_text() {
		return __( 'Assets Status', 'as3cf-assets' );
	}

	/**
	 * Get button text.
	 *
	 * @return string
	 */
	public function get_button_text() {
		return esc_html_x( 'Scan Now', 'Scan the filesystem for files to upload to S3', 'as3cf-assets' );
	}

	/**
	 * Get queued status text.
	 *
	 * @return string
	 */
	public function get_queued_status() {
		return '';
	}

	/**
	 * Get status description.
	 *
	 * @return string
	 */
	public function get_status_description() {
		if ( $this->as3cf->is_scanning() || $this->as3cf->is_processing() ) {
			$message = __( 'Scanning and uploading files to S3.', 'as3cf-assets' );
		} elseif ( $this->as3cf->is_purging() ) {
			$message = __( 'Purging files from S3.', 'as3cf-assets' );
		} elseif ( ! (bool) $this->as3cf->get_setting( 'enable-addon' ) ) {
			$message = __( 'No CSS or JS is being served because "Copy & Serve" is off.', 'as3cf-assets' );
		} else {
			$message = $this->scripts_served_message();
		}

		return $message;
	}

	/**
	 * Get message contents for scripts being served or not
	 *
	 * @return string Message content
	 */
	private function scripts_served_message() {
		$css_count = $this->as3cf->count_scripts_being_served( 'css' );
		$js_count  = $this->as3cf->count_scripts_being_served( 'js' );
		$url       = $this->as3cf->dbrains_url( '/wp-offload-s3/doc/assets-addon/', array(
			'utm_campaign' => 'addons+install',
		), 'serving-urls' );

		if ( $this->as3cf->count_files() ) {
			// Files have been uploaded, but may or may be served
			if ( 0 === ( $css_count + $js_count ) ) {
				$more_info_link = AS3CF_Utils::dbrains_link( $url, _x( 'Why?', 'Why are css and js assets not serving?', 'as3cf-assets' ) );
				$message        = sprintf( __( 'CSS and JS files have been uploaded to S3 but none of the files have been served just yet. %s', 'as3cf-assets' ), $more_info_link );
			} else {
				$more_info_link = $this->as3cf->more_info_link( $url, 'serving-urls' );
				$message        = sprintf( __( '%d JS and %d CSS enqueued files are currently being served. %s', 'as3cf-assets' ), $js_count, $css_count, $more_info_link );
			}
		} else {
			// No files have been uploaded or are being served
			$more_info_link = AS3CF_Utils::dbrains_link( $url, _x( 'Why?', 'Why are css and js assets not serving?', 'as3cf-assets' ) );
			$message        = sprintf( __( 'No CSS or JS files are being served. %s', 'as3cf-assets' ), $more_info_link );
		}

		return $message;
	}

	/**
	 * Returns text to be displayed in Next Scan block.
	 *
	 * @return string
	 */
	private function get_next_scan_text() {
		if ( ! $this->as3cf->is_plugin_enabled() ) {
			return '';
		}

		$next_scan_time = $this->as3cf->get_next_scan_time();
		$next_scan      = empty( $next_scan_time ) ? '' : esc_html__( 'Next scan:', 'as3cf-assets' ) . date( ' M d, Y @ H:i', $next_scan_time );

		return $next_scan;
	}

	/**
	 * Can a scan be performed?
	 *
	 * @return bool
	 */
	private function scan_allowed() {
		return $this->as3cf->is_plugin_enabled();
	}

	/**
	 * Can a purge be performed?
	 *
	 * @return bool
	 */
	private function purge_allowed() {
		if ( ! $this->as3cf->is_plugin_setup() ) {
			return false;
		}

		if ( ! $this->as3cf->count_files() ) {
			return false;
		}

		return true;
	}

	/**
	 * Get progress.
	 *
	 * @return int
	 */
	public function get_progress() {
		return $this->as3cf->get_scan_progress();
	}

	/**
	 * Is processing.
	 *
	 * @return bool
	 */
	public function is_queued() {
		return $this->as3cf->is_scanning() || $this->as3cf->is_processing() || $this->as3cf->is_purging();
	}

	/**
	 * AJAX handle start.
	 */
	public function ajax_handle_start() {
		check_ajax_referer( $this->tool_key . '_start', 'nonce' );

		if ( $this->is_queued() ) {
			return;
		}

		$this->as3cf->initiate_scan_files_for_s3();
	}

	/**
	 * AJAX handle purge.
	 */
	public function ajax_handle_purge() {
		check_ajax_referer( $this->tool_key . '_purge', 'nonce' );

		if ( $this->is_queued() ) {
			return;
		}

		$this->as3cf->initiate_remove_files_from_s3();
	}

	/**
	 * Get background process class.
	 *
	 * @return Background_Tool_Process|null
	 */
	protected function get_background_process_class() {
		return null;
	}

	/**
	 * Should render?
	 *
	 * @return bool
	 */
	public function should_render() {
		return $this->as3cf->is_plugin_setup();
	}

}