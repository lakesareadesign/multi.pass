<?php

class WDS_Admin extends WDS_Renderable{

	private $_handlers = array();

	public function __construct () {
		$this->init();
	}

	private function init () {
		// Set up dash
		if (file_exists(WDS_PLUGIN_DIR . 'external/dash/wpmudev-dash-notification.php')) {
			global $wpmudev_notices;
			if (!is_array($wpmudev_notices)) $wpmudev_notices = array();
			$wpmudev_notices[] = array(
				'id'      => 167,
				'name'    => 'SmartCrawl',
				'screens' => array(
					'toplevel_page_wds_wizard-network',
					'toplevel_page_wds_wizard',
					'smartcrawl_page_wds_onpage-network',
					'smartcrawl_page_wds_onpage',
					'smartcrawl_page_wds_sitemap-network',
					'smartcrawl_page_wds_sitemap',
					'smartcrawl_page_wds_settings-network',
					'smartcrawl_page_wds_settings',
					'smartcrawl_page_wds_autolinks-network',
					'smartcrawl_page_wds_autolinks',
					'smartcrawl_page_wds_social-network',
					'smartcrawl_page_wds_social',
				)
			);
			require_once (WDS_PLUGIN_DIR . 'external/dash/wpmudev-dash-notification.php');
		}

		add_action('admin_init', array($this, 'register_setting'));
		add_action('admin_init', array($this, 'admin_master_reset'));
		add_filter('whitelist_options', array($this, 'save_options'), 20);

		add_action('wp_ajax_wds_dismiss_message', array($this, 'wds_dismiss_message'));
		add_action('wp_ajax_wds-user-search', array($this, 'json_user_search'));
		add_action('wp_ajax_wds-user-search-add-user', array($this, 'json_user_search_add_user'));

		if (WDS_Settings::get_setting('extras-admin_bar')) {
			add_action('admin_bar_menu', array($this, 'add_toolbar_items'), 99);
		}

		add_filter('plugin_action_links_' . WDS_PLUGIN_BASENAME, array($this, 'add_settings_link'));

		require_once (WDS_PLUGIN_DIR . 'admin/settings.php');
		require_once WDS_PLUGIN_DIR . 'core/class_wds_service.php';

		$wds_options = WDS_Settings::get_options();

		// Sanity check first!
		if (!get_option('blog_public')) {
			add_action('admin_notices', array($this, 'blog_not_public_notice'));
		}

		if (!empty($wds_options['access-id']) && !empty($wds_options['secret-key'])) {
			require_once (WDS_PLUGIN_DIR . 'tools/seomoz/api.php');
			require_once (WDS_PLUGIN_DIR . 'tools/seomoz/results.php');
			require_once (WDS_PLUGIN_DIR . 'tools/seomoz/dashboard-widget.php');
		}

		require_once (WDS_PLUGIN_DIR . 'admin/settings/dashboard.php');
		$this->_handlers['dashboard'] = WDS_Settings_Dashboard::get_instance();

		if (WDS_Settings::get_setting('checkup')) {
			require_once(WDS_PLUGIN_DIR . 'admin/settings/checkup.php');
			$this->_handlers['checkup'] = WDS_Checkup_Settings::get_instance();
		}

		if (WDS_Settings::get_setting('onpage')) {
			require_once(WDS_PLUGIN_DIR . 'admin/settings/onpage.php');
			$this->_handlers['onpage'] = WDS_Onpage_Settings::get_instance();
		}

		if (WDS_Settings::get_setting('social')) {
			require_once(WDS_PLUGIN_DIR . 'admin/settings/social.php');
			$this->_handlers['social'] = WDS_Social_Settings::get_instance();
		}

		require_once(WDS_PLUGIN_DIR . 'tools/sitemaps.php');
		require_once(WDS_PLUGIN_DIR . 'admin/settings/sitemap.php');
		$this->_handlers['sitemap'] = WDS_Sitemap_Settings::get_instance();
		if (WDS_Settings::get_setting('sitemap')) {
			require_once(WDS_PLUGIN_DIR . 'tools/sitemaps-dashboard-widget.php');
		}

		require_once(WDS_PLUGIN_DIR . 'admin/settings/autolinks.php');
		$this->_handlers['autolinks'] = WDS_Autolinks_Settings::get_instance();

		require_once(WDS_PLUGIN_DIR . 'admin/settings/settings.php');
		$this->_handlers['settings'] = WDS_Settings_Settings::get_instance();

		if (
			!class_exists('WDS_Controller_Onboard') &&
			file_exists(WDS_PLUGIN_DIR . '/core/class_wds_controller_onboard.php')
		) {
			require_once(WDS_PLUGIN_DIR . '/core/class_wds_controller_onboard.php');
			WDS_Controller_Onboard::serve();
		}

		if (
			!class_exists('WDS_Controller_Analysis') &&
			file_exists(WDS_PLUGIN_DIR . '/core/class_wds_controller_analysis.php')
		) {
			require_once(WDS_PLUGIN_DIR . '/core/class_wds_controller_analysis.php');
			WDS_Controller_Analysis::serve();
		}

		if (WDS_Settings::get_setting('onpage')) {
			require_once (WDS_PLUGIN_DIR . 'admin/metabox.php');
			require_once (WDS_PLUGIN_DIR . 'admin/taxonomy.php');
		}
	}

	/**
	 * Adds settings plugin action link
	 *
	 * @param array $links Action links list
	 *
	 * @return array Augmented action links
	 */
	public function add_settings_link ($links) {
		if (!is_array($links)) return $links;

		$links[] = sprintf(
			'<a href="%s">%s</a>',
			esc_url(add_query_arg('page', WDS_Settings::TAB_DASHBOARD, admin_url('admin.php'))),
			esc_html(__('Settings', 'wds'))
		);

		return $links;
	}

	/**
	 * Saves the submitted options
	 *
	 * @return array
	 */
	public function save_options ($whitelist_options) {
		global $action;

		$wds_pages = array(
			'wds_settings_options',
			'wds_autolinks_options',
			'wds_onpage_options',
			'wds_sitemap_options',
			'wds_seomoz_options',
			'wds_social_options',
			'wds_redirections_options',
			'wds_checkup_options',
		);
		if (is_multisite() && WDS_SITEWIDE == true && 'update' == $action && isset($_POST['option_page']) && in_array( $_POST['option_page'], $wds_pages)) {
			global $option_page;

			$unregistered = false;
			check_admin_referer( $option_page . '-options' );

			if ( !isset( $whitelist_options[ $option_page ] ) )
				wp_die( __( 'Error: options page not found.' , 'wds') );

			$options = $whitelist_options[ $option_page ];

			if ( $options && is_array($options) ) {
				foreach ( $options as $option ) {
					$option = trim($option);
					$value = null;
					if ( isset($_POST[$option]) )
						$value = $_POST[$option];
					if ( !is_array($value) )
						$value = trim($value);
					$value = stripslashes_deep($value);
					update_site_option($option, $value);
				}
			}

			$errors = get_settings_errors();
			set_transient('wds-settings-save-errors' , $errors, 30);

			$goback = add_query_arg('updated', 'true', wp_get_referer());
			wp_safe_redirect($goback);
			die;
		}

		return $whitelist_options;
	}

	/**
	 * Admin page handler getter
	 *
	 * @param string $hndl Handler to get
	 *
	 * @return object Handler
	 */
	public function get_handler ($hndl) {
		return isset($this->_handlers[$hndl])
			? $this->_handlers[$hndl]
			: $this
		;
	}

	/**
	 * Admin reset options switch processing
	 *
	 * @return bool|void
	 */
	public function admin_master_reset () {
		if (is_multisite() && !current_user_can('manage_network_options')) return false;
		if (!is_multisite() && !current_user_can('manage_options')) return false;

		if (isset($_GET['wds-reset'])) {
			require_once(WDS_PLUGIN_DIR . '/core/class_wds_reset.php');
			WDS_Reset::reset();
			wp_safe_redirect(add_query_arg('wds-reset-reload', 'true', remove_query_arg('wds-reset')));
			die;
		}

		if (isset($_GET['wds-reset-reload'])) {
			wp_safe_redirect(remove_query_arg('wds-reset-reload'));
			die;
		}

		return false;
	}

	/**
	 * Brute-register all the settings.
	 *
	 * If we got this far, this is a sane thing to do.
	 * This overrides the `WDS_Core_Admin::register_setting()`.
	 *
	 * In response to "Unable to save options multiple times" bug.
	 */
	public function register_setting () {
		register_setting('wds_settings_options', 'wds_settings_options', array($this->get_handler('settings'), 'validate'));
		register_setting('wds_sitemap_options', 'wds_sitemap_options', array($this->get_handler('sitemap'), 'validate'));
		register_setting('wds_onpage_options', 'wds_onpage_options', array($this->get_handler('onpage'), 'validate'));
		//register_setting('wds_seomoz_options', 'wds_seomoz_options', array($this->get_handler('seomoz'), 'validate'));
		register_setting('wds_social_options', 'wds_social_options', array($this->get_handler('social'), 'validate'));
		register_setting('wds_autolinks_options', 'wds_autolinks_options', array($this->get_handler('autolinks'), 'validate'));
		register_setting('wds_redirections_options', 'wds_redirections_options', array($this->get_handler('redirections'), 'validate'));
		register_setting('wds_checkup_options', 'wds_checkup_options', array($this->get_handler('checkup'), 'validate'));
	}

	/**
	 * Adds admin toolbar items
	 *
	 * @param object $bar Admin toolbar object
	 */
	public function add_toolbar_items ($bar) {
		if (empty($bar) || !function_exists('is_admin_bar_showing')) return false;
		if (!is_admin_bar_showing()) return false;

		if (!apply_filters('wds-admin-ui-show_bar', true)) return false;

		// Do not show if sitewide and we're not super admin
		if (defined('WDS_SITEWIDE') && WDS_SITEWIDE && !is_super_admin()) return false;

		$root = array(
			'id' => 'wds-root',
			'title' => __('SmartCrawl', 'wds'),
		);
		$bar->add_node($root);
		foreach ($this->_handlers as $hndl => $handler) {
			if (empty($handler) || empty($handler->slug)) continue;

			if (!(defined('WDS_SITEWIDE') && WDS_SITEWIDE) && !is_super_admin()) {
				if (!WDS_Settings_Admin::is_tab_allowed($handler->slug)) continue;
			}

			$href = (
				defined('WDS_SITEWIDE') && WDS_SITEWIDE ? network_admin_url('admin.php') : admin_url('admin.php')
			) . '?page=' . $handler->slug;
			$bar->add_node(array(
				'id' => $root['id'] . '.' . $handler->slug,
				'parent' => $root['id'],
				'title' => $handler->title,
				'href' => $href,
			));
		}
	}

	/**
	 * Validate user data for some/all of your input fields
	 */
	public function validate ($input) {
		return $input; // return validated input
	}

	/**
	 * Shows blog not being public notice.
	 */
	public function blog_not_public_notice () {
		if ( ! current_user_can( 'manage_options' ) ) return false;

		echo '<div class="notice-error notice is-dismissible"><p>' .
			sprintf( __( 'This site discourages search engines from indexing the pages, which will affect your SEO efforts. <a href="%s">You can fix this here</a>', 'wds' ), admin_url( '/options-reading.php' ) ) .
		'</p></div>';

	}

	public function wds_dismiss_message()
	{
		$message = wds_get_array_value($_POST, 'message');
		if ($message === null) {
			wp_send_json_error();
			return;
		}

		$dismissed_messages = get_user_meta(get_current_user_id(), 'wds_dismissed_messages', true);
		$dismissed_messages = $dismissed_messages === '' ? array() : $dismissed_messages;
		$dismissed_messages[ $message ] = true;
		update_user_meta(get_current_user_id(), 'wds_dismissed_messages', $dismissed_messages);
	}

	public function json_user_search()
	{
		$result = array('success' => false);
		$params = stripslashes_deep($_GET);
		$query = wds_get_array_value($params, 'query');

		if (!$query) {
			wp_send_json($result);
			die();
		}

		$users = get_users(array(
			'search' => '*' . $params['query'] . '*',
			'fields' => 'all_with_meta'
		));

		$return_users = array();
		foreach ($users as $user) {
			/**
			 * @var $user WP_User
			 */
			$return_users[] = array(
				'id'   => $user->get('ID'),
				'text' => $user->get('display_name')
			);
		}
		$result['items'] = $return_users;

		wp_send_json($result);
	}

	public function json_user_search_add_user()
	{
		$result = array('success' => false);
		$params = stripslashes_deep($_POST);

		$option_name = wds_get_array_value($params, 'option_name');
		$users_key = wds_get_array_value($params, 'users_key');
		$new_user_key = wds_get_array_value($params, 'new_user_key');

		$user_search_options = wds_get_array_value($params, $option_name);
		$email_recipients = wds_get_array_value($user_search_options, $users_key);
		$new_user = wds_get_array_value($user_search_options, $new_user_key);

		if ($new_user === null) {
			wp_send_json($result);
			return;
		}

		if ($email_recipients === null) {
			$email_recipients = array();
		}

		if (!in_array($new_user, $email_recipients)) {
			$email_recipients[] = $new_user;
		}

		$new_markup = $this->_load('user-search', array(
			'users'        => $email_recipients,
			'option_name'  => $option_name,
			'users_key'    => $users_key,
			'new_user_key' => $new_user_key
		));

		$result['user_search'] = $new_markup;
		$result['success'] = true;

		wp_send_json($result);
	}

	protected function _get_view_defaults()
	{
		return array();
	}
}

$WDS_Admin = new WDS_Admin();
