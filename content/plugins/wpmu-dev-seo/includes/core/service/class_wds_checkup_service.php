<?php

class WDS_Checkup_Service extends WDS_Service {

	const IMPL_AJAX = 'implementation::ajax';
	const IMPL_REST = 'implementation::rest';

	public function __construct () {
		if (self::IMPL_AJAX === $this->get_implementation_type()) {
			require_once(dirname(__FILE__) . '/class_wds_checkup_ajax_service.php');
			$this->_implementation = new WDS_Checkup_Ajax_Service;
		} else {
			require_once(dirname(__FILE__) . '/class_wds_checkup_rest_service.php');
			$this->_implementation = new WDS_Checkup_Rest_Service;
		}
	}

	/**
	 * Gets currently set implementation technique
	 *
	 * @return string
	 */
	public function get_implementation_type () {
		return self::IMPL_REST;
	}

	/**
	 * Gets implementation object instance
	 *
	 * @return object
	 */
	public function get_implementation () {
		return $this->_implementation;
	}

	public function get_known_verbs () {
		return $this->_implementation->get_known_verbs();
	}

	public function is_cacheable_verb ($verb) {
		return $this->_implementation->is_cacheable_verb($verb);
	}

	public function get_service_base_url () {
		return $this->_implementation->get_service_base_url();
	}

	public function get_request_url ($verb) {
		return $this->_implementation->get_request_url($verb);
	}

	public function get_request_arguments ($verb) {
		return $this->_implementation->get_request_arguments($verb);
	}

	public function handle_error_response ($response) {
		return $this->_implementation->handle_error_response($response);
	}

	/**
	 * Gets last checked string
	 *
	 * @param string $format Optional timestamp format string
	 *
	 * @return string Last checkup updated time
	 */
	public function get_last_checked ($format=false) {
		$format = !empty($format)
			? $format
			: get_option('date_format') . ' ' . get_option('time_format')
		;
		$time = $this->get_last_checked_timestamp();
		if (empty($time)) return __('Never', 'wds');

		return date_i18n($format, $time);
	}

	/**
	 * Sets last checked time
	 *
	 * @param int $time Optional timestamp, defaults to now
	 *
	 * @return bool
	 */
	public function set_last_checked ($time=false) {
		$time = !empty($time) && is_numeric($time)
			? (int)$time
			: current_time('timestamp')
		;
		return !!update_option($this->get_filter('checkup-last'), $time);
	}

	/**
	 * Checks whether a call is currently being processed
	 *
	 * @return bool
	 */
	public function in_progress () {
		$flag = $this->get_progress_flag();

		$expected_timeout = intval($flag) + 360;
		if (!empty($flag) && is_numeric($flag) && time() > $expected_timeout) {
			// Over 6 minutes, clear flag forcefully
			$this->stop();
		}

		return !!$flag;
	}

	/**
	 * Gets progress flag state
	 *
	 * @return bool
	 */
	public function get_progress_flag () {
		return get_option($this->get_filter("checkup-progress"), false);
	}

	/**
	 * Sets progress flag state
	 *
	 * param bool $flag Whether the service check is in progress
	 *
	 * @return bool
	 */
	public function set_progress_flag ($flag) {
		if (!empty($flag)) $flag = time();
		return !!update_option($this->get_filter("checkup-progress"), $flag);
	}

	/**
	 * Issues a start request, if not already issued
	 *
	 * @return  bool
	 */
	public function start () {
		if ($this->in_progress()) {
			return true;
		}

		$this->set_progress_flag(true);
		$this->set_cached_error("checkup", false);

		$verb = $this->_implementation->get_result_verb();
		$this->set_cached("checkup-{$verb}", false);
		delete_option($this->get_filter("checkup-{$verb}"));
		$result = $this->request($this->_implementation->get_start_verb());

		$data = !empty($result['data']) ? $result['data'] : array();
		if (empty($data)) {
			// Log error ...
			return false;
		}

		$overall = !empty($data['overall']) ? $data['overall'] : array();
		$pcnt = !empty($overall['pcnt_complete']) ? (int)$overall['pcnt_complete'] : 0;

		if ($pcnt && $pcnt >= 99.9) {
			$this->done($data);
		}

		return true;
	}

	/**
	 * Called when the request is actually done
	 *
	 * @return void
	 */
	public function done ($data) {
		$verb = $this->_implementation->get_result_verb();

		$this->set_cached("checkup-{$verb}", $data);
		update_option($this->get_filter("checkup-{$verb}"), $data);

		$this->stop();

		if (is_callable(array($this->_implementation, 'after_done'))) {
			$this->_implementation->after_done();
		}

		do_action($this->get_filter('checkup_done'), $data, $this);
	}

	/**
	 * Stops expecting response
	 *
	 * @return bool
	 */
	public function stop () {
		$this->set_progress_flag(false);
		return true;
	}

	/**
	 * Checks current status
	 *
	 * Issues status request, or serves cached update
	 *
	 * @return int Percentage
	 */
	public function status () {
		$res = $this->in_progress()
			? $this->request($this->_implementation->get_result_verb())
			: $this->get_cached($this->_implementation->get_result_verb())
		;
		if (!is_array($res)) $res = array();
		if (isset($res['success']) && empty($res['success'])) {
			$this->done($res);
			return 100;
		}
		$status = isset($res['success']) && !empty($res['success']) ? 1 : 0;
		if (!empty($res['data'])) $data = $res['data'];

		if (!empty($data['overall']['pcnt_complete'])) {
			$status = (int)$data['overall']['pcnt_complete'];
			if ($status >= 100) {
				$this->done($data);
				return 100;
			}
		} else if (empty($res) && empty($status)) {
			$this->done($res);
			return 100;
		}

		return $status;
	}

	/**
	 * Checks result
	 *
	 * Issues result request, or serves cached update
	 *
	 * @return array
	 */
	public function result () {
		if ($this->in_progress()) return array();

		$verb = $this->_implementation->get_result_verb();
		$res = get_option($this->get_filter("checkup-{$verb}"), array());
		if (empty($res)) {
			$res = $this->request($verb);
			$this->done($res);

			$this->set_last_checked();
		}

		if (!is_array($res)) {
			// JSON string
			$res = json_decode($res, true);
			if (!empty($res['data'])) $res = $res['data']; // @TODO This should probably be refactored
		} else if (!empty($res['data'])) {
			$res = $res['data'];
		}

		if (is_array($res) && !empty($res['seo'])) return $res['seo'];

		$error = $this->get_cached_error("checkup");
	   	if (empty($error) && is_string($res)) $error = $res;

		return !empty($error)
			? array('error' => $error)
			: array('error' => __('Your request timed out', 'wds'))
		;
	}

	/**
	 * @return mixed|void
	 */
	public function get_last_checked_timestamp()
	{
		return get_option($this->get_filter('checkup-last'), false);
	}

}


/**
 * Abstract implementation class
 */
abstract class WDS_Checkup_Service_Implementation extends WDS_Service {

	abstract public function get_start_verb ();
	abstract public function get_result_verb ();
}