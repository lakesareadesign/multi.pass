<?php

abstract class WDS_Settings_Admin extends WDS_Settings {

	public $sections       = array();
	public $options        = array();
	public $capability     = 'list_users';
	public $option_name    = '';
	public $name           = '';
	public $slug           = '';
	public $action_url     = '';
	public $msg            = '';
	public $wds_page_hook  = '';
	public $blog_tabs      = array();

	abstract public function validate ($input);

	protected function __construct() {
		if( is_multisite() && WDS_SITEWIDE ) {
			$this->capability = 'manage_network_options';
		}

		// add_filter( 'contextual_help', array( &$this, 'contextual_help' ), 10, 3 );

		$this->init();

	}

	public function init () {
		global $wp_version;

		$this->options = self::get_specific_options($this->option_name);
		if (is_multisite() && defined('WDS_SITEWIDE') && WDS_SITEWIDE) {
			$this->capability = 'manage_network_options';
		}

		add_action( 'init', array( $this, 'defaults' ), 999 );
		add_action( 'admin_body_class', array( $this, 'add_body_class' ) );

		if ( is_multisite() ) {
			add_action( 'network_admin_menu', array( $this, 'add_page' ) );
		}
		if (!is_multisite() || !(defined('WDS_SITEWIDE') && WDS_SITEWIDE)) {
			add_action( 'admin_menu', array( $this, 'add_page' ) );
		}

	}

	/**
	 * Loads the view file and returns the output as string
	 *
	 * @param string $view View file to load
	 * @param array $args Optional array of arguments to pass to view
	 *
	 * @return mixed (string)View output on success, (bool)false on failure
	 */
	protected function _load ($view, $args=array()) {
		$view = preg_replace('/[^-_a-z0-9]/i', '', $view);
		if (empty($view)) return false;

		$_path = wp_normalize_path(WDS_PLUGIN_DIR . 'admin/templates/' . $view . '.php');
		if (!file_exists($_path) || !is_readable($_path)) return false;

		if (empty($args) || !is_array($args)) $args = array();
		$args = wp_parse_args($args, $this->_get_view_defaults());

		if (!empty($args)) extract($args);

		ob_start();
		include($_path);
		return ob_get_clean();
	}

	/**
	 * Renders the view by calling `_load`
	 *
	 * @param string $view View file to load
	 * @param array $args Optional array of arguments to pass to view
	 *
	 * @return bool
	 */
	protected function _render ($view, $args=array()) {
		$view = $this->_load($view, $args);
		if (!empty($view)) {
			echo $view;
		}
		return !empty($view);
	}

	/**
	 * Renders the whole page view by calling `_render`
	 *
	 * As a side-effect, also calls `WDEV_Plugin_Ui::output()`
	 *
	 * @param string $view View file to load
	 * @param array $args Optional array of arguments to pass to view
	 *
	 * @return bool
	 */
	protected function _render_page ($view, $args=array()) {
		WDEV_Plugin_Ui::output();
		$this->_render($view, $args);
	}

	/**
	 * Check if a tab (settings page) is allowed for access
	 *
	 * It can be not allowed for access to site admins
	 *
	 * @param string $tab Tab to check
	 *
	 * @return bool
	 */
	public static function is_tab_allowed ($tab) {
		if (empty($tab)) return false;

		if (!is_multisite()) return true; // On single installs, everything is good
		if (is_network_admin()) return true; // Always good in network
		if (defined('WDS_SITEWIDE') && WDS_SITEWIDE) return is_network_admin(); // If we're sitewide, we're good *in network admin* pages

		// We're network install, not sitewide now.
		// Let's see what's up
		$allowed = WDS_Settings_Settings::get_blog_tabs();
		if (empty($allowed)) return false;

		return in_array($tab, array_keys($allowed)) && !empty($allowed[$tab]);
	}

	/**
	 * Check if the current tab (settings page) is allowed for access
	 *
	 * @return bool
	 */
	protected function _is_current_tab_allowed () {
		return !empty($this->slug)
			? self::is_tab_allowed($this->slug)
			: false
		;
	}

