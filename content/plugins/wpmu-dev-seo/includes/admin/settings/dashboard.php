<?php

class WDS_Settings_Dashboard extends WDS_Settings_Admin {

	const CRAWL_TIMEOUT_CODE = 'crawl_timeout';
	const BOX_SOCIAL = 'wds-social-dashboard-box';
	const BOX_ADVANCED_TOOLS = 'wds-advanced-tools-dashboard-box';
	const BOX_ONPAGE = 'wds-title-and-meta-dashboard-box';
	const BOX_CONTENT_ANALYSIS = 'wds-content-analysis-box';
	const BOX_SITEMAP = 'wds-sitemap-box';
	const BOX_SEO_CHECKUP = 'wds-seo-checkup';
	const BOX_TOP_STATS = 'wds-dashboard-stats';

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
		add_action('wp_ajax_wds-service-ignore', array($this, 'json_service_ignore'));
		add_action('wp_ajax_wds-service-unignore', array($this, 'json_service_unignore'));
		add_action('wp_ajax_wds-service-ignores-purge', array($this, 'json_service_ignores_purge'));

		add_action('wp_ajax_wds-service-update_sitemap', array($this, 'json_service_update_sitemap'));
		add_action('wp_ajax_wds-activate-component', array($this, 'json_activate_component'));
		add_action('wp_ajax_wds-reload-box', array($this, 'json_reload_component'));

