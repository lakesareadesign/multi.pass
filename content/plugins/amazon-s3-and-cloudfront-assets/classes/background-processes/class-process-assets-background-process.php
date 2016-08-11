<?php

class AS3CF_Process_Assets_Background_Process extends AS3CF_Background_Process {

	/**
	 * @var string
	 */
	protected $action = 'process-assets';

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
		$item = $this->as3cf->process_assets->process_s3_files( $item );

		if ( empty( $item ) ) {
			// Remove from job queue.
			return false;
		}

		// Remainder of files to be processed.
		return $item;
	}
}
