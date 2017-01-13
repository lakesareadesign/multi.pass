<?php

/**
 * Author: Hoang Ngo
 */
if ( ! class_exists( 'Moose_Manager' ) ) {
	require_once __DIR__ . '/moose-manager.php';
}

class WP_Moose_Manager extends Moose_Manager {
	private static $static;

	/**
	 * @return WP_Moose_Manager
	 */
	public static function get_instance() {
		if ( ! self::$static instanceof WP_Moose_Manager ) {
			self::$static = new WP_Moose_Manager();
		}

		return self::$static;
	}

	/**
	 * @param $group
	 *
	 * @return null|WP_Moose_Task
	 */
	public function get_next_task( $group ) {
		$all_tasks = $this->find_all_task( $group );
		//task should be added in postition
		foreach ( $all_tasks as $i => $task ) {
			if ( $task['type'] == 'one_time' && $task['status'] != 'complete' ) {
				//usually this should in position, for saving time now, we will check the previous
				if ( empty( $task['run_when'] ) ) {
					//this should be first line, return right away
					return $task['id'];
				} elseif ( ! empty( $task['run_when'] ) && $this->_is_prev_task_done( $all_tasks, $task['run_when'] ) ) {
					//check if the trigger task is done
					return $task['id'];
				}
			} elseif ( $task['type'] == 'on_time' && $task['run_when'] && $task['run_when'] <= time() ) {
				return $task['id'];
			}
		}

		return null;
	}

	public function clear_all_tasks( $group ) {
		delete_option( $this->get_group_name( $group ) );
	}

	/**
	 * @param $group
	 *
	 * @return mixed|void
	 */
	public function find_all_task( $group ) {
		return get_option( $this->get_group_name( $group ), array() );
	}

	/**
	 * @param $group
	 * @param $id
	 *
	 * @return null
	 */
	public function find_task( $group, $id ) {
		$tasks = $this->find_all_task( $group );
		foreach ( $tasks as $task ) {
			if ( $task['id'] == $id ) {
				return $task;
			}
		}

		return null;
	}

	/**
	 * @param $group
	 *
	 * @return bool
	 */
	public function is_group_completed( $group ) {
		$tasks       = $this->find_all_task( $group );
		$is_complete = true;
		foreach ( $tasks as $task ) {
			if ( $task['status'] != 'complete' ) {
				$is_complete = false;
				break;
			}
		}

		return $is_complete;
	}

	/**
	 * @param $group
	 *
	 * @return string
	 */
	private function get_group_name( $group ) {
		return 'wdg_' . $group;
	}


}