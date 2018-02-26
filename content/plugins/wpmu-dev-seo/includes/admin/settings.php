<?php
/**
 * Admin area setup stuff
 *
 * @package wpmu-dev-seo
 */

/**
 * Admin area instance page abstraction
 */
abstract class Smartcrawl_Settings_Admin extends Smartcrawl_Settings {

	/**
	 * Sections
	 *
	 * @var array
	 */
	public $sections = array();

	/**
	 * Settings corresponding to this page
	 *
	 * @var array
	 */
	public $options = array();

	/**
	 * Capability required for this page
	 *
	 * @var string
	 */
	public $capability = 'list_users';

	/**
	 * Name of the options corresponding to this page
	 *
	 * @var string
	 */
	public $option_name = '';

	/**
	 * Page name
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * Page slug
	 *
	 * @var string
	 */
	public $slug = '';

	/**
	 * Action URL
	 *
	 * @var string
	 */
	public $action_url = '';

	/**
	 * Action message
	 *
	 * @var string
	 */
	public $msg = '';

	/**
	 * Current page hook
	 *
	 * @var string
	 */
	public $smartcrawl_page_hook  = '';

	/**
	 * Blog tabs
	 *
	 * @var array
	 */
	public $blog_tabs = array();

	/**
	 * Validation abstraction
	 *
	 * @param array $input Raw input to validate.
	 *
	 * @return array
	 */
	abstract public function validate ( $input );

	/**
	 * Constructor
	 */
	protected function __construct() {
		if ( is_multisite() && SMARTCRAWL_SITEWIDE ) {
			$this->capability = 'manage_network_options';
		}

		$this->init();

	}

	/**
	 * Initializes the interface and binds hooks
	 */
	public function init() {
		$this->options = self::get_specific_options( $this->option_name );
		if ( is_multisite() && defined( 'SMARTCRAWL_SITEWIDE' ) && SMARTCRAWL_SITEWIDE ) {
			$this->capability = 'manage_network_options';
		}

		add_action( 'init', array( $this, 'defaults' ), 999 );
		add_action( 'admin_body_class', array( $this, 'add_body_class' ), 20 );

		add_action( 'admin_init', array( $this, 'save_last_active_tab' ) );

		if ( is_multisite() ) {
			add_action( 'network_admin_menu', array( $this, 'add_page' ) );
		}
		if ( ! is_multisite() || ! (defined( 'SMARTCRAWL_SITEWIDE' ) && SMARTCRAWL_SITEWIDE) ) {
			add_action( 'admin_menu', array( $this, 'add_page' ) );
		}

	}

	/**
	 * Renders the whole page view by calling `_render`
	 *
	 * As a side-effect, also calls `WDEV_Plugin_Ui::output()`
	 *
	 * @param string $view View file to load.
	 * @param array  $args Optional array of arguments to pass to view.
	 *
	 * @return bool
	 */
	protected function _render_page( $view, $args = array() ) {
		WDEV_Plugin_Ui::output();
		$this->_render( $view, $args );
		return true;
	}

	/**
	 * Check if a tab (settings page) is allowed for access
	 *
	 * It can be not allowed for access to site admins
	 *
	 * @param string $tab Tab to check.
	 *
	 * @return bool
	 */
	public static function is_tab_allowed( $tab ) {
		if ( empty( $tab ) ) { return false; }

		if ( ! is_multisite() ) { return true; } // On single installs, everything is good
		if ( is_network_admin() ) { return true; } // Always good in network
		if ( smartcrawl_is_switch_active( 'SMARTCRAWL_SITEWIDE' ) ) { return smartcrawl_is_switch_active( 'DOING_AJAX' ) ? true : is_network_admin(); } // If we're sitewide, we're good *in network admin* pages

		// We're network install, not sitewide now.
		// Let's see what's up.
		$allowed = Smartcrawl_Settings_Settings::get_blog_tabs();
		if ( empty( $allowed ) ) { return false; }

		return in_array( $tab, array_keys( $allowed ) ) && ! empty( $allowed[ $tab ] );
	}

