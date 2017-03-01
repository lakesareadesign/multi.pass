<?php

class WDS_Sitemap_Settings extends WDS_Settings_Admin {


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

		if (!empty($input['wds_sitemap-setup'])) $result['wds_sitemap-setup'] = true;

		$strings = array(
			'verification-google',
			'verification-bing',
			'verification-pages',
		);
		foreach ($strings as $str) {
			if (isset($input[$str])) $result[$str] = sanitize_text_field($input[$str]);
		}

		$booleans = array(
			'ping-google',
			'ping-bing',
			'sitemap-images',
			'sitemap-stylesheet',
			'sitemap-dashboard-widget',
			'sitemap-disable-automatic-regeneration',
			'sitemap-buddypress-groups',
			'sitemap-buddypress-profiles',
		);
		foreach ($booleans as $bool) {
			if (!empty($input[$bool])) $result[$bool] = true;
		}

		// Array Booleans
		$input['exclude_post_types'] = !empty($input['exclude_post_types']) && is_array($input['exclude_post_types']) ? $input['exclude_post_types'] : array();
		foreach (array_keys($this->_get_post_types_options()) as $post_type) {
			$result[$post_type] = in_array($post_type, $input['exclude_post_types']);
		}
		$input['exclude_taxonomies'] = !empty($input['exclude_taxonomies']) && is_array($input['exclude_taxonomies']) ? $input['exclude_taxonomies'] : array();
		foreach (array_keys($this->_get_taxonomies_options()) as $tax) {
			$result[$tax] = in_array($tax, $input['exclude_taxonomies']);
		}

		// BuddyPress-specific
		$bpo = $this->_get_buddyress_template_values();
		if (!empty($bpo['exclude_groups']) && is_array($bpo['exclude_groups'])) {
			$input['exclude_bp_groups'] = is_array($input['exclude_bp_groups']) ? $input['exclude_bp_groups'] : array();
			foreach ($bpo['exclude_groups'] as $slug => $name) {
				$key = "sitemap-buddypress-{$slug}";
				$result[$key] = in_array($slug, $input['exclude_bp_groups']);
			}
		}

		if (!empty($bpo['exclude_roles']) && is_array($bpo['exclude_roles'])) {
			$input['exclude_bp_roles'] = is_array($input['exclude_bp_roles']) ? $input['exclude_bp_roles'] : array();
			foreach ($bpo['exclude_roles'] as $slug => $name) {
				$key = "sitemap-buddypress-roles-{$slug}";
				$result[$key] = in_array($slug, $input['exclude_bp_roles']);
			}
		}

