<?php

class Snapshot_Controller_Full_Log extends Snapshot_Controller_Full {

	private static $_instance;

	public static function get () {
		if (empty(self::$_instance)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function run () {
		$this->dispatch_logging();
	}

	/**
	 * Dispatches logging according to settings
	 *
	 * Either stored, and/or defaults
	 *
	 * @uses config['full_log_enable']
	 * @uses config['full_log_setup']
	 *
	 * @return bool
	 */
	public function dispatch_logging () {
		$updated = false;

		$enabled = (bool)$this->_model->get_config('full_log_enable', false);
		if (!$enabled) return $updated; // Logging not enabled, continue

		$log_setup = $this->_model->get_config('full_log_setup', array());
		$log = Snapshot_Helper_Log::get();
		$known_levels = $log->get_known_levels();
		$known_sections = $log->get_known_sections();

		foreach ($log_setup as $section => $level) {
			$level = (int)$level;
			if (empty($level)) continue; // No logging for this section, carry on
			if (!in_array($section, array_keys($known_sections))) continue; // Unknown section
			if (!in_array($level, array_keys($known_levels))) continue; // Unknown level

			$const = $log->get_section_constant_name($section);
			if (defined($const)) continue; // Already defined, let's not error

			define($const, $level);
			$updated = true;
		}

		return $updated;
	}

	/**
	 * Actually stores the submitted log setup
	 *
	 * @uses config['full_log_setup']
	 * @uses config['full_log_enable']
	 *
	 * @param Snapshot_Model_Post $data Submitted data
	 *
	 * @return bool
	 */
	public function process_submissions (Snapshot_Model_Post $data) {
		if (
			!current_user_can(Snapshot_View_Full_Backup::get()->get_page_role())
			||
			!$data->is_valid_action('snapshot-full_backups-log_setup')
		) return false;

		// Enable/disable logging
		if ($data->has('log-enable')) {
			$this->_model->set_config('full_log_enable', $data->is_true('log-enable'));
			if (!$data->is_true('log-enable')) {
				// No logging. Null out everything and short out
				$this->_model->set_config('full_log_setup', array());
				return true;
			}
		}

		// Log levels processing
		if (!$data->has('log_level')) return false; // No sensible data to process

		$known_levels = Snapshot_Helper_Log::get()->get_known_levels();
		$known_sections = Snapshot_Helper_Log::get()->get_known_sections();
		$submitted = $data->value('log_level');

		if (!empty($submitted) && is_array($submitted)) {
			$log_setup = $this->_model->get_config('full_log_setup', array());
			foreach ($submitted as $section => $level) {
				if (!in_array($section, array_keys($known_sections))) continue;

				// Set up default loggins
				$log_setup[$section] = Snapshot_Helper_Log::LEVEL_DEFAULT;

				$level = (int)$level;
				if ($level && !in_array($level, array_keys($known_levels))) continue;
				$log_setup[$section] = $level;

			}
			$this->_model->set_config('full_log_setup', $log_setup);
		}

		return true;
	}
}