<?php

abstract class WDS_Settings {

	const COMP_AUTOLINKS = 'autolinks';
	const COMP_ONPAGE = 'onpage';
	const COMP_SEOMOZ = 'seomoz';
	const COMP_SITEMAP = 'sitemap';
	const COMP_REDIRECTIONS = 'redirections';

	const TAB_DASHBOARD = 'wds_wizard';
	const TAB_AUTOLINKS = 'wds_autolinks';
	const TAB_ONPAGE = 'wds_onpage';
	const TAB_SEOMOZ = 'wds_seomoz';
	const TAB_SITEMAP = 'wds_sitemap';
	const TAB_SETTINGS = 'wds_settings';
	const TAB_REDIRECTIONS = 'wds_redirections';

	/**
	 * Options getter
	 *
	 * Use this to get rid of as much of `global` cancer as we can
	 *
	 * @return array Options array
	 */
	public static function get_options () {
		global $wds_options;
		return $wds_options;
	}

	/**
	 * Gets sitewide options
	 *
	 * @return array
	 */
	public static function get_sitewide_options () {
		return get_site_option('wds_settings_options', array());
	}

	/**
	 * Explicit local site option getter
	 *
	 * @return array
	 */
	public static function get_local_options () {
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
	public static function get_option ($key, $fallback=false) {
		$options = self::get_sitewide_options();
		$value = isset($options[$key])
			? $options[$key]
			: $fallback
		;

		if (!(defined('WDS_SITEWIDE') && WDS_SITEWIDE)) {
			$options = self::get_local_options();
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
			self::COMP_AUTOLINKS => __('Automatic Links' , 'wds'),
			self::COMP_ONPAGE => __('Title & Meta Optimization' , 'wds'),
			self::COMP_SEOMOZ => __('Moz Report' , 'wds'),
			self::COMP_SITEMAP => __('XML Sitemap' , 'wds'),
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
			self::COMP_SITEMAP,
			self::COMP_REDIRECTIONS,
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

		$options = is_multisite() && defined('WDS_SITEWIDE') && WDS_SITEWIDE
			? get_site_option($options_key)
			: get_option($options_key)
		;
		return $options;
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