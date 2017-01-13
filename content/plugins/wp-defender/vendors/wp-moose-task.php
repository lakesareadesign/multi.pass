<?php

/**
 * Author: Hoang Ngo
 */
if ( ! class_exists( 'Moose_Task' ) ) {
	require_once __DIR__ . '/moose-task.php';
}

class WP_Moose_Task extends Moose_Task {
	public function __construct() {
		$this->on_init();
		$this->bind_data();
	}

	/**
	 * meta data, incase we need to store st in db
	 * @var array
	 */
	public $meta = array();

	public $warning = '';

	public $error;

	public function process() {

	}

	public function on_init() {

	}

	/**
	 * Saving this task status to group
	 */
	public function save() {
		$group              = get_option( $this->get_group_name(), array() );
		$group[ $this->id ] = array(
			'id'       => $this->id,
			'status'   => $this->status,
			'meta'     => $this->meta,
			'type'     => $this->type,
			'run_when' => $this->run_when
		);

		update_option( $this->get_group_name(), $group );
	}

	public function bind_data() {
		$group = get_option( $this->get_group_name(), array() );
		if ( isset( $group[ $this->id ] ) ) {
			$this->status = $group[ $this->id ]['status'];
			$this->status = $group[ $this->id ]['meta'];
			$this->status = $group[ $this->id ]['type'];
			$this->status = $group[ $this->id ]['run_when'];
		} else {
			$this->status = 'waiting';
			//init
			$this->save();
		}
	}

	/**
	 * @return string
	 */
	public function get_lock_path() {
		return $this->get_group_name() . '_lock';
	}

	public function is_locked( $time_last = '2 minutes' ) {
		$locked_time = get_option( $this->get_lock_path() );
		if ( $locked_time && $locked_time > strtotime( $time_last ) ) {
			return true;
		}

		return false;
	}

	public function create_lock() {
		update_option( $this->get_lock_path(), time() );
	}

	public function unlock() {
		delete_option( $this->get_lock_path() );
	}

	/**
	 * @param $group
	 *
	 * @return string
	 */
	private function get_group_name() {
		return 'wdg_' . $this->group;
	}

	/**
	 * @param $size
	 *
	 * @return string
	 */
	public function convert_size( $size ) {
		$unit = array( 'b', 'kb', 'mb', 'gb', 'tb', 'pb' );
		if ( $size == false ) {
			return esc_html__( "N/A", wp_defender()->domain );
		}

		return @round( $size / pow( 1024, ( $i = floor( log( $size, 1024 ) ) ) ), 2 ) . ' ' . $unit[ $i ];
	}
}