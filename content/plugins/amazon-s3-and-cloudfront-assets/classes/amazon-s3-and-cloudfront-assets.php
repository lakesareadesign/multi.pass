<?php

class Amazon_S3_And_CloudFront_Assets extends Amazon_S3_And_CloudFront_Pro {

	protected $theme_url;
	protected $theme_dir;
	protected $plugins_url;
	protected $plugins_dir;

	// Async requests
	protected $scan_files_for_s3_request;
	protected $remove_files_from_s3_request;

	// Minify
	protected $minify_background_process;
	public    $minify;

	protected $slug = 'amazon-s3-and-cloudfront-assets';
	protected $plugin_prefix = 'as3cf_assets';
	protected $default_tab = 'assets';
	protected $scanning_lock_key = 'as3cf-assets-scanning';
	protected $processing_lock_key = 'as3cf-assets-processing';
	protected $purging_lock_key = 'as3cf-assets-purging';
	protected $scanning_cron_interval_in_minutes;
	protected $scanning_cron_hook = 'as3cf_assets_scan_files_for_s3_cron';
	protected $processing_cron_hook = 'as3cf_assets_process_files_for_s3_cron';
	protected $custom_endpoint;
	protected $exclude_dirs;
	protected $location_versions;

	const SETTINGS_KEY = 'as3cf_assets';
	const SETTINGS_CONSTANT = 'WPOS3_ASSETS_SETTINGS';
	const FILES_SETTINGS_KEY = 'as3cf_assets_files';
	const TO_PROCESS_SETTINGS_KEY = 'as3cf_assets_files_to_process';
	const ENQUEUED_SETTINGS_KEY = 'as3cf_assets_enqueued_scripts';
	const LOCATION_VERSIONS_KEY = 'as3cf_assets_location_versions';
	const FAILURES_KEY = 'as3cf_assets_failures';

	/**
	 * @param string              $plugin_file_path
	 * @param Amazon_Web_Services $aws
	 */
	public function __construct( $plugin_file_path, $aws ) {
		parent::__construct( $plugin_file_path, $aws );
	}

	/**
	 * Plugin initialization
	 *
	 * @param string $plugin_file_path
	 */
	function init( $plugin_file_path ) {
		add_action( 'as3cf_plugin_load', array( $this, 'load_addon' ) );
		add_action( 'as3cf_pre_tab_render', array( $this, 'script_served_count_notice' ), 100 );
		add_action( 'as3cf_pre_tab_render', array( $this, 'maybe_display_s3_message' ) );

		add_filter( 'as3cf_settings_tabs', array( $this, 'settings_tabs' ) );
		add_action( 'as3cf_after_settings', array( $this, 'settings_page' ) );

		// Cron to scan files for S3 upload
		$this->scanning_cron_interval_in_minutes = apply_filters( 'as3cf_assets_cron_files_s3_interval', 5 );
		add_filter( 'as3cf_assets_setting_enable-cron', array( $this, 'cron_healthchecks' ) );
		add_filter( 'cron_schedules', array( $this, 'cron_schedules' ) );
		add_action( $this->scanning_cron_hook, array( $this, 'scan_files_for_s3' ) );
		add_action( $this->processing_cron_hook, array( $this, 'process_s3_files' ) );
		add_action( 'switch_theme', array( $this, 'initiate_scan_files_for_s3' ) );
		add_action( 'activated_plugin', array( $this, 'initiate_scan_files_for_s3' ) );
		// Custom URL to scan files for S3
		$this->custom_endpoint = apply_filters( 'as3cf_assets_custom_endpoint', 'wpos3-assets-scan' );
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
		add_action( 'admin_init', array( $this, 'clean_url_after_manual_action' ) );

		// Serve files
		add_filter( 'style_loader_src', array( $this, 'serve_css_from_s3' ) );
		add_filter( 'script_loader_src', array( $this, 'serve_js_from_s3' ) );

		// AJAX handlers
		add_action( 'wp_ajax_as3cf-assets-save-bucket', array( $this, 'ajax_save_bucket' ) );
		add_action( 'wp_ajax_as3cf-assets-create-bucket', array( $this, 'ajax_create_bucket' ) );
		add_action( 'wp_ajax_as3cf-assets-manual-save-bucket', array( $this, 'ajax_save_bucket' ) );
		add_action( 'wp_ajax_as3cf-assets-get-buckets', array( $this, 'ajax_get_buckets' ) );
		add_action( 'wp_ajax_as3cf-assets-generate-key', array( $this, 'ajax_generate_key' ) );
		add_action( 'wp_ajax_as3cf-assets-manual-scan', array( $this, 'ajax_manual_scan' ) );
		add_action( 'wp_ajax_as3cf-assets-manual-purge', array( $this, 'ajax_manual_purge' ) );

		add_filter( 'plugin_action_links', array( $this, 'plugin_actions_settings_link' ), 10, 2 );
		add_filter( 'as3cf_diagnostic_info', array( $this, 'diagnostic_info' ) );

		load_plugin_textdomain( 'as3cf-assets', false, dirname( plugin_basename( $plugin_file_path ) ) . '/languages/' );

		// Async requests
		$this->scan_files_for_s3_request    = new AS3CF_Scan_Files_For_S3( $this );
		$this->remove_files_from_s3_request = new AS3CF_Remove_Files_From_S3( $this );

		// Minify
		$this->minify_background_process = new AS3CF_Minify_Background_Process( $this );
		$this->minify                    = new AS3CF_Minify( $this, $this->minify_background_process );

		// Purge S3 assets on upgrade, if required
		new AS3CF_Assets_Upgrade( $this );
	}

	/**
	 * Load the addon
	 */
	function load_addon() {
		$version = $this->get_asset_version();
		$suffix  = $this->get_asset_suffix();

		$src = plugins_url( 'assets/css/styles.css', $this->plugin_file_path );
		wp_enqueue_style( 'as3cf-assets-styles', $src, array( 'as3cf-styles' ), $version );

		$src = plugins_url( 'assets/js/script' . $suffix . '.js', $this->plugin_file_path );
		wp_enqueue_script( 'as3cf-assets-script', $src, array( 'jquery', 'wp-util', 'as3cf-script' ), $version, true );

		wp_localize_script( 'as3cf-assets-script',
			'as3cf_assets',
			array(
				'strings'      => array(
					'generate_key_error' => __( 'Error getting new key: ', 'as3cf-assets' ),
					'manual_error'       => __( 'Error performing manual action: ', 'as3cf-assets' ),
					'processing'         => _x( 'Processing', 'Processing manual action', 'as3cf-assets' ),
				),
				'nonces'       => array(
					'create_bucket' => wp_create_nonce( 'as3cf-assets-create-bucket' ),
					'manual_bucket' => wp_create_nonce( 'as3cf-assets-manual-save-bucket' ),
					'save_bucket'   => wp_create_nonce( 'as3cf-assets-save-bucket' ),
					'get_buckets'   => wp_create_nonce( 'as3cf-assets-get-buckets' ),
					'generate_key'  => wp_create_nonce( 'as3cf-assets-generate-key' ),
					'manual_scan'   => wp_create_nonce( 'as3cf-assets-manual-scan' ),
					'manual_purge'  => wp_create_nonce( 'as3cf-assets-manual-purge' ),
				),
				'redirect_url' => $this->get_plugin_page_url( array( 'as3cf-assets-manual' => '1' ) ),
			)
		);

		$this->handle_post_request();
	}

	/**
	 * Override the settings tabs
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	function settings_tabs( $tabs ) {
		$tabs['assets']  = _x( 'Assets', 'Show the Assets settings tab', 'as3cf-assets' );
		if ( isset( $tabs['support'] ) ) {
			// Make sure the tab is before the support tab
			$support = $tabs['support'];
			unset( $tabs['support'] );
			$tabs['support'] = $support;
		}

		return $tabs;
	}

	/**
	 * Display the settings page for the addon
	 */
	function settings_page() {
		$this->render_view( 'settings' );
	}

	/**
	 * Accessor for plugin slug to be different to the main plugin
	 *
	 * @param bool $true_slug
	 *
	 * @return string
	 */
	public function get_plugin_slug( $true_slug = false ) {
		return $this->slug;
	}

	/**
	 * Whitelist the settings
	 *
	 * @return array
	 */
	function get_settings_whitelist() {
		return array(
			'bucket',
			'region',
			'domain',
			'cloudfront',
			'enable-script-object-prefix',
			'object-prefix',
			'enable-addon',
			'file-extensions',
			'enable-cron',
			'enable-custom-endpoint',
			'custom-endpoint-key',
			'enable-minify',
			'enable-gzip',
		);
	}

	/**
	 * Render a view template file specific to child class
	 * or use parent view as a fallback
	 *
	 * @param string $view View filename without the extension
	 * @param array  $args Arguments to pass to the view
	 */
	function render_view( $view, $args = array() ) {
		extract( $args );
		$view_file = $this->plugin_dir_path . '/view/' . $view . '.php';

		if ( ! file_exists( $view_file ) ) {
			global $as3cfpro;
			$view_file = $as3cfpro->plugin_dir_path . '/view/pro/' . $view . '.php';
		}

		if ( ! file_exists( $view_file ) ) {
			$view_file = $as3cfpro->plugin_dir_path . '/view/' . $view . '.php';
		}

		include $view_file;
	}

