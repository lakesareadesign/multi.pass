<?php

class WDS_Seo_Service extends WDS_Service {

	const ERR_BASE_API_ISSUE = 40;
	const ERR_BASE_CRAWL_RUN = 51;
	const ERR_BASE_COOLDOWN = 52;
	const ERR_BASE_CRAWL_ERR = 53;
	const ERR_BASE_GENERIC = 59;

	public function get_known_verbs () {
		return array('start', 'status', 'result', 'sync');
	}

	public function is_cacheable_verb ($verb) {
		return in_array($verb, array('start', 'result'));
	}

	public function get_service_base_url () {
		$base_url = 'https://premium.wpmudev.org/';

		$api = apply_filters(
			$this->get_filter('api-endpoint'),
			'api'
		);

		$namespace = apply_filters(
			$this->get_filter('api-namespace'),
			'seo-audit/v1'
		);

		if (defined('WPMUDEV_CUSTOM_API_SERVER') && WPMUDEV_CUSTOM_API_SERVER) {
			$base_url = trailingslashit(WPMUDEV_CUSTOM_API_SERVER);
		}

		return trailingslashit($base_url) . trailingslashit($api) . trailingslashit($namespace);
	}

	public function get_request_url ($verb) {
		if (empty($verb)) return false;

		$domain = apply_filters(
			$this->get_filter('domain'),
			network_site_url()
		);
		if (empty($domain)) return false;

		$query_url = http_build_query(array(
			'domain' => $domain
		));
		$query_url = $query_url && preg_match('/^\?/', $query_url) ? $query_url : "?{$query_url}";

		return trailingslashit($this->get_service_base_url()) .
			$verb .
			$query_url
		;
		if (empty($verb)) return false;
		return trailingslashit(trailingslashit($this->get_service_base_url()) . $verb);
	}

	public function get_request_arguments ($verb) {
		$domain = apply_filters(
			$this->get_filter('domain'),
			network_site_url()
		);
		if (empty($domain)) return false;

		$key = $this->get_dashboard_api_key();
		if (empty($key)) return false;

		$args = array(
			'method' => 'GET',
			'timeout' => 40,
			'sslverify' => false,
			'headers' => array(
				'Authorization' => "Basic {$key}",
			),
		);

		if ('sync' === $verb) {
			if (!class_exists('WDS_Model_Ignores')) require_once(WDS_PLUGIN_DIR . 'core/class_wds_model_ignores.php');
			$ignores = new WDS_Model_Ignores;

			$args['method'] = 'POST';
			$args['body'] = array(
				'ignored_issue_ids' => json_encode($ignores->get_all()),
			);
		}

		return $args;
	}

	/**
	 * Local ignores list sync handler
	 *
	 * @return bool Status
	 */
	public function sync_ignores () {
		WDS_Logger::debug('Start syncing the ignore list');
		return $this->request('sync');
	}

	/**
	 * Public wrapper for start service method call
	 *
	 * @return mixed Service response hash on success, (bool)false on failure
	 */
	public function start () {
		WDS_Logger::debug('Starting a new crawl');
		$result = $this->request('start');
		if ($result) {
			$this->_clear_result();
		}

		return $result;
	}

	private function _clear_result () {
		$this->clear_cached('result');
		delete_option($this->get_filter('seo-service-result'));
	}

	private function _get_result () {
		$result = get_option($this->get_filter('seo-service-result'), false);
		if (false === $result) {
			$result = $this->get_cached('result');
		}
		return $result;
	}

	/**
	 * Public result getter
	 *
	 * @return mixed result
	 */
	public function get_result () {
		return $this->_get_result();
	}

	/**
	 * Sets result to new value
	 *
	 * Sets both cache and permanent result
	 *
	 * @return bool
	 */
	public function set_result ($result) {
		$this->set_cached('result', $result);

		// Also clear ignores cache, we're dealing with the new result
		if (!class_exists('WDS_Model_Ignores')) require_once(WDS_PLUGIN_DIR . 'core/class_wds_model_ignores.php');
		$ignores = new WDS_Model_Ignores;
		$ignores->clear();

		return !!update_option($this->get_filter('seo-service-result'), $result);
	}

	/**
	 * Public wrapper for status service method call
	 *
	 * @return mixed Service response hash on success, (bool)false on failure
	 */
	public function status () {
		$result = $this->_get_result();
		$result = !empty($result)
			? $result
			: $this->request('status')
		;

		return $result;
	}

	/**
	 * Public wrapper for result service method call
	 *
	 * @return mixed Service response hash on success, (bool)false on failure
	 */
	public function result () {
		$result = $this->request('result');
		if (!empty($result)) {
			$this->set_result($result);
		}

		return $result;
	}

	public function handle_error_response ($response) {
		$body = wp_remote_retrieve_body($response);
		$data = json_decode($body, true);
		if (empty($body) || empty($data)) {
			$this->_set_error(__('Unspecified error', 'wds'));
			return true;
		}

		$msg = '';
		if (!empty($data['message'])) $msg = $data['message'];

		if (!empty($data['data']['manage_link'])) {
			$url = esc_url($data['data']['manage_link']);
			$msg .= ' <a href="' . $url . '">' . __('Manage', 'wds') . '</a>';
		}

		if (!empty($msg)) $this->_set_error($msg);

		return true;
	}


}