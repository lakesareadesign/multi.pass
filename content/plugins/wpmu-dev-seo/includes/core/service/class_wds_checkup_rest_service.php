<?php

class WDS_Checkup_Rest_Service extends WDS_Checkup_Service_Implementation {

	public function get_known_verbs () {
		return array('start', 'result', 'emails');
	}

	public function is_cacheable_verb ($verb) {
		return false;
	}

	public function get_service_base_url () {
		$base_url = 'https://premium.wpmudev.org/';

		if (defined('WPMUDEV_CUSTOM_API_SERVER') && WPMUDEV_CUSTOM_API_SERVER) {
			$base_url = trailingslashit(WPMUDEV_CUSTOM_API_SERVER);
		}

		$api = apply_filters(
			$this->get_filter('api-endpoint'),
			'api'
		);

		$namespace = apply_filters(
			$this->get_filter('api-namespace'),
			'seo-checkup/v1'
		);

		return trailingslashit($base_url) . trailingslashit($api) . trailingslashit($namespace);
	}

	public function get_request_url ($verb) {
		if (empty($verb)) return false;
		if ('emails' === $verb) return $this->get_emails_request_url();

		$domain = apply_filters(
			$this->get_filter('domain'),
			network_site_url()
		);
		if (empty($domain)) return false;

		$query_url = http_build_query(array(
			'domain' => $domain
		));
		$query_url = $query_url && preg_match('/^\?/', $query_url) ? $query_url : "?{$query_url}";

		$request_url = trailingslashit($this->get_service_base_url()) .
			$verb .
			$query_url
		;

		return $request_url;
	}

	public function get_request_arguments ($verb) {
		if ('emails' === $verb) return $this->get_emails_request_arguments();

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

		return $args;
	}

	public function handle_error_response ($response) {
		$body = wp_remote_retrieve_body($response);
		if (empty($body)) return false;

		$error = json_decode($body, true);
		if (empty($error['message'])) return false;

		$this->set_cached_error("checkup", $error['message']);
	}

	public function get_start_verb () { return 'start'; }
	public function get_result_verb () { return 'result'; }

	/**
	 * Gets triggered after done method to ping the service with emails
	 */
	public function after_done () {
		$this->request('emails');
	}

	/**
	 * Returns emails-specific request URL
	 *
	 * return string
	 */
	public function get_emails_request_url () {
		return trailingslashit($this->get_service_base_url()) .
			'emails'
		;
	}

	/**
	 * Returns emails-specific request arguments
	 *
	 * @return array
	 */
	public function get_emails_request_arguments () {
		$key = $this->get_dashboard_api_key();
		if (empty($key)) return false;

		$opts = WDS_Settings::get_component_options(WDS_Settings::COMP_CHECKUP);
		$emails = array();
		if (!empty($opts['email-recipients']) && is_array($opts['email-recipients'])) {
			foreach ($opts['email-recipients'] as $user_id) {
				$user = new WP_User($user_id);
				$email = $user->user_email;
				if (!empty($email)) $emails[] = $email;
			}
			$emails = array_values(array_filter(array_unique($emails)));
		}

		if (empty($emails)) return false;

		$domain = apply_filters(
			$this->get_filter('domain'),
			network_site_url()
		);
		if (empty($domain)) return false;

		$args = array(
			'method' => 'POST',
			'timeout' => 40,
			'sslverify' => false,
			'headers' => array(
				'Authorization' => "Basic {$key}",
			),
			'body' => array(
				'emails' => $emails,
				'domain' => $domain,
			),
		);

		return $args;
	}

}