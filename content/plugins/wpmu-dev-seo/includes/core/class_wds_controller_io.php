<?php

if (!class_exists('WDS_WorkUnit')) require_once (dirname(__FILE__) . '/class_wds_work_unit.php');

class WDS_Controller_IO extends WDS_WorkUnit {

	private static $_instance;

	private $_is_running = false;

	public function get_filter_prefix () { return 'wds-controller-io'; }

	/**
	 * Boot controller listeners
	 *
	 * Do it only once, if they're already up do nothing
	 *
	 * @return bool Status
	 */
	public static function serve () {
		$me = self::get();
		if ($me->is_running()) return false;

		return $me->_add_hooks();
	}

	public static function stop () {
		$me = self::get();
		if (!$me->is_running()) return false;

		return $me->_remove_hooks();
	}

	/**
	 * Obtain instance without booting up
	 *
	 * @return WDS_Controller_IO instance
	 */
	public static function get () {
		if (empty(self::$_instance)) self::$_instance = new self;
		return self::$_instance;
	}

	/**
	 * Bind listening actions
	 *
	 * @return bool
	 */
	private function _add_hooks () {

		add_action('admin_init', array($this, 'dispatch_actions'));

		return !!$this->_is_running = true;
	}

	/**
	 * Unbinds listening actions
	 *
	 * @return bool
	 */
	private function _remove_hooks () {

		remove_action('admin_init', array($this, 'dispatch_actions'));

		return !$this->_is_running = false;
	}

	/**
	 * Check if we already have the actions bound
	 *
	 * @return bool Status
	 */
	public function is_running () {
		return $this->_is_running;
	}

	/**
	 * Dispatches action listeners for admin pages
	 *
	 * @return bool
	 */
	public function dispatch_actions () {
		if (is_network_admin() && !current_user_can('manage_network_options')) return false;
		if (is_admin() && !current_user_can('manage_options')) return false;

		$data = stripslashes_deep($_POST);
		$action = !empty($data['io-action']) ? $data['io-action'] : false;
		if ('export' === $action && !empty($data['wds-settings-action-export'])) return $this->process_export_request();
		if ('import' === $action && !empty($data['wds-settings-action-import'])) return $this->process_import_request();

		return false;
	}

	/**
	 * Handles export request processing
	 *
	 * @return bool
	 */
	public function process_export_request () {
		if (is_network_admin() && !current_user_can('manage_network_options')) wp_die('Nope');
		if (is_admin() && !current_user_can('manage_options')) wp_die('Nope');

		if (
			empty($_POST['wds-settings-action-export'])
			||
			!wp_verify_nonce($_POST['wds-settings-action-export'], 'wds-export')
		) {
			$this->add_error('export', __('Invalid export parameters', 'wds'));
			return false;
		}

		if (!class_exists('WDS_Export')) require_once(WDS_PLUGIN_DIR . '/core/class_wds_export.php');
		$json = WDS_Export::load()->get_json();
		$filename = 'wds-settings-' . date('Y-m-d.H-i-s') . '.json';
		if (empty($json)) {
			$this->add_error('export', __('Something went wrong gathering your settings data for export', 'wds'));
			return false;
		}

		header("Content-Type: application/json");
		header("Content-Disposition: attachment; filename=\"{$filename}\"");
		header('Cache-Control: private');
		header('Pragma: private');

		echo $json;
		@ob_flush();
		die;

		return true;
	}

	/**
	 * Handles import request processing
	 *
	 * @return bool
	 */
	public function process_import_request () {
		if (is_network_admin() && !current_user_can('manage_network_options')) wp_die('Nope');
		if (is_admin() && !current_user_can('manage_options')) wp_die('Nope');

		$_POST['option_page'] = 'wds-export';

		if (
			empty($_POST['wds-settings-action-import'])
			||
			!wp_verify_nonce($_POST['wds-settings-action-import'], 'wds-import')
		) {
			$this->add_error('import', __('Invalid import parameters', 'wds'));
			return false;
		}

		// Verify uploaded file
		$json = false;
		if (empty($_FILES['wds_import_json'])) {
			$this->add_error('import', __('Please, upload the settings file', 'wds'));
		} else {
			$file = $_FILES['wds_import_json'];
			$error = __('Invalid import file', 'wds');

			if (!isset($file['error']) || is_array($file['error']) || empty($file['tmp_name'])) {
				$this->add_error('import', $error);
				return false;
			}

			if (UPLOAD_ERR_OK !== $file['error']) {
				$this->add_error('import', $error);
				return false;
			}

			if (wp_max_upload_size() < $file['size']) {
				$this->add_error('import', $error);
				return false;
			}

			$mime = false;
			if (extension_loaded('fileinfo')) {
				$fi = finfo_open(FILEINFO_MIME_TYPE);
				$mime = finfo_file($fi, $file['tmp_name']);
				finfo_close($fi);
			} else if (function_exists('mime_content_type')) {
				$mime = mime_content_type($file['tmp_name']);
			} else {
				// ueh... let's go with least secure approach
				$mime = $file['type'];
			}
			$mime_types = array(
				'application/json',
				'text/json',
				'text/x-json',
				'text/plain'
			);
			if (!in_array($mime, $mime_types)) {
				$this->add_error('import', $error);
				return false;
			}

			$json = file_get_contents($file['tmp_name']);
			$test = json_decode($json, true);
			if (empty($test)) {
				$json = false;
			}
		}

		if (empty($json)) {
			$this->add_error('import', __('Invalid import file JSON content', 'wds'));
			return false;
		}

		if (!class_exists('WDS_Import')) require_once(WDS_PLUGIN_DIR . '/core/class_wds_import.php');
		$instance = WDS_Import::load($json);
		$result = $instance->save();

		if (empty($result)) {
			$this->add_error('import', __('Something went wrong importing your data', 'wds'));
			foreach ($instance->get_errors() as $code => $error) $this->add_error($code, $error);
			return false;
		}

		$errors = $this->get_errors();
		if (empty($errors)) {
			wp_safe_redirect(esc_url_raw(add_query_arg('import', 'success', remove_query_arg('updated'))));
			die;
		}

		return true;
	}

}
