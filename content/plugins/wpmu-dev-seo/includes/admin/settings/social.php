<?php

class WDS_Social_Settings extends WDS_Settings_Admin {


	private static $_instance;

	public static function get_instance () {
		if (empty(self::$_instance)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Validate submitted options
	 *
	 * @param array $input Raw input
	 *
	 * @return array Validated input
	 */
	public function validate ($input) {
		$result = array();

		if (!empty($input['wds_social-setup'])) $result['wds_social-setup'] = true;

		$result['disable-schema'] = !empty($input['disable-schema']);

		$urls = array(
			'facebook_url',
			'instagram_url',
			'linkedin_url',
			'pinterest_url',
			'gplus_url',
			'youtube_url',
		);
		foreach ($urls as $type) {
			if (empty($input[$type])) continue;
			if (!preg_match('/^https?:\/\//', $input[$type])) continue;
			$result[$type] = $input[$type];
		}

		if (!empty($input['sitename'])) $result['sitename'] = sanitize_text_field($input['sitename']);
		if (!empty($input['override_name'])) $result['override_name'] = sanitize_text_field($input['override_name']);
		if (!empty($input['organization_name'])) $result['organization_name'] = sanitize_text_field($input['organization_name']);
		if (!empty($input['organization_logo'])) $result['organization_logo'] = sanitize_text_field($input['organization_logo']);
		if (!empty($input['schema_type'])) $result['schema_type'] = sanitize_text_field($input['schema_type']);
		if (!empty($input['twitter_username'])) $result['twitter_username'] = sanitize_text_field($input['twitter_username']);
		if (!empty($input['twitter-card-type'])) $result['twitter-card-type'] = sanitize_text_field($input['twitter-card-type']);
		if (!empty($input['fb-app-id'])) $result['fb-app-id'] = sanitize_text_field($input['fb-app-id']);

		$result['og-enable'] = !empty($input['og-enable']);
		$result['twitter-card-enable'] = !empty($input['twitter-card-enable']);

		$this->_toggle_og_globally(
			$result['og-enable']
		);

		if (!empty($input['pinterest-verify'])) {
			if (!class_exists('WDS_Pinterest_Printer')) require_once(WDS_PLUGIN_DIR . '/tools/class_wds_pinterest_printer.php');
			$pin = WDS_Pinterest_Printer::get();
			$raw = trim($input['pinterest-verify']);
			$tag = $pin->get_verified_tag($raw);
			$result['pinterest-verify'] = str_replace(' ', '', $raw) === str_replace(' ', '', $tag) ? $tag : false;
			$result['pinterest-verification-status'] = str_replace(' ', '', $raw) === str_replace(' ', '', $tag) ? '' : 'fail';
		} else $result['pinterest-verification-status'] = false;

		return $result;
	}

	private function _toggle_og_globally($new_value)
	{
		$existing_settings = WDS_Settings::get_specific_options('wds_onpage_options');
		$strings = array(
			'home',
			'author',
			'date',
			'search',
			'404',
			'category',
			'post_tag',
			'bp_groups',
			'bp_profile',
			'mp_marketplace-base',
			'mp_marketplace-categories',
			'mp_marketplace-tags'
		);

		foreach (get_taxonomies(array('_builtin' => false), 'objects') as $taxonomy) {
			$strings[] = $taxonomy->name;
		}

		foreach (get_post_types(array('public' => true)) as $post_type) {
			$strings[] = $post_type;
		}

		foreach ($strings as $string) {
			$existing_settings["og-active-{$string}"] = $new_value;
		}

		WDS_Settings::update_specific_options('wds_onpage_options', $existing_settings);
	}

	public function init () {
		$this->option_name = 'wds_social_options';
		$this->name        = WDS_Settings::COMP_SOCIAL;
		$this->slug        = WDS_Settings::TAB_SOCIAL;
		$this->action_url  = admin_url( 'options.php' );
		$this->title       = __( 'Social', 'wds' );
		$this->page_title  = __( 'SmartCrawl Wizard: Social', 'wds' );

		parent::init();
	}

	/**
	 * Add admin settings page
	 */
	public function options_page () {
		parent::options_page();

		$options = WDS_Settings::get_component_options($this->name);
		$options = wp_parse_args(
			(is_array($options) ? $options : array()),
			$this->get_default_options()
		);

		$arguments = array(
			'options' => $options,
		);
		if (!class_exists('WDS_Schema_Printer')) require_once(WDS_PLUGIN_DIR . '/tools/class_wds_schema_printer.php');
		if (!class_exists('WDS_Twitter_Printer')) require_once(WDS_PLUGIN_DIR . '/tools/class_wds_twitter_printer.php');

		$arguments['active_tab'] = $this->_get_last_active_tab('tab_accounts');
		wp_enqueue_script('wds-admin-social');
		wp_enqueue_media();

		$this->_render_page('social/social-settings', $arguments);
	}

	/**
	 * Gets default options set and their initial values
	 *
	 * @return array
	 */
	public function get_default_options () {
		return array(
			// Accounts
			'sitename' => get_bloginfo('name'),
			'disable-schema' => false,
			'schema_type' => '',
			'override_name' => '',
			'organization_name' => '',
			'organization_logo' => '',
			'twitter_username' => '',
			'facebook_url' => '',
			'instagram_url' => '',
			'linkedin_url' => '',
			'pinterest_url' => '',
			'gplus_url' => '',
			'youtube_url' => '',
			// Twitter
			'twitter-card-enable' => false,
			'twitter-card-type' => '',
			// Pinterest
			'pinterest-verify' => '',
			// OpenGraph
			'og-enable' => true,
			// Facebook-specific
			'fb-app-id' => '',
		);
	}

	/**
	 * Default settings
	 */
	public function defaults () {
		$options = WDS_Settings::get_component_options($this->name);
		$options = is_array($options) ? $options : array();

		foreach ($this->get_default_options() as $opt => $default) {
			if (!isset($options[$opt])) $options[$opt] = $default;
		}

		if( is_multisite() && WDS_SITEWIDE ) {
			update_site_option( $this->option_name, $options );
		} else {
			update_option( $this->option_name, $options );
		}
	}

}
