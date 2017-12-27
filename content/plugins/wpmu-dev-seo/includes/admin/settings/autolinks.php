<?php

/**
 * Init WDS Autolinks Settings
 */
class WDS_Autolinks_Settings extends WDS_Settings_Admin {


	private static $_instance;

	public static function get_instance () {
		if (empty(self::$_instance)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Static known public post types getter
	 *
	 * @return array A list of known post type *objects* keyed by name
	 */
	public static function get_post_types () {
		static $post_types;

		if (empty($post_types)) {
			$exclusions = array(
				'revision',
				'nav_menu_item',
				'attachment',
			);
			$raw = get_post_types(array(
				'public' => true,
			), 'objects');
			foreach ($raw as $pt => $pto) {
				if (in_array($pt, $exclusions)) continue;
				$post_types[$pt] = $pto;
			}
		}

		return is_array($post_types)
			? $post_types
			: array()
		;
	}

	/**
	 * Validate submitted options
	 *
	 * @param array $input Raw input
	 *
	 * @return array Validated input
	 */
	public function validate ($input) {
		$save_redirects = isset($input['save_redirects']) && $input['save_redirects'];
		if ($save_redirects) {
			$this->save_redirects($input);

			$result = self::get_specific_options($this->option_name);

			if (isset($input['redirect-attachments'])) {
				$result['redirect-attachments'] = !empty($input['redirect-attachments']);
			}
			if (isset($input['redirect-attachments-images_only'])) {
				$result['redirect-attachments-images_only'] = !empty($input['redirect-attachments-images_only']);
			}

			if (isset($input['redirections-code'])) {
				$this->_validate_and_save_extra_options($input);
			}

			return $result;
		}

		$service = $this->get_site_service();

		$result = array();

		if (!empty($input['wds_autolinks-setup'])) $result['wds_autolinks-setup'] = true;

		if ($service->is_member()) {
			// Booleans
			$booleans = array(
				'comment',
				'onlysingle',
				'allowfeed',
				'casesens',
				'customkey_preventduplicatelink',
				'target_blank',
				'rel_nofollow',
				'allow_empty_tax',
				'excludeheading',
			);

			foreach ($booleans as $bool) {
				if (!empty($input[$bool])) $result[$bool] = true;
			}

			// Boolean Arrays
			$post_type_names = array_keys(self::get_post_types());
			foreach (array_merge($post_type_names, array('comment')) as $post_type) {
				$result[$post_type] = in_array($post_type, $input);
			}
			foreach ($post_type_names as $post_type) {
				$result["l{$post_type}"] = in_array("l{$post_type}", $input);
			}
			foreach (get_taxonomies() as $taxonomy) {
				$tax = get_taxonomy($taxonomy);
				$key = strtolower($tax->labels->name);
				$result["l{$key}"] = in_array("l{$key}", $input);
			}

			// Numerics
			$numeric = array(
				'cpt_char_limit',
				'tax_char_limit',
				'link_limit',
				'single_link_limit',
			);
			foreach ($numeric as $num) {
				if (isset($input[$num])) {
					if (is_numeric($input[$num])) $result[$num] = (int)$input[$num];
					else if (!empty($input[$num])) add_settings_error($num, $num, __('Limit values must be numeric'));
				}
			}

			// Strings
			$strings = array(
				'ignore',
				'ignorepost',
			);
			foreach ($strings as $str) {
				if (isset($input[$str])) $result[$str] = sanitize_text_field($input[$str]);
			}

			// Custom keywords, they need newlines
			if (isset($input['customkey'])) {
				$str = wp_check_invalid_utf8($input['customkey']);
				$str = wp_pre_kses_less_than($str);
				$str = wp_strip_all_tags($str);
				$result['customkey'] = $str;

				$found = false;
				while ( preg_match('/%[a-f0-9]{2}/i', $str, $match) ) {
					$str = str_replace($match[0], '', $str);
					$found = true;
				}
				if ($found) $str = trim(preg_replace('/ +/', ' ', $str));
			}
		}

		return $result;
	}

	private function _validate_and_save_extra_options($input)
	{
		$settings = WDS_Settings::get_specific_options('wds_settings_options');
		$settings['redirections-code'] = (int)$input['redirections-code'];
		WDS_Settings::update_specific_options('wds_settings_options', $settings);
	}

	public function init () {
		$this->option_name = 'wds_autolinks_options';
		$this->name = WDS_Settings::COMP_AUTOLINKS;
		$this->slug = WDS_Settings::TAB_AUTOLINKS;
		$this->action_url = admin_url( 'options.php' );
		$this->title = __( 'Advanced Tools', 'wds' );
		$this->page_title = __( 'SmartCrawl Wizard: Advanced Tools', 'wds' );

		add_action('wp_ajax_wds-load_exclusion-post_data', array($this, 'json_load_post'));
		add_action('wp_ajax_wds-load_exclusion_posts-posts_data-specific', array($this, 'json_load_posts_specific'));
		add_action('wp_ajax_wds-load_exclusion_posts-posts_data-paged', array($this, 'json_load_posts_paged'));
		add_action('admin_init', array($this, 'reset_moz_api_credentials'));

		parent::init();
	}

	public function reset_moz_api_credentials()
	{
		if (isset($_POST['reset-moz-credentials']) && $_POST['reset-moz-credentials']) {
			$options = self::get_specific_options('wds_settings_options');
			unset($options['access-id']);
			unset($options['secret-key']);
			self::update_specific_options('wds_settings_options', $options);

			wp_redirect(esc_url_raw(wp_get_referer()));
		}
	}

	/**
	 * Loads Individual post data
	 *
	 * Outputs AJAX response
	 */
	public function json_load_post () {
		$result = array(
			'id' => 0,
			'title' => '',
			'type' => '',
		);
		if (!current_user_can('edit_others_posts')) wp_send_json($result);

		$post_id = !empty($_POST['id']) && is_numeric($_POST['id'])
			? (int)$_POST['id']
			: false
		;
		if (empty($post_id)) wp_send_json($result);

		$post = get_post($post_id);
		if (!$post) wp_send_json($result);

		wp_send_json($this->_post_to_response_data($post));
	}

	/**
	 * Loads posts by specific IDs
	 *
	 * Outputs AJAX response
	 */
	public function json_load_posts_specific () {
		$result = array(
			'meta' => array(),
			'posts' => array(),
		);
		if (!current_user_can('edit_others_posts')) wp_send_json($result);

		$post_ids = !empty($_POST['posts']) && is_array($_POST['posts'])
			? array_values(array_filter(array_map('intval', $_POST['posts'])))
			: array()
		;
		if (empty($post_ids)) wp_send_json($result);

		$args = array(
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'post__in' => $post_ids,
			'ignore_sticky_posts' => true,
			'post_type' => 'any',
		);

		$query = new WP_Query($args);

		$result['meta'] = array(
			'total' => $query->max_num_pages,
			'page' => 1,
		);

		foreach ($query->posts as $post) {
			$result['posts'][] = $this->_post_to_response_data($post);
		}

		wp_send_json($result);
	}

	/**
	 * Loads paged posts of certain type
	 *
	 * Outputs AJAX response
	 */
	public function json_load_posts_paged () {
		$result = array(
			'meta' => array(),
			'posts' => array(),
		);
		if (!current_user_can('edit_others_posts')) wp_send_json($result);
		$args = array(
			'post_status' => 'publish',
			'posts_per_page' => 10,
			'ignore_sticky_posts' => true,
		);
		$page = 1;
		if (!empty($_POST['type']) && in_array($_POST['type'], array_keys(self::get_post_types()))) {
			$args['post_type'] = $_POST['type'];
		}
		if (!empty($_POST['page']) && is_numeric($_POST['page'])) {
			$args['paged'] = (int)$_POST['page'];
			$page = $args['paged'];
		}

		$query = new WP_Query($args);

		$result['meta'] = array(
			'total' => $query->max_num_pages,
			'page' => $page,
		);

		foreach ($query->posts as $post) {
			$result['posts'][] = $this->_post_to_response_data($post);
		}

		wp_send_json($result);
	}

	/**
	 * Makes the post response format uniform
	 *
	 * @param object $post WP_Post instance
	 *
	 * @return array Post response hash
	 */
	private function _post_to_response_data ($post) {
		$result = array(
			'id' => 0,
			'title' => '',
			'type' => '',
			'date' => '',
		);
		if (empty($post) || empty($post->ID)) return $result;
		static $date_format;

		if (empty($date_format)) $date_format = get_option('date_format');

		$post_id = $post->ID;
		$result['id'] = $post_id;
		$result['title'] = get_the_title($post_id);
		$result['type'] = get_post_type($post_id);
		$result['date'] = get_post_time($date_format, false, $post_id);

		return $result;
	}

	/**
	 * Add admin settings page
	 */
	public function options_page () {
		parent::options_page();

		$wds_options = WDS_Settings::get_options();
		$arguments = array(
			'insert' => array(),
		);

		$post_types = array();
		foreach (self::get_post_types() as $post_type => $pt) {
			$key = strtolower( $pt->name );
			$post_types["l{$key}"] = $pt->labels->name;

			$arguments['insert']["{$key}"] = $pt->labels->name;
		}

		$taxonomies = array();
		foreach ( get_taxonomies() as $taxonomy ) {
			if ( !in_array( $taxonomy, array( 'nav_menu', 'link_category', 'post_format' ) ) ) {
				$tax = get_taxonomy($taxonomy);
				$key = strtolower( $tax->labels->name );

				$taxonomies["l{$key}"] = $tax->labels->name;
			}
		}
		$redirection_model = new WDS_Model_Redirection;
		$arguments['redirections'] = $redirection_model->get_all_redirections();
		$arguments['redirection_types'] = $redirection_model->get_all_redirection_types();

		$arguments['linkto'] = array_merge( $post_types, $taxonomies );
		$arguments['insert']['comment'] = __( 'Comments' , 'wds');

		$arguments['active_tab'] = $this->_get_last_active_tab('tab_automatic_linking');

		wp_enqueue_script('wds-admin-autolinks');
		wp_enqueue_script('wds-admin-redirects');
		$this->_render_page('advanced-tools/advanced-tools-settings', $arguments);
	}

	/**
	 * Default settings
	 */
	public function defaults() {

		if( is_multisite() && WDS_SITEWIDE ) {
			$this->options = get_site_option( $this->option_name );
		} else {
			$this->options = get_option( $this->option_name );
		}

		if ( empty($this->options['ignorepost']) ) {
			$this->options['ignorepost'] = '';
		}

		if ( empty($this->options['ignore']) ) {
			$this->options['ignore'] = '';
		}

		if ( empty($this->options['customkey']) ) {
			$this->options['customkey'] = '';
		}

		if (empty($this->options['cpt_char_limit'])) {
			$this->options['cpt_char_limit'] = '';
		}

		if (empty($this->options['tax_char_limit'])) {
			$this->options['tax_char_limit'] = '';
		}

		if (empty($this->options['link_limit'])) {
			$this->options['link_limit'] = '';
		}

		if (empty($this->options['single_link_limit'])) {
			$this->options['single_link_limit'] = '';
		}

		if( is_multisite() && WDS_SITEWIDE ) {
			update_site_option( $this->option_name, $this->options );
		} else {
			update_option( $this->option_name, $this->options );
		}
	}

	/**
	 * @param $input
	 * @return mixed
	 */
	public function save_redirects($input) {
		$urls = !empty($input['urls']) && is_array($input['urls'])
			? $input['urls']
			: array();
		$redirection_model = new WDS_Model_Redirection;

		$new_urls = array();
		$new_types = array();
		foreach ($urls as $index => $url_details) {
			$source = wds_get_array_value($url_details, 'source');
			$source = trim(esc_url($source));

			$destination = wds_get_array_value($url_details, 'destination');
			$destination = trim(esc_url($destination));

			if(!trim($source) || !trim($destination)) {
				continue;
			}
			if (!preg_match('/^https?:\/\//', $source)) $source = home_url($source);
			if (!preg_match('/^https?:\/\//', $destination)) $destination = home_url($destination);

			$new_urls[ $source ] = $destination;

			$type = wds_get_array_value($url_details, 'type');
			$status = $redirection_model->get_valid_redirection_status_type($type);

			$new_types[ $source ] = $status;
		}
		$redirection_model->set_all_redirections($new_urls);
		$redirection_model->set_all_redirection_types($new_types);
	}

	/**
	 * @return object
	 */
	private function get_site_service()
	{
		if (!class_exists('WDS_Service')) {
			require_once(WDS_PLUGIN_DIR . 'core/class_wds_service.php');
		}
		$service = WDS_Service::get(WDS_Service::SERVICE_SITE);
		return $service;
	}

}
