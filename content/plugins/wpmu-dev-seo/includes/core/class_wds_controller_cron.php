<?php

class WDS_Controller_Cron {

	const ACTION_CRAWL = 'wds-cron-start_service';
	const ACTION_CHECKUP = 'wds-cron-start_checkup';
	const ACTION_CHECKUP_RESULT = 'wds-cron-checkup_result';

	private static $_instance;

	/**
	 * Controller actively running flag
	 *
	 * @var bool
	 */
	private $_is_running = false;

	private function __construct () {}
	private function __clone () {}

	/**
	 * Singleton instance getter
	 *
	 * @return object WDS_Controller_Cron instance
	 */
	public static function get () {
		if (empty(self::$_instance)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Boots controller interface
	 *
	 * @return bool
	 */
	public function run () {
		if (!$this->is_running()) {
			$this->_add_hooks();
		}
		return $this->is_running();
	}

	/**
	 * Controller interface stop
	 *
	 * @return bool
	 */
	public function stop () {
		if ($this->is_running()) {
			$this->_remove_hooks();
		}
		return $this->is_running();
	}

	/**
	 * Check whether controller interface is active
	 *
	 * @return bool
	 */
	public function is_running () { return !!$this->_is_running; }

	/**
	 * Gets estimated next event time based on parameters
	 *
	 * @param int $pivot Pivot time - base estimation relative to this (UNIX timestamp)
	 * @param strng $frequency Valid frequency interval
	 * @param int $dow Day of the week (0-6)
	 * @param int $tod Time of day (0-23)
	 *
	 * @return int Estimated next event time as UNIX timestamp
	 */
	public function get_estimated_next_event ($pivot, $frequency, $dow, $tod) {
		$start = $this->get_initial_pivot_time($pivot, $frequency);
		$offset = $start + ($dow * DAY_IN_SECONDS);
		$time = strtotime(date("Y-m-d {$tod}:00", $offset));
		$freqs = array(
			'daily' => DAY_IN_SECONDS,
			'weekly' => 7 * DAY_IN_SECONDS,
			'monthly' => 30 * DAY_IN_SECONDS,
		);
		if ($time > $pivot) return $time;

		$freq = $freqs[$this->get_valid_frequency($frequency)];
		return $time + $freq;
	}

	/**
	 * Gets primed pivot time for a given frequency value
	 *
	 * @param int $pivot Raw pivot UNIX timestamp
	 * @param string $frequency Frequency interval
	 *
	 * @return int Zeroed pivot time for given frequency interval
	 */
	public function get_initial_pivot_time ($pivot, $frequency) {
		$frequency = $this->get_valid_frequency($frequency);

		if ('daily' === $frequency) {
			return strtotime(date("Y-m-d 00:00", $pivot));
		}

		if ('weekly' === $frequency) {
			$monday = strtotime('this monday', $pivot);
			if ($monday > $pivot) return $monday - (7 * DAY_IN_SECONDS);
			return $monday;
		}

		if ('monthly' === $frequency) {
			$day = (int)date("d", $pivot);
			$today = strtotime(date("Y-m-d H:i", $pivot));

			return $today - ($day * DAY_IN_SECONDS);
		}

		return $pivot;
	}

	/**
	 * Gets next scheduled event time
	 *
	 * @param string $event Optional event name, defaults to service start
	 *
	 * @return int|bool UNIX timestamp or false if no next event
	 */
	public function get_next_event ($event=false) {
		$event = !empty($event) ? $event : self::ACTION_CRAWL;
		return wp_next_scheduled($this->get_filter($event));
	}

	/**
	 * Checks whether we have a next event scheduled
	 *
	 * @param string $event Optional event name, defaults to service start
	 *
	 * @return bool
	 */
	public function has_next_event ($event=false) {
		return !!$this->get_next_event($event);
	}

	/**
	 * Unschedules a particular event
	 *
	 * @param string $event Optional event name, defaults to service start
	 *
	 * @return bool
	 */
	public function unschedule ($event=false) {
		$event = !empty($event) ? $event : self::ACTION_CRAWL;
		WDS_Logger::info("Unscheduling event {$event}");
		$tstamp = $this->get_next_event($event);
		if ($tstamp) {
			WDS_Logger::debug("Found next event {$event} at {$tstamp}");
			wp_unschedule_event($tstamp, $this->get_filter($event));
		}

		wp_clear_scheduled_hook($this->get_filter($event));
		return true;
	}

	/**
	 * Schedules a particular event
	 *
	 * @param string $event Event name
	 * @param int $time UNIX timestamp
	 * @param string $recurrence Event recurrence
	 *
	 * @return bool
	 */
	public function schedule ($event, $time, $recurrence=false) {
		WDS_Logger::info("Start scheduling new {$recurrence} event {$event}");

		$this->unschedule($event);
		$recurrence = $this->get_valid_frequency($recurrence);
		$now = time();
		while ($time < $now) {
			WDS_Logger::debug("Time in the past, applying offset for {$recurrence} recurrence");
			$offset = DAY_IN_SECONDS;
			if ('weekly' === $recurrence) $offset *= 7;
			if ('monthly' === $recurrence) $offset *= 30;
			$time += $offset;
		}

		WDS_Logger::debug(sprintf("Adding new {$recurrence} event {$event} at {$time} (%s)", date("Y-m-d@H:i", $time)));

		$result = false !== wp_schedule_event(
			$time,
			$recurrence,
			$this->get_filter($event)
		);

		if ($result) {
			WDS_Logger::info("New {$recurrence} event {$event} added at {$time}");
		} else {
			WDS_Logger::warning("Failed adding new {$recurrence} event {$event} at {$time}");
		}

		return $result;
	}

	/**
	 * Sets up overall schedules
	 *
	 * @uses WDS_Controller_Cron::set_up_checkup_schedule()
	 * @uses WDS_Controller_Cron::set_up_crawler_schedule()
	 *
	 * @return void
	 */
	public function set_up_schedule () {
		WDS_Logger::debug("Setting up schedules");
		$this->set_up_crawler_schedule();
		$this->set_up_checkup_schedule();
	}

	/**
	 * Sets up checkup service schedule
	 *
	 * @return void
	 */
	public function set_up_checkup_schedule () {
		WDS_Logger::debug("Setting up checkup schedule");

		$options = WDS_Settings::get_component_options(WDS_Settings::COMP_CHECKUP);

		if (empty($options['checkup-cron-enable'])) {
			WDS_Logger::debug("Disabling checkup cron");
			$this->unschedule(self::ACTION_CHECKUP);
			return false;
		}

		$current = $this->get_next_event(self::ACTION_CHECKUP);
		$now = time();
		$frequency = $this->get_valid_frequency(
			(!empty($options['checkup-frequency']) ? $options['checkup-frequency'] : array())
		);
		$dow = !empty($options['checkup-dow']) && in_array((int)$options['checkup-dow'], range(0,6))
			? (int)$options['checkup-dow']
			: 0
		;
		$tod = !empty($options['checkup-tod']) && in_array((int)$options['checkup-tod'], range(0,23))
			? (int)$options['checkup-tod']
			: 0
		;
		$next = $this->get_estimated_next_event($now, $frequency, $dow, $tod);

		$msg = sprintf("Attempt rescheduling checkup start ({$frequency},{$dow},{$tod}): {$next} (%s)", date("Y-m-d@H:i", $next));
		if (!empty($current)) $msg .= sprintf(" by replacing {$current} (%s)", date("Y-m-d@H:i", $current));
		WDS_Logger::debug($msg);

		if ($current !== $next) {
			WDS_Logger::info(sprintf(
				"Rescheduling checkup start from {$current} (%s) to {$next} (%s)",
				date("Y-m-d@H:i", $current),
				date("Y-m-d@H:i", $next)
			));
			$this->schedule(self::ACTION_CHECKUP, $next, $frequency);
		} else {
			WDS_Logger::info("Currently scheduled checkup matches our next sync estimate, leaving it alone");
		}
	}

	/**
	 * Sets up crawl service schedule
	 *
	 * @return void
	 */
	public function set_up_crawler_schedule () {
		WDS_Logger::debug("Setting up cralwer schedule");

		$options = WDS_Settings::get_component_options(WDS_Settings::COMP_SITEMAP);

		if (empty($options['crawler-cron-enable'])) {
			WDS_Logger::debug("Disabling crawler cron");
			$this->unschedule(self::ACTION_CRAWL);
			return false;
		}

		$current = $this->get_next_event(self::ACTION_CRAWL);
		$now = time();
		$frequency = $this->get_valid_frequency(
			(!empty($options['crawler-frequency']) ? $options['crawler-frequency'] : array())
		);
		$dow = !empty($options['crawler-dow']) && in_array((int)$options['crawler-dow'], range(0,6))
			? (int)$options['crawler-dow']
			: 0
		;
		$tod = !empty($options['crawler-tod']) && in_array((int)$options['crawler-tod'], range(0,23))
			? (int)$options['crawler-tod']
			: 0
		;
		$next = $this->get_estimated_next_event($now, $frequency, $dow, $tod);

		$msg = sprintf("Attempt rescheduling crawl start ({$frequency},{$dow},{$tod}): {$next} (%s)", date("Y-m-d@H:i", $next));
		if (!empty($current)) $msg .= sprintf(" by replacing {$current} (%s)", date("Y-m-d@H:i", $current));
		WDS_Logger::debug($msg);

		if ($current !== $next) {
			WDS_Logger::info(sprintf(
				"Rescheduling crawl start from {$current} (%s) to {$next} (%s)",
				date("Y-m-d@H:i", $current),
				date("Y-m-d@H:i", $next)
			));
			$this->schedule(self::ACTION_CRAWL, $next, $frequency);
		} else {
			WDS_Logger::info("Currently scheduled crawl matches our next sync estimate, leaving it alone");
		}
	}

	/**
	 * Gets a list of frequency intervals
	 *
	 * @return array
	 */
	public function get_frequencies () {
		return array(
			'daily' => __('Daily', 'wds'),
			'weekly' => __('Weekly', 'wds'),
			'monthly' => __('Monthly', 'wds'),
		);
	}

	/**
	 * Gets validated frequency interval
	 *
	 * @return string
	 */
	public function get_valid_frequency ($freq) {
		if (in_array($freq, array_keys($this->get_frequencies()))) return $freq;
		return $this->get_default_frequency();
	}

	/**
	 * Gets default frequency interval (fallback)
	 *
	 * @return string
	 */
	public function get_default_frequency () {
		return 'weekly';
	}

	/**
	 * Starts crawl
	 *
	 * @return bool
	 */
	public function start_crawl () {
		WDS_Logger::debug("Triggered automated crawl start action");

		$service = WDS_Service::get(WDS_Service::SERVICE_SEO);
		//if ($service->is_crawl_requested()) return false; // Already running
		$result = $service->start();

		if ($result) {
			WDS_Logger::debug("Successfully started a crawl");
		} else {
			WDS_Logger::warning("Automated crawl start action failed");
		}

		return $result;
	}

	/**
	 * Starts checkup
	 *
	 * @return bool
	 */
	public function start_checkup () {
		WDS_Logger::debug("Triggered automated checkup start action");

		$service = WDS_Service::get(WDS_Service::SERVICE_CHECKUP);
		if ($service->in_progress()) return false; // Already running
		$result = $service->start();

		if ($result) {
			WDS_Logger::debug("Successfully started a checkup");
			// Check result immediately
			$this->check_checkup_result();
		} else {
			WDS_Logger::warning("Automated checkup start action failed");
		}

		return $result;
	}

	/**
	 * Checks checkup result for cron action
	 *
	 * Schedules another singular check after timeout if not ready yet.
	 *
	 * @return bool
	 */
	public function check_checkup_result () {
		WDS_Logger::debug("Triggered checkup results check");

		$service = WDS_Service::get(WDS_Service::SERVICE_CHECKUP);
		$status = $service->status();
		WDS_Logger::debug("Checkup status: {$status}%");

		if ((int)$status < 100) {
			WDS_Logger::debug("Re-scheduling checkup status event");
			wp_schedule_single_event(time() + $this->get_checkup_ping_delay(), $this->get_filter(self::ACTION_CHECKUP_RESULT), array('test' => rand()));
		}

		return $status >= 100;
	}

	/**
	 * Gets time delay for checkup ping individual requests
	 *
	 * @return int
	 */
	public function get_checkup_ping_delay () {
		return 600;
	}

	public function add_cron_schedule_intervals ($intervals) {
		if (!is_array($intervals)) return $intervals;

		if (!isset($intervals['daily'])) {
			$intervals['daily'] = array(
				'display' => __('SmartCrawl Daily', 'wds'),
				'interval' => DAY_IN_SECONDS,
			);
		}

		if (!isset($intervals['weekly'])) {
			$intervals['weekly'] = array(
				'display' => __('SmartCrawl Weekly', 'wds'),
				'interval' => 7 * DAY_IN_SECONDS,
			);
		}

		if (!isset($intervals['monthly'])) {
			$intervals['monthly'] = array(
				'display' => __('SmartCrawl Monthly', 'wds'),
				'interval' => 30 * DAY_IN_SECONDS,
			);
		}

		return $intervals;
	}

	/**
	 * Sets up controller listening interface
	 *
	 * Also sets up controller running flag approprietly.
	 *
	 * @return void
	 */
	private function _add_hooks () {

		add_filter('cron_schedules', array($this, 'add_cron_schedule_intervals'));

		$copts = WDS_Settings::get_component_options(WDS_Settings::COMP_SITEMAP);
		if (!empty($copts['crawler-cron-enable'])) {
			add_action($this->get_filter(self::ACTION_CRAWL), array($this, 'start_crawl'));
		}

		$chopts = WDS_Settings::get_component_options(WDS_Settings::COMP_CHECKUP);
		if (!empty($chopts['checkup-cron-enable'])) {
			add_action($this->get_filter(self::ACTION_CHECKUP), array($this, 'start_checkup'));
			add_action($this->get_filter(self::ACTION_CHECKUP_RESULT), array($this, 'check_checkup_result'));
		}

		$this->_is_running = true;
	}

	/**
	 * Tears down controller listening interface
	 *
	 * Also sets up controller running flag approprietly.
	 *
	 * @return void
	 */
	private function _remove_hooks () {

		remove_action($this->get_filter(self::ACTION_CRAWL), array($this, 'start_crawl'));
		remove_action($this->get_filter(self::ACTION_CHECKUP), array($this, 'start_checkup'));
		remove_filter('cron_schedules', array($this, 'add_cron_schedule_intervals'));

		$this->_is_running = false;
	}

	/**
	 * Gets prefixed filter action
	 *
	 * @param string $what Filter action suffix
	 *
	 * @return string Full filter action
	 */
	public function get_filter ($what) {
		return 'wds-controller-cron-' . $what;
	}
}