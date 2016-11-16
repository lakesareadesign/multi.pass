<?php

class Amazon_S3_And_CloudFront_Enable_Media_Replace {

	/**
	 * @var Amazon_S3_And_CloudFront
	 */
	protected $as3cf;

	/**
	 * @param string $plugin_file_path
	 */
	function __construct( $plugin_file_path ) {
		global $as3cfpro;
		$this->as3cf = $as3cfpro;

		/*
		 * Enable Media Replace
		 * https://wordpress.org/plugins/enable-media-replace/
		 */
		add_filter( 'as3cf_get_attached_file', array( $this, 'download_file' ), 10, 4 );
		add_filter( 'update_attached_file', array( $this, 'maybe_process_s3_replacement' ), 101, 2 );
		add_filter( 'as3cf_update_attached_file', array( $this, 'process_s3_replacement' ), 10, 2 );
		add_filter( 'as3cf_get_attachment_s3_info', array( $this, 'update_file_prefix_on_replace' ), 10, 2 );
		add_filter( 'as3cf_pre_update_attachment_metadata', array( $this, 'remove_existing_s3_files_before_replace' ), 10, 4 );
		$this->download_file_wrapper();

		load_plugin_textdomain( 'as3cf-enable-media-replace', false, dirname( plugin_basename( $plugin_file_path ) ) . '/languages/' );
	}

	/**
	 * Until Enable Media Replace plugin implements the PR so we can use get_attached_file()
	 * we need to determine if we need to copy the local file back a different way
	 *
	 * https://github.com/mansj/enable-media-replace/pull/15
	 */
	function download_file_wrapper() {
		$wp_filter = $GLOBALS['wp_filter'];

		if ( ! empty( $wp_filter['emr_unfiltered_get_attached_file'] ) ) {
			// once the EMR PR has been merged we can move the following filter hook to the construct
			// and remove this whole method including doing_enable_media_replace()
			add_filter( 'emr_unfiltered_get_attached_file', '__return_false' );
		} else {
			add_action( 'admin_init', array( $this, 'doing_enable_media_replace' ) );
		}
	}

	/**
	 * A temporary alternative way to determine if the EMR is processing so we can copy back the S3 file
	 * to the server if the local file does not exist.
	 *
	 */
	function doing_enable_media_replace() {
		if ( $this->as3cf->plugin_compat->is_ajax() ) {
			return;
		}

		if ( ! $this->is_replacing_media() ) {
			return;
		}

		$attachment_id = filter_input( INPUT_POST, 'ID', FILTER_VALIDATE_INT );

		if ( empty( $attachment_id ) ) {
			return;
		}

		// Manually call get_attached_file() so our filter hooks are triggered,
		// as EMR runs the method with filters suppressed
		get_attached_file( $attachment_id );
	}

	/**
	 * Allow the Enable Media Replace plugin to copy the S3 file back to the local
	 * server when the file is missing on the server via get_attached_file()
	 *
	 * @param string $url
	 * @param string $file
	 * @param int    $attachment_id
	 * @param array  $s3_object
	 *
	 * @return string
	 */
	function download_file( $url, $file, $attachment_id, $s3_object ) {
		return $this->as3cf->plugin_compat->copy_image_to_server_on_action( 'media_replace_upload', false, $url, $file, $s3_object );
	}

	/**
	 * Allow the Enable Media Replace plugin to remove old images from S3 when performing a replace
	 *
	 * @param bool  $pre
	 * @param array $data
	 * @param int   $post_id
	 * @param array $s3object
	 *
	 * @return bool
	 */
	function remove_existing_s3_files_before_replace( $pre, $data, $post_id, $s3object = array() ) {
		if ( ! $this->is_replacing_media() ) {
			return $pre;
		}

		if ( $s3object ) {
			// Only remove old attachment files if they exist on S3
			$this->as3cf->remove_attachment_files_from_s3( $post_id, $s3object );
		}

		// abort the rest of the update_attachment_metadata hook,
		// as we will process via update_attached_file
		return true;
	}

	/**
	 * Process the file replacement on a local only file if we are now
	 * offloading to S3.
	 *
	 * @param string $file
	 * @param int    $attachment_id
	 *
	 * @return string
	 */
	public function maybe_process_s3_replacement( $file, $attachment_id ) {
		if ( ! $this->is_replacing_media() ) {
			return $file;
		}

		if ( ! $this->as3cf->is_plugin_setup() ) {
			return $file;
		}

		if ( ! ( $s3object = $this->as3cf->get_attachment_s3_info( $attachment_id ) ) ) {
			// Process the replacement for a local file
			return $this->process_s3_replacement( $file, $attachment_id );
		}

		return $file;
	}

	/**
	 * Allow the Enable Media Replace to use update_attached_file() so it can
	 * replace the file on S3.
	 *
	 * @param string $file
	 * @param int    $attachment_id
	 *
	 * @return string
	 */
	function process_s3_replacement( $file, $attachment_id ) {
		if ( ! $this->is_replacing_media() ) {
			return $file;
		}

		// upload attachment to S3
		$this->as3cf->upload_attachment_to_s3( $attachment_id, null, $file );

		return $file;
	}

	/**
	 * Are we doing a media replacement?
	 *
	 * @return bool
	 */
	public function is_replacing_media() {
		$action = filter_input( INPUT_GET, 'action' );

		if ( empty( $action ) ) {
			return false;
		}

		return ( 'media_replace_upload' === sanitize_key( $action ) );
	}

	/**
	 * Update the file prefix in the S3 meta
	 *
	 * @param array|string $s3object
	 * @param int          $attachment_id
	 *
	 * @return array|string
	 */
	public function update_file_prefix_on_replace( $s3object, $attachment_id ) {
		if ( ! $this->is_replacing_media() ) {
			// Not replacing using EMR
			return $s3object;
		}

		if ( '' === $s3object ) {
			// First time upload to S3
			return $s3object;
		}

		if ( ! $this->as3cf->get_setting( 'object-versioning' ) ) {
			// Not using object versioning
			return $s3object;
		}

		$is_doing_upload = false;
		$callers         = debug_backtrace();

		foreach ( $callers as $caller ) {
			if ( isset( $caller['function'] ) && 'upload_attachment_to_s3' === $caller['function'] ) {
				$is_doing_upload = true;
				break;
			}
		}

		if ( ! $is_doing_upload ) {
			return $s3object;
		}

		// Get attachment folder time
		$time = $this->as3cf->get_attachment_folder_time( $attachment_id );
		$time = date( 'Y/m', $time );

		// Update the file prefix to generate new object versioning string
		$prefix   = $this->as3cf->get_file_prefix( $time );
		$filename = basename( $s3object['key'] );

		$s3object['key'] = $prefix . $filename;

		return $s3object;
	}
}