	/**
	 * Accessor for a plugin setting with conditions to defaults and upgrades
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return int|mixed|string|WP_Error
	 */
	function get_setting( $key, $default = '' ) {
		global $as3cf;

		$settings = $this->get_settings();

		// Region
		if ( false !== ( $region = $this->get_setting_region( $settings, $key, $default ) ) ) {
			return $region;
		}

		if ( 'ssl' === $key ) {
			return 'http';
		}

		if ( 'domain' === $key && ! isset( $settings['domain'] ) ) {
			return $as3cf->get_setting( $key );
		}

		if ( 'file-extensions' === $key && ! isset( $settings['file-extensions'] ) ) {
			return 'css,js,jpg,jpeg,png,gif,woff,woff2,ttf,svg,eot,otf,ico';
		}

		if ( 'custom-endpoint-key' === $key && ! isset( $settings['custom-endpoint-key'] ) ) {
			$key = $this->generate_key();

			return $key;
		}

		if ( 'enable-cron' === $key && ! isset( $settings['enable-cron'] ) ) {
			// Turn on cron by default
			$this->schedule_event( $this->scanning_cron_hook );

			return '1';
		}

		// Default enable object prefix - enabled unless path is empty
		if ( 'enable-script-object-prefix' === $key ) {
			if ( isset( $settings['enable-script-object-prefix'] ) && '0' === $settings['enable-script-object-prefix'] ) {
				return 0;
			}

			if ( isset( $settings['object-prefix'] ) && '' === trim( $settings['object-prefix'] ) ) {
				if ( false === $this->get_defined_setting( 'object-prefix', false ) ) {
					return 0;
				}
			}
		}

		if ( 'enable-minify' === $key && ! isset( $settings['enable-minify'] ) ) {
			return '1';
		}

		// Default enable Gzip if not using CloudFront custom domain
		if ( 'enable-gzip' === $key && ! isset( $settings['enable-gzip'] ) ) {
			return ( 'cloudfront' !== $this->get_setting( 'domain' ) ) ? '1' : '0';
		}

		// 1.1 Update 'Bucket as Domain' to new CloudFront/Domain UI
		if ( 'domain' === $key && 'virtual-host' === $settings[ $key ] ) {
			return $this->upgrade_virtual_host();
		}

		$value = AWS_Plugin_Base::get_setting( $key, $default );

		// Bucket
		if ( false !== ( $bucket = $this->get_setting_bucket( $key, $value, 'AS3CF_ASSETS_BUCKET' ) ) ) {
			return $bucket;
		}

		return apply_filters( 'as3cf_assets_setting_' . $key, $value );
	}

	/**
	 * Filter in defined settings with sensible defaults.
	 *
	 * @param array $settings
	 *
	 * @return array $settings
	 */
	function filter_settings( $settings ) {
		$defined_settings = $this->get_defined_settings();

		// Bail early if there are no defined settings
		if ( empty( $defined_settings ) ) {
			return $settings;
		}

		foreach ( $defined_settings as $key => $value ) {
			$allowed_values = array();

			if ( 'domain' === $key ) {
				$allowed_values = array(
					'subdomain',
					'path',
					'virtual-host',
					'cloudfront',
				);
			}

			$checkboxes = array(
				'enable-addon',
				'enable-cron',
				'enable-gzip',
				'enable-minify',
				'enable-script-object-prefix',
				'enable-custom-endpoint',
				'object-versioning',
			);

			if ( in_array( $key, $checkboxes ) ) {
				$allowed_values = array( '0', '1' );
			}

			// Unexpected value, remove from defined_settings array.
			if ( ! empty( $allowed_values ) && ! in_array( $value, $allowed_values ) ) {
				$this->remove_defined_setting( $key );
				continue;
			}

			// Value defined successfully
			$settings[ $key ] = $value;
		}

		return $settings;
	}

	/**
	 * Disables the save button if all settings have been defined.
	 *
	 * @param string $defined_settings
	 *
	 * @return string
	 */
	function maybe_disable_save_button( $defined_settings = array() ) {
		$attr                 = 'disabled="disabled"';
		$defined_settings     = ! empty( $defined_settings ) ? $defined_settings : $this->get_defined_settings();
		$whitelisted_settings = $this->get_settings_whitelist();
		$settings_to_skip     = array(
			'bucket',
			'region',
			'custom-endpoint-key',
		);

		foreach ( $whitelisted_settings as $setting ) {
			if ( in_array( $setting, $settings_to_skip ) ) {
				continue;
			}

			if ( 'object-prefix' === $setting ) {
				if ( isset( $defined_settings['enable-script-object-prefix'] ) && '0' === $defined_settings['enable-script-object-prefix'] ) {
					continue;
				}
			}

			if ( 'cloudfront' === $setting ) {
				if ( isset( $defined_settings['domain'] ) && 'cloudfront' !== $defined_settings['domain'] ) {
					continue;
				}
			}

			if ( ! isset( $defined_settings[ $setting ] ) ) {
				// If we're here, there's a setting that hasn't been defined.
				return '';
			}
		}

		return $attr;
	}

	/**
	 * Is the addon setup to copy and serve files?
	 * 
	 * @return bool
	 */
	function is_plugin_setup() {
		$setup = false;
		if ( (bool) $this->get_setting( 'enable-addon' ) ) {
			$setup = parent::is_plugin_setup();
		}

		return $setup;
	}

	/**
	 * Perform custom actions after the settings are saved
	 */
	function save_settings() {
		$old_settings = get_site_option( static::SETTINGS_KEY );
		$new_settings = $this->get_settings();

		parent::save_settings();

		// First save
		if ( false === $old_settings ) {
			return;
		}

		$keys = array(
			'enable-cron',
			'enable-addon',
			'bucket',
			'enable-script-object-prefix',
			'object-prefix',
		);

		// Default values
		foreach ( $keys as $key ) {
			if ( ! isset( $new_settings[ $key ] ) ) {
				$new_settings[ $key ] = '';
			}

			if ( ! isset( $old_settings[ $key ] ) ) {
				$old_settings[ $key ] = '';
			}
		}

		if ( $old_settings['enable-cron'] !== $new_settings['enable-cron'] ) {
			// Toggle the cron job for scanning files for S3
			if ( '1' === $new_settings['enable-cron'] ) {
				// Kick off a scan straight away
				$this->initiate_scan_files_for_s3();
				// Schedule the cron job
				$this->schedule_event( $this->scanning_cron_hook );
			} else {
				$this->clear_scheduled_event( $this->scanning_cron_hook );
			}
		}

		if ( $old_settings['enable-addon'] !== $new_settings['enable-addon'] ) {
			if ( '1' === $new_settings['enable-addon'] ) {
				// Kick off a scan straight away
				$this->initiate_scan_files_for_s3();
			}
		}

		if ( $old_settings['bucket'] !== $new_settings['bucket'] ) {
			if ( '' !== $old_settings['bucket'] ) {
				// Clear the script cache and remove files from S3
				// so we always copy and serve scripts from the new bucket
				$this->initiate_remove_files_from_s3( $old_settings );
			}
		}

		// Clear the script cache and remove files from S3
		// so we always copy and serve scripts from the new path
		if ( $old_settings['enable-script-object-prefix'] !== $new_settings['enable-script-object-prefix'] ) {
			$this->initiate_remove_files_from_s3( $old_settings );
		}

		if ( $old_settings['object-prefix'] !== $new_settings['object-prefix'] ) {
			$this->initiate_remove_files_from_s3( $old_settings );
		}

		// Purge and scan when gzip settings toggled
		if ( isset( $old_settings['enable-gzip'] ) && isset( $new_settings['enable-gzip'] ) ) {
			if ( $old_settings['enable-gzip'] !== $new_settings['enable-gzip'] ) {
				$this->initiate_remove_files_from_s3( $old_settings, true );
			}
		}
	}

	/**
	 * Generate a key for the custom endpoint for security
	 *
	 * @return string
	 */
	function generate_key() {
		$key = strtolower( wp_generate_password( 32, false ) );

		return $key;
	}

	/**
	 * AJAX handler for generate_key()
	 */
	function ajax_generate_key() {
		$this->verify_ajax_request();

		$key = $this->generate_key();

		$out = array(
			'success' => '1',
			'key'     => $key,
		);

		$this->end_ajax( $out );
	}

	/**
	 * Scan the files for S3 on a custom URL
	 */
	function template_redirect() {
		if ( ! $this->get_setting( 'enable-custom-endpoint' ) ) {
			// We have not enabled the custom endpoint, abort
			return;
		}

		if ( ! isset( $_GET[ $this->custom_endpoint ] ) || $this->get_setting( 'custom-endpoint-key' ) !== $_GET[ $this->custom_endpoint ] ) {
			// No key or incorrect key supplied, abort
			return;
		}

		if ( isset( $_GET['purge'] ) && 1 === intval( $_GET['purge'] ) ) {
			// Purge all files from S3
			$bucket = $this->get_setting( 'bucket' );
			$region = $this->get_setting( 'region' );

			$this->remove_all_files_from_s3( $bucket, $region );
		}

		$this->scan_files_for_s3();
		exit;
	}

