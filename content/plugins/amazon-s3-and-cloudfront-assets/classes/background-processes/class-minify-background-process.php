<?php

class AS3CF_Minify_Background_Process extends AS3CF_Background_Process {

	/**
	 * @var string
	 */
	protected $action = 'minify';

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
		$file    = $item['file'];
		$details = $item['details'];

		$body = $this->as3cf->minify->handle_file( $file, $details );

		if ( is_wp_error( $body ) ) {
			// Remove from job queue
			return false;
		}

		$key    = $this->as3cf->minify->prefix_key( $details['s3_info']['key'] );
		$type   = $details['extension'];
		$upload = $this->as3cf->minify->upload_file( $body, $details, $key, $file );

		if ( is_wp_error( $upload ) ) {
			// Remove from job queue
			return false;
		}

		$enqueued_files = $this->as3cf->get_enqueued_files();

		$enqueued_files[ $type ][ $file ]['minified'] = true;

		$this->as3cf->save_enqueued_files( $enqueued_files );

		// Remove from job queue
		return false;
	}

}