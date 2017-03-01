<?php

class WDS_Settings_Settings extends WDS_Settings_Admin {


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

		if (!empty($input['wds_settings-setup'])) $result['wds_settings-setup'] = true;

		$booleans = array_keys(WDS_Settings::get_known_components());
		foreach ($booleans as $bool) {
			if (!empty($input[$bool])) $result[$bool] = true;
		}
		if (!empty($input['redirections-code']) && is_numeric($input['redirections-code'])) {
			$code = (int)$input['redirections-code'];
			if (in_array($code, array(301, 302))) $result['redirections-code'] = $code;
		}

		$strings = array(
			'access-id',
			'secret-key',
		);
		foreach ($strings as $str) {
			if (!empty($input[$str])) $result[$str] = sanitize_text_field($input[$str]);
		}

		// Roles
		foreach ($this->_get_permission_contexts() as $ctx) {
			if (empty($input[$ctx])) continue;
			$roles = array_keys($this->_get_filtered_roles("wds-{$ctx}"));
			$check_context = is_array($input[$ctx])
				? $input[$ctx]
				: array($input[$ctx])
			;
			$result[$ctx] = array();
			foreach ($check_context as $ctx_item) {
				if (in_array($ctx_item, $roles)) $result[$ctx][] = $ctx_item;
			}
		}

		// Blog tabs
		if (is_multisite() && current_user_can('manage_network_options')) {
			$raw = !empty($input['wds_blog_tabs']) && is_array($input['wds_blog_tabs'])
				? $input['wds_blog_tabs']
				: array()
			;
			$tabs = array();
			foreach ($raw as $key => $tab) {
				if (!empty($tab)) $tabs[$key] = true;
			}

			update_site_option('wds_blog_tabs', $tabs);
		}

		return $result;
	}

	public function init () {
		$this->option_name = 'wds_settings_options';
		$this->name        = 'settings';
		$this->slug        = WDS_Settings::TAB_SETTINGS;
		$this->action_url  = admin_url( 'options.php' );
		$this->title       = __( 'Settings', 'wds' );
		$this->page_title  = __( 'SmartCrawl Wizard: Settings', 'wds' );

		parent::init();
	}

	/**
	 * Get allowed blog tabs
	 *
	 * @return array
	 */
	public static function get_blog_tabs () {
		$blog_tabs = get_site_option('wds_blog_tabs');
		return is_array($blog_tabs)
			? $blog_tabs
			: array()
		;
	}

	/**
	 * Get (optionally filtered) default roles
	 *
	 * @param string $context_filter Optional filter to pass the roles through first
	 *
	 * @return array List of roles
	 */
	protected function _get_filtered_roles ($context_filter=false) {
		$default_roles = array(
			'manage_network'       => __( 'Super Admin' ),
			'list_users'           => sprintf(__('%s (and up)', 'wds'), __( 'Site Admin' )),
			'moderate_comments'    => sprintf(__('%s (and up)', 'wds'), __( 'Editor' )),
			'edit_published_posts' => sprintf(__('%s (and up)', 'wds'), __( 'Author' )),
			'edit_posts'           => sprintf(__('%s (and up)', 'wds'), __( 'Contributor' )),
		);
		if (!is_multisite()) unset($default_roles['manage_network']);

		return !empty($context_filter)
			? (array)apply_filters($context_filter, $default_roles)
			: $default_roles
		;
	}

	/**
	 * Get a list of permission contexts used for roles filtering
	 *
	 * @return array
	 */
	protected function _get_permission_contexts () {
		return array(
			'seo_metabox_permission_level',
			'seo_metabox_301_permission_level',
			'urlmetrics_metabox_permission_level',
		);
	}

	/**
	 * Add admin settings page
	 */
	public function options_page () {
		parent::options_page();

		$arguments['default_roles'] = $this->_get_filtered_roles();

		$arguments['active_components'] = WDS_Settings::get_known_components();
		if (!empty($arguments['active_components'][WDS_Settings::COMP_SEOMOZ])) unset($arguments['active_components'][WDS_Settings::COMP_SEOMOZ]);

		$arguments['slugs'] = array(
			WDS_Settings::TAB_ONPAGE => __( 'Title & Meta', 'wds' ),
			WDS_Settings::TAB_SITEMAP => __( 'Sitemaps', 'wds' ),
			WDS_Settings::TAB_AUTOLINKS => __( 'Automatic Links', 'wds' ),
			WDS_Settings::TAB_SETTINGS => __( 'Settings', 'wds' ),
		);

		if (is_multisite()) {
			$arguments['blog_tabs'] = self::get_blog_tabs();
		}

		foreach ($this->_get_permission_contexts() as $ctx) {
			$arguments[$ctx] = $this->_get_filtered_roles("wds-{$ctx}");
		}

		$this->_render_page('settings-settings', $arguments);
	}

	/**
	 * Default settings
	 */
	public function defaults () {
		if( is_multisite() && WDS_SITEWIDE ) {
			$this->options = get_site_option( $this->option_name );
		} else {
			$this->options = get_option( $this->option_name );
		}


		if ( empty($this->options) && empty($this->options['onpage']) ) {
			$this->options['onpage'] = 1;
		}

		if ( empty($this->options) && empty($this->options['autolinks']) ) {
			$this->options['autolinks'] = 1;
		}

		if ( empty($this->options) && empty($this->options['seomoz']) ) {
			$this->options['seomoz'] = 1;
		}

		if ( empty($this->options) && empty($this->options['sitemap']) ) {
			$this->options['sitemap'] = 1;
		}

		if ( empty($this->options['seo_metabox_permission_level']) ) {
			$this->options['seo_metabox_permission_level'] = ( is_multisite() ? 'manage_network' : 'list_users' );
		}

		if ( empty($this->options['urlmetrics_metabox_permission_level']) ) {
			$this->options['urlmetrics_metabox_permission_level'] = ( is_multisite() ? 'manage_network' : 'list_users' );
		}

		if ( empty($this->options['seo_metabox_301_permission_level']) ) {
			$this->options['seo_metabox_301_permission_level'] = ( is_multisite() ? 'manage_network' : 'list_users' );
		}

		if ( empty($this->options['access-id']) ) {
			$this->options['access-id'] = '';
		}

		if ( empty($this->options['secret-key']) ) {
			$this->options['secret-key'] = '';
		}

		apply_filters( 'wds_defaults', $this->options );

		if( is_multisite() && WDS_SITEWIDE ) {
			update_site_option( $this->option_name, $this->options );
		} else {
			update_option( $this->option_name, $this->options );
		}
	}

}