	/**
	 * Return an associative array of details for WP Core, theme and plugins
	 *
	 * @return array
	 */
	protected function get_file_locations() {
		$locations_in_scope = apply_filters( 'as3cf_assets_locations_in_scope_to_scan', array(
			'core',
			'themes',
			'plugins',
			'mu-plugins',
		) );

		$locations = array();

		// WP Core
		$exclude = $this->get_exclude_dirs();
		$exclude[] = str_replace( ABSPATH, '', WP_CONTENT_DIR );
		if ( in_array( 'core', $locations_in_scope ) ) {
			$locations[] = array(
				'path'    => ABSPATH,
				'url'     => site_url(),
				'type'    => 'core',
				'object'  => '',
				'exclude' => apply_filters( 'as3cf_assets_core_exclude_dirs', $exclude ),
			);
		}

		// Active theme(s)
		if ( in_array( 'themes', $locations_in_scope ) ) {
			$themes    = $this->get_active_themes();
			$locations = array_merge( $locations, $themes );
		}

		// Active plugins
		if ( in_array( 'plugins', $locations_in_scope ) ) {
			$plugins   = $this->get_active_plugins();
			$locations = array_merge( $locations, $plugins );
		}

		// MU plugins
		if ( file_exists( WPMU_PLUGIN_DIR ) && in_array( 'mu-plugins', $locations_in_scope ) ) {
			$locations[] = array(
				'path'    => WPMU_PLUGIN_DIR,
				'url'     => WPMU_PLUGIN_URL,
				'type'    => 'mu-plugins',
				'object'  => '',
				'exclude' => apply_filters( 'as3cf_assets_mu_plugin_exclude_dirs', $this->get_exclude_dirs() ),
			);
		}

		return apply_filters( 'as3cf_assets_locations_to_scan', $locations );
	}

	/**
	 * Returns an array of distinct themes and child themes active on a site
	 *
	 * @return array
	 */
	function get_active_themes() {
		$themes = array();

		$themes = $this->add_active_theme( $themes );

		if ( is_multisite() ) {
			$blog_ids = $this->get_blog_ids();
			foreach ( $blog_ids as $blog_id ) {
				$this->switch_to_blog( $blog_id );
				$themes = $this->add_active_theme( $themes );
				$this->restore_current_blog();
			}
		}

		return array_values( $themes );
	}

	/**
	 * Add a theme to the array of themes to be scanned.
	 * If the theme is a child theme, then add the parent also.
	 *
	 * @param array $distinct_themes
	 * @param bool  $is_parent_theme
	 *
	 * @return array
	 */
	function add_active_theme( $distinct_themes, $is_parent_theme = false ) {
		$theme = array(
			'path'    => $is_parent_theme ? get_template_directory() : get_stylesheet_directory(),
			'url'     => $is_parent_theme ? get_template_directory_uri() : get_stylesheet_directory_uri(),
			'type'    => 'themes',
			'exclude' => apply_filters( 'as3cf_assets_theme_exclude_dirs', $this->get_exclude_dirs() ),
		);

		$theme_name      = $is_parent_theme ? get_template() : get_stylesheet();
		$theme['object'] = $theme_name;

		if ( isset( $distinct_themes[ $theme_name ] ) ) {
			// Theme already added, bail.
			return $distinct_themes;
		}

		if ( ! file_exists( $theme['path'] ) ) {
			// Theme directory does not exist, bail.
			return $distinct_themes;
		}

		// Add theme to our array
		$distinct_themes[ $theme_name ] = $theme;

		// Check if theme is a child theme, can't use is_child_theme() as uses constants
		if ( ! $is_parent_theme && get_template_directory() !== get_stylesheet_directory() ) {
			// Add the parent theme to the array
			$distinct_themes = $this->add_active_theme( $distinct_themes, true );
		}

		return $distinct_themes;
	}

	/**
	 * Returns an array of distinct plugins active on a site
	 *
	 * @return array
	 */
	function get_active_plugins() {
		$plugins = array();

		// Active plugins for current site
		$active_plugins = (array) get_option( 'active_plugins', array() );
		$plugins = $this->add_active_plugins( $plugins, $active_plugins );

		if ( is_multisite() ) {
			// Get network activated plugins
			$network_plugins = (array) get_site_option( 'active_sitewide_plugins', array() );
			$plugins = $this->add_active_plugins( $plugins, $network_plugins, true );

			$blog_ids = $this->get_blog_ids();
			foreach ( $blog_ids as $blog_id ) {
				// Get site specific activated plugins
				$active_plugins = (array) get_blog_option( $blog_id, 'active_plugins', array() );
				$plugins = $this->add_active_plugins( $plugins, $active_plugins );
			}
		}

		return array_values( $plugins );
	}

	/**
	 * Compare a list of plugins with a distinct list of plugins.
	 * If a plugin isn't in our list add it to it.
	 *
	 * @param array $distinct_plugins
	 * @param array $plugins_to_add
	 * @param bool  $networkwide is the plugins list network wide?
	 *
	 * @return array
	 */
	function add_active_plugins( $distinct_plugins, $plugins_to_add, $networkwide = false ) {
		$plugin_details = array(
			'type'   => 'plugins',
			'exclude' => apply_filters( 'as3cf_assets_plugin_exclude_dirs', $this->get_exclude_dirs() ),
		);

		$plugins_url = plugins_url();

		foreach ( $plugins_to_add as $key => $value ) {
			$plugin = ( $networkwide ) ? $key : $value;

			if ( isset( $distinct_plugins[ $plugin ] ) ) {
				continue;
			}

			$dir = dirname( $plugin );

			if ( '.' === $dir ) {
				// Ignore plugins not in a folder
				continue;
			}

			$dir  = '/' . $dir;
			$name = basename( $plugin, '.php' );

			if ( ! file_exists( WP_PLUGIN_DIR . $dir ) ) {
				// Ignore if plugin directory doesn't exist
				continue;
			}

			$plugin_details['path']   = WP_PLUGIN_DIR . $dir;
			$plugin_details['url']    = $plugins_url . $dir;
			$plugin_details['object'] = $name;

			$distinct_plugins[ $plugin ] = $plugin_details;
		}

		return $distinct_plugins;
	}

	/**
	 * Define an array of directories to ignore when scanning plugins and themes
	 *
	 * @return array
	 */
	function get_exclude_dirs() {
		if ( is_null( $this->exclude_dirs ) ) {
			$this->exclude_dirs = array(
				'node_modules',
				'.git',
				'.sass-cache',
				'.svn',
			);
		}

		return $this->exclude_dirs;
	}

	/**
	 * Add a custom cron schedule for our process to scan files for S3
	 *
	 * @param array $schedules
	 *
	 * @return array
	 */
	function cron_schedules( $schedules ) {
		$schedules[ $this->scanning_cron_hook ] = array(
			'interval' => $this->scanning_cron_interval_in_minutes * 60,
			'display'  => sprintf( __( 'AS3CF Assets -  S3 Upload every %d Minutes', 'as3cf-assets' ), $this->scanning_cron_interval_in_minutes ),
		);

		$interval = apply_filters( 'as3cf_assets_cron_process_files_interval', 1 );
		$schedules[ $this->processing_cron_hook ] = array(
			'interval' => $interval * 60,
			'display'  => sprintf( __( 'AS3CF Assets -  S3 Process every %d Minute(s)', 'as3cf-assets' ), $interval ),
		);

		return $schedules;
	}

	/**
	 * Cron processing healthchecks
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function cron_healthchecks( $value ) {
		if ( $value ) {
			$this->schedule_event( $this->scanning_cron_hook );
		}

		$processing = get_site_option( self::TO_PROCESS_SETTINGS_KEY );

		if ( ! empty( $processing ) ) {
			$this->schedule_event( $this->processing_cron_hook );
		}

		return $value;
	}

	/**
	 * Initiate an async request to scan files for S3
	 */
	function initiate_scan_files_for_s3() {
		$this->scan_files_for_s3_request->dispatch();
	}

	/**
	 * Initiate an async request to remove files for S3 and clear our file cache
	 *
	 * @param array|null $settings
	 * @param bool       $scan_after_purge Start the scan again after removal?
	 */
	function initiate_remove_files_from_s3( $settings = null, $scan_after_purge = false ) {
		if ( is_null( $settings ) ) {
			$settings  = get_site_option( static::SETTINGS_KEY );
		}

		$region = isset( $settings['region'] ) ? $settings['region'] : '';
		$data   = array(
			'bucket' => $settings['bucket'],
			'region' => $region,
		);

		if ( $scan_after_purge ) {
			$data['scan'] = $scan_after_purge;
		}

		// Clear the script cache and remove files from S3
		// so we always copy and serve scripts from the new bucket
		$this->remove_files_from_s3_request->data( $data )->dispatch();
	}

