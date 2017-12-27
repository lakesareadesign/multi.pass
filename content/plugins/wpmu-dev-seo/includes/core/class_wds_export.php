<?php

if (!class_exists('WDS_Model_IO')) require_once(dirname(__FILE__) . '/class_wds_model_io.php');

class WDS_Export {

	private $_model;

	public function __construct () {
		$this->_model = new WDS_Model_IO;
	}

	/**
	 * Loads all options
	 *
	 * @return WDS_Model_IO instance
	 */
	public static function load () {
		$me = new self;

		$me->load_all();

		return $me->_model;
	}

	/**
	 * Loads everything
	 *
	 * @return WDS_Model_IO instance
	 */
	public function load_all () {
		foreach ($this->_model->get_sections() as $section) {
			$method = array($this, "load_{$section}");
			if (!is_callable($method)) continue;

			call_user_func($method);
		}

		return $this->_model;
	}

	/**
	 * Loads options
	 *
	 * @return WDS_Model_IO instance
	 */
	public function load_options () {
		$options = array();

		$components = WDS_Settings::get_all_components();
		foreach ($components as $component) {
			$options[$this->get_option_name($component)] = WDS_Settings::get_component_options($component);
		}

		$options['wds_settings_options'] = wds_is_switch_active('WDS_SITEWIDE')
			? WDS_Settings::get_sitewide_settings()
			: WDS_Settings::get_local_settings()
		;

		$options['wds_blog_tabs'] = get_site_option('wds_blog_tabs');

		$this->_model->set(WDS_Model_IO::OPTIONS, $options);

		return $this->_model;
	}

	/**
	 * Gets option name
	 *
	 * @param string $comp Partial
	 *
	 * @return string Options key
	 */
	public function get_option_name ($comp) {
		if (in_array($comp, WDS_Settings::get_all_components())) return "wds_{$comp}_options";
	}

	/**
	 * Loads ignores
	 *
	 * @return WDS_Model_IO instance
	 */
	public function load_ignores () {
		if (!class_exists('WDS_Model_Ignores')) require_once WDS_PLUGIN_DIR . '/core/class_wds_model_ignores.php';
		$model = new WDS_Model_Ignores;
		$this->_model->set(WDS_Model_IO::IGNORES, $model->get_all());
		return $this->_model;
	}

	/**
	 * Loads extra sitemap URLs
	 *
	 * @return WDS_Model_IO instance
	 */
	public function load_extra_urls () {
		if (!class_exists('WDS_XML_Sitemap')) require_once WDS_PLUGIN_DIR . '/tools/sitemaps.php';
		$this->_model->set(WDS_Model_IO::EXTRA_URLS, WDS_XML_Sitemap::get_extra_urls());
		return $this->_model;
	}

	/**
	 * Loads all stored postmeta
	 *
	 * @return WDS_Model_IO instance
	 */
	public function load_postmeta () {
		global $wpdb;
		$res = $wpdb->get_results(
			"SELECT post_id,meta_key,meta_value FROM {$wpdb->postmeta} WHERE meta_key LIKE '_wds%'",
			ARRAY_A
		);
		$this->_model->set(WDS_Model_IO::POSTMETA, $res);
		return $this->_model;
	}

	/**
	 * Loads all stored taxmeta for the current site
	 *
	 * @return WDS_Model_IO instance
	 */
	public function load_taxmeta () {
		$taxmeta = get_option('wds_taxonomy_meta');
		if (!is_array($taxmeta)) $taxmeta = array();
		$this->_model->set(WDS_Model_IO::TAXMETA, $taxmeta);
		return $this->_model;
	}

	/**
	 * Loads all stored redirects for the current site
	 *
	 * @return WDS_Model_IO instance
	 */
	public function load_redirects () {
		if (!class_exists('WDS_Model_Redirection')) {
			require_once WDS_PLUGIN_DIR . '/core/class_wds_model_redirection.php';
		}
		$model = new WDS_Model_Redirection();
		$this->_model->set(WDS_Model_IO::REDIRECTS, $model->get_all_redirections());
		return $this->_model;
	}
}