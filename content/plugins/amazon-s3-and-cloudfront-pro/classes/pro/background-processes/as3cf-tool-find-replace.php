<?php

class AS3CF_Tool_Find_Replace extends AS3CF_Background_Process {

	/**
	 * @var string
	 */
	protected $action = 'find_replace';

	/**
	 * @var string
	 */
	protected $lock_key = '';

	/**
	 * Initiate new background process
	 *
	 * @param Aws\S3\S3Client $as3cf Instance of calling class
	 */
	public function __construct( $as3cf ) {
		parent::__construct( $as3cf );
	}

	/**
	 * Task
	 *
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param mixed $item Queue item to iterate over
	 *
	 * @return mixed
	 */
	protected function task( $item ) {
		// Control the direction of the find and replace
		$upload = isset( $item['upload'] ) ? $item['upload'] : true;

		// If the item is part of a queue with a lock key, ensure completion message waits for lock to be released.
		$this->lock_key = empty( $item['lock_key'] ) ? '' : $item['lock_key'];

		$this->as3cf->switch_to_blog( $item['blog_id'] );

		// Perform find and replace
		$this->as3cf->find_and_replace_attachment_urls( $item['attachment_id'], $upload );

		// Remove local files if we are uploading to S3
		if ( $upload && $this->as3cf->get_setting( 'remove-local-file' ) ) {
			$paths = $this->as3cf->get_attachment_file_paths( $item['attachment_id'] );

			if ( ! empty( $paths ) ) {
				$this->as3cf->remove_local_files( $paths );
			}
		}

		$this->as3cf->restore_current_blog();

		return false; // Remove from queue
	}

	/**
	 * Complete
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		parent::complete();

		$args = array(
			'flash'    => false,
			'lock_key' => $this->lock_key,
		);

		$this->as3cf->notices->add_notice( __( '<strong>WP Offload S3 Find & Replace Complete</strong> &mdash; Media items within your content have been updated to use the S3 URLs.', 'amazon-s3-and-cloudfront' ), $args );
	}

}