	/**
	 * Redirect to our settings tab after a manual action redirect,
	 * removing the query var added to force redirect in javascript.
	 */
	function clean_url_after_manual_action() {
		if ( ! isset( $_GET['page'] ) || self::$plugin_page != $_GET['page'] ) {
			return;
		}

		if ( isset( $_GET['as3cf-assets-manual'] ) && 1 == $_GET['as3cf-assets-manual'] ) {
			wp_redirect( $this->get_plugin_page_url() );
			exit;
		}
	}

	/**
	 * AJAX handler for manual scan now button
	 */
	function ajax_manual_scan() {
		check_ajax_referer( 'as3cf-assets-manual-scan', '_nonce' );
		$this->scan_files_for_s3();

		$this->end_ajax( array( 'success' => 1 ) );
	}

	/**
	 * AJAX handler for manual purge button
	 */
	function ajax_manual_purge() {
		check_ajax_referer( 'as3cf-assets-manual-purge', '_nonce' );

		$bucket = $this->get_setting( 'bucket' );
		$region = $this->get_setting( 'region' );

		$this->remove_all_files_from_s3( $bucket, $region, true );

		$this->end_ajax( array( 'success' => 1 ) );
	}

	/**
	 * Is the plugin scanning files for S3
	 *
	 * @return bool
	 */
	public function is_scanning() {
		return (bool) get_site_transient( $this->scanning_lock_key );
	}

	/**
	 * Is the plugin purging files from S3
	 *
	 * @return bool
	 */
	public function is_purging() {
		return (bool) get_site_transient( $this->purging_lock_key );
	}

	/**
	 * Display an info notice when we are performing a scan
	 *
	 * @param string $tab
	 */
	public function maybe_display_s3_message( $tab ) {
		if ( 'assets' !== $tab ) {
			return;
		}

		if ( ! $this->is_scanning() && ! $this->is_purging() ) {
			return;
		}

		$message = __( '<strong>Scanning & Uploading Files to S3</strong> &mdash; This background task may take a while depending on how many files there are.', 'as3cf-assets' );
		if ( $this->is_purging() ) {
			$message = __( '<strong>Purging Files from S3</strong> &mdash; This background task may take a while depending on how many files there are.', 'as3cf-assets' );
		}

		$args = array(
			'message' => $message,
			'inline'  => true,
		);

		$this->render_view( 'notice', $args );
	}

	/**
	 * Get the number of seconds to expire the scanning lock transient
	 *
	 * @return int
	 */
	function get_scanning_expiration() {
		return apply_filters( 'as3cf_assets_scanning_expiration', MINUTE_IN_SECONDS * 20 );
	}

	/**
	 * Get the number of seconds to expire the purging lock transient
	 *
	 * @return int
	 */
	function get_purging_expiration() {
		return apply_filters( 'as3cf_assets_purging_expiration', MINUTE_IN_SECONDS * 10 );
	}

	/**
	 * Scan the files we need to copy to S3 and maybe remove from S3
	 *
	 * @return int
	 */
	public function scan_files_for_s3() {
		if ( ! $this->is_plugin_setup() ) {
			return;
		}

		if ( $this->is_scanning() || $this->is_purging() ) {
			// Abort if already running the scan or purging existing files
			return;
		}

		// Lock and cleanup after 10 minutes
		set_site_transient( $this->scanning_lock_key, true, $this->get_scanning_expiration() );

		$extensions         = $this->get_setting( 'file-extensions' );
		$extensions         = str_replace( array( '.', ' ' ), '', $extensions );
		$extensions         = explode( ',', $extensions );
		$extensions         = apply_filters( 'as3cf_assets_file_extensions', $extensions );
		$locations          = $this->get_file_locations();
		$ignore_hidden_dirs = apply_filters( 'as3cf_assets_ignore_hidden_dirs', true );

		$saved_files      = $this->get_files();
		$files_to_save    = array();
		$files_to_process = array();

		foreach ( $locations as $location ) {
			$path            = trailingslashit( $location['path'] );
			$url             = trailingslashit( $location['url'] );
			$exclude         = isset( $location['exclude'] ) ? $location['exclude'] : array();
			$update          = false;
			$files_to_update = array();

			$location_files = $this->find_files_in_path( $path, $extensions, $exclude, $ignore_hidden_dirs );

			foreach ( $location_files as $file => $object ) {
				$details = array(
					'url'           => str_replace( $path, $url, $file ),
					'base'          => str_replace( $path, '', $file ),
					'local_version' => filemtime( $file ),
					'type'          => $location['type'],
					'object'        => $location['object'],
					'extension'     => pathinfo( $file, PATHINFO_EXTENSION ),
					's3_version'    => 0,
				);

				if ( apply_filters( 'as3cf_assets_ignore_file', false, $file, $details ) ) {
					continue;
				}

				if ( isset( $saved_files[ $file ] ) ) {
					// File has already been scanned so use the existing S3 details
					$details['s3_version'] = $saved_files[ $file ]['s3_version'];
					if ( isset( $saved_files[ $file ]['s3_info'] ) ) {
						$details['s3_info'] = $saved_files[ $file ]['s3_info'];
					}
				}

				if ( $this->is_failure( 'gzip', $file, true ) || $this->is_failure( 'upload', $file, true ) ) {
					$files_to_process[] = array(
						'action' => 'copy',
						'file'   => $file,
						'object' => $details['object'],
					);
				} elseif (
					! $this->is_failure( 'gzip', $file ) &&
					! $this->is_failure( 'upload', $file ) &&
					version_compare( $details['s3_version'], $details['local_version'], '!=' )
				) {
					$update = true;
				}

				$files_to_save[ $file ]   = $details;
				$files_to_update[ $file ] = $details;
			}

			// File modified, purge entire location
			if ( $update && ! empty( $files_to_update ) ) {
				$this->set_object_version_prefix( $location['type'], $location['object'] );

				foreach ( $files_to_update as $file => $details ) {
					// Copy new version to S3
					$files_to_process[] = array(
						'action' => 'copy',
						'file'   => $file,
						'object' => $details['object'],
					);

					// Remove previous version from S3
					if ( 0 !== $details['s3_version'] && isset( $saved_files[ $file ]['s3_info'] ) ) {
						$files_to_process[] = array(
							'action' => 'remove',
							'url'    => $details['url'],
							'key'    => $details['s3_info']['key'],
						);
					}
				}
			}
		}

		// Remove files from S3 that don't exist locally anymore
		if ( ! empty( $saved_files ) ) {
			foreach ( $saved_files as $file => $details ) {
				if ( ! isset( $files_to_save[ $file ] ) ) {
					// File does not exist anymore, or extension not in scope
					$files_to_process[] = array(
						'action' => 'remove',
						'url'    => $details['url'],
						'key'    => $details['s3_info']['key'],
					);
				}
			}
		}

		// Save the base url for core files
		$this->set_setting( 'base_url', site_url() );
		$this->save_settings();
		// Save the files array to the db
		$this->save_files( $files_to_save );

		if ( ! empty( $files_to_process ) ) {
			// Save the files to be processed to S3 to the db
			update_site_option( self::TO_PROCESS_SETTINGS_KEY, $files_to_process );
			// Start the cron to batch process files to S3
			$this->schedule_event( $this->processing_cron_hook );
			// Kick off the first processing batch
			$this->process_s3_files( $files_to_process, $files_to_save );
		} else {
			// Unlock scanning
			delete_site_transient( $this->scanning_lock_key );
			// Stop the cron if somehow still on
			$this->clear_scheduled_event( $this->processing_cron_hook );
		}
	}

