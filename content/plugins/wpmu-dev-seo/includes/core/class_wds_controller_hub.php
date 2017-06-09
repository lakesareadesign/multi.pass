<?php

class WDS_Controller_Hub {


	private static $_instance;

	private $_is_running = false;

	private function __construct () {}

	/**
	 * Boot controller listeners
	 *
	 * Do it only once, if they're already up do nothing
	 *
	 * @return bool Status
	 */
	public static function serve () {
		$me = WDS_Controller_Hub::get();
		if ($me->is_running()) return false;

		$me->_add_hooks();
		return true;
	}

	/**
	 * Obtain instance without booting up
	 *
	 * @return WDS_Controller_Hub instance
	 */
	public static function get () {
		if (empty(self::$_instance)) self::$_instance = new self;
		return self::$_instance;
	}

	/**
	 * Bind listening actions
	 */
	private function _add_hooks () {
		add_filter('wdp_register_hub_action', array($this, 'register_hub_actions'));

		$this->_is_running = true;
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
	 * Registers Hub action listeners
	 *
	 * @param array $actions All the Hub actions registered this far
	 *
	 * @return array Augmented actions
	 */
	public function register_hub_actions ($actions) {
		if (!is_array($actions)) return $actions;

		$actions['wds-sync-ignores'] = array($this, 'json_sync_ignores_list');
		$actions['wds-purge-ignores'] = array($this, 'json_purge_ignores_list');

		$actions['wds-sync-extras'] = array($this, 'json_sync_extras_list');
		$actions['wds-purge-extras'] = array($this, 'json_purge_extras_list');


		return $actions;
	}

	/**
	 * Fresh ignores from the Hub action handler
	 *
	 * Updates local ignores list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 *
	 * @return bool Status
	 */
	public function sync_ignores_list ($params=array(), $action='') {
		if (!class_exists('WDS_Model_Ignores')) require_once(WDS_PLUGIN_DIR . 'core/class_wds_model_ignores.php');
		$ignores = new WDS_Model_Ignores;

		$data = stripslashes_deep((array)$params);
		if (empty($data['issue_ids']) || !is_array($data['issue_ids'])) {
			return false;
		}

		$status = true;
		foreach ($data['issue_ids'] as $issue_id) {
			$tmp = $ignores->set_ignore($issue_id);
			if (!$tmp) $status = false;
		}

		return $status;
	}

	/**
	 * Fresh ignores from the Hub action handler
	 *
	 * Updates local ignores list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 */
	public function json_sync_ignores_list ($params=array(), $action='') {
		WDS_Logger::info('Received ignores syncing request');
		$status = $this->sync_ignores_list($params, $action);
		return !empty($status)
			? wp_send_json_success()
			: wp_send_json_error()
		;
	}

	/**
	 * Purge ignores from the Hub action handler
	 *
	 * Purges local ignores list when the Hub storage is purged.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 *
	 * @return bool Status
	 */
	public function purge_ignores_list ($params=array(), $action='') {
		if (!class_exists('WDS_Model_Ignores')) require_once(WDS_PLUGIN_DIR . 'core/class_wds_model_ignores.php');
		$ignores = new WDS_Model_Ignores;

		return $ignores->clear();
	}

	/**
	 * Purge ignores from the Hub action handler
	 *
	 * Purges local ignores list when the Hub storage is purged.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 */
	public function json_purge_ignores_list ($params=array(), $action='') {
		WDS_Logger::info('Received ignores purging request');
		$status = $this->purge_ignores_list($params, $action);
		return !empty($status)
			? wp_send_json_success()
			: wp_send_json_error()
		;
	}

	/**
	 * Fresh extras from the Hub action handler
	 *
	 * Updates local extra URLs list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 *
	 * @return bool Status
	 */
	public function sync_extras_list ($params=array(), $action='') {
		if (!class_exists('WDS_XML_Sitemap')) require_once(WDS_PLUGIN_DIR . 'tools/sitemaps.php');
		$data = stripslashes_deep((array)$params);
		if (empty($data['urls']) || !is_array($data['urls'])) {
			return false;
		}

		$existing = WDS_XML_Sitemap::get_extra_urls();
		foreach ($data['urls'] as $url) {
			$existing[] = esc_url($url);
		}

		return WDS_XML_Sitemap::set_extra_urls($existing);
	}

	/**
	 * Fresh extras from the Hub action handler
	 *
	 * Updates local extra URLs list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 */
	public function json_sync_extras_list ($params=array(), $action='') {
		WDS_Logger::info('Received extras syncing request');
		$status = $this->sync_extras_list($params, $action);
		return !empty($status)
			? wp_send_json_success()
			: wp_send_json_error()
		;
	}

	/**
	 * Purge extras from the Hub action handler
	 *
	 * Purges local extra URLs list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 *
	 * @return bool Status
	 */
	public function purge_extras_list ($params=array(), $action='') {
		if (!class_exists('WDS_XML_Sitemap')) require_once(WDS_PLUGIN_DIR . 'tools/sitemaps.php');
		return WDS_XML_Sitemap::set_extra_urls(array());
	}

	/**
	 * Purge extras from the Hub action handler
	 *
	 * Purges local extra URLs list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 */
	public function json_purge_extras_list ($params=array(), $action='') {
		$status = $this->purge_extras_list($params, $action);
		return !empty($status)
			? wp_send_json_success()
			: wp_send_json_error()
		;
	}


}