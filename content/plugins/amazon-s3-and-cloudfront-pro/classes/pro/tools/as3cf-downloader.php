<?php
/**
 * Downloader Tool
 *
 * @package     amazon-s3-and-cloudfront-pro
 * @subpackage  Classes/Tools/Downloader
 * @copyright   Copyright (c) 2016, Delicious Brains
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AS3CF_Downloader Class
 *
 * This class handles downloading attachments from S3
 *
 * @since 1.1
 */
class AS3CF_Downloader extends AS3CF_Tool {

	/**
	 * @var string
	 */
	protected $tool_key = 'downloader';

	/**
	 * @var bool
	 */
	protected $show_file_size = false;

	/**
	 * @var string
	 */
	protected $last_processed_key;

	/**
	 * @var bool
	 */
	protected static $deactivate_prompt_rendered = false;

	/**
	 * Initialize Downloader
	 */
	public function init() {
		parent::init();

		$this->last_processed_key = 'wpos3_tool_' . $this->tool_key . '_last_id';

		$this->maybe_render_deactivate_prompt();
	}

	/**
	 * Get the details for the sidebar block
	 *
	 * @return array|bool
	 */
	protected function get_sidebar_notice_args() {
		if ( ! $this->as3cf->is_plugin_setup() ) {
			// Don't show tool if not setup
			return false;
		}

		$to_process_stats = $this->get_attachments_to_process_stats();

		// Don't show tool if media library empty
		if ( 0 === $to_process_stats['total_attachments'] ) {
			return false;
		}

		// Don't show tool if no attachments uploaded to S3
		if ( 0 === $to_process_stats['total_to_process'] ) {
			return false;
		}

		$button_title = __( 'Begin Download', 'amazon-s3-and-cloudfront' );
		if ( false !== $this->get_resume_offset() ) {
			$button_title = __( 'Resume Download', 'amazon-s3-and-cloudfront' );
		}

		$args = array(
			'title'        => __( 'Download all files from S3 to server', 'amazon-s3-and-cloudfront' ),
			'button_title' => $button_title,
			'description'  => __( 'If you\'ve ever had the "Remove Files From Server" option on, some Media Library files are likely missing on your server. You can use this tool to download any missing files back to your server.', 'amazon-s3-and-cloudfront' ),
		);

		return $args;
	}

	/**
	 * Add our tools strings for Javascript
	 *
	 * @return array
	 */
	protected function get_tool_js_strings() {
		$strings = array(
			'tool_title'                        => __( 'Downloading Media Library from S3', 'amazon-s3-and-cloudfront' ),
			'zero_files_processed'              => _x( 'Files Processed', 'Number of files downloaded from S3', 'amazon-s3-and-cloudfront' ),
			'files_processed'                   => _x( '%1$d of %2$d Files Downloaded', 'Number of files out of total downloaded from S3', 'amazon-s3-and-cloudfront' ),
			'completed_with_some_errors'        => __( 'Download completed with some errors', 'amazon-s3-and-cloudfront' ),
			'partial_complete_with_some_errors' => __( 'Download partially completed with some errors', 'amazon-s3-and-cloudfront' ),
			'cancelling_process'                => _x( 'Cancelling download', 'The download is being cancelled', 'amazon-s3-and-cloudfront' ),
			'completing_current_request'        => __( 'Completing current media download batch', 'amazon-s3-and-cloudfront' ),
			'paused'                            => _x( 'Paused', 'The download has been temporarily stopped', 'amazon-s3-and-cloudfront' ),
			'pausing'                           => _x( 'Pausing&hellip;', 'The download is being paused', 'amazon-s3-and-cloudfront' ),
			'process_cancellation_failed'       => __( 'Download cancellation failed', 'amazon-s3-and-cloudfront' ),
			'process_cancelled'                 => _x( 'Download cancelled', 'The download has been cancelled', 'amazon-s3-and-cloudfront' ),
			'finalizing_process'                => _x( 'Finalizing download', 'The download is in the last stages', 'amazon-s3-and-cloudfront' ),
			'sure'                              => _x( 'Are you sure you want to leave whilst download from S3?', 'Confirmation required', 'amazon-s3-and-cloudfront' ),
			'process_failed'                    => _x( 'Download failed', 'Download of attachments from S3 did not complete', 'amazon-s3-and-cloudfront' ),
			'process_paused'                    => _x( 'Download Paused', 'The download has been temporarily stopped', 'amazon-s3-and-cloudfront' ),
		);

		return $strings;
	}

	/**
	 * Get the last attachment processed to be used as an offset
	 *
	 * @return false|array
	 */
	public function get_resume_offset() {
		return get_site_option( $this->last_processed_key, false );
	}

	/**
	 * Inject the last processed attachment to the blogs data to resume a download
	 * where it last stopped.
	 *
	 * @return array
	 */
	protected function get_blogs_data() {
		$blogs = parent::get_blogs_data();

		if ( false !== ( $last_processed_attachment = $this->get_resume_offset() ) ) {
			if ( is_array( $last_processed_attachment ) ) {
				$blogs[ $last_processed_attachment['blog_id'] ]['last_attachment'] = $last_processed_attachment['attachment_id'];
			}
		}

		return $blogs;
	}