	/**
	 * Copy files to S3 and remove files from S3 that have been scanned
	 *
	 * @param array|null $files_to_process
	 * @param array|null $saved_files
	 */
	function process_s3_files( $files_to_process = null, $saved_files = null ) {
		if ( empty( $files_to_process ) && ! ( $files_to_process = get_site_option( self::TO_PROCESS_SETTINGS_KEY ) ) ) {
			// If we have got here with no files to process, clean up
			$this->stop_processing();

			return;
		}

		if ( is_null( $saved_files ) ) {
			$saved_files = $this->get_files();
		}
		$enqueued_files = $this->get_enqueued_files();

		$bucket      = $this->get_setting( 'bucket' );
		$region      = $this->get_setting( 'region' );
		$s3client    = $this->get_s3client( $region );

		$count         = 0;
		$batch_limit   = apply_filters( 'as3cf_assets_file_process_batch_limit', 500 );
		$time_limit    = apply_filters( 'as3cf_assets_file_process_batch_time_limit', 20 ); // Seconds
		$finish_time   = time() + $time_limit;
		$files_copied  = 0;
		$files_removed = 0;

		foreach ( $files_to_process as $key => $file ) {
			$count++;
			// Batch or time limit reached.
			if ( $count > $batch_limit || time() >= $finish_time ) {
				break;
			}

			switch ( $file['action'] ) {
				case 'remove':
					$this->remove_file_from_s3( $region, $bucket, $file );

					$path = $this->get_file_absolute_path( $file['url'] );
					$type = pathinfo( $path, PATHINFO_EXTENSION );
					$files_removed++;
					unset( $enqueued_files[ $type ][ $path ] );

					break;
				case 'copy':
					if ( ! isset( $saved_files[ $file['file'] ] ) ) {
						// If for some reason we don't have the file saved
						// in the scanned files array anymore, don't copy it
						break;
					}

					$details   = $saved_files[ $file['file'] ];
					$body      = file_get_contents( $file['file'] );
					$gzip_body = $this->maybe_gzip_file( $file['file'], $details, $body );

					if ( is_wp_error( $gzip_body ) ) {
						$s3_info = $this->copy_file_to_s3( $s3client, $bucket, $file['file'], $details );
					} else {
						$s3_info = $this->copy_body_to_s3( $s3client, $bucket, $gzip_body, $details, true );
					}

					if ( is_wp_error( $s3_info ) ) {
						$this->handle_failure( $file['file'], 'upload' );
					} else {
						$details['s3_version']        = $details['local_version'];
						$details['s3_info']           = $s3_info;
						$saved_files[ $file['file'] ] = $details;

						$files_copied++;

						// Maybe remove file from upload failure queue
						if ( $this->is_failure( 'upload', $file['file'] ) ) {
							$this->remove_failure( 'upload', $file['file'] );
						}

						// Maybe remove file from gzip failure queue
						if ( ! is_wp_error( $gzip_body ) && $this->is_failure( 'gzip', $file['file'] ) ) {
							$this->remove_failure( 'gzip', $file['file'] );
						}
					}

					break;
			}

			unset( $files_to_process[ $key ] );
		}

		if ( $files_copied > 0 ) {
			// If we have copied files to S3 update our saved files array
			$this->save_files( $saved_files );
		}

		if ( $files_removed > 0 ) {
			// If we have removed files from S3, update enqueued files array
			$this->save_enqueued_files( $enqueued_files );
		}

		if ( empty( $files_to_process ) ) {
			// We have processed all the files to S3, clean up
			$this->stop_processing();
		} else {
			// We have processed some but not all files, update for the next batch
			update_site_option( self::TO_PROCESS_SETTINGS_KEY, $files_to_process );
		}
	}

	/**
	 * End the batch processing of files to S3
	 */
	function stop_processing() {
		// Remove the scanning lock transient
		delete_site_transient( $this->scanning_lock_key );
		// Delete the files to process settings
		delete_site_option( self::TO_PROCESS_SETTINGS_KEY );
		// Stop processing cron
		$this->clear_scheduled_event( $this->processing_cron_hook );
	}

	/**
	 * Find all files in path and sub directories that match extensions
	 *
	 * @param string $path          Root path to start the search of files from
	 * @param array  $extensions    Extensions of files to find
	 * @param array  $exclude_paths Paths to ignore from the search
	 * @param bool   $ignore_hidden_dirs
	 *
	 * @return RegexIterator $files Files found in path
	 */
	protected function find_files_in_path( $path, $extensions = array(), $exclude_paths = array(), $ignore_hidden_dirs = true ) {
		/**
		 * @param SplFileInfo                     $file
		 * @param mixed                           $key
		 * @param RecursiveCallbackFilterIterator $iterator
		 *
		 * @return bool True if you need to recurse or if the item is acceptable
		 */
		$filter = function ( $file, $key, $iterator ) use ( $exclude_paths, $ignore_hidden_dirs ) {
			$filename = $file->getFilename();

			// Ignore hidden directories by default
			if ( $ignore_hidden_dirs && $file->isDir() && '.' === $filename[0] ) {
				return false;
			}

			// Ignore files with incorrect permissions
			if ( ! $file->isReadable() ) {
				return false;
			}

			if ( $iterator->hasChildren() && ! in_array( $file->getFilename(), $exclude_paths ) ) {
				return true;
			}

			return $file->isFile();
		};

		$dir      = new RecursiveDirectoryIterator( $path, RecursiveDirectoryIterator::SKIP_DOTS );
		$iterator = new RecursiveIteratorIterator(
			new RecursiveCallbackFilterIterator( $dir, $filter ),
			RecursiveIteratorIterator::SELF_FIRST
		);

		$exts  = implode( '|', $extensions );
		$files = new RegexIterator( $iterator, '/^.*\.(' . $exts . ')$/i', RecursiveRegexIterator::GET_MATCH );

		return $files;
	}

	/**
	 * Get the scheme of a URL, or revert to default if without one
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	function get_url_scheme( $url ) {
		$src_parts      = $this->parse_url( $url );
		$default_scheme = is_ssl() ? 'https' : 'http';
		if ( ! isset( $src_parts['host'] ) ) {
			// not a URL, just path to file
			$scheme = $default_scheme;
		} else {
			// respect the scheme of the src URL
			$scheme = isset( $src_parts['scheme'] ) ? $src_parts['scheme'] : '';
		}

		return $scheme;
	}

	/**
	 * Remove scheme from a URL
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	function get_url_without_scheme( $url ) {
		$url = preg_replace( '(https?:)', '', $url );
		return $url;
	}

	/**
	 * Parses a URL into its components. Compatible with PHP < 5.4.7.
	 *
	 * @param $url string The URL to parse.
	 *
	 * @return array|false The parsed components or false on error.
	 */
	function parse_url( $url ) {
		$url = trim( $url );
		if ( 0 === strpos( $url, '//' ) ) {
			$url       = 'http:' . $url;
			$no_scheme = true;
		} else {
			$no_scheme = false;
		}

		$parts = parse_url( $url );
		if ( $no_scheme ) {
			unset( $parts['scheme'] );
		}

		return $parts;
	}

	/**
	 * Copy a script file to S3 and record the S3 details
	 *
	 * @param Aws\S3\S3Client $s3client
	 * @param string          $bucket
	 * @param string          $file
	 * @param array           $details
	 * @param null|string     $key
	 *
	 * @return array|WP_Error
	 */
	function copy_file_to_s3( $s3client, $bucket, $file, $details, $key = null ) {
		if ( ! file_exists( $file ) ) {
			$error_msg = sprintf( __( 'File does not exist - %s', 'as3cf-assets' ), $file );
			AS3CF_Error::log( $error_msg, 'ASSETS' );

			return new WP_Error( 'exception', $error_msg );
		}

		$args               = $this->get_s3_upload_args( $details, $key, $bucket );
		$args['SourceFile'] = $file;

		try {
			$s3client->putObject( $args );
		} catch ( Exception $e ) {
			$error_msg = sprintf( __( 'Error uploading %s to S3: %s', 'as3cf-assets' ), $file, $e->getMessage() );
			AS3CF_Error::log( $error_msg, 'ASSETS' );

			return new WP_Error( 'exception', $error_msg );
		}

		return $this->get_s3_upload_info( $args );
	}

	/**
	 * Copy a file body to S3 and record the S3 details
	 *
	 * @param Aws\S3\S3Client $s3client
	 * @param string          $bucket
	 * @param string          $body
	 * @param array           $details
	 * @param bool            $gzip
	 * @param null|string     $key
	 *
	 * @return array|WP_Error
	 */
	public function copy_body_to_s3( $s3client, $bucket, $body, $details, $gzip = false, $key = null ) {
		$args = $this->get_s3_upload_args( $details, $key, $bucket );

		$args['Body']        = $body;
		$args['ContentType'] = $this->get_mime_from_details( $details );

		if ( $gzip ) {
			$args['ContentEncoding'] = 'gzip';
		}

		try {
			$s3client->putObject( $args );
		} catch ( Exception $e ) {
			$error_msg = sprintf( __( 'Error uploading body to S3: %s', 'as3cf-assets' ), $e->getMessage() );
			AS3CF_Error::log( $error_msg );

			return new WP_Error( 'exception', $error_msg );
		}

		return $this->get_s3_upload_info( $args );
	}

	/**
	 * Get S3 upload args
	 *
	 * @param array  $details
	 * @param string $key
	 * @param string $bucket
	 *
	 * @return array
	 */
	protected function get_s3_upload_args( $details, $key, $bucket ) {
		$prefix = $this->get_prefix( $details );

		if ( is_null( $key ) ) {
			$key = $prefix . $details['base'];
		}

		$args = array(
			'Bucket'       => $bucket,
			'Key'          => $key,
			'ACL'          => self::DEFAULT_ACL,
			'CacheControl' => 'max-age=31536000',
			'Expires'      => date( 'D, d M Y H:i:s O', time() + 31536000 ),
		);

		return apply_filters( 'as3cf_assets_object_meta', $args, $details );
	}

	/**
	 * Get mime from details
	 *
	 * @param array $details
	 *
	 * @return string
	 */
	protected function get_mime_from_details( $details ) {
		$extension = $details['extension'];
		$mimes     = $this->get_mime_types_to_gzip();

		return isset( $mimes[ $extension ] ) ? $mimes[ $extension ] : 'text/plain';
	}

