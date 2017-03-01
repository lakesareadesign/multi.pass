<?php

class WDS_Settings_Dashboard extends WDS_Settings_Admin {

	const CRAWL_TIMEOUT_CODE = 'crawl_timeout';

	protected $_seo_service;
	protected $_uptime_service;

	private static $_instance;

	public static function get_instance () {
		if (empty(self::$_instance)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function validate ($input) { return $inpt; }

	public function init () {
		$this->slug = WDS_Settings::TAB_DASHBOARD;
		$this->title = __( 'SmartCrawl', 'wds' );
		$this->sub_title = __( 'Dashboard', 'wds' );
		$this->page_title = __( 'SmartCrawl Wizard: Dashboard', 'wds' );

		add_action('wp_ajax_wds-service-start', array($this, 'json_service_start'));
		add_action('wp_ajax_wds-service-status', array($this, 'json_service_status'));
		add_action('wp_ajax_wds-service-result', array($this, 'json_service_result'));

		add_action('wp_ajax_wds-service-redirect', array($this, 'json_service_redirect'));

		add_action('wp_ajax_wds-service-update_sitemap', array($this, 'json_service_update_sitemap'));

		parent::init();
	}

	/**
	 * Handles sitemap updating requests
	 */
	public function json_service_update_sitemap () {
		$result = array();
		$controller = WDS_Controller_Sitemap::get();

		// First up, find out how much stuff we got in the sitemap
		$data = $controller->get_sitemap_stats();
		$previous_count = !empty($data['items']) && is_numeric($data['items'])
			? (int)$data['items']
			: 0
		;

		// Update sitemap
		$controller->update_sitemap();

		// Get fresh count
		$data = $controller->get_sitemap_stats();
		$current_count = !empty($data['items']) && is_numeric($data['items'])
			? (int)$data['items']
			: 0
		;

		$diff = (int)($current_count - $previous_count);

		// Let's clear up the sitemap service results
		$service = WDS_Service::get(WDS_Service::SERVICE_SEO);
		$cres = $service->get_result();
		if (isset($cres['issues'])) {
			$cres['issues']['sitemap'] = !empty($cres['issues']['sitemap'])
				? $cres['issues']['sitemap']
				: 0
			;
			$cres['issues']['sitemap'] = 0;
			if (isset($cres['issues']['issues'])) $cres['issues']['issues']['sitemap'] = 0; // Fix data model deviation
			$cres['issues']['messages'] = !empty($cres['issues']['messages'])
				? $cres['issues']['messages']
				: array()
			;
			$msg = sprintf(
				__('We just updated your sitemap adding %1$d new items, for a total of %2$d. Please, re-crawl your site', 'wds'),
				$diff,
				$current_count
			);
			if (!in_array($msg, $cres['issues']['messages'])) $cres['issues']['messages'][] = $msg;
			$service->set_result($cres);
		}

		$result = array(
			'previous' => $previous_count,
			'current' => $current_count,
			'diff' => $diff,
		);

		wp_send_json($result);
	}

	/**
	 * Handles service redirect requests
	 */
	public function json_service_redirect () {
		$data = stripslashes_deep($_POST);
		$result = array();

		if (
			empty($data['source']) ||
			empty($data['redirect']) ||
			empty($data['wds-redirect'])
		) wp_send_json_error($result);

		if (!wp_verify_nonce($_POST['wds-redirect'], 'wds-redirect')) wp_send_json_error($result);

		$is_sitewide = is_multisite() && defined('WDS_SITEWIDE') && WDS_SITEWIDE;

		$permissions = $is_sitewide ? 'manage_network_options' : 'manage_options';
		if (!current_user_can($permissions)) wp_send_json_error($result);

		$source = esc_url($data['source']);
		$redirect = esc_url($data['redirect']);
		$rmodel = new WDS_Model_Redirection;

		$status_code = $rmodel->get_default_redirection_status_type();

		// Set both redirection and default status code
		$result['status'] = $rmodel->set_redirection($source, $redirect) && $rmodel->set_redirection_type($source, $status_code);

		wp_send_json($result);
	}

	/**
	 * Handle service crawl start request
	 */
	public function json_service_start () {
		$service = $this->_get_seo_service();
		$result = $service->start();

		$result = !empty($result) && is_array($result)
			? $result
			: array()
		;

		$error = empty($result) || !empty($result['code']);
		if (!empty($error)) {
			if (empty($result)) {
				$msgs = $service->get_errors();
				if (!empty($msgs)) $result['message'] = join(' ', $msgs);
			}
			$result = array(
				'success' => false,
				'code' => !empty($result['code']) ? $result['code'] : false,
				'message' => !empty($result['message']) ? $result['message'] : false,
			);
		}

		wp_send_json($result);
	}

	/**
	 * Handle service crawl status request
	 */
	public function json_service_status () {
		$service = $this->_get_seo_service();
		$result = $service->status();

		$result = !empty($result) && is_array($result)
			? $result
			: array()
		;
		$error = empty($result) || !empty($result['code']);
		if (!empty($error)) {
			if (empty($result)) {
				$msgs = $service->get_errors();
				if (!empty($msgs)) $result['message'] = join(' ', $msgs);
			}
			$code = !empty($result['code']) ? $result['code'] : false;
			$msg = !empty($result['message']) ? $result['message'] : false;

			// Crawl timed out, let's force the result now
			if ($code && self::CRAWL_TIMEOUT_CODE === $code) {
				$service->result();
			}

			$result = array(
				'success' => false,
				'code' => $code,
				'message' => $msg,
			);
		}

		wp_send_json($result);
	}

	/**
	 * Handle service crawl result request
	 */
	public function json_service_result () {
		$service = $this->_get_seo_service();
		$result = $service->result();

		$result = !empty($result) && is_array($result)
			? $result
			: array()
		;
		$error = empty($result) || !empty($result['code']);
		if (!empty($error)) {
			if (empty($result)) {
				$msgs = $service->get_errors();
				if (!empty($msgs)) $result['message'] = join(' ', $msgs);
			}
			$result = array(
				'success' => false,
				'code' => !empty($result['code']) ? $result['code'] : false,
				'message' => !empty($result['message']) ? $result['message'] : false,
			);
		}

		wp_send_json($result);
	}

	/**
	 * Add admin settings page
	 */
	public function options_page () {
		wp_enqueue_script('wds-admin-service');

		$uptime = $this->_get_uptime_service();

		$this->_render_page('dashboard-settings', array(
			'current_admin_url' => menu_page_url($this->wds_page_hook),
			'seo_message_box' => $this->_get_seo_service_message(),
			'uptime_message_box' => $this->_get_uptime_service_message(),
		));
	}

	/**
	 * Gets the SEO service box part
	 *
	 * @return string
	 */
	private function _get_seo_service_message () {
		$service = $this->_get_seo_service();
		$msg = '';

		// First up, can we access this at all?
		if ($service->can_access()) {

			// Okay, we can
			if ($service->has_dashboard()) {
				$result = $service->get_result();
				$status = false;

				// If we don't have perma-cached result,
				// we issued a re-crawl. So, let's check where we're at
				if (empty($result)) {
					$status = $service->status();
					$result = !empty($status['end'])
						? $service->result()
						: array()
					;
				} else $status = $result;

				$issues = !empty($result['issues'])
					? $result['issues']
					: array()
				;
				if (isset($issues['issues']) && is_array($issues['issues'])) $issues = $issues['issues'];

/*
if (!class_exists('WDS_SeoReport')) require_once(dirname(__FILE__) . '/../core/class_wds_seo_report.php');
$report = WDS_SeoReport::build($issues);
ms1_die_test($report->get_issues_count('5xx'));
*/

				$rmodel = new WDS_Model_Redirection;

				// We have Dashboard ready to go, we're connected and all
				$msg = $this->_load('dashboard-dialog-has_dashboard-service_seo', array(
					'status' => $status,
					'result' => $result,
					'issues' => $issues,
					'redirections' => $rmodel->get_all_redirections(),
					'errors' => $service->get_errors(),
				));
			} else if ($service->is_dahsboard_active()) {
				// Dashboard is active, but we're not connected
				$msg = $this->_load('dashboard-dialog-not_logged_in-service_seo');
			} else {
				// Dashboard not installed
				// Can we even install?
				if ($service->can_install()) $msg = $this->_load('dashboard-dialog-not_installed-service_seo');
			}
		}

		return $msg;
	}

	/**
	 * Gets the Uptime service box part
	 *
	 * Temporarily disabled
	 *
	 * @return string
	 */
	private function _get_uptime_service_message () {
		// As per Asana task, temporarily disable uptime report
		// See: https://app.asana.com/0/345574004857/277849197601097/
		return false;

		$service = $this->_get_uptime_service();
		$msg = '';

		// First up, can we access this at all?
		if ($service->can_access()) {

			// Okay, we can
			if ($service->is_dahsboard_active()) {
				// We have Dashboard active, good enough
				$response = $service->request('day');
				$msg = $this->_load('dashboard-dialog-has_dashboard-service_uptime', array(
					'data' => $response,
					'errors' => $service->get_errors(),
				));
			} else {
				// Dashboard not installed
				// Can we even install?
				if ($service->can_install()) $msg = $this->_load('dashboard-dialog-not_installed-service_uptime');
			}
		}

		return $msg;
	}

	/**
	 * Add sub page to the Settings Menu
	 */
	public function add_page () {
		if (!$this->_is_current_tab_allowed()) return false;

		$svg = '<?xml version="1.0" encoding="UTF-8" standalone="no"?><svg width="16px" height="16px" xmlns="http://www.w3.org/2000/svg"><g id="Page-1" stroke="none" stroke-width="1" fill="#A0A5AA" fill-rule="evenodd"><path d="M15.6875,0 L14,1.307393 L14,10.4280156 C14,10.9571984 13.625,11.3929961 13.15625,11.3929961 C12.65625,11.3929961 12.28125,10.9571984 12.28125,10.4280156 L12.28125,5.57198444 C12.28125,4.0155642 11.125,2.73929961 9.71875,2.73929961 C8.3125,2.73929961 7.1875,4.0155642 7.1875,5.57198444 L7.1875,10.4280156 C7.1875,10.9571984 6.78125,11.3929961 6.3125,11.3929961 C5.84375,11.3929961 5.46875,10.9571984 5.46875,10.4280156 L5.46875,5.57198444 C5.46875,4.0155642 4.3125,2.73929961 2.90625,2.73929961 C1.5,2.73929961 0.34375,4.0155642 0.34375,5.57198444 L0.34375,16 L2.03125,14.692607 L2.03125,5.57198444 C2.03125,5.04280156 2.4375,4.60700389 2.90625,4.60700389 C3.375,4.60700389 3.78125,5.04280156 3.78125,5.57198444 L3.75,10.4280156 C3.75,11.9844358 4.90625,13.2607004 6.3125,13.2607004 C7.71875,13.2607004 8.875,11.9844358 8.875,10.4280156 L8.875,5.57198444 C8.875,5.04280156 9.25,4.60700389 9.71875,4.60700389 C10.21875,4.60700389 10.59375,5.04280156 10.59375,5.57198444 L10.59375,10.4280156 C10.59375,11.9844358 11.71875,13.2607004 13.15625,13.2607004 C14.5625,13.2607004 15.6875,11.9844358 15.6875,10.4280156 L15.6875,0 Z" id="Shape"></path></g></svg>';
		$icon = 'data:image/svg+xml;base64,' . base64_encode( $svg );

		$this->wds_page_hook = add_menu_page(
			$this->page_title,
			$this->title,
			$this->capability,
			$this->slug,
			array( &$this, 'options_page' ),
			$icon
		);

		$this->wds_page_hook = add_submenu_page(
			$this->slug,
			$this->page_title,
			$this->sub_title,
			$this->capability,
			$this->slug,
			array( &$this, 'options_page' )
		);

		add_action( "admin_print_styles-{$this->wds_page_hook}", array( &$this, 'admin_styles' ) );
		add_action( "admin_print_scripts-{$this->wds_page_hook}", array( &$this, 'admin_scripts' ) );
	}

	/**
	 * Default settings
	 */
	public function defaults () {

	}

	/**
	 * Always allow dashboard tab if there's more than one tab allowed
	 *
	 * Overrides WDS_Settings::_is_current_tab_allowed
	 *
	 * @return bool
	 */
	protected function _is_current_tab_allowed () {
		if (parent::_is_current_tab_allowed()) return true;
		// Else we always add dashboard if there are other pages
		$all_tabs = WDS_Settings_Settings::get_blog_tabs();

		return !empty($all_tabs);
	}

	protected function _get_seo_service () {
		if (!empty($this->_seo_service)) return $this->_seo_service;

		$this->_seo_service = WDS_Service::get(WDS_Service::SERVICE_SEO);

		return $this->_seo_service;
	}

	protected function _get_uptime_service () {
		if (!empty($this->_uptime_service)) return $this->_uptime_service;

		$this->_uptime_service = WDS_Service::get(WDS_Service::SERVICE_UPTIME);

		return $this->_uptime_service;
	}

}