		return $result;
	}

	public function init () {
		$this->option_name = 'wds_sitemap_options';
		$this->name        = WDS_Settings::COMP_SITEMAP;
		$this->slug        = WDS_Settings::TAB_SITEMAP;
		$this->action_url  = admin_url( 'options.php' );
		$this->title       = __( 'Sitemap', 'wds' );
		$this->page_title  = __( 'SmartCrawl Wizard: Sitemap', 'wds' );

		parent::init();
	}

	/**
	 * Get a list of post type based options
	 *
	 * @return array
	 */
	protected function _get_post_types_options () {
		$options = array();

		foreach (get_post_types(array(
			'public' => true,
			'show_ui' => true,
		)) as $post_type) {
			if (in_array($post_type, array('revision', 'nav_menu_item', 'attachment'))) continue;
			$pt = get_post_type_object($post_type);
			$options['post_types-' . $post_type . '-not_in_sitemap'] = $pt->labels->name;
		}

		return $options;
	}

	/**
	 * Get a list of taxonomy based options
	 *
	 * @return array
	 */
	protected function _get_taxonomies_options () {
		$options = array();

		foreach (get_taxonomies(array(
			'public' => true,
			'show_ui' => true,
		)) as $taxonomy) {
			if (in_array($taxonomy, array('nav_menu', 'link_category', 'post_format'))) continue;
			$tax = get_taxonomy($taxonomy);
			$options['taxonomies-' . $taxonomy . '-not_in_sitemap'] = $tax->labels->name;
		}

		return $options;
	}

	/**
	 * Add admin settings page
	 */
	public function options_page () {
		parent::options_page();

		$wds_options = WDS_Settings::get_options();
		$arguments = array(
			'post_types' => array(),
			'taxonomies' => array(),
			'engines' => array(
				'ping-google' => __('Google', 'wds'),
				'ping-bing' => __('Bing', 'wds'),
			),
			'checkbox_options' => array(
				'yes' => __('Yes', 'wds'),
			),
			'verification_pages' => array(
				'' => __('All pages', 'wds'),
				'home' => __('Home page', 'wds'),
			),
		);

		foreach ($this->_get_post_types_options() as $opt => $name) {
			$arguments['post_types'][$opt] = $name;
		}
		foreach ($this->_get_taxonomies_options() as $opt => $name) {
			$arguments['taxonomies'][$opt] = $name;
		}

		$arguments['google_msg'] = !empty($wds_options['verification-google'])
			? '<code>' . esc_html('<meta name="google-site-verification" value="') . esc_attr($wds_options['verification-google']) . esc_html('" />') . '</code>'
			: '<small>' . esc_html(__('No META tag will be added', 'wds')) . '</small>'
		;
		$arguments['bing_msg'] = !empty($wds_options['verification-bing'])
			? '<code>' . esc_html('<meta name="msvalidate.01" content="') . esc_attr($wds_options['verification-bing']) . esc_html('" />') . '</code>'
			: '<small>' . esc_html(__('No META tag will be added', 'wds')) . '</small>'
		;

		$arguments['wds_buddypress'] = $this->_get_buddyress_template_values();

		wp_enqueue_script('wds-admin-sitemaps');
		$this->_render_page('sitemap-settings', $arguments);
	}

	/**
	 * BuddyPress settings fields helper.
	 *
	 * @return array BuddyPress values for the template
	 */
	private function _get_buddyress_template_values () {
		$arguments = array();
		if (!defined('BP_VERSION')) return $arguments;

		$arguments['checkbox_options'] = array(
			'yes' => __('Yes', 'wds'),
		);

		if (function_exists('groups_get_groups')) { // We have BuddyPress groups, so let's get some settings
			$groups = groups_get_groups(array('per_page' => WDS_BP_GROUPS_LIMIT));
			$arguments['groups'] = !empty($groups['groups']) ? $groups['groups'] : array();
			$arguments['exclude_groups'] = array();
			foreach ($arguments['groups'] as $group) {
				$arguments['exclude_groups']["exclude-buddypress-group-{$group->slug}"] = $group->name;
			}
		}

		$wp_roles = new WP_Roles();
		$wp_roles = $wp_roles->get_names();
		$wp_roles = $wp_roles ? $wp_roles : array();
		$arguments['exclude_roles'] = array();
		foreach ($wp_roles as $key=>$label) {
			$arguments['exclude_roles']["exclude-profile-role-{$key}"] = $label;
		}

		return $arguments;
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

		$dir = wp_upload_dir();
		$path = trailingslashit( $dir['basedir'] );

		if ( empty($this->options['sitemappath']) ) {
			$this->options['sitemappath'] = $path . 'sitemap.xml';
		}

		if ( empty($this->options['sitemapurl']) ) {
			$this->options['sitemapurl'] = get_bloginfo( 'url' ) . '/sitemap.xml';
		}

		if ( empty($this->options['sitemap-images']) ) {
			$this->options['sitemap-images'] = 0;
		}

		if ( empty($this->options['sitemap-stylesheet']) ) {
			$this->options['sitemap-stylesheet'] = 0;
		}

		if ( empty($this->options['sitemap-dashboard-widget']) ) {
			$this->options['sitemap-dashboard-widget'] = 0;
		}

		if ( empty($this->options['sitemap-disable-automatic-regeneration']) ) {
			$this->options['sitemap-disable-automatic-regeneration'] = 0;
		}

		if ( empty($this->options['verification-google']) ) {
			$this->options['verification-google'] = '';
		}

		if ( empty($this->options['verification-bing']) ) {
			$this->options['verification-bing'] = '';
		}

		if ( empty($this->options['verification-pages']) ) {
			$this->options['verification-pages'] = '';
		}

		if ( empty($this->options['sitemap-buddypress-groups']) ) {
			$this->options['sitemap-buddypress-groups'] = 0;
		}

		if ( empty($this->options['sitemap-buddypress-profiles']) ) {
			$this->options['sitemap-buddypress-profiles'] = 0;
		}

		// if ( empty($this->options['newssitemappath']) ) {
		// 	$this->options['newssitemappath'] = $path . 'news_sitemap.xml';
		// }

		// if ( empty($this->options['newssitemapurl']) ) {
		// 	$this->options['newssitemapurl'] = get_bloginfo( 'url' ) . '/news_sitemap.xml';
		// }

		// if ( empty($this->options['enablexmlsitemap']) ) {
		// 	$this->options['enablexmlsitemap'] = 1;
		// }

		if( is_multisite() && WDS_SITEWIDE ) {
			update_site_option( $this->option_name, $this->options );
		} else {
			update_option( $this->option_name, $this->options );
		}
	}

}
