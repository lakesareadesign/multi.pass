<?php

if (!class_exists('WDS_Renderable')) require_once(WDS_PLUGIN_DIR . '/core/class_wds_renderable.php');

abstract class WDS_Settings extends WDS_Renderable {

	const COMP_AUTOLINKS = 'autolinks';
	const COMP_ONPAGE = 'onpage';
	const COMP_SEOMOZ = 'seomoz';
	const COMP_SOCIAL = 'social';
	const COMP_SITEMAP = 'sitemap';
	const COMP_REDIRECTIONS = 'redirections';
	const COMP_CHECKUP = 'checkup';

	const TAB_DASHBOARD = 'wds_wizard';
	const TAB_AUTOLINKS = 'wds_autolinks';
	const TAB_ONPAGE = 'wds_onpage';
	const TAB_SEOMOZ = 'wds_seomoz';
	const TAB_SOCIAL = 'wds_social';
	const TAB_SITEMAP = 'wds_sitemap';
	const TAB_SETTINGS = 'wds_settings';
	const TAB_REDIRECTIONS = 'wds_redirections';
	const TAB_CHECKUP = 'wds_checkup';

	/**
	 * Holds options cache, so it's only populated once
	 *
	 * @var array
	 */
	private static $_all_options = array();

	/**
	 * Options getter
	 *
	 * Use this to get rid of as much of `global` cancer as we can
	 *
	 * @return array Options array
	 */
	public static function get_options () {
		if (empty(self::$_all_options)) {
			self::$_all_options = self::_populate_options();
		}
		return self::$_all_options;
	}

	/**
	 * Merges all options together
	 *
	 * Context and config dependent
	 *
	 * @return array
	 */
	private static function _populate_options () {
		$settings = is_multisite() && wds_is_switch_active('WDS_SITEWIDE') || !wds_is_allowed_tab(self::TAB_SETTINGS)
			? self::get_sitewide_settings()
			: self::get_local_settings()
		;
		$autolinks = is_multisite() && wds_is_switch_active('WDS_SITEWIDE') || !wds_is_allowed_tab(self::TAB_AUTOLINKS)
			? get_site_option(self::TAB_AUTOLINKS . '_options', array())
			: get_option(self::TAB_AUTOLINKS . '_options', array())
		;
		$onpage = is_multisite() && wds_is_switch_active('WDS_SITEWIDE') || !wds_is_allowed_tab(self::TAB_ONPAGE)
			? get_site_option(self::TAB_ONPAGE . '_options', array())
			: get_option(self::TAB_ONPAGE . '_options', array())
		;
		$sitemap = is_multisite() && wds_is_switch_active('WDS_SITEWIDE') || !wds_is_allowed_tab(self::TAB_SITEMAP)
			? get_site_option(self::TAB_SITEMAP . '_options', array())
			: get_option(self::TAB_SITEMAP . '_options', array())
		;
		$social = is_multisite() && wds_is_switch_active('WDS_SITEWIDE') || !wds_is_allowed_tab(self::TAB_SOCIAL)
			? get_site_option(self::TAB_SOCIAL . '_options', array())
			: get_option(self::TAB_SOCIAL . '_options', array())
		;
		$checkup = is_multisite() && wds_is_switch_active('WDS_SITEWIDE') || !wds_is_allowed_tab(self::TAB_CHECKUP)
			? get_site_option(self::TAB_CHECKUP . '_options', array())
			: get_option(self::TAB_CHECKUP . '_options', array())
		;
		return array_merge(
			(array)$settings,
			(array)$autolinks,
			(array)$onpage,
			(array)$sitemap,
			(array)$social,
			(array)$checkup
		);
	}

	/**
	 * Resets all options
	 *
	 * @return array Reset options
	 */
	public static function reset_options () {
		$list = self::get_known_tabs();

		foreach ($list as $item) {
			delete_site_option("{$item}_options");
			delete_option("{$item}_options");
		}

		self::$_all_options = array();
		return self::get_options();
	}

	/**
	 * Gets sitewide options
	 *
	 * @return array
	 */
	public static function get_sitewide_settings () {
		return get_site_option('wds_settings_options', array());
	}

