<?php

/**
 * @author: Hoang Ngo
 */
abstract class WD_Scan_Abstract extends WD_Component {
	/**
	 * Does this scan require DEV Dashboard
	 * @var bool
	 */
	public $dashboard_required;
	/**
	 * Files need scan
	 * @var array
	 */
	public $total_files = array();

	/**
	 * @var array
	 */
	public $file_scanned = array();
	/**
	 * Some scan doesn't count percent
	 * @var bool
	 */
	public $percentable = false;

	/**
	 * This is the max percent of a step can reach, can do later
	 * @var float
	 */
	public $max_percent;

	/**
	 * @var bool
	 */
	public $is_enabled = true;

	/**
	 * @var null|WD_Scan_Result_Model
	 * @since 1.0.3
	 */
	public $model = null;

	/**
	 * Last scan model
	 * @var null|WD_Scan_Result_Model
	 * @since 1.0.3
	 */
	public $last_scan = null;

	/**
	 * Storing last scanned file, keep only 3 record
	 * @var array
	 */
	public $last_try = array();

	/**
	 * @return mixed
	 */
	public abstract function process();

	/**
	 * @param $model
	 *
	 * @return bool
	 */
	protected function maybe_run_this_scan( $model ) {
		$false_status = array(
			WD_Scan_Result_Model::STATUS_ERROR,
			WD_Scan_Result_Model::STATUS_PAUSE
		);

		if ( in_array( $model->status, $false_status ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @return int
	 * @since 1.0.3
	 */
	protected function get_cpu_usage() {
		if ( stristr( PHP_OS, 'win' ) ) {
			return false;
		} else {
			$loaded = sys_getloadavg();
			if ( isset( $loaded[0] ) ) {
				return $loaded[0];
			}
		}

		return 0;
	}

	/**
	 * @return bool
	 * @since 1.0.3
	 */
	protected function cpu_reach_threshold() {
		$current = $this->get_cpu_usage();
		$limit   = apply_filters( 'wd_limit_cpu', 0.85 );

		if ( $current === false ) {
			//we can't detect, it might be windows server, just return
			return false;
		}

		if ( $current > $limit ) {
			$this->log( $current, self::ERROR_LEVEL_DEBUG, 'cpu' );

			return true;
		}

		return false;
	}

	/**
	 * if this scan done or not
	 * @return bool
	 */
	abstract function check();

	/**
	 * cleanup a scan after finished
	 * @return mixed
	 */
	abstract function clean_up();

	/**
	 * if a scan is enabled
	 * @return mixed
	 */
	abstract function is_enabled();
}