		parent::init();
	}

	/**
	 * Handles service ignores addition
	 */
	public function json_service_ignore () {
		$result = array('status' => 0);
		if (!current_user_can('manage_options')) return wp_send_json($result);

		if (!class_exists('WDS_Model_Ignores')) require_once(WDS_PLUGIN_DIR . 'core/class_wds_model_ignores.php');
		$ignores = new WDS_Model_Ignores;

		$data = stripslashes_deep($_POST);
		if (empty($data['issue_id'])) return wp_send_json($result);

		$issue_id = $data['issue_id'];
		$issue_ids = is_array($issue_id) ? $issue_id : array($issue_id);

		foreach ($issue_ids as $issue) {
			$ignores->set_ignore($issue);
		}

		// Send updated list to Hub
		$service = WDS_Service::get(WDS_Service::SERVICE_SEO);
		if (!$service->sync_ignores()) {
			WDS_Logger::debug('We encountered an error syncing ignores with Hub');
		}

		$result['status'] = 1;
		return wp_send_json($result);
	}

	/**
	 * Handles service un-ignores addition
	 */
	public function json_service_unignore()
	{
		$result = array('status' => 0);
		if (!current_user_can('manage_options')) {
			wp_send_json($result);
			return;
		}

		if (!class_exists('WDS_Model_Ignores')) require_once(WDS_PLUGIN_DIR . 'core/class_wds_model_ignores.php');
		$ignores = new WDS_Model_Ignores;

		$data = stripslashes_deep($_POST);
		if (empty($data['issue_id'])) {
			wp_send_json($result);
			return;
		}

		$issue_id = $data['issue_id'];
		$issue_ids = is_array($issue_id) ? $issue_id : array($issue_id);

		foreach ($issue_ids as $issue) {
			$ignores->unset_ignore($issue);
		}

		// Send updated list to Hub
		$service = WDS_Service::get(WDS_Service::SERVICE_SEO);
		if (!$service->sync_ignores()) {
			WDS_Logger::debug('We encountered an error syncing ignores with Hub');
		}

		$result['status'] = 1;
		wp_send_json($result);
	}

	/**
	 * Handles service ignores purging
	 */
	public function json_service_ignores_purge () {
		$result = array('status' => 0);
		if (!current_user_can('manage_options')) return wp_send_json($result);

		if (!class_exists('WDS_Model_Ignores')) require_once(WDS_PLUGIN_DIR . 'core/class_wds_model_ignores.php');
		$ignores = new WDS_Model_Ignores;

		if ($ignores->clear()) {
			// Send updated list to Hub
			$service = WDS_Service::get(WDS_Service::SERVICE_SEO);
			if (!$service->sync_ignores()) {
				WDS_Logger::debug('We encountered an error syncing ignores with Hub');
			}

			$result['status'] = 1;
		}

		return wp_send_json($result);
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
			// Start with a generic message
			$msg = __('Sitemap updated. Please, re-crawl your site', 'wds');
			if ($diff > 0) {
				sprintf(
					__('We just updated your sitemap adding %1$d new items, for a total of %2$d. Please, re-crawl your site', 'wds'),
					$diff,
					$current_count
				);
			} else if ($diff < 0) {
				sprintf(
					__('No new items were added to your sitemap, but we did detect a change (for %1$d items total). Please, re-crawl your site.', 'wds'),
					$current_count
				);
			}

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

		if (true === $result) {
			$result = $service->status();
		}

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
			$service->stop();
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

	public function json_activate_component()
	{
		$result = array('success' => false);
		$data = stripslashes_deep($_POST);

		$option_id = wds_get_array_value($data, 'option');
		$flag = wds_get_array_value($data, 'flag');

		if (is_null($option_id) || is_null($flag)) {
			wp_send_json($result);
			return;
		}

		$options = self::get_specific_options($option_id);
		$options[ $flag ] = true;
		self::update_specific_options($option_id, $options);

		$result['success'] = true;
		wp_send_json($result);
	}

	function json_reload_component()
	{
		$result = array('success' => false);
		$data = stripslashes_deep($_POST);

		$box_id = wds_get_array_value($data, 'box_id');

		if (is_null($box_id)) {
			wp_send_json($result);
			return;
		}

		if (!is_array($box_id)) {
			$box_id = array($box_id);
		}

		$box_id = array_unique($box_id);

		foreach ($box_id as $id) {
			$result[ $id ] = $this->load_box_markup($id);
		}

		$result['success'] = true;
		wp_send_json($result);
	}

	function load_box_markup($box_id)
	{
		switch ($box_id) {
			case self::BOX_SOCIAL:
				return $this->_load('dashboard/dashboard-widget-social');

			case self::BOX_ADVANCED_TOOLS:
				return $this->_load('dashboard/dashboard-widget-advanced-tools');

			case self::BOX_ONPAGE:
				return $this->_load('dashboard/dashboard-widget-onpage');

			case self::BOX_CONTENT_ANALYSIS:
				return $this->_load('dashboard/dashboard-widget-content-analysis');

			case self::BOX_SITEMAP:
				return $this->_load('dashboard/dashboard-widget-sitemap');

			case self::BOX_SEO_CHECKUP:
				return $this->_load('dashboard/dashboard-widget-seo-checkup');

			case self::BOX_TOP_STATS:
				return $this->_load('dashboard/dashboard-top');
		};

		return null;
	}

	/**
	 * Process run action
	 *
	 * @return void
	 */
	public function process_run_action () {
		if (!empty($_GET['run-checkup'])) {
			return $this->run_checkup();
		}
	}

	/**
	 * Add admin settings page
	 */
	public function options_page () {
		wp_enqueue_script('wds-admin-dashboard');

		$uptime = $this->_get_uptime_service();

		$this->_render_page('dashboard/dashboard', array(
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

				if (!class_exists('WDS_SeoReport')) require_once(WDS_PLUGIN_DIR . 'core/class_wds_seo_report.php');
				$report = WDS_SeoReport::build($result);

				$rmodel = new WDS_Model_Redirection;

				// We have Dashboard ready to go, we're connected and all
				$msg = $this->_load('dashboard-dialog-has_dashboard-service_seo', array(
					'status' => $status,
					'has_result' => !empty($result),
					'report' => $report,
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

		$svg = '<?xml version="1.0" encoding="UTF-8" standalone="no"?><svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Artboard" fill-rule="nonzero" fill="#FFFFFF"><path d="M0.558,12.1008055 L17.445,12.1008055 C16.1402452,15.6456454 12.7704642,18 9.0015,18 C5.23253577,18 1.86275481,15.6456454 0.558,12.1008055 Z M17.442,5.89919449 L0.555,5.89919449 C1.85975481,2.35435463 5.22953577,4.81675263e-16 8.9985,7.11236625e-16 C12.7674642,9.40797988e-16 16.1372452,2.35435463 17.442,5.89919449 Z M0.042,8 L17.958,8 C17.985,8.32740214 18,8.66192171 18,9 C18,9.33807829 17.985,9.66903915 17.958,10 L0.042,10 C0.018,9.66903915 0,9.33807829 0,9 C0,8.66192171 0.018,8.32740214 0.042,8 Z" id="smartcrawl"></path></g></g></svg>';
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

		// For pages that can deal with run requests, let's make sure they
		// actually do that early enough
		if (is_callable(array($this, 'process_run_action'))) {
			add_action('load-' . $this->wds_page_hook, array($this, 'process_run_action'));
		}

		add_action( "admin_print_styles-{$this->wds_page_hook}", array( &$this, 'admin_styles' ) );
		add_action( "admin_print_scripts-{$this->wds_page_hook}", array( &$this, 'admin_scripts' ) );
	}

	/**
	 * Default settings
	 */
	public function defaults()
	{
		$this->options = WDS_Settings::get_options();
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