	/**
	 * Explicit local site option getter
	 *
	 * @return array
	 */
	public static function get_local_settings () {
		return get_option('wds_settings_options', array());
	}

	/**
	 * Gets contextual per-blog option or sitewide fallback
	 *
	 * @param string $key Option name to check
	 * @param mixed $fallback What to return on failure
	 *
	 * @return mixed Value or falback
	 */
	public static function get_setting ($key, $fallback=false) {
		$options = self::get_sitewide_settings();
		$value = isset($options[$key])
			? $options[$key]
			: $fallback
		;

		if (!(defined('WDS_SITEWIDE') && WDS_SITEWIDE)) {
			$options = self::get_local_settings();
			$value = isset($options[$key])
				? $options[$key]
				: $value
			;
		}

		return $value;
	}

	/**
	 * Returns known components, as component => title pairs
	 *
	 * @return array Known components
	 */
	public static function get_known_components () {
		return array(
			self::COMP_AUTOLINKS => __('Advanced Tools' , 'wds'),
			self::COMP_ONPAGE => __('Title & Meta Optimization' , 'wds'),
			self::COMP_SEOMOZ => __('Moz Report' , 'wds'),
			self::COMP_SOCIAL => __('Social' , 'wds'),
			self::COMP_SITEMAP => __('XML Sitemap' , 'wds'),
			self::COMP_CHECKUP => __('SEO Checkup', 'wds'),
		);
	}

	public static function get_known_tabs () {
		return array(
			self::TAB_DASHBOARD,
			self::TAB_SEOMOZ,
			self::TAB_REDIRECTIONS,
			self::TAB_SETTINGS,
			self::TAB_AUTOLINKS,
			self::TAB_ONPAGE,
			self::TAB_SITEMAP,
			self::TAB_SOCIAL,
			self::TAB_CHECKUP,
		);
	}

	/**
	 * Returns extended list of known components keys
	 *
	 * @return array Known components
	 */
	public static function get_all_components () {
		return array(
			self::COMP_AUTOLINKS,
			self::COMP_ONPAGE,
			self::COMP_SEOMOZ,
			self::COMP_SOCIAL,
			self::COMP_SITEMAP,
			self::COMP_REDIRECTIONS,
			self::COMP_CHECKUP,
		);
	}

	/**
	 * Gets component-specific options
	 *
	 * @param string $component One of the known components (use class constants pl0x)
	 *
	 * @return array Component-specific options
	 */
	public static function get_component_options ($component) {
		if (empty($component)) return array();
		if (!in_array($component, self::get_all_components())) return array();

		$options_key = "wds_{$component}_options";
		return self::get_specific_options($options_key);
	}

	/**
	 * Gets component-specific options
	 *
	 * @param string $options_key Specific options key we're after
	 *
	 * @return array Options
	 */
	public static function get_specific_options ($options_key) {
		if (empty($options_key)) return array();

		$options = is_multisite() && wds_is_switch_active('WDS_SITEWIDE')
			? get_site_option($options_key)
			: get_option($options_key)
		;
		return $options;
	}

	/**
	 * Updates component-specific options
	 *
	 * @param string $component One of the known components (use class constants pl0x)
	 * @param array $options Specific options we want to save
	 */
	public static function update_component_options ($component, $options) {
		if (empty($component)) return array();
		if (!in_array($component, self::get_all_components())) return array();

		$options_key = "wds_{$component}_options";
		return self::update_specific_options($options_key, $options);
	}

	/**
	 * Updates component-specific options
	 *
	 * @param string $options_key Specific options key we're after
	 * @param array $options Specific options we want to save
	 */
	public static function update_specific_options ($option_key, $options) {
		return is_multisite() && wds_is_switch_active('WDS_SITEWIDE')
			? update_site_option($option_key, $options)
			: update_option($option_key, $options)
		;
	}

	/**
	 * Filter name getter
	 *
	 * @param string $suffix Action suffix
	 *
	 * @return string Final filter name
	 */
	public function get_filter ($suffix) {
		if (empty($suffix)) return false;
		if (!is_string($suffix)) return false;

		$component = !empty($this->name) || !in_array($this->name, array_keys(self::get_known_components()))
			? $this->name
			: 'general'
		;
		return "wds-settings-{$component}-{$suffix}";
	}

}