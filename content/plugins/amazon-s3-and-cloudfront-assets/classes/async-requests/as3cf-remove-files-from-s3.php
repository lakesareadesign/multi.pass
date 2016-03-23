<?php

class AS3CF_Remove_Files_From_S3 extends AS3CF_Async_Request {

	/**
	 * @var string
	 */
	protected $action = 'remove_assets_from_s3';

	/**
	 * Handle
	 *
	 * Override this method to perform any actions required
	 * during the async request.
	 */
	protected function handle() {
		if ( ! isset( $_POST['bucket'] ) || ! isset( $_POST['region'] ) ) {
			wp_die();
		}

		$bucket = sanitize_text_field( $_POST['bucket'] );
		$region = sanitize_text_field( $_POST['region'] );

		$this->as3cf->remove_all_files_from_s3( $bucket, $region );

		if ( isset( $_POST['scan'] ) ) {
			$this->as3cf->scan_files_for_s3();
		}
	}

}