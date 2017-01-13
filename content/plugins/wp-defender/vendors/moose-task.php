<?php

/**
 * Author: Hoang Ngo
 */
abstract class Moose_Task {
	/**
	 * Id of this task
	 * @var string
	 */
	public $id;
	/**
	 * Type of this task, can be one_time, or on_time
	 * If it is on_time, then it will be schedule to run.
	 * If one_time, then it will bind to an action, or run immediately
	 * @var string
	 */
	public $type = 'one_time';

	/**
	 * Group this task belong to
	 *
	 * @var string
	 */
	public $group = '';

	/**
	 * If @type = on_time, then this should be a unix timestamp
	 * If @type = one_time, then it can be null for run immediately, or an id, so this can run after the task with id is done
	 * @var string
	 */
	public $run_when = '';

	/**
	 * Status of the task, can be wait, process, complete, error
	 * @var string
	 */
	public $status = '';

	/**
	 * @return mixed
	 */
	abstract function on_init();

	/**
	 * @return mixed
	 */
	abstract function process();

	/**
	 * @return mixed
	 */
	abstract function save();

	/**
	 * @return mixed
	 */
	abstract function get_lock_path();

	/**
	 * create a file lock
	 */
	protected function create_lock() {
		if ( is_dir( $this->get_lock_path() ) ) {
			file_put_contents( $this->get_lock_path() . '/lock_' . $this->id, time(), LOCK_EX );
		} else {
			$this->status = 'error';
		}
	}

	/**
	 * Check if file lock is valid
	 *
	 * @param string $time_last
	 *
	 * @return bool
	 */
	protected function is_locked( $time_last = '2 minutes' ) {
		if ( file_exists( $this->get_lock_path() . '/lock_' . $this->id ) ) {
			//check content, a lock should only be locked in 2 min
			$time = file_get_contents( $this->get_lock_path() . '/lock_' . $this->id );
			if ( $time && strtotime( '+' . $time_last, $time ) < time() ) {
				return false;
			} else {
				return true;
			}
		}

		return false;
	}

	/**
	 * remove lock
	 */
	protected function unlock() {
		@unlink( $this->get_lock_path() . '/lock_' . $this->id );
	}
}