	/**
	 * Get S3 upload info
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	protected function get_s3_upload_info( $args ) {
		$s3_info = array(
			'key' => $args['Key'],
		);

		if ( self::DEFAULT_ACL !== $args['ACL'] ) {
			$s3_info['acl'] = $args['ACL'];
		}

		return $s3_info;
	}

	/**
	 * Remove files previously uploaded to S3
	 *
	 * @param array       $files
	 * @param string|null $bucket
	 * @param string|null $region
	 * @param bool        $log_error
	 *
	 * @return bool
	 */
	function remove_files_from_s3( $files, $bucket = null, $region = null, $log_error = false  ) {
		if ( is_null( $bucket ) ) {
			$bucket = $this->get_setting( 'bucket' );
		}

		if ( is_null( $region ) ) {
			$region = $this->get_setting( 'region' );
		}

		$objects = array();
		foreach ( $files as $file => $details ) {
			if ( ! isset( $details['s3_info'] ) ) {
				continue;
			}

			// Delete original version
			$objects[] = array( 'Key' => $details['s3_info']['key'] );

			// Delete minified version
			$path = $this->get_file_absolute_path( $details['url'] );

			if ( $this->minify->is_file_minified( $path ) ) {
				$key = $this->minify->prefix_key( $details['s3_info']['key'] );
				$objects[] = array( 'Key' => $key );
			}
		}

		if ( ! empty( $objects ) ) {
			return $this->delete_s3_objects( $region, $bucket, $objects, $log_error );
		}

		return true;
	}

	/**
	 * Remove a file from S3
	 *
	 * @param string $region
	 * @param string $bucket
	 * @param array  $file
	 *
	 * @return bool
	 */
	function remove_file_from_s3( $region, $bucket, $file ) {
		$objects = array();

		// Delete original version
		$objects[] = array( 'Key' => $file['key'] );

		// Delete minified version
		if ( isset( $file['url'] ) ) {
			$path = $this->get_file_absolute_path( $file['url'] );

			if ( $this->minify->is_file_minified( $path ) ) {
				$file['key'] = $this->minify->prefix_key( $file['key'] );
				$objects[]   = array( 'Key' => $file['key'] );
			}
		}

		return $this->delete_s3_objects( $region, $bucket, $objects );
	}

	/**
	 * Remove all scripts from S3 and cached scripts
	 *
	 * @param string $bucket
	 * @param string $region
	 * @param bool   $log_error
	 *
	 * @return bool
	 */
	public function remove_all_files_from_s3( $bucket, $region, $log_error = false ) {
		if ( $this->is_scanning() || $this->is_purging() ) {
			// Abort if already running the scan or purging existing files
			return false;
		}

		// Lock and cleanup after 10 minutes
		set_site_transient( $this->purging_lock_key, true, $this->get_purging_expiration() );

		// Get all files to remove from the existing bucket
		$files = $this->get_files();

		if ( $files  ) {
			$this->remove_files_from_s3( $files, $bucket, $region, $log_error );
		}

		// Remove the cached files and scripts
		delete_site_option( self::FILES_SETTINGS_KEY );
		delete_site_option( self::ENQUEUED_SETTINGS_KEY );
		delete_site_option( self::LOCATION_VERSIONS_KEY );
		delete_site_option( self::FAILURES_KEY );

		// Clear failure notices
		$this->notices->remove_notice_by_id( 'assets_gzip_failure' );
		$this->notices->remove_notice_by_id( 'assets_minify_failure' );

		delete_site_transient( $this->purging_lock_key );

		return true;
	}

	/**
	 * Generate a dynamic prefix for the file on S3
	 *
	 * @param array $details
	 *
	 * @return string e.g my-site/theme/twentyfifteen/1429606827/
	 */
	function get_prefix( $details ) {
		$prefix = '';

		if ( $this->get_setting( 'enable-script-object-prefix' ) ) {
			$prefix = trim( $this->get_setting( 'object-prefix' ) );
			$prefix = ltrim( trailingslashit( $prefix ), '/' );
		}

		$prefix .= trailingslashit( $details['type'] );
		if ( '' !== $details['object'] ) {
			$prefix .= trailingslashit( $details['object'] );
		}

		$version = $this->get_object_version_prefix( $details['type'], $details['object'] );
		$prefix .= trailingslashit( $version );

		return $prefix;
	}


	/**
	 * Get object version prefix
	 *
	 * @param string $type
	 * @param string $object
	 *
	 * @return string
	 */
	function get_object_version_prefix( $type, $object ) {
		if ( is_null( $this->location_versions ) ) {
			$this->location_versions = get_site_option( static::LOCATION_VERSIONS_KEY );
		}

		if ( isset( $this->location_versions[ $type ][ $object ] ) ) {
			// Location already has a version prefix, return it
			return $this->location_versions[ $type ][ $object ];
		}

		return $this->set_object_version_prefix( $type, $object );
	}

	/**
	 * Set object version prefix
	 *
	 * @param string $type
	 * @param string $object
	 *
	 * @return string
	 */
	function set_object_version_prefix( $type, $object ) {
		if ( is_null( $this->location_versions ) ) {
			$this->location_versions = get_site_option( static::LOCATION_VERSIONS_KEY );
		}

		$this->location_versions[ $type ][ $object ] = date( 'YmdHis' );
		update_site_option( static::LOCATION_VERSIONS_KEY, $this->location_versions );

		return $this->location_versions[ $type ][ $object ];
	}

	/**
	 * Replace an enqueued style's fully-qualified URL with one on S3
	 *
	 * @param string $src The source URL of the enqueued style.
	 *
	 * @return string
	 */
	function serve_css_from_s3( $src ) {
		$src = $this->serve_from_s3( 'css', $src );

		return $src;
	}

	/**
	 * Replace an enqueued scripts's fully-qualified URL with one on S3
	 *
	 * @param string $src The source URL of the enqueued script.
	 *
	 * @return string
	 */
	function serve_js_from_s3( $src ) {
		$src = $this->serve_from_s3( 'js', $src );

		return $src;
	}

	/**
	 * Wrapper for replacing CSS and JS local URLs with S3 URLs
	 *
	 * @param string $script_type
	 * @param string $src
	 *
	 * @return string
	 */
	function serve_from_s3( $script_type, $src ) {
		if ( ! $this->get_setting( 'enable-addon' ) ) {
			return $src;
		}

		if ( is_admin() || ! ( $files = $this->get_files() ) ) {
			// We haven't scanned any scripts to replace
			return $src;
		}

		$url_parts = $this->parse_url( $src );

		if ( isset( $url_parts['host'] ) ) {
			$host_length      = strlen( $url_parts['host'] );
			$http_host_domain = substr( $_SERVER['HTTP_HOST'], 0 - $host_length, $host_length );

			// Test for scripts served by subdomain subsites in multistie
			// They must have the same domain as the $_SERVER['HTTP_HOST']
			if ( $http_host_domain != $url_parts['host'] ) {
				// External script, ignore

				return $src;
			}
		}

		// Get the handle to file mapping array for quicker access to scripts
		$enqueued_scripts     = get_site_option( self::ENQUEUED_SETTINGS_KEY, array() );
		$locations_processing = $this->get_locations_processing();
		$script               = false;

		// Get file absolute path
		$path = $this->get_file_absolute_path( $src );

		if ( isset( $enqueued_scripts[ $script_type ][ $path ] ) ) {
			if ( isset( $files[ $path ] ) ) {
				$script = $files[ $path ];
			}

			if ( isset( $files[ $path ] ) && in_array( $files[ $path ]['object'], $locations_processing ) ) {
				// Location still processing, don't enqueue S3 link
				return $src;
			}
		}

		if ( ! $script ) {
			// We haven't already process this script and added to the 'enqueued_scripts' mapping
			$url = explode( '?', $src );
			$url = $this->get_url_without_scheme( $url[0] );

			$base_url = $this->get_setting( 'base_url', site_url() );
			$base_url = $this->get_url_without_scheme( $base_url );

			foreach ( $files as $file => $details ) {
				if ( $script_type !== $details['extension'] ) {
					continue;
				}

				if ( in_array( $details['object'], $locations_processing ) ) {
					// Location still processing, don't enqueue S3 link
					continue;
				}

				if ( $this->match_url_with_file( $url, $details['url'], $base_url ) ) {
					$script = $details;

					// Add the script to the 'enqueued_scripts' mapping for the future
					$enqueued_scripts[ $script_type ][ $file ] = array();
					update_site_option( self::ENQUEUED_SETTINGS_KEY, $enqueued_scripts );
					break;
				}
			}
		}

		if ( ! $script || ! isset( $script['s3_info'] ) ) {
			// This script hasn't been scanned or hasn't been uploaded yet to S3
			return $src;
		}

		if ( version_compare( $script['s3_version'], $script['local_version'], '!=' ) ) {
			// The latest version hasn't been uploaded yet to S3
			return $src;
		}

		$s3_info = $script['s3_info'];
		$scheme  = $this->get_url_scheme( $src );
		$bucket  = $this->get_setting( 'bucket' );
		$region  = $this->get_setting( 'region' );
		$domain  = $this->get_s3_url_domain( $bucket, $region );
		$key     = $s3_info['key'];

		// Serve minified version if enabled
		if ( $this->get_setting( 'enable-minify' ) ) {
			$key = $this->minify->maybe_prefix_key( $script, $path );
		}

		$key = $this->maybe_update_cloudfront_path( $key );

		// Handle file name encoding
		$file = $this->encode_filename_in_path( $key );

		// force use of secured url when ACL has been set to private
		if ( isset( $s3_info['acl'] ) && self::PRIVATE_ACL == $s3_info['acl'] ) {
			$expires = self::DEFAULT_EXPIRES;
		}

		if ( isset( $expires ) ) {
			try {
				$expires = time() + $expires;
				$secure_url = $this->get_s3client( $region )->getObjectUrl( $bucket, $key, $expires );
			}
			catch ( Exception $e ) {
				return $src;
			}
		}

		$scheme = ( $scheme ) ? $scheme . ':' : '';
		$src    = $scheme . '//' . $domain . '/' . $file;

		if ( isset( $secure_url ) ) {
			$src .= substr( $secure_url, strpos( $secure_url, '?' ) );
		}

		return apply_filters( 'as3cf_assets_file_url', $src );
	}