	/**
	 * Check if the current tab (settings page) is allowed for access
	 *
	 * @return bool
	 */
	protected function _is_current_tab_allowed() {
		return ! empty( $this->slug )
			? self::is_tab_allowed( $this->slug )
			: false
		;
	}

	/**
	 * Add sub page to the Settings Menu
	 */
	public function add_page() {
		$allowed = true;

		if ( ! $this->_is_current_tab_allowed() ) { $allowed = false; }

		// Only allow network settings page on multisite when sitewide mode is off.
		if ( is_multisite() && ! smartcrawl_is_switch_active( 'SMARTCRAWL_SITEWIDE' ) && is_network_admin() ) {
			$allowed = Smartcrawl_Settings::TAB_SETTINGS === $this->slug;
		}

		if ( ! $allowed ) { return false; }

		$this->smartcrawl_page_hook = add_submenu_page(
			'wds_wizard',
			$this->page_title,
			$this->title,
			$this->capability,
			$this->slug,
			array( $this, 'options_page' )
		);

		// For pages that can deal with run requests, let's make sure they actually do that early enough.
		if ( is_callable( array( $this, 'process_run_action' ) ) ) {
			add_action( 'load-' . $this->smartcrawl_page_hook, array( $this, 'process_run_action' ) );
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		add_action( "admin_print_styles-{$this->smartcrawl_page_hook}", array( $this, 'admin_styles' ) );
		add_action( "admin_print_scripts-{$this->smartcrawl_page_hook}", array( $this, 'admin_scripts' ) );

	}

	/**
	 * Unified admin tab URL getter
	 *
	 * Also takes into account whether the tab is allowed or not
	 *
	 * @param string $tab Tab to check.
	 *
	 * @return string Unescaped admin URL, or tab anchor on failure
	 */
	public static function admin_url( $tab ) {
		$fallback = '#' . esc_attr( $tab );

		if ( empty( $tab ) ) { return $fallback; }
		if ( ! self::is_tab_allowed( $tab ) ) { return $fallback; }

		$use_network_url = false;
		if ( is_multisite() && smartcrawl_is_switch_active( 'SMARTCRAWL_SITEWIDE' ) ) {
			$use_network_url = is_network_admin() || smartcrawl_is_switch_active( 'DOING_AJAX' );
		}

		return ! empty( $use_network_url )
			? add_query_arg( 'page', $tab, network_admin_url( 'admin.php' ) )
			: add_query_arg( 'page', $tab, admin_url( 'admin.php' ) );
	}

	/**
	 * Registers the scripts with global admin functionality
	 */
	public static function register_global_admin_scripts() {
		$version = Smartcrawl_Loader::get_version();
		if ( ! wp_script_is( 'wds-admin', 'registered' ) ) {
			wp_register_script( 'wds-admin', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin.js', array( 'jquery' ), $version );
		}

		if ( ! wp_script_is( 'wds-admin-opengraph', 'registered' ) ) {
			wp_register_script( 'wds-admin-opengraph', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-opengraph.js', array( 'underscore', 'jquery', 'wds-admin' ), $version );
		}

		if ( ! wp_script_is( 'wds-select2', 'registered' ) ) {
			wp_register_script( 'wds-select2', SMARTCRAWL_PLUGIN_URL . 'js/external/select2.min.js', array( 'jquery' ), $version );
		}

		if ( ! wp_script_is( 'wds-qtip2-script', 'registered' ) ) {
			wp_register_script( 'wds-qtip2-script', SMARTCRAWL_PLUGIN_URL . 'js/external/jquery.qtip.min.js', array( 'jquery' ), $version );
		}

		wp_register_style( 'wds-admin-opengraph', SMARTCRAWL_PLUGIN_URL . '/css/wds-opengraph.css', null, $version );

		wp_register_style( 'wds-qtip2-style', SMARTCRAWL_PLUGIN_URL . '/css/external/jquery.qtip.min.css', null, $version );

		wp_register_style( 'wds-select2', SMARTCRAWL_PLUGIN_URL . 'css/external/select2.min.css', null, $version );

		wp_register_style( 'wds-app', SMARTCRAWL_PLUGIN_URL . 'css/app.css', array( 'wds-qtip2-style' ), $version );
	}

	/**
	 * Registers the known scripts on admin side.
	 */
	public function register_admin_scripts() {
		// Do the globals first.
		self::register_global_admin_scripts();

		$version = Smartcrawl_Loader::get_version();
		if ( class_exists( 'Smartcrawl_Onpage_Settings' ) && ! wp_script_is( 'wds-admin-macros', 'registered' ) ) {
			wp_register_script( 'wds-admin-macros', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-macros.js', array( 'underscore', 'jquery', 'wds-admin' ), $version );
			wp_localize_script('wds-admin-macros', '_wds_macros', array(
				'macros' => Smartcrawl_Onpage_Settings::get_macros(),
				'templates' => array(
					'list' => $this->_load( 'underscore-macros-list' ),
				),
				'strings' => array(
					'Insert dynamic macro' => __( 'Insert dynamic macro', 'wds' ),
				),
			));
		}

		if ( ! wp_script_is( 'wds-admin-service', 'registered' ) ) {
			wp_register_script( 'wds-admin-service', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-service.js', array( 'underscore', 'jquery', 'wds-admin' ), $version );
			wp_localize_script('wds-admin-service', '_wds_service', array(
				'strings' => array(
					'Connecting' => __( 'Connecting...', 'wds' ),
					'Parsing results' => __( 'Parsing results...', 'wds' ),
					'Something went wrong' => __( 'It appears something went wrong with communicating with the service', 'wds' ),
					'Checking the site ...' => __( 'Checking the site ...', 'wds' ),
					'Still working ...' => __( 'Still working ...', 'wds' ),
					'Waiting for service response ...' => __( 'Waiting for service response ...', 'wds' ),
					'Request queued, waiting ...' => __( 'Request queued, waiting ...', 'wds' ),
				),
				'templates' => array(
					'run' => $this->_load( 'dashboard-dialog-seo_service-run' ),
				),
			));
		}

		if ( ! wp_script_is( 'wds-admin-keywords', 'registered' ) ) {
			wp_register_script( 'wds-admin-keywords', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-keywords.js', array( 'underscore', 'jquery', 'wds-admin' ), $version );
			wp_localize_script('wds-admin-keywords', '_wds_keywords', array(
				'templates' => array(
					'custom' => $this->_load( 'underscore-keywords-custom' ),
					'pairs'  => $this->_load( 'underscore-keywords-pairs' ),
					'form'   => $this->_load( 'underscore-keywords-form' ),
				),
				'strings' => array(
					'Keyword'                                                                                                                              => __( 'Keyword', 'wds' ),
					'Auto-Linked URL'                                                                                                                      => __( 'Auto-Linked URL', 'wds' ),
					'Add New'                                                                                                                              => __( 'Add New', 'wds' ),
					'Add Custom Keywords'                                                                                                                  => __( 'Add Custom Keywords', 'wds' ),
					'Update Custom Keywords'                                                                                                               => __( 'Update Custom Keywords', 'wds' ),
					'Add'                                                                                                                                  => __( 'Add', 'wds' ),
					'Update'                                                                                                                               => __( 'Update', 'wds' ),
					'Edit'                                                                                                                                 => __( 'Edit', 'wds' ),
					'Remove'                                                                                                                               => __( 'Remove', 'wds' ),
					'E.g. Cats, Kittens, Felines'                                                                                                          => __( 'E.g. Cats, Kittens, Felines', 'wds' ),
					'E.g. /cats'                                                                                                                           => __( 'E.g. /cats', 'wds' ),
					'Keyword group'                                                                                                                        => __( 'Keyword group', 'wds' ),
					'- Usually related terms'                                                                                                              => __( '- Usually related terms', 'wds' ),
					'Link URL'                                                                                                                             => __( 'Link URL', 'wds' ),
					'- Both internal and external links are supported'                                                                                     => __( '- Both internal and external links are supported', 'wds' ),
					'Choose your keywords, and then specify the URL to auto-link to.'                                                                      => __( 'Choose your keywords, and then specify the URL to auto-link to.', 'wds' ),
					'Formats include relative (E.g. <b>/cats</b>) or absolute URLs (E.g. <b>www.website.com/cats</b> or <b>https://website.com/cats</b>).' => __( 'Formats include relative (E.g. <b>/cats</b>) or absolute URLs (E.g. <b>www.website.com/cats</b> or <b>https://website.com/cats</b>).', 'wds' ),
					'Cancel'                                                                                                                               => __( 'Cancel', 'wds' ),
				),
			));
		}

		if ( class_exists( 'Smartcrawl_Autolinks_Settings' ) && ! wp_script_is( 'wds-admin-postlist', 'registered' ) ) {
			wp_register_script( 'wds-admin-postlist', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-postlist.js', array( 'underscore', 'jquery', 'wds-admin' ), $version );
			wp_localize_script('wds-admin-postlist', '_wds_postlist', array(
				'templates' => array(
					'exclude' => $this->_load( 'underscore-postlist-exclusion' ),
					'exclude-item' => $this->_load( 'underscore-postlist-exclusion-item' ),
					'selector' => $this->_load( 'underscore-postlist-selector' ),
					'selector-list' => $this->_load( 'underscore-postlist-selector-list' ),
					'selector-list-item' => $this->_load( 'underscore-postlist-selector-list-item' ),
				),
				'post_types' => Smartcrawl_Autolinks_Settings::get_post_types(),
				'strings' => array(
					'Add Posts' => __( 'Add Posts', 'wds' ),
					'Remove' => __( 'Remove', 'wds' ),
					'Post' => __( 'Post', 'wds' ),
					'Post Type' => __( 'Post Type', 'wds' ),
					'Loading post items, please hold on' => __( 'Loading post items, please hold on...', 'wds' ),
					'Jump to page' => __( 'Jump to page:', 'wds' ),
					'Total Pages' => __( 'Total Pages:', 'wds' ),
				),
			));
		}

		if ( class_exists( 'Smartcrawl_Autolinks_Settings' ) && ! wp_script_is( 'wds-admin-autolinks', 'registered' ) ) {
			wp_register_script('wds-admin-autolinks', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-autolinks.js', array(
				'underscore',
				'jquery',
				'wds-admin',
				'wds-select2',
				'wds-select2-admin',
				'wds-admin-keywords',
				'wds-admin-postlist',
			), $version);
		}

		if ( 'Smartcrawl_Autolinks_Settings' == get_class( $this ) && ! wp_script_is( 'wds-admin-redirects', 'registered' ) ) {
			wp_register_script('wds-admin-redirects', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-redirects.js', array(
				'underscore',
				'jquery',
				'wds-admin',
				'wds-select2',
				'wds-select2-admin',
			), $version);

			wp_localize_script('wds-admin-redirects', '_wds_redirects', array(
				'templates' => array(
					'redirect-item' => $this->_load( 'advanced-tools/underscore-redirect-item' ),
					'update-form'   => $this->_load( 'advanced-tools/underscore-bulk-update-form' ),
				),
				'strings'   => array(
					'Permanent (301)'                        => __( 'Permanent (301)', 'wds' ),
					'Temporary (302)'                        => __( 'Temporary (302)', 'wds' ),
					'Options'                                => __( 'Options', 'wds' ),
					'Remove'                                 => __( 'Remove', 'wds' ),
					'Cancel'                                 => __( 'Cancel', 'wds' ),
					'Update'                                 => __( 'Update', 'wds' ),
					'Redirect Type'                          => __( 'Redirect Type', 'wds' ),
					'New URL'                                => __( 'New URL', 'wds' ),
					'Bulk Update'                            => __( 'Bulk Update', 'wds' ),
					'Please select some items to edit them.' => __( 'Please select some items to edit them.', 'wds' ),
				),
			));
		}

		if ( class_exists( 'Smartcrawl_Onpage_Settings' ) && ! wp_script_is( 'wds-admin-onpage', 'registered' ) ) {
			wp_register_script('wds-admin-onpage', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-onpage.js', array(
				'wds-admin-macros',
				'wds-admin-opengraph',
				'wds-qtip2-script',
				'jquery',
			), $version);
		}

		if ( class_exists( 'Smartcrawl_Sitemap_Settings' ) && ! wp_script_is( 'wds-admin-sitemaps', 'registered' ) ) {
			wp_register_script('wds-admin-sitemaps', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-sitemaps.js', array(
				'wds-admin',
				'wds-qtip2-script',
				'jquery',
			), $version);
		};

		if ( class_exists( 'Smartcrawl_Settings_Dashboard' ) && ! wp_script_is( 'wds-admin-dashboard', 'registered' ) ) {
			wp_register_script('wds-admin-dashboard', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-dashboard.js', array(
				'wds-admin',
				'wds-qtip2-script',
				'jquery',
			), $version);
		};

		if ( class_exists( 'Smartcrawl_Checkup_Settings' ) && ! wp_script_is( 'wds-admin-checkup', 'registered' ) ) {
			wp_register_script('wds-admin-checkup', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-checkup.js', array(
				'wds-admin',
				'wds-qtip2-script',
				'jquery',
			), $version);
		};

		if ( class_exists( 'Smartcrawl_Social_Settings' ) && ! wp_script_is( 'wds-admin-social', 'registered' ) ) {
			wp_register_script('wds-admin-social', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-social.js', array(
				'wds-admin',
				'wds-qtip2-script',
				'jquery',
			), $version);
		};

		if ( class_exists( 'Smartcrawl_Settings_Settings' ) && ! wp_script_is( 'wds-admin-settings', 'registered' ) ) {
			wp_register_script('wds-admin-settings', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-settings.js', array(
				'wds-admin',
				'wds-qtip2-script',
				'jquery',
			), $version);
		};
	}

	/**
	 * Enqueue styles
	 */
	public function admin_styles() {
		$version = Smartcrawl_Loader::get_version();

		$this->enqueue_shared_ui();

		wp_enqueue_style( 'wds-qtip2-style' );
		wp_enqueue_style( 'wds-select2' );
		wp_enqueue_style( 'wds-app' );

		if ( file_exists( SMARTCRAWL_PLUGIN_DIR . 'css/' . $this->name . '.css' ) ) {
			wp_enqueue_style( $this->slug, SMARTCRAWL_PLUGIN_URL . 'css/' . $this->name . '.css', array( 'wds' ), $version );
		}
	}

	/**
	 * Enqueue scripts
	 */
	public function admin_scripts() {
		$version = Smartcrawl_Loader::get_version();

		wp_enqueue_script( 'wds' );

		wp_enqueue_script( 'wds-select2' );
		wp_enqueue_script( 'wds-select2-admin', SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-select2.js', array( 'wds-select2' ), $version );

		if ( file_exists( SMARTCRAWL_PLUGIN_DIR . 'js/' . $this->name . '.js' ) ) {
			wp_enqueue_script( $this->slug, SMARTCRAWL_PLUGIN_URL . 'js/' . $this->name . '.js', array( 'wds' ), $version );
		}

	}

	/**
	 * Initiates a checkup run
	 */
	public function run_checkup() {
		if ( current_user_can( 'manage_options' ) ) {
			$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
			$service->start();
		}
		wp_safe_redirect( esc_url( remove_query_arg( 'run-checkup' ) ) );
		die;
	}

	/**
	 * Display the admin options page
	 */
	public function options_page() {
		$this->msg = '';
		if ( ! empty( $_GET['updated'] ) || ! empty( $_GET['settings-updated'] ) ) {
			$this->msg = __( 'Settings updated' , 'wds' );

			if ( function_exists( 'w3tc_pgcache_flush' ) ) {
				w3tc_pgcache_flush();
				$this->msg .= __( ' &amp; W3 Total Cache Page Cache flushed' , 'wds' );
			} elseif ( function_exists( 'wp_cache_clear_cache' ) ) {
				wp_cache_clear_cache();
				$this->msg .= __( ' &amp; WP Super Cache flushed' , 'wds' );
			}
		}

	}

	/**
	 * Sets up contextual help
	 *
	 * @param string $contextual_help Help.
	 *
	 * @return string
	 */
	public function contextual_help( $contextual_help ) {
		if ( ! empty( $_GET['page'] ) && $_GET['page'] === $this->slug && ! empty( $this->contextual_help ) ) {
			$contextual_help = $this->contextual_help;
		}

		return $contextual_help;
	}

	/**
	 * Adds body class
	 *
	 * @TODO: Apparently a no-op?
	 *
	 * @param string $class Class that's being processed.
	 *
	 * @return string
	 */
	public function add_body_class( $class ) {
		global $current_screen;

		if ( str_replace( '-network', '', $current_screen->id ) === $this->smartcrawl_page_hook ) {
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
	protected function _get_view_defaults() {
		$errors = get_transient( 'wds-settings-save-errors' );
		$errors = ! empty( $errors ) ? $errors : array();
		return array(
			'_view' => array(
				'slug' => $this->slug,
				'name' => $this->name,
				'option_name' => $this->option_name,
				'options' => $this->options,
				'action_url' => $this->action_url,
				'msg' => $this->msg,
				'errors' => $errors,
			),
		);
	}

	/**
	 * On form submission, this method saves the last active tab in a transient so that it can be opened when the page is refreshed.
	 */
	public function save_last_active_tab() {
		if ( isset( $_POST['wds-admin-active-tab'] ) ) {
			set_transient( 'wds-admin-active-tab', sanitize_key( $_POST['wds-admin-active-tab'] ), 10 );
		}
	}

	/**
	 * Checks if the last active tab is stored in the transient and returns its value. If nothing is available then it returns the default value.
	 *
	 * @param string $default Fallback value.
	 *
	 * @return string The last active tab.
	 */
	protected function _get_last_active_tab( $default = '' ) {
		$active_tab = get_transient( 'wds-admin-active-tab' );
		delete_transient( 'wds-admin-active-tab' );

		return $active_tab ? $active_tab : $default;
	}

	/**
	 * Sets up and enqueues shared UI library
	 *
	 * @param bool $add_class Whether to add admin body class to the current page.
	 */
	public static function enqueue_shared_ui( $add_class = true ) {
		$version = Smartcrawl_Loader::get_version();
		if ( $add_class ) {
			add_filter(
				'admin_body_class',
				array( 'WDEV_Plugin_Ui', 'admin_body_class' )
			);
		}

		/**
		 * Enqueue Dashboard UI Shared Lib.
		 * We are doing it this way instead of calling WDEV_Plugin_Ui::load because we want to clear out the cache
		 * by changing the version.
		 */
		$shared_ui_url = SMARTCRAWL_PLUGIN_URL . 'admin/shared-ui';
		wp_enqueue_style(
			'wdev-plugin-google_fonts',
			'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:400,500,300,300italic',
			false,
			$version
		);

		wp_enqueue_style(
			'wdev-plugin-ui',
			$shared_ui_url . '/wdev-ui.css',
			array( 'wdev-plugin-google_fonts' ),
			$version
		);

		wp_enqueue_script(
			'wdev-plugin-ui',
			$shared_ui_url . '/wdev-ui.js',
			array( 'jquery' ),
			$version
		);
	}
}