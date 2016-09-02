<?php

/**
 * Admin pages controller
 */
class Snapshot_Controller_Full_Admin extends Snapshot_Controller_Full {

	const CODE_ERROR_BULK_DELETE = 'bdel';
	const CODE_ERROR_DOWNLOAD = 'download';

	/**
	 * Singleton instance
	 *
	 * @var object Snapshot_Controller_Full_Admin
	 */
	private static $_instance;

	/**
	 * View instance object
	 *
	 * @var object Snapshot_View_Full_Backup
	 */
	private $_view;

	/**
	 * Constructor - never to the outside world
	 */
	protected function __construct () {
		parent::__construct();
		$this->_view = Snapshot_View_Full_Backup::get();
	}

	/**
	 * Gets singleton instance
	 *
	 * @return object Snapshot_Controller_Full_Admin instance
	 */
	public static function get () {
		if (empty(self::$_instance)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Serves the controller
	 */
	public function run () {
		$this->_view->run();
		add_action('admin_init', array($this, 'process_submissions'));
	}

	/**
	 * Runs on plugin deactivation
	 *
	 * Removes config settings
	 */
	public function deactivate () {
		$this->_model->set_config('active', false);
		$this->_model->set_config('frequency', false);
		$this->_model->set_config('schedule_time', false);
		$this->_model->set_config('secret-key', false);

		$this->_model->remote()->remove_token();
	}

	/**
	 * Dispatch submission processing.
	 */
	public function process_submissions () {
		if ( is_multisite() ) {
			if ( ! is_super_admin() ) {
				return false;
			}
			if ( ! is_network_admin() ) {
				return false;
			}
		}
		if (!current_user_can($this->_view->get_page_role())) return false;

		$data = new Snapshot_Model_Post;
		if ($data->is_empty()) return false;

		if ($data->has('activate')) return $this->_activate_backups($data);
		else if ($data->has('snapshot-settings')) return $this->_update_settings($data);
		else if ($data->has('snapshot-schedule')) return $this->_schedule_backups($data);
		else if ($data->has('snapshot-disable-cron')) return $this->_deactivate_backups($data);
		else if ($data->has('snapshot-enable-cron')) return $this->_reenable_cron_backups($data);
		else if ($data->has('download')) return $this->_download_backup($data);
		else if ($data->has('snapshot-full_backups-list-nonce') && $data->has('delete-bulk')) return $this->_bulk_delete($data);
	}

	/**
	 * Deletes the snapshots in bulk
	 *
	 * @param Snapshot_Model_Post $data Request data
	 *
	 * @return bool False on failure
	 */
	private function _bulk_delete (Snapshot_Model_Post $data) {
		if (
			!current_user_can($this->_view->get_page_role())
			||
			!wp_verify_nonce($data->value('snapshot-full_backups-list-nonce'), 'snapshot-full_backups-list')
		) return false;
		if (!$this->_is_backup_processing_ready()) return false;

		$to_remove = $data->value('delete-bulk');
		if (empty($to_remove) || !is_array($to_remove)) return false; // Not valid data

		$status = true; // Assume all is good
		foreach ($to_remove as $timestamp) {
			$timestamp = (int)$timestamp;
			if (!$timestamp) continue; // Not a valid timestamp

			$status = $this->_model->delete_backup($timestamp);
			if (!$status) break;
		}

		if (!empty($status)) {
			// Update all settings, new list included
			$this->_model->update_remote_schedule();
		}

		$url = !empty($status)
			? remove_query_arg('error')
			: add_query_arg('error', self::CODE_ERROR_BULK_DELETE)
		;
		wp_safe_redirect($url);
		die;
	}

	/**
	 * Downloads the requested file
	 *
	 * On success, sends over the download file
	 *
	 * @param Snapshot_Model_Post $data Request data
	 *
	 * @return bool False on failure
	 */
	private function _download_backup (Snapshot_Model_Post $data) {
		if (
			!current_user_can($this->_view->get_page_role())
			||
			!wp_verify_nonce($data->value('nonce'), 'snapshot-full_backups-download')
		) return false;

		if (!$data->is_numeric('download')) return false;
		$timestamp = (int)$data->value('download');

		$file = $this->_model->local()->get_backup($timestamp);
		if (empty($file) || !file_exists($file)) {
			// Try to deal with remote file directly
			$url = $this->_model->remote()->get_backup_link($timestamp);
			if (!$url) {
				wp_safe_redirect(add_query_arg('error', self::CODE_ERROR_DOWNLOAD));
			} else {
				wp_redirect($url);
			}
			die;
		}

		// So we have a local backup file... carry on packing

		ob_end_clean(); // Clean up anything up until now
		header('Content-Description: File Transfer');
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header('Content-Length: ' . filesize($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		readfile($file);

		@unlink($file); // Kill the file, we don't need it anymore
		die;
	}

	/**
	 * Save backup activation
	 *
	 * @param Snapshot_Model_Post $data Request data
	 *
	 * @return bool
	 */
	private function _activate_backups (Snapshot_Model_Post $data) {
		if (
			!current_user_can($this->_view->get_page_role())
			||
			!$data->is_valid_action('snapshot-full_backups-activate')
		) return false;

		if ($this->_model->is_active()) {
			if ($data->is_true('activate')) return false; // Pleonasm
			$this->_model->set_config('active', false);
		} else {
			if (!$data->is_true('activate')) return false; // Pleonasm

			if ($data->has('secret-key')) {

				$key = sanitize_text_field($data->value('secret-key'));
				if (empty($key)) return false;

				$old_key = $this->_model->get_config('secret-key', false);
				$this->_model->set_config('secret-key', $key);
				if (empty($key) || $key !== $old_key) $this->_model->remote()->remove_token();

				// Require secret key to activate the backups
				$this->_model->set_config('active', true);

				// Send initial schedule update
				$this->_model->update_remote_schedule();
			}

			// We can't attempt to update remote schedule
			// when we have no secret key at activation time.
			// We can't handle the scenario descrobed here:
			// https://app.asana.com/0/11140230629075/163832507640609
			// as it is happening outside our control
		}

		return true;
	}

	/**
	 * Completely deactivates full backups
	 *
	 * @param Snapshot_Model_Post $data Request data
	 *
	 * @return bool
	 */
	private function _deactivate_backups (Snapshot_Model_Post $data) {
		if (
			!current_user_can($this->_view->get_page_role())
			||
			!$data->is_valid_action('snapshot-full_backups-schedule')
		) return false;

		$this->_model->set_config('frequency', false);
		$this->_model->set_config('schedule_time', false);
		$this->_model->set_config('disable_cron', true);
		Snapshot_Controller_Full_Cron::get()->stop();

		// Let the service know
		$this->_model->update_remote_schedule();

		return false;
	}

	/**
	 * Re-enables cron backups
	 *
	 * @param Snapshot_Model_Post $data Request data
	 *
	 * @return bool
	 */
	private function _reenable_cron_backups (Snapshot_Model_Post $data) {
		if (
			!current_user_can($this->_view->get_page_role())
			||
			!$data->is_valid_action('snapshot-full_backups-schedule')
		) return false;

		$this->_model->set_config('disable_cron', false);

		// Let the service know
		$this->_model->update_remote_schedule();

		return true;
	}

	/**
	 * Save backup overall settings
	 *
	 * @param Snapshot_Model_Post $data Request data
	 *
	 * @return bool
	 */
	private function _update_settings (Snapshot_Model_Post $data) {
		if (
			!current_user_can($this->_view->get_page_role())
			||
			!$data->is_valid_action('snapshot-full_backups-settings')
		) return false;

		// Do the secret key part first
		if ($data->has('secret-key')) {
			$key = sanitize_text_field($data->value('secret-key'));
			$old_key = $this->_model->get_config('secret-key', false);
			$this->_model->set_config('secret-key', $key);
			if (empty($key) || $key !== $old_key) $this->_model->remote()->remove_token();

			// Also stop cron when there's no secret key
			if (empty($key)) {
				$this->_model->set_config('frequency', false);
				$this->_model->set_config('schedule_time', false);
				$this->_model->set_config('disable_cron', true);
				Snapshot_Controller_Full_Cron::get()->stop();
			}
		}

		// Do the limit part
		if ($data->has('backups-limit')) {
			$limit = (int)$data->value('backups-limit');
			Snapshot_Model_Full_Remote_Storage::get()->set_max_backups_limit($limit);
			// ... *then* update remote info
			$this->_model->update_remote_schedule();
		}

		// Do the logging part
		if ($data->has('log-enable')) {
			Snapshot_Controller_Full_Log::get()->process_submissions($data);
		}
	}

	/**
	 * Save backup frequency settings
	 *
	 * @param Snapshot_Model_Post $data Request data
	 *
	 * @return bool
	 */
	private function _schedule_backups (Snapshot_Model_Post $data) {
		if (
			!current_user_can($this->_view->get_page_role())
			||
			!$data->is_valid_action('snapshot-full_backups-schedule')
		) return false;

		// Check validity
		if (!$data->has('frequency') || !$data->has('schedule_time')) return false;

		if (!$data->is_in_range('frequency', array_keys($this->_model->get_frequencies()))) return false;
		if (!$data->is_in_range('schedule_time', array_keys($this->_model->get_schedule_times()))) return false;

		$this->_model->set_config('frequency', $data->value('frequency'));
		$this->_model->set_config('schedule_time', $data->value('schedule_time'));

		// Reset cron hooks
		Snapshot_Controller_Full_Cron::get()->reschedule();

		// ... *then* update remote info
		$this->_model->update_remote_schedule();

		return true;
	}
}