	/**
	 * Add sub page to the Settings Menu
	 */
	public function add_page () {
		if (!$this->_is_current_tab_allowed()) return false;

		$this->wds_page_hook = add_submenu_page(
			'wds_wizard',
			$this->page_title,
			$this->title,
			$this->capability,
			$this->slug,
			array( $this, 'options_page' )
		);

		add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));

		add_action( "admin_print_styles-{$this->wds_page_hook}", array( $this, 'admin_styles' ) );
		add_action( "admin_print_scripts-{$this->wds_page_hook}", array( $this, 'admin_scripts' ) );

	}

	/**
	 * Unified admin tab URL getter
	 *
	 * Also takes into account whether the tab is allowed or not
	 *
	 * @param string $tab Tab to check
	 *
	 * @return string Unescaped admin URL, or tab anchor on failure
	 */
	public static function admin_url ($tab) {
		$fallback = '#' . esc_attr($tab);

		if (empty($tab)) return $fallback;
		if (!self::is_tab_allowed($tab)) return $fallback;

		return is_network_admin()
			? add_query_arg('page', $tab, network_admin_url('admin.php'))
			: add_query_arg('page', $tab, admin_url('admin.php'))
		;
	}

	/**
	 * Registers the scripts with global admin functionality
	 */
	public static function register_global_admin_scripts () {
		$version = WDS_Loader::get_version();
		if (!wp_script_is('wds-admin', 'registered')) {
			wp_register_script('wds-admin', WDS_PLUGIN_URL . 'js/wds-admin.js', array('jquery'), $version);
		}

		if (!wp_script_is('wds-admin-opengraph', 'registered')) {
			wp_register_script('wds-admin-opengraph', WDS_PLUGIN_URL . 'js/wds-admin-opengraph.js', array('underscore', 'jquery', 'wds-admin'), $version);
		}

		wp_register_style('wds-admin-opengraph', WDS_PLUGIN_URL . '/css/wds-opengraph.css', null, $version);
	}

	/**
	 * Registers the known scripts on admin side.
	 */
	public function register_admin_scripts () {
		// Do the globals first
		self::register_global_admin_scripts();

		$version = WDS_Loader::get_version();
		if (class_exists('WDS_Onpage_Settings') && !wp_script_is('wds-admin-macros', 'registered')) {
			wp_register_script('wds-admin-macros', WDS_PLUGIN_URL . 'js/wds-admin-macros.js', array('underscore', 'jquery', 'wds-admin'), $version);
			wp_localize_script('wds-admin-macros', '_wds_macros', array(
				'macros' => WDS_Onpage_Settings::get_macros(),
				'templates' => array(
					'list' => $this->_load('underscore-macros-list'),
				),
				'strings' => array(
					'Insert Macro' => __('Insert Macro', 'wds'),
				)
			));
		}

		if (!wp_script_is('wds-admin-service', 'registered')) {
			wp_register_script('wds-admin-service', WDS_PLUGIN_URL . 'js/wds-admin-service.js', array('underscore', 'jquery', 'wds-admin'), $version);
			wp_localize_script('wds-admin-service', '_wds_service', array(
				'strings' => array(
					'Connecting' => __('Connecting...', 'wds'),
					'Parsing results' => __('Parsing results...', 'wds'),
					'Something went wrong' => __('It appears something went wrong with communicating with the service', 'wds'),
					'Checking the site ...' => __('Checking the site ...', 'wds'),
					'Still working ...' => __('Still working ...', 'wds'),
					'Waiting for service response ...' => __('Waiting for service response ...', 'wds'),
					'Request queued, waiting ...' => __('Request queued, waiting ...', 'wds'),
				),
				'templates' => array(
					'run' => $this->_load('dashboard-dialog-seo_service-run'),
				)
			));
		}

		if (!wp_script_is('wds-admin-keywords', 'registered')) {
			wp_register_script('wds-admin-keywords', WDS_PLUGIN_URL . 'js/wds-admin-keywords.js', array('underscore', 'jquery', 'wds-admin'), $version);
			wp_localize_script('wds-admin-keywords', '_wds_keywords', array(
				'templates' => array(
					'custom' => $this->_load('underscore-keywords-custom'),
					'pairs' => $this->_load('underscore-keywords-pairs')
				),
				'strings' => array(
					'Add Keyword Group'	=> __('Add Keyword Group', 'wds'),
					'Custom Keywords' => __('Custom Keywords', 'wds'),
					'Link To' => __('Link To', 'wds'),
					'Add Keywords separated by comma' => __('Add Keywords separated by comma', 'wds'),
					'Add URL to link Custom Keywords' => __('Add URL to link Custom Keywords', 'wds'),
					'e.g. Cats, Kittens, Felines' => __('e.g. Cats, Kittens, Felines', 'wds'),
					'e.g. http://cats.com' => __('e.g. http://cats.com', 'wds'),
					'There\'s no custom keywords defined just yet. Why not add some?' => __('There\'s no custom keywords defined just yet. Why not add some?', 'wds'),
				)
			));
		}

		if (class_exists('WDS_Autolinks_Settings') && !wp_script_is('wds-admin-postlist', 'registered')) {
			wp_register_script('wds-admin-postlist', WDS_PLUGIN_URL . 'js/wds-admin-postlist.js', array('underscore', 'jquery', 'wds-admin'), $version);
			wp_localize_script('wds-admin-postlist', '_wds_postlist', array(
				'templates' => array(
					'exclude' => $this->_load('underscore-postlist-exclusion'),
					'exclude-item' => $this->_load('underscore-postlist-exclusion-item'),
					'selector' => $this->_load('underscore-postlist-selector'),
					'selector-list' => $this->_load('underscore-postlist-selector-list'),
					'selector-list-item' => $this->_load('underscore-postlist-selector-list-item'),
				),
				'post_types' => WDS_Autolinks_Settings::get_post_types(),
				'strings' => array(
					'Add Posts, Pages and CPTs' => __('Add Posts, Pages &amp; CPTs', 'wds'),
					'Loading post items, please hold on' => __('Loading post items, please hold on...', 'wds'),
					'Jump to page' => __('Jump to page:', 'wds'),
					'Total Pages' => __('Total Pages:', 'wds'),
					'' => __('', 'wds'),
				),
			));
		}

		if (class_exists('WDS_Autolinks_Settings') && !wp_script_is('wds-admin-autolinks', 'registered')) {
			wp_register_script('wds-admin-autolinks', WDS_PLUGIN_URL . 'js/wds-admin-autolinks.js', array(
				'underscore',
				'jquery',
				'wds-admin',
				'wds-select2',
				'wds-select2-admin',
				'wds-admin-keywords',
				'wds-admin-postlist',
			), $version);
		}

		if (class_exists('WDS_Settings_Redirections') && !wp_script_is('wds-admin-redirections', 'registered')) {
			wp_register_script('wds-admin-redirections', WDS_PLUGIN_URL . 'js/wds-admin-redirections.js', array(
				'underscore',
				'jquery',
				'wds-admin',
				'wds-select2',
				'wds-select2-admin',
			), $version);
		}

		if (class_exists('WDS_Onpage_Settings') && !wp_script_is('wds-admin-onpage', 'registered')) {
			wp_register_script('wds-admin-onpage', WDS_PLUGIN_URL . 'js/wds-admin-onpage.js', array(
				'wds-admin-macros',
				'wds-admin-opengraph',
				'jquery',
			), $version);
		}
	}

	/**
	 * Enqueue styles
	 */
	public function admin_styles () {
		$version = WDS_Loader::get_version();
		/* Enqueue Dashboard UI Shared Lib */
		WDEV_Plugin_Ui::load( WDS_PLUGIN_URL . 'admin/shared-ui' );

		wp_enqueue_style( 'wds-select2', WDS_PLUGIN_URL . 'css/external/select2.min.css', null, $version );
		//wp_enqueue_style( 'wds', WDS_PLUGIN_URL . 'css/admin.css' );
		wp_enqueue_style( 'wds-app', WDS_PLUGIN_URL . 'css/app.css', null, $version );

		if( file_exists( WDS_PLUGIN_DIR . 'css/' . $this->name . '.css' ) ) {
			wp_enqueue_style( $this->slug, WDS_PLUGIN_URL . 'css/' . $this->name . '.css', array( 'wds' ), $version );
		}

	}

	/**
	 * Enqueue scripts
	 */
	public function admin_scripts () {
		$version = WDS_Loader::get_version();

		wp_enqueue_script('wds');

		wp_enqueue_script( 'wds-select2', WDS_PLUGIN_URL . 'js/external/select2.min.js', array('jquery'), $version );
		wp_enqueue_script( 'wds-select2-admin', WDS_PLUGIN_URL . 'js/wds-admin-select2.js', array('wds-select2'), $version );

		if( file_exists( WDS_PLUGIN_DIR . 'js/' . $this->name . '.js' ) ) {
			wp_enqueue_script( $this->slug, WDS_PLUGIN_URL . 'js/' . $this->name . '.js', array( 'wds' ), $version );
		}

	}

	/**
	 * Display the admin options page
	 */
	public function options_page () {
		$this->msg = '';
		if ( ! empty( $_GET['updated'] ) ) {
			$this->msg = __( 'Settings updated' , 'wds');

			if ( function_exists( 'w3tc_pgcache_flush' ) ) {
				w3tc_pgcache_flush();
				$this->msg .= __( ' &amp; W3 Total Cache Page Cache flushed' , 'wds');
			} else if ( function_exists( 'wp_cache_clear_cache' )) {
				wp_cache_clear_cache();
				$this->msg .= __( ' &amp; WP Super Cache flushed' , 'wds');
			}
		}

	}

	public function contextual_help ( $contextual_help, $screen_id, $screen ) {
		if ( ! empty( $_GET['page'] ) && $_GET['page'] == $this->slug && ! empty( $this->contextual_help ) ) {
			$contextual_help = $this->contextual_help;
		}

		return $contextual_help;
	}

	public function add_body_class ( $class ) {
		global $current_screen;

		if( str_replace( '-network', '', $current_screen->id ) ===  $this->wds_page_hook ) {
			return $class;
		} else {
			return $class;
		}
	}

	/**
	 * Populates view defaults with view meta information
	 *
	 * @return array Defaults
	 */
	protected function _get_view_defaults () {
		$errors = get_transient('wds-settings-save-errors');
		$errors = !empty($errors) ? $errors : array();
		return array(
			'_view' => array(
				'slug' => $this->slug,
				'name' => $this->name,
				'option_name' => $this->option_name,
				'options' => $this->options,
				'action_url' => $this->action_url,
				'msg' => $this->msg,
				'errors' => $errors,
			)
		);
	}

}