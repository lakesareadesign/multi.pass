<?php

class AS3CF_Process_Assets {

	/**
	 * @var Amazon_S3_And_CloudFront_Assets
	 */
	protected $as3cf;

	/**
	 * @var AS3CF_Process_Assets_Background_Process
	 */
	protected $background_process;

	/**
	 * @var bool
	 */
	protected $save_on_shutdown = false;

	/**
	 * @var array|bool
	 */
	protected $batches = false;

	/**
	 * AS3CF_Process_Assets constructor.
	 *
	 * @param Amazon_S3_And_CloudFront_Assets         $as3cf
	 * @param AS3CF_Process_Assets_Background_Process $background_process
	 */
	public function __construct( Amazon_S3_And_CloudFront_Assets $as3cf, $background_process ) {
		$this->as3cf              = $as3cf;
		$this->background_process = $background_process;

		add_action( 'shutdown', array( $this, 'save_queue' ) );
	}

	/**
	 * Append a batch of files to be processed to the background processing queue.
	 *
	 * @param array $files_to_process
	 */
	public function batch_process( $files_to_process ) {
		if ( ! empty( $files_to_process ) && is_array( $files_to_process ) ) {
			$this->save_on_shutdown = true;

			$this->background_process->push_to_queue( $files_to_process );
		}
	}

	/**
	 * Save queue
	 */
	public function save_queue() {
		if ( $this->save_on_shutdown ) {
			$this->background_process->save()->dispatch();
		}
	}

	/**
	 * Returns all files to be processed across all batches.
	 *
	 * @return array
	 */
	public function to_process() {
		if ( false === $this->batches ) {
			$this->batches = $this->background_process->get_batches();
		}

		$to_process = array();

		if ( ! empty( $this->batches ) ) {
			$to_process = array_reduce(
				$this->batches,
				array( $this, 'flatten_batches' ),
				array()
			);
		}

		return $to_process;
	}

	/**
	 * Copy files to S3 and remove files from S3 that have been scanned
	 *
	 * @param array      $files_to_process
	 * @param array|null $saved_files
	 *
	 * @return array Remainder of files that were not processed due to time or batch limits, empty array if all
	 *               processed.
	 */
	public function process_s3_files( $files_to_process, $saved_files = null ) {
		if ( empty( $files_to_process ) || ! is_array( $files_to_process ) ) {
			return $files_to_process;
		}

		if ( is_null( $saved_files ) ) {
			$saved_files = $this->as3cf->get_files();
		}
		$enqueued_files = $this->as3cf->get_enqueued_files();

		$bucket   = $this->as3cf->get_setting( 'bucket' );
		$region   = $this->as3cf->get_setting( 'region' );
		$s3client = $this->as3cf->get_s3client( $region );

		$count           = 0;
		$batch_limit     = apply_filters( 'as3cf_assets_file_process_batch_limit', 100 );
		$time_limit      = apply_filters( 'as3cf_assets_file_process_batch_time_limit', 10 ); // Seconds
		$throttle_period = 1000000 * apply_filters( 'as3cf_assets_seconds_between_file_uploads', 0 ); // Microseconds

		$finish_time   = time() + $time_limit;
		$files_copied  = 0;
		$files_removed = 0;

		foreach ( $files_to_process as $key => $file ) {
			$count++;
			// Batch or time limit reached.
			if ( $count > $batch_limit || time() >= $finish_time ) {
				break;
			}

			switch ( $file['action'] ) {
				case 'remove':
					$this->as3cf->remove_file_from_s3( $region, $bucket, $file );

					$path = $this->as3cf->get_file_absolute_path( $file['url'] );
					$type = pathinfo( $path, PATHINFO_EXTENSION );
					$files_removed++;
					unset( $enqueued_files[ $type ][ $path ] );

					break;
				case 'copy':
					if ( ! isset( $saved_files[ $file['file'] ] ) ) {
						// If for some reason we don't have the file saved
						// in the scanned files array anymore, don't copy it
						break;
					}

					// If the file has been removed or moved before the batch was processed, skip it.
					if ( ! file_exists( $file['file'] ) ) {
						break;
					}

					$details   = $saved_files[ $file['file'] ];
					$body      = file_get_contents( $file['file'] );
					$gzip_body = $this->as3cf->maybe_gzip_file( $file['file'], $details, $body );

					if ( is_wp_error( $gzip_body ) ) {
						$s3_info = $this->as3cf->copy_file_to_s3( $s3client, $bucket, $file['file'], $details );
					} else {
						$s3_info = $this->as3cf->copy_body_to_s3( $s3client, $bucket, $gzip_body, $details, true );
					}

					if ( is_wp_error( $s3_info ) ) {
						$this->as3cf->handle_failure( $file['file'], 'upload' );
					} else {
						$details['s3_version']        = $details['local_version'];
						$details['s3_info']           = $s3_info;
						$saved_files[ $file['file'] ] = $details;

						$files_copied++;

						// Maybe remove file from upload failure queue
						if ( $this->as3cf->is_failure( 'upload', $file['file'] ) ) {
							$this->as3cf->remove_failure( 'upload', $file['file'] );
						}

						// Maybe remove file from gzip failure queue
						if ( ! is_wp_error( $gzip_body ) && $this->as3cf->is_failure( 'gzip', $file['file'] ) ) {
							$this->as3cf->remove_failure( 'gzip', $file['file'] );
						}
					}

					break;
			}

			unset( $files_to_process[ $key ] );

			// Let the server breathe a little.
			usleep( $throttle_period );
		}

		// If we have copied files to S3 update our saved files array
		if ( $files_copied > 0 ) {
			$this->as3cf->save_files( $saved_files );
		}

		// If we have removed files from S3, update enqueued files array
		if ( $files_removed > 0 ) {
			$this->as3cf->save_enqueued_files( $enqueued_files );
		}

		// Return remainder of files to process, empty array means all processed.
		return $files_to_process;
	}

	/**
	 * Merge all batches and their tasks into a single array.
	 *
	 * @param array    $batches
	 * @param StdClass $batch
	 *
	 * @return array
	 */
	private function flatten_batches( $batches, $batch ) {
		return array_merge(
			$batches,
			array_reduce(
				$batch->data,
				'array_merge',
				array()
			)
		);
	}
}