	/**
	 * Get locations processing
	 *
	 * @return array
	 */
	function get_locations_processing() {
		$locations = array();

		if ( ! ( $files = get_site_option( self::TO_PROCESS_SETTINGS_KEY ) ) ) {
			return $locations;
		}

		foreach ( $files as $file ) {
			if ( 'copy' === $file['action'] && isset( $file['object'] ) ) {
				if ( ! in_array( $file['object'], $locations ) ) {
					// Add location if not already added
					$locations[] = $file['object'];
				}
			}
		}

		return $locations;
	}

	/**
	 * Display a notice displaying information about how many scripts uploaded and serving from S3
	 *
	 * @param string $tab
	 */
	public function script_served_count_notice( $tab ) {
		if ( 'assets' !== $tab ) {
			return;
		}

		if ( ! $this->is_plugin_setup() ) {
			return;
		}

		$css_count = $this->count_scripts_being_served( 'css' );
		$js_count  = $this->count_scripts_being_served( 'js' );

		if ( 0 === ( $css_count + $js_count ) ) {
			$message = __( 'No CSS or JS files are being served.', 'as3cf-assets' );
		} else {
			$more_info_link = $this->more_info_link( 'https://deliciousbrains.com/wp-offload-s3/doc/assets-addon/', 'serving-urls' );
			$message        = sprintf( __( '%d JS and %d CSS enqueued files are currently being served. %s', 'as3cf-assets' ), $js_count, $css_count, $more_info_link );
		}

		$args = array( 'message' => $message );

		$this->render_view( 'info-notice', $args );
	}

	/**
	 * Get failures
	 *
	 * @param string $type
	 * @param bool   $final
	 *
	 * @return array
	 */
	protected function get_failures( $type, $final = true ) {
		$failures = get_site_option( self::FAILURES_KEY, array() );

		if ( empty( $failures[ $type ] ) ) {
			return array();
		}

		$return = array();

		foreach ( $failures[ $type ] as $file => $failure ) {
			if ( ! $final ) {
				$return[ $file ] = $failure;

				continue;
			}

			if ( $failure['count'] >= 3 ) {
				$return[ $file ] = $failure;
			}
		}

		return $return;
	}

	/**
	 * Update failures
	 *
	 * @param string $type
	 * @param array  $failures
	 */
	protected function update_failures( $type, $failures ) {
		$current = get_site_option( self::FAILURES_KEY, array() );

		$current[ $type ] = $failures;

		update_site_option( self::FAILURES_KEY, $current );
	}

	/**
	 * Match an enqueued script URL to a file we have stored on S3
	 *
	 * @param string  $url      The enqueued src URL without scheme
	 * @param  string $file_url The current file URL
	 * @param  string $base_url The base url of the site / network
	 *
	 * @return bool
	 */
	function match_url_with_file( $url, $file_url, $base_url ) {
		// Remove the scheme from the current file url
		$file_url = $this->get_url_without_scheme( $file_url );

		if ( $url === $file_url ) {
			// Schemeless URLs match, typical for single site installs
			return true;
		}

		global $wp_scripts;
		// Get the base url for the enqueued scripts without scheme
		$site_base_url = $this->get_url_without_scheme( $wp_scripts->base_url );

		// Replace the files base url with the current sites base url
		// This is for subsites of a network in multisite
		$file_url = str_replace( $base_url, $site_base_url, $file_url );
		if ( $url === $file_url ) {
			return true;
		}

		return false;
	}

	/**
	 * Get file absolute path
	 *
	 * @param string $url
	 *
	 * @return mixed
	 */
	protected function get_file_absolute_path( $url ) {
		global $wp_scripts;

		$base_path = untrailingslashit( ABSPATH );
		$base_url  = untrailingslashit( $this->get_url_without_scheme( $wp_scripts->base_url ) );
		$url       = $this->get_url_without_scheme( preg_replace( '@\?.*@', '', $url ) );

		return str_replace( $base_url, $base_path, $url );
	}

	/**
	 * Count the number of scripts that have been uploaded to S3 which we are serving
	 *
	 * @param string $script_type CSS, JS
	 *
	 * @return int
	 */
	function count_scripts_being_served( $script_type ) {
		$scripts_count = 0;
		if ( ! ( $scripts = get_site_option( self::ENQUEUED_SETTINGS_KEY ) ) ) {
			// We haven't scanned any scripts to serve
			return $scripts_count;
		}

		if ( ! isset( $scripts[ $script_type ] ) ) {
			return $scripts_count;
		}

		$scripts_count = count( $scripts[ $script_type ] );

		return $scripts_count;
	}

	/**
	 * Get files
	 *
	 * @return mixed
	 */
	public function get_files() {
		return get_site_option( self::FILES_SETTINGS_KEY, array() );
	}

	/**
	 * Save files
	 *
	 * @param array $files
	 */
	public function save_files( $files ) {
		update_site_option( self::FILES_SETTINGS_KEY, $files );
	}

	/**
	 * Get enqueued files
	 *
	 * @return mixed
	 */
	public function get_enqueued_files() {
		return get_site_option( self::ENQUEUED_SETTINGS_KEY, array() );
	}

	/**
	 * Save enqueued files
	 *
	 * @param array $files
	 */
	public function save_enqueued_files( $files ) {
		update_site_option( self::ENQUEUED_SETTINGS_KEY, $files );
	}

	/**
	 * Maybe gzip file
	 *
	 * @param string $file
	 * @param array  $details
	 * @param string $body
	 *
	 * @return bool|string
	 */
	public function maybe_gzip_file( $file, $details, $body ) {
		if ( ! (bool) $this->get_setting( 'enable-gzip' ) ) {
			// Gzip disabled
			return $this->_throw_error( 'gzip_disabled' );
		}

		if ( ! array_key_exists( $details['extension'], $this->get_mime_types_to_gzip() ) ) {
			// Extension not supported
			return $this->_throw_error( 'gzip_extension' );
		}

		if ( false === ( $gzip_body = gzencode( $body ) ) ) {
			// Couldn't gzip file
			$this->handle_gzip_failure( $file );

			return $this->_throw_error( 'gzip_gzencode' );
		}

		return $gzip_body;
	}

	/**
	 * Handle gzip failure
	 *
	 * @param string $file
	 *
	 * @return int
	 */
	protected function handle_gzip_failure( $file ) {
		return $this->handle_failure( $file, 'gzip' );
	}

	/**
	 * Handle process failure
	 *
	 * @param string $file
	 * @param string $type
	 *
	 * @return int
	 */
	public function handle_failure( $file, $type ) {
		$failures  = get_site_option( self::FAILURES_KEY, array() );
		$count     = 1;
		$timestamp = time();
		$expires   = time() - ( 5 * MINUTE_IN_SECONDS );

		if ( isset( $failures[ $type ][ $file ] ) ) {
			$count = $failures[ $type ][ $file ]['count'];

			if ( $failures[ $type ][ $file ]['count'] < 3 && $failures[ $type ][ $file ]['timestamp'] <= $expires ) {
				$count++;
			}
		}

		$failures[ $type ][ $file ] = array(
			'count'     => $count,
			'timestamp' => $timestamp,
		);

		update_site_option( self::FAILURES_KEY, $failures );

		// Reached limit, show notice
		if ( 3 === $count ) {
			$this->update_failure_notice( $type );
		}

		return $count;
	}

