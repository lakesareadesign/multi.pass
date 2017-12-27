<?php

if (!class_exists('WDS_Model_IO')) require_once(dirname(__FILE__) . '/class_wds_model_io.php');
if (!class_exists('WDS_WorkUnit')) require_once (dirname(__FILE__) . '/class_wds_work_unit.php');

class WDS_Import extends WDS_WorkUnit {

	private $_model;

	public function __construct () {
		parent::__construct();
		$this->_model = new WDS_Model_IO;
	}

	/**
	 * Loads all options
	 *
	 * @param string $json JSON model to load from
	 *
	 * @return WDS_Import instance
	 */
	public static function load ($json) {
		$me = new self;

		$me->load_all($json);

		return $me;
	}

	/**
	 * Loads everything
	 *
	 * @param string $json JSON model to load from
	 *
	 * @return WDS_Model_IO instance
	 */
	public function load_all ($json) {
		$data = json_decode($json, true);
		if (empty($data)) return $this->_model;

		foreach ($this->_model->get_sections() as $section) {
			if (!isset($data[$section]) || !is_array($data[$section])) continue;
			$this->_model->set($section, $data[$section]);
		}

		return $this->_model;
	}

	public function save () {
		$overall_status = true;

		foreach ($this->_model->get_sections() as $section) {
			$method = array($this, "save_{$section}");
			if (!is_callable($method)) continue;
			$status = call_user_func($method);

			if (!$status) {
				$this->add_error($section, __('Import process failed, aborting', 'wds'));
				$overall_status = false;
			}
			if (!$overall_status) break;
		}

		return $overall_status;
	}

	public function save_options () {
		$overall_status = true;
		foreach ($this->_model->get(WDS_Model_IO::OPTIONS) as $key => $value) {
			if (false === $value) continue; // Do not force-add false values
			if ('wds_blog_tabs' === $key) {
				$old = get_site_option($key);
				$status = update_site_option($key, $value);
			} else {
				$status = wds_is_switch_active('WDS_SITEWIDE')
					? update_site_option($key, $value)
					: update_option($key, $value)
				;
			}
			if (false) {
				$this->add_error($key, sprintf(__('Failed importing options: %s', 'wds'), $key));
				$overall_status = false;
			}
			if (!$overall_status) break;
		}

		return $overall_status;
	}

	public function save_ignores () {
		if (!class_exists('WDS_Model_Ignores')) require_once WDS_PLUGIN_DIR . '/core/class_wds_model_ignores.php';
		$data = $this->_model->get(WDS_Model_IO::IGNORES);
		$ignores = new WDS_Model_Ignores;

		$overall_status = true;
		foreach ($data as $key) {
			$status = $ignores->set_ignore($key);
			// Now, since update_(site_)option can return non-true for success,
			// we do not do any error checking
			/*
			if (!$status) {
				$this->add_error($key, sprintf(__('Failed importing ignores: %s', 'wds'), $key));
				$overall_status = false;
			}
			if (!$overall_status) break;
		 */
		}

		return $overall_status;
	}

	public function save_extra_urls () {
		if (!class_exists('WDS_XML_Sitemap')) require_once WDS_PLUGIN_DIR . '/tools/sitemaps.php';
		$data = $this->_model->get(WDS_Model_IO::EXTRA_URLS);
		$result = WDS_XML_Sitemap::set_extra_urls($data);

		return WDS_XML_Sitemap::get_extra_urls() === $data;
	}

	public function save_postmeta () {
		return true;
	}

	public function save_taxmeta () {
		return true;
	}

	public function save_redirects () {
		if (!class_exists('WDS_Model_Redirection')) {
			require_once WDS_PLUGIN_DIR . '/core/class_wds_model_redirection.php';
		}
		$model = new WDS_Model_Redirection();
		$redirects = $this->_model->get(WDS_Model_IO::REDIRECTS);
		$types = $this->_model->get(WDS_Model_IO::REDIRECT_TYPES);

		$result = $model->set_all_redirections($redirects);
		$result = $model->set_all_redirection_types($types);

		return $redirects === $model->get_all_redirections() && $types === $model->get_all_redirection_types();
	}

	public function get_filter_prefix () { return 'wds-import'; }

}