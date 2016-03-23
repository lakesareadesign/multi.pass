<?php

class AS3CF_Scan_Files_For_S3 extends AS3CF_Async_Request {

	/**
	 * @var string
	 */
	protected $action = 'scan_assets_for_s3';

	/**
	 * Handle
	 *
	 * Override this method to perform any actions required
	 * during the async request.
	 */
	protected function handle() {
		$this->as3cf->scan_files_for_s3();
	}

}