	/**
	 * Is failure
	 *
	 * @param string $type
	 * @param string $file
	 * @param bool   $processable
	 *
	 * @return bool
	 */
	public function is_failure( $type, $file, $processable = false ) {
		$failures = $this->get_failures( $type, false );

		if ( isset( $failures[ $file ] ) ) {
			if ( ! $processable ) {
				return true;
			}

			$expires = time() - ( 5 * MINUTE_IN_SECONDS );

			if ( $failures[ $file ]['count'] < 3 && $failures[ $file ]['timestamp'] <= $expires ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Remove failure
	 *
	 * @param string $type
	 * @param string $file
	 *
	 * @return int
	 */
	public function remove_failure( $type, $file ) {
		$failures = $this->get_failures( $type, false );

		if ( isset( $failures[ $file ] ) ) {
			unset( $failures[ $file ] );

			$this->maybe_clear_enqueued_file( $file, $type );
			$this->update_failures( $type, $failures );
		}

		if ( 0 === count( $failures ) ) {
			$id = 'assets_' . $type . '_failure';

			$this->notices->remove_notice_by_id( $id );
		}

		return count( $failures );
	}

	/**
	 * Maybe clear enqueued file
	 *
	 * @param string $file
	 * @param string $type
	 */
	protected function maybe_clear_enqueued_file( $file, $type ) {
		if ( 'gzip' !== $type ) {
			return;
		}

		$files = $this->get_enqueued_files();
		$save  = false;

		if ( isset( $files['css'][ $file ] ) ) {
			unset( $files['css'][ $file ] );
			$save = true;
		}

		if ( isset( $files['js'][ $file ] ) ) {
			unset( $files['js'][ $file ] );
			$save = true;
		}

		if ( $save ) {
			$this->save_enqueued_files( $files );
		}
	}

	/**
	 * Update failure notice
	 *
	 * @param string $type
	 */
	protected function update_failure_notice( $type ) {
		$id = 'assets_' . $type . '_failure';

		if ( ! is_null( $this->notices->find_notice_by_id( $id ) ) ) {
			$this->notices->undismiss_notice_for_all( $id );

			return;
		}

		$args = array(
			'type'                  => 'error',
			'flash'                 => false,
			'only_show_to_user'     => false,
			'only_show_on_tab'      => 'assets',
			'custom_id'             => $id,
			'show_callback'         => array( 'as3cf_assets', 'failure_' . $type . '_notice_callback' ),
		);

		$this->notices->add_notice( $this->get_failure_message( $type ), $args );
	}

	/**
	 * Get failure message
	 *
	 * @param string $type
	 *
	 * @return string
	 */
	protected function get_failure_message( $type ) {
		$title   = __( 'Gzip Error', 'as3cf-assets' );
		$message = __( 'There were errors when attempting to compress your assets.', 'as3cf-assets' );

		if ( 'minify' === $type ) {
			$title   = __( 'Minify Error', 'as3cf-assets' );
			$message = __( 'There were errors when attempting to minify your assets.', 'as3cf-assets' );
		}

		if ( 'upload' === $type ) {
			$title   = __( 'Upload Error', 'as3cf-assets' );
			$message = __( 'There were errors when attempting to upload your assets to S3.', 'as3cf-assets' );
		}

		return sprintf( '<strong>%s</strong> &mdash; %s', $title, $message );
	}

	/**
	 * Failure to upload notice callback
	 */
	public function failure_upload_notice_callback() {
		$this->failure_notice_callback( 'upload' );
	}

	/**
	 * Failure gzip notice callback
	 */
	public function failure_gzip_notice_callback() {
		$this->failure_notice_callback( 'gzip' );
	}

	/**
	 * Failure minify notice callback
	 */
	public function failure_minify_notice_callback() {
		$this->failure_notice_callback( 'minify' );
	}

	/**
	 * Failure notice callback
	 *
	 * @param string $type
	 */
	protected function failure_notice_callback( $type ) {
		$errors = $this->get_failures( $type );

		$this->render_view( 'failure-notice', array( 'errors' => $errors ) );
	}

	/**
	 * Assets more info link
	 *
	 * @param string $hash
	 *
	 * @return string
	 */
	public function assets_more_info_link( $hash ) {
		return $this->more_info_link( 'https://deliciousbrains.com/wp-offload-s3/doc/assets-addon-settings/', $hash );
	}

	/**
	 * Get minified assets
	 *
	 * @param bool|array $enqueued
	 * @param bool       $absolute_path
	 *
	 * @return array
	 */
	protected function get_minified_assets( $enqueued = false, $absolute_path = true ) {
		if ( false === $enqueued || ! is_array( $enqueued ) ) {
			$enqueued = $this->get_enqueued_files();
		}

		$minified = array();

		foreach ( $enqueued as $type ) {
			foreach( $type as $file => $details ) {
				if ( isset( $details['minified'] ) && $details['minified'] ) {
					$minified[] = $file;
				}
			}
		}

		if ( ! $absolute_path ) {
			foreach( $minified as $key => $value ) {
				$minified[ $key ] = str_replace( ABSPATH, '', $value );
			}
		}

		return $minified;
	}

	/**
	 * Addon specific diagnostic info
	 *
	 * @param string $output
	 *
	 * @return string
	 */
	function diagnostic_info( $output = '' ) {
		$output .= 'Assets Addon: ';
		$output .= "\r\n";
		$output .= 'Enabled: ';
		$output .= $this->on_off( 'enable-addon' );
		$output .= "\r\n";
		$output .= 'Cron: ';
		$output .= $this->on_off( 'enable-cron' );
		if ( $this->get_setting( 'enable-cron' ) ) {
			$output .= "\r\n";
			$output .= 'Scanning Cron: ';
			$output .= ( wp_next_scheduled( $this->scanning_cron_hook ) ) ? 'On' : 'Off';
		}
		$output .= "\r\n";
		$output .= 'Processing Cron: ';
		$output .= ( wp_next_scheduled( $this->processing_cron_hook ) ) ? 'On' : 'Off';
		$output .= "\r\n";
		$output .= 'Bucket: ';
		$output .= $this->get_setting( 'bucket' );
		$output .= "\r\n";
		$output .= 'Region: ';
		$region = $this->get_setting( 'region' );
		if ( ! is_wp_error( $region ) ) {
			$output .= $region;
		}
		$output .= "\r\n";
		$output .= 'Domain: ';
		$domain = $this->get_setting( 'domain' );
		$output .= $domain;
		$output .= "\r\n";
		if ( 'cloudfront' === $domain ) {
			$output .= 'CloudFront: ';
			$output .= $this->get_setting( 'cloudfront' );
			$output .= "\r\n";
		}
		$output .= 'Enable Path: ';
		$output .= $this->on_off( 'enable-script-object-prefix' );
		$output .= "\r\n";
		$output .= 'Custom Path: ';
		$output .= $this->get_setting( 'object-prefix' );
		$output .= "\r\n";
		$output .= 'File Extensions: ';
		$output .= $this->get_setting( 'file-extensions' );
		$output .= "\r\n";
		$output .= 'Minify: ';
		$output .= $this->on_off( 'enable-minify' );
		$output .= "\r\n";
		$output .= 'Gzip: ';
		$output .= $this->on_off( 'enable-gzip' );
		$output .= "\r\n";
		$output .= 'Custom Endpoint: ';
		$custom_endpoint = $this->on_off( 'enable-custom-endpoint' );
		$output .= $custom_endpoint;
		$output .= "\r\n";
		if ( 'On' === $custom_endpoint ) {
			$output .= 'Custom Endpoint: ';
			$output .= home_url( '/?' . $this->custom_endpoint . '=' . $this->get_setting( 'custom-endpoint-key' ) );
			$output .= "\r\n";
		}

		if ( $files = $this->get_files() ) {
			$output .= 'Scanned Files: ';
			$output .= count( $files );
			$output .= "\r\n";
		}

		if ( $processing = get_site_option( self::TO_PROCESS_SETTINGS_KEY ) ) {
			$output .= 'Processing Files: ';
			$output .= count( $processing );
			$output .= "\r\n";
		}

		if ( $enqueued = get_site_option( self::ENQUEUED_SETTINGS_KEY ) ) {
			if ( isset( $enqueued['css'] ) ) {
				$output .= 'Enqueued CSS: ' . count( $enqueued['css'] );
				$output .= "\r\n";
			}
			if ( isset( $enqueued['js'] ) ) {
				$output .= 'Enqueued JS: ' . count( $enqueued['js'] );
				$output .= "\r\n";
			}

			$minified_assets = $this->get_minified_assets( $enqueued, false );
			if ( ! empty( $minified_assets ) ) {
				$output .= "\r\n";
				$output .= 'Minified Assets: ';
				$output .= "\r\n";
				$output .= implode( "\r\n", $minified_assets );
				$output .= "\r\n\r\n";
			}
		}

		if ( $minify_failures = $this->get_failures( 'minify', false ) ) {
			$output .= 'Minify Failures: ';
			$output .= "\r\n";
			$output .= print_r( $minify_failures, true );
			$output .= "\r\n";
		}

		if ( $gzip_failures = $this->get_failures( 'gzip', false ) ) {
			$output .= 'Gzip Failures: ';
			$output .= "\r\n";
			$output .= print_r( $gzip_failures, true );
			$output .= "\r\n";
		}

		return $output;
	}
}
