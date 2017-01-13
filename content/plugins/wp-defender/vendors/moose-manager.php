<?php

/**
 * Author: Hoang Ngo
 */
abstract class Moose_Manager {
	/**
	 * Get next task for processing
	 *
	 * @param $group
	 *
	 * @return mixed
	 */
	abstract function get_next_task( $group );

	/**
	 * @param $group
	 *
	 * @return mixed
	 */
	abstract function find_all_task( $group );

	/**
	 * @param $group
	 * @param $id
	 *
	 * @return mixed
	 */
	abstract function find_task( $group, $id );

	/**
	 * @param $group
	 *
	 * @return mixed
	 */
	abstract function is_group_completed( $group );

	/**
	 * @param $group
	 *
	 * @return mixed
	 */
	abstract function clear_all_tasks( $group );

	/**
	 * @param $all_tasks
	 * @param $run_when
	 *
	 * @return bool
	 */
	protected function _is_prev_task_done( $all_tasks, $run_when ) {
		if ( is_array( $run_when ) ) {
			//we need to validate if the first run when is in queue
			//if yes, then we will wait for it, if no, try the rest
			$wait_for = null;
			foreach ( $run_when as $rw ) {
				foreach ( $all_tasks as $id => $task ) {
					if ( $id == $rw ) {
						$wait_for = $id;
						break;
					}
				}
			}
			if ( $wait_for == null ) {
				return false;
			}
			foreach ( $all_tasks as $id => $task ) {
				if ( $id == $wait_for && $task['status'] == 'complete' ) {
					return true;
				}
			}
		} else {
			foreach ( $all_tasks as $id => $task ) {
				if ( $id == $run_when && $task['status'] == 'complete' ) {
					return true;
				}
			}

		}

		return false;
	}
}