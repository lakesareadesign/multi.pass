<?php

class WDS_Admin {

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
				)
			);
			require_once (WDS_PLUGIN_DIR . 'external/dash/wpmudev-dash-notification.php');
		}

		add_action('admin_init', array($this, 'register_setting'));
		add_filter('whitelist_options', array($this, 'save_options'), 20);

		add_action('admin_bar_menu', array($this, 'add_toolbar_items'), 99);


		require_once (WDS_PLUGIN_DIR . 'admin/core/settings.php');
		require_once WDS_PLUGIN_DIR . 'admin/core/class_wds_service.php';

		$wds_options = WDS_Settings::get_options();

		// Sanity check first!
		if (!get_option('blog_public')) {
			add_action('admin_notices', array($this, 'blog_not_public_notice'));
		}

		if (!empty($wds_options['access-id']) && !empty($wds_options['secret-key'])) {
			require_once (WDS_PLUGIN_DIR . 'admin/seomoz/api.php');
			require_once (WDS_PLUGIN_DIR . 'admin/seomoz/results.php');
			require_once (WDS_PLUGIN_DIR . 'admin/seomoz/dashboard-widget.php');
		}

		require_once (WDS_PLUGIN_DIR . 'admin/settings/dashboard.php');
		$this->_handlers['dashboard'] = WDS_Settings_Dashboard::get_instance();

		if (!empty($wds_options['onpage'])) {
			require_once (WDS_PLUGIN_DIR . 'admin/settings/onpage.php');
			$this->_handlers['onpage'] = WDS_Onpage_Settings::get_instance();
		}

		if (!empty($wds_options['sitemap'])) {
			require_once (WDS_PLUGIN_DIR . 'tools/sitemaps.php');
			require_once (WDS_PLUGIN_DIR . 'admin/settings/sitemap.php');
			$this->_handlers['sitemap'] = WDS_Sitemap_Settings::get_instance();
		}

		//require_once ( WDS_PLUGIN_DIR . 'admin/settings/seomoz.php' );
		//$this->_handlers['seomoz'] = WDS_Seomoz_Settings::get_instance();

		if (!empty($wds_options['autolinks'])) {
			require_once (WDS_PLUGIN_DIR . 'admin/settings/autolinks.php');
			$this->_handlers['autolinks'] = WDS_Autolinks_Settings::get_instance();
		}

		require_once (WDS_PLUGIN_DIR . 'admin/settings/settings.php');
		$this->_handlers['settings'] = WDS_Settings_Settings::get_instance();

		if (!empty($wds_options['sitemap-dashboard-widget'])) {
			require_once (WDS_PLUGIN_DIR . 'admin/sitemaps-dashboard-widget.php');
		}

		if (!empty( $wds_options['onpage'])) {
			require_once (WDS_PLUGIN_DIR . 'admin/metabox.php');
			require_once (WDS_PLUGIN_DIR . 'admin/taxonomy.php');
		}

		// Redirections
		$rmodel = new WDS_Model_Redirection;
		if ($rmodel->has_redirections()) {
			require_once (WDS_PLUGIN_DIR . 'admin/settings/redirections.php');
			$this->_handlers['redirections'] = WDS_Settings_Redirections::get_instance();
		}
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
			'wds_redirections_options'
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
		register_setting('wds_autolinks_options', 'wds_autolinks_options', array($this->get_handler('autolinks'), 'validate'));
		register_setting('wds_redirections_options', 'wds_redirections_options', array($this->get_handler('redirections'), 'validate'));
	}

	/**
	 * Adds admin toolbar items
	 *
	 * @param object $bar Admin toolbar object
	 */
	public function add_toolbar_items ($bar) {
		if (empty($bar) || !function_exists('is_admin_bar_showing')) return false;
		if (!is_admin_bar_showing()) return false;

		if (defined('WDS_SITEWIDE') && WDS_SITEWIDE && !is_super_admin()) return false;

		$root = array(
			'id' => 'wds-root',
			'title' => __('SmartCrawl', 'wds'),
		);
		$bar->add_node($root);
		foreach ($this->_handlers as $hndl => $handler) {
			if (empty($handler) || empty($handler->slug)) continue;
			$bar->add_node(array(
				'id' => $root['id'] . '.' . $handler->slug,
				'parent' => $root['id'],
				'title' => $handler->title,
				'href' => (defined('WDS_SITEWIDE') && WDS_SITEWIDE ? network_admin_url('admin.php') : admin_url('admin.php')) . '?page=' . $handler->slug,
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

		echo '<div class="error"><p>' .
			sprintf( __( 'This site discourages search engines from indexing the pages, which will affect your SEO efforts. <a href="%s">You can fix this here</a>', 'wps' ), admin_url( '/options-reading.php' ) ) .
		'</p></div>';

	}

}

$WDS_Admin = new WDS_Admin();