	/**
	 * Get the attachments uploaded to S3
	 *
	 * @param string     $prefix
	 * @param int        $blog_id
	 * @param bool       $count
	 * @param null|int   $limit
	 * @param null|int   $offset
	 * @param null|array $exclude
	 *
	 * @return array|int
	 */
	protected function get_attachments_to_process( $prefix, $blog_id, $count = false, $limit = null, $offset = null, $exclude = null ) {
		global $wpdb;

		$limit_sql = $offset_sql = $where_sql = '';

		if ( $count ) {
			$select_sql = 'SELECT COUNT(*)';
			$action     = 'get_var';
		} else {
			$select_sql = "SELECT pm.`post_id` as ID, pm.`meta_value` as 'data', {$blog_id} AS 'blog_id'";
			if ( ! is_null( $offset ) ) {
				$offset = absint( $offset );
				$offset_sql .= "AND pm.`post_id` > {$offset}";
			}
			if ( ! is_null( $limit ) ) {
				$limit     = absint( $limit );
				$limit_sql = "LIMIT {$limit}";
			}
			if ( ! is_null( $exclude ) ) {
				$post__not_in = implode( ',', array_map( 'absint', (array) $exclude ) );
				$where_sql    = "AND pm.`post_id` not in ({$post__not_in})";
			}

			$action = 'get_results';
		}

		$sql = $select_sql . ' ';
		$sql .= "FROM `{$prefix}postmeta` pm
				WHERE pm.`meta_key` = 'amazonS3_info'";
		$sql .= ' ' . $where_sql;
		$sql .= ' ' . $offset_sql;
		$sql .= ' ORDER BY pm.`post_id`';
		$sql .= ' ' . $limit_sql;

		$results = $wpdb->$action( $sql );

		return $results;
	}

	/**
	 * Download the attachment from S3
	 *
	 * @param int   $attachment_id
	 * @param int   $blog_id
	 *
	 * @return bool
	 */
	protected function handle_attachment( $attachment_id, $blog_id ) {
		// Copy back S3 file to local, only when files don't exist locally
		$result = $this->as3cf->download_attachment_from_s3( $attachment_id, true, true );
		$return = true;

		if ( is_wp_error( $result ) ) {
			$this->progress['error_count']++;

			if ( $this->progress['error_count'] <= 100 ) {
				// Build error message
				$errors = $result->get_error_data();

				$this->errors = array_merge( $this->errors, $errors );

				$this->process_errors[ $blog_id ][ $attachment_id ] = $errors;
			}

			$return = false;
		} elseif ( method_exists( $this, 'handle_attachment_success' ) ) {
			$this->handle_attachment_success( $attachment_id );
		}

		$data = array(
			'attachment_id' => $attachment_id,
			'blog_id'       => $blog_id,
			'upload'        => false,
		);

		update_site_option( $this->last_processed_key, $data );

		return $return;
	}

	/**
	 * Clear the last processed key when tool has fully completed
	 */
	public function ajax_finish_process() {
		parent::ajax_finish_process();

		$completed = $this->as3cf->filter_input( 'completed', INPUT_POST, FILTER_VALIDATE_BOOLEAN );

		if ( $completed ) {
			delete_site_option( $this->last_processed_key );
		}
	}

	/**
	 * Maybe render deactivate plugin prompt.
	 */
	public function maybe_render_deactivate_prompt() {
		if ( self::$deactivate_prompt_rendered ) {
			return;
		}

		if ( ! $this->as3cf->get_setting( 'remove-local-file' ) ) {
			return;
		}

		add_action( 'load-plugins.php', array( $this, 'deactivate_plugin_assets' ) );
		add_action( 'admin_footer', array( $this, 'deactivate_plugin_modal' ) );

		self::$deactivate_prompt_rendered = true;
	}

	/**
	 * Register the modal for plugin deactivation
	 */
	public function deactivate_plugin_assets() {
		$version   = $this->as3cf->get_asset_version();
		$suffix    = $this->as3cf->get_asset_suffix();
		$file_path = $this->as3cf->get_plugin_file_path();

		$src = plugins_url( 'assets/js/pro/tool-downloader' . $suffix . '.js', $file_path );
		wp_enqueue_script( 'as3cf-pro-tool-downloader-script', $src, array( 'as3cf-modal' ), $version, true );

		$args = array(
			'plugin_url'  => $this->as3cf->get_plugin_page_url( array( 'tool' => $this->tool_key ) ),
			'plugin_slug' => $this->as3cf->get_plugin_row_slug(),
		);

		wp_localize_script( 'as3cf-pro-tool-downloader-script', 'as3cfpro_downloader', $args );

		wp_enqueue_style( 'as3cf-modal' );
	}

	/**
	 * Load the view for the plugin deactivation modal
	 */
	public function deactivate_plugin_modal() {
		global $pagenow;
		if ( 'plugins.php' !== $pagenow ) {
			return;
		}

		$this->as3cf->render_view( 'deactivate-plugin-prompt' );
	}

	/**
	 * Message for error notice
	 *
	 * @return string
	 */
	protected function get_error_notice_message() {
		$title   = __( 'Download Errors', 'amazon-s3-and-cloudfront' );
		$message = __( 'Previous attempts at downloading your media library from S3 have resulted in errors.', 'amazon-s3-and-cloudfront' );

		return sprintf( '<strong>%s</strong> &mdash; %s', $title, $message );
	}
}