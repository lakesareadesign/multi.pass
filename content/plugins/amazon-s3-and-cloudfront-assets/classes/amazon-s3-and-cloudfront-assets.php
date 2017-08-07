<?php

use DeliciousBrains\WP_Offload_S3_Assets\Tools\Process_Assets;

class Amazon_S3_And_CloudFront_Assets extends Amazon_S3_And_CloudFront_Pro {

	protected $theme_url;
	protected $theme_dir;
	protected $plugins_url;
	protected $plugins_dir;

	// Async requests
	protected $scan_files_for_s3_request;
	protected $remove_files_from_s3_request;

	// Process Assets
	protected $process_assets_background_process;
	public $process_assets;

	// Minify
	protected $minify_background_process;
	public $minify;

	protected $slug = 'amazon-s3-and-cloudfront-assets';
	protected $plugin_prefix = 'as3cf_assets';
	protected $default_tab = 'assets';
	protected $scanning_lock_key = 'as3cf-assets-scanning';
	protected $purging_lock_key = 'as3cf-assets-purging';
	protected $scanning_cron_interval_in_minutes;
	protected $scanning_cron_hook = 'as3cf_assets_scan_files_for_s3_cron';
	protected $custom_endpoint;
	protected $exclude_dirs;
	protected $location_versions;
	private $files;
	private $files_count;
	private $files_to_enqueue = array();

	const SETTINGS_KEY = 'as3cf_assets';
	const SETTINGS_CONSTANT = 'WPOS3_ASSETS_SETTINGS';
	const FILES_SETTINGS_KEY = 'as3cf_assets_files';
	const TO_PROCESS_SETTINGS_KEY = 'as3cf_assets_files_to_process'; // Legacy
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

		// UI Setup filters
		add_filter( 'as3cf_settings_tabs', array( $this, 'settings_tabs' ) );
		add_action( 'as3cf_after_settings', array( $this, 'settings_page' ) );

		// Custom theme & plugin support filter
		add_filter( 'as3cf_get_asset', array( $this, 'get_asset' ) );

		// Cron to scan files for S3 upload
		$this->scanning_cron_interval_in_minutes = apply_filters( 'as3cf_assets_cron_files_s3_interval', 5 );
		add_filter( 'as3cf_assets_setting_enable-cron', array( $this, 'cron_healthchecks' ) );
		add_filter( 'cron_schedules', array( $this, 'cron_schedules' ) );
		add_action( $this->scanning_cron_hook, array( $this, 'scan_files_for_s3' ) );
		add_action( 'switch_theme', array( $this, 'initiate_scan_files_for_s3' ) );
		add_action( 'activated_plugin', array( $this, 'initiate_scan_files_for_s3' ) );
		add_action( 'upgrader_process_complete', array( $this, 'initiate_scan_files_for_s3' ) );

		// Custom URL to scan files for S3
		$this->custom_endpoint = apply_filters( 'as3cf_assets_custom_endpoint', 'wpos3-assets-scan' );
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );

		// Serve files
		add_filter( 'style_loader_src', array( $this, 'serve_css_from_s3' ) );
		add_filter( 'script_loader_src', array( $this, 'serve_js_from_s3' ) );
		add_action( 'shutdown', array( $this, 'maybe_save_enqueued_files' ) );

		// AJAX handlers
		add_action( 'wp_ajax_as3cf-assets-save-bucket', array( $this, 'ajax_save_bucket' ) );
		add_action( 'wp_ajax_as3cf-assets-create-bucket', array( $this, 'ajax_create_bucket' ) );
		add_action( 'wp_ajax_as3cf-assets-manual-save-bucket', array( $this, 'ajax_save_bucket' ) );
		add_action( 'wp_ajax_as3cf-assets-get-buckets', array( $this, 'ajax_get_buckets' ) );
		add_action( 'wp_ajax_as3cf-assets-generate-key', array( $this, 'ajax_generate_key' ) );

		add_filter( 'plugin_action_links', array( $this, 'plugin_actions_settings_link' ), 10, 2 );
		add_filter( 'as3cf_diagnostic_info', array( $this, 'diagnostic_info' ) );

		load_plugin_textdomain( 'as3cf-assets', false, dirname( plugin_basename( $plugin_file_path ) ) . '/languages/' );

		// Async requests
		$this->scan_files_for_s3_request    = new AS3CF_Scan_Files_For_S3( $this );
		$this->remove_files_from_s3_request = new AS3CF_Remove_Files_From_S3( $this );

		// Process Assets
		$this->process_assets_background_process = new AS3CF_Process_Assets_Background_Process( $this );
		$this->process_assets                    = new AS3CF_Process_Assets( $this, $this->process_assets_background_process );

		// Minify
		$this->minify_background_process = new AS3CF_Minify_Background_Process( $this );
		$this->minify                    = new AS3CF_Minify( $this, $this->minify_background_process );

		// Purge S3 assets on upgrade, if required
		new AS3CF_Assets_Upgrade( $this );

		// Register tools
		$this->sidebar->register_tool( new Process_Assets( $this ), 'background' );
	}

	/**
	 * Load the addon
	 */
	public function load_addon() {
		$this->enqueue_style( 'as3cf-assets-styles', 'assets/css/styles', array( 'as3cf-styles' ) );
		$this->enqueue_script( 'as3cf-assets-script', 'assets/js/script', array( 'jquery', 'as3cf-pro-sidebar' ) );

		wp_localize_script( 'as3cf-assets-script', 'as3cf_assets', array(
				'strings'      => array(
					'generate_key_error' => __( 'Error getting new key: ', 'as3cf-assets' ),
					'copy_not_enabled'   => __( 'No CSS or JS is being served because "Copy & Serve" is off.', 'as3cf-assets' ),
				),
				'nonces'       => array(
					'create_bucket' => wp_create_nonce( 'as3cf-assets-create-bucket' ),
					'manual_bucket' => wp_create_nonce( 'as3cf-assets-manual-save-bucket' ),
					'save_bucket'   => wp_create_nonce( 'as3cf-assets-save-bucket' ),
					'get_buckets'   => wp_create_nonce( 'as3cf-assets-get-buckets' ),
					'generate_key'  => wp_create_nonce( 'as3cf-assets-generate-key' ),
				),
				'redirect_url' => $this->get_plugin_page_url( array( 'as3cf-assets-manual' => '1' ) ),
			) );

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
		$tabs['assets'] = _x( 'Assets', 'Show the Assets settings tab', 'as3cf-assets' );

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
	 * Get statistics on a scan's progress
	 *
	 * @return array|float
	 */
	public function get_scan_progress() {
		// We're not scanning or processing, return 0
		if ( ! $this->is_scanning() && ! $this->is_processing() ) {
			return 0;
		}

		$files = $this->count_files();

		// Only count unique file copy actions as remove's are generally paired with copy actions and require much less time.
		$to_process = array_unique(
			array_map(
				function ( $job ) {
					if ( 'copy' === $job['action'] ) {
						return $job['file'];
					}

					return null;
				},
				$this->process_assets->to_process()
			)
		);

		// There are no files to scan, return 0
		if ( 0 === $files ) {
			return 0;
		}

		// We have files to process, count them
		if ( false !== $to_process ) {
			$files_to_process = count( $to_process );
		} else {
			// There are no more files to scan, return 100
			return 100;
		}

		// Calculate the percentage processed
		$percent_left = ( min( $files_to_process, $files ) / $files ) * 100;
		$progress     = round( 100 - $percent_left, 2 );

		return $progress;
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
	public function get_settings_whitelist() {
		return array(
			'bucket',
			'region',
			'domain',
			'cloudfront',
			'enable-script-object-prefix',
			'object-prefix',
			'force-https',
			'enable-addon',
			'file-extensions',
			'enable-cron',
			'enable-custom-endpoint',
			'custom-endpoint-key',
			'enable-minify',
			'enable-minify-excludes',
			'minify-excludes',
			'enable-gzip',
		);
	}

	/**
	 * List of settings that should skip full sanitize.
	 *
	 * @return array
	 */
	function get_skip_sanitize_settings() {
		return array( 'minify-excludes' );
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
	public function get_setting( $key, $default = '' ) {
		global $as3cf;

		$settings = $this->get_settings();

		// Region
		if ( false !== ( $region = $this->get_setting_region( $settings, $key, $default ) ) ) {
			return $region;
		}

		if ( 'force-https' === $key && ! isset( $settings['force-https'] ) ) {
			return '0';
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
				'force-https',
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
	 * Is plugin enabled?
	 *
	 * @return bool
	 */
	public function is_plugin_enabled() {
		$enabled = false;

		if ( (bool) $this->get_setting( 'enable-addon' ) ) {
			$enabled = $this->is_plugin_setup();
		}

		return $enabled;
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
	 * Return an associative array of details for WP Core, theme and plugins.
	 *
	 * @return array
	 */
	protected function get_file_locations() {
		$locations_in_scope = apply_filters( 'as3cf_assets_locations_in_scope_to_scan', array(
			'admin',
			'core',
			'themes',
			'plugins',
			'mu-plugins',
		) );

		$locations = array();

		// wp-admin directory
		if ( in_array( 'admin', $locations_in_scope ) ) {
			$locations[] = array(
				'path'    => ABSPATH . 'wp-admin',
				'url'     => site_url( '/wp-admin' ),
				'type'    => 'admin',
				'object'  => '',
				'exclude' => apply_filters( 'as3cf_assets_admin_exclude_dirs', $this->get_exclude_dirs() ),
			);
		}

		// wp-includes directory
		if ( in_array( 'core', $locations_in_scope ) ) {
			$locations[] = array(
				'path'    => ABSPATH . WPINC,
				'url'     => site_url( '/' . WPINC ),
				'type'    => 'core',
				'object'  => '',
				'exclude' => apply_filters( 'as3cf_assets_core_exclude_dirs', $this->get_exclude_dirs() ),
			);
		}

		// Active theme(s)
		if ( in_array( 'themes', $locations_in_scope ) ) {
			$themes    = $this->get_active_themes();
			$locations = array_merge( $locations, $themes );
		}

		// Active plugins
		if ( in_array( 'plugins', $locations_in_scope ) ) {
			$plugins   = $this->get_plugins();
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
	 * Returns an array of distinct themes and child themes active on a site.
	 *
	 * @return array
	 */
	protected function get_active_themes() {
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
	 * Returns an array of plugins installed
	 *
	 * @return array
	 */
	function get_plugins() {
		$installed_plugins = array_keys( get_plugins() );
		$plugins           = array();
		$plugins_url       = plugins_url();

		foreach ( $installed_plugins as $plugin ) {
			$dir = dirname( $plugin );

			if ( '.' === $dir ) {
				// Ignore plugins not in a folder
				continue;
			}

			$plugins[ $plugin ] = array(
				'type'    => 'plugins',
				'exclude' => apply_filters( 'as3cf_assets_plugin_exclude_dirs', $this->get_exclude_dirs() ),
				'path'    => trailingslashit( WP_PLUGIN_DIR ) . $dir,
				'url'     => trailingslashit( $plugins_url ) . $dir,
				'object'  => basename( $plugin, '.php' ),
			);
		}

		return array_values( apply_filters( 'as3cf_assets_plugins_to_scan', $plugins ) );
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

		return $value;
	}

	/**
	 * Initiate an async request to scan files for S3
	 */
	public function initiate_scan_files_for_s3() {
		$this->unlock_all_scanning_locations();

		$this->scan_files_for_s3_request->dispatch();
	}

	/**
	 * Initiate an async request to remove files for S3 and clear our file cache
	 *
	 * @param array|null $settings
	 * @param bool       $scan_after_purge Start the scan again after removal?
	 */
	public function initiate_remove_files_from_s3( $settings = null, $scan_after_purge = false ) {
		if ( is_null( $settings ) ) {
			$settings = get_site_option( static::SETTINGS_KEY );
		}

		$data = array(
			'bucket' => isset( $settings['bucket'] ) ? $settings['bucket'] : $this->get_setting( 'bucket' ),
			'region' => isset( $settings['region'] ) ? $settings['region'] : '',
		);

		if ( $scan_after_purge ) {
			$data['scan'] = $scan_after_purge;
		}

		// Clear the script cache and remove files from S3
		// so we always copy and serve scripts from the new bucket
		$this->remove_files_from_s3_request->data( $data )->dispatch();
	}

	/**
	 * Creates properly formatted lock key given a base key and location.
	 *
	 * @param string     $lock_key
	 * @param array|null $location
	 *
	 * @return string
	 */
	private function generate_lock_key( $lock_key, $location = null ) {
		if ( is_array( $location ) && ! empty( $location['type'] ) ) {
			$suffix = sanitize_key( $location['type'] );
			$suffix .= empty( $location['object'] ) ? '' : sanitize_key( $location['object'] );
			$lock_key .= '_' . md5( $suffix );
		}

		return $lock_key;
	}

	/**
	 * Is the plugin scanning files for S3
	 *
	 * @param array|null $location
	 *
	 * @return bool
	 */
	public function is_scanning( $location = null ) {
		return (bool) get_site_transient( $this->generate_lock_key( $this->scanning_lock_key, $location ) );
	}

	/**
	 * Set scanning lockout.
	 *
	 * @param array|null $location
	 */
	private function lock_scanning( $location = null ) {
		set_site_transient( $this->generate_lock_key( $this->scanning_lock_key, $location ), true, $this->get_scanning_expiration( $location ) );
	}

	/**
	 * Remove scanning lockout.
	 *
	 * @param array|null $location
	 */
	private function unlock_scanning( $location = null ) {
		delete_site_transient( $this->generate_lock_key( $this->scanning_lock_key, $location ) );
	}

	/**
	 * Unlock all scanning locations.
	 */
	private function unlock_all_scanning_locations() {
		$locations = $this->get_file_locations();

		foreach ( $locations as $location ) {
			$this->unlock_scanning( $location );
		}
	}

	/**
	 * Get the number of seconds to expire the scanning lock transient
	 *
	 * @param array|null $location
	 *
	 * @return int
	 */
	private function get_scanning_expiration( $location = null ) {
		$seconds = MINUTE_IN_SECONDS * max( $this->scanning_cron_interval_in_minutes - 1, 1 );
		$seconds = $this->get_scanning_expiration_by_location( $seconds, $location );

		return apply_filters( 'as3cf_assets_scanning_expiration', $seconds, $location );
	}

	/**
	 * By default we scan admin & core at most every 30 mins, mu-plugins every 15 mins, everything else at default
	 * auto-scan interval.
	 *
	 * We return 29 mins for core, 14 for mu-plugins so that we don't accidentally overlap cron intervals by a second or
	 * so and therefore delay by a cron tick.
	 *
	 * @param integer    $seconds
	 * @param array|null $location
	 *
	 * @return int
	 */
	public function get_scanning_expiration_by_location( $seconds, $location = null ) {
		if ( is_array( $location ) && ! empty( $location['type'] ) ) {
			if ( in_array( $location['type'], array( 'admin', 'core' ) ) ) {
				return MINUTE_IN_SECONDS * 29;
			}

			if ( 'mu-plugins' === $location['type'] ) {
				return MINUTE_IN_SECONDS * 14;
			}
		}

		return $seconds;
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
	 * Set purging lockout.
	 */
	private function lock_purging() {
		set_site_transient( $this->purging_lock_key, true, $this->get_purging_expiration() );
	}

	/**
	 * Remove purging lockout.
	 */
	private function unlock_purging() {
		delete_site_transient( $this->purging_lock_key );
	}

	/**
	 * Get the number of seconds to expire the purging lock transient
	 *
	 * @return int
	 */
	private function get_purging_expiration() {
		return apply_filters( 'as3cf_assets_purging_expiration', MINUTE_IN_SECONDS * 10 );
	}

	/**
	 * Is there anything currently being processed?
	 *
	 * @return bool
	 */
	public function is_processing() {
		$to_process = $this->process_assets->to_process();

		return empty( $to_process ) ? false : true;
	}

	/**
	 * Scan the files we need to copy to S3 and maybe remove from S3
	 */
	public function scan_files_for_s3() {
		if ( ! $this->is_plugin_enabled() ) {
			return;
		}

		// Abort if already running the global scan or purging existing files
		if ( $this->is_scanning() || $this->is_purging() ) {
			return;
		}

		// Lock and cleanup after set period.
		$this->lock_scanning();

		$locations = $this->get_file_locations();

		foreach ( $locations as $location ) {
			$this->scan_files_for_s3_by_location( $location );

			// Force new batch per location as some are rather large.
			$this->process_assets_background_process->save();
		}

		// For each removed location add its files to a remove batch.
		$this->remove_files_for_redundant_locations( $locations );

		// Save the base url for core files
		$this->set_setting( 'base_url', site_url() );
		$this->save_settings();

		// Unlock scanning
		$this->unlock_scanning();
	}

	/**
	 * Scan the files we need to copy to S3 and maybe remove from S3 for a given location.
	 *
	 * @param array   $location
	 * @param boolean $unlock Force unlock of the scan location on completion of scan.
	 */
	public function scan_files_for_s3_by_location( $location, $unlock = false ) {
		if ( ! isset( $location['path'], $location['url'], $location['type'], $location['object'], $location['exclude'] ) ) {
			return;
		}

		if ( $this->is_scanning( $location ) ) {
			return;
		}

		$this->lock_scanning( $location );

		$saved_files      = $this->get_saved_files_by_location( $location );
		$found_files      = $this->get_found_files_by_location( $location, $saved_files );
		$files_to_process = $this->get_processable_files_by_location( $location, $saved_files, $found_files );

		$this->save_files( $found_files );

		if ( empty( $found_files ) ) {
			// Location empty, remove from location versions key
			$this->remove_location_version( $location );
		}

		if ( ! empty( $files_to_process ) ) {
			// Files to process, dispatch batch
			$this->process_assets->batch_process( $files_to_process );
		}

		if ( true === $unlock ) {
			$this->unlock_scanning( $location );
		}
	}

	/**
	 * Get found files by location.
	 *
	 * Finds all files in a location and merges the existing saved data
	 * for files scanned previously.
	 *
	 * @param array $location
	 * @param array $saved_files
	 *
	 * @return array
	 */
	private function get_found_files_by_location( $location, $saved_files ) {
		$path           = trailingslashit( $location['path'] );
		$url            = trailingslashit( $location['url'] );
		$extensions     = $this->get_file_extensions( $location );
		$exclusions     = isset( $location['exclude'] ) ? $location['exclude'] : array();
		$ignore_hidden  = apply_filters( 'as3cf_assets_ignore_hidden_dirs', true, $location );
		$location_files = $this->find_files_in_path( $path, $extensions, $exclusions, $ignore_hidden );
		$found_files    = array();

		foreach ( $location_files as $file => $object ) {
			$details = array(
				'url'           => str_replace( $path, $url, $file ),
				'base'          => str_replace( $path, '', $file ),
				'local_version' => filemtime( $file ),
				'type'          => $location['type'],
				'object'        => $location['object'],
				'extension'     => pathinfo( $file, PATHINFO_EXTENSION ),
				's3_version'    => 0,
				'location'      => $location['type'],
			);

			if ( apply_filters( 'as3cf_assets_ignore_file', false, $file, $details ) ) {
				continue;
			}

			if ( isset( $saved_files[ $file ] ) ) {
				$details['s3_version'] = $saved_files[ $file ]['s3_version'];

				if ( isset( $saved_files[ $file ]['s3_info'] ) ) {
					$details['s3_info'] = $saved_files[ $file ]['s3_info'];
				}
			}

			$found_files[ $file ] = $details;
		}

		return $found_files;
	}

	/**
	 * Get processable files by location.
	 *
	 * Files are processable if new or modified and are not in the failure queue.
	 *
	 * @param array $location
	 * @param array $saved_files
	 * @param array $found_files
	 *
	 * @return array
	 */
	private function get_processable_files_by_location( $location, $saved_files, $found_files ) {
		$files_processing = $this->process_assets->to_process();
		$files_to_process = array();
		$purge_location   = false;

		foreach ( $found_files as $file => $details ) {
			if ( $this->is_file_processing( $file, $files_processing ) ) {
				// File already queued for processing, skip
				continue;
			}

			if ( ! $this->is_file_processable( $file ) ) {
				// File in failure queue, skip
				continue;
			}

			if ( empty( $details['s3_version'] ) ) {
				// New file, push to queue
				$files_to_process = $this->add_to_process_queue( $files_to_process, 'copy', $file, $details );
			} elseif ( version_compare( $details['s3_version'], $details['local_version'], '!=' ) ) {
				// File modified, entire location needs purging
				$purge_location = true;

				break;
			}
		}

		if ( $purge_location ) {
			// Remove and add all location files
			$files_to_process = $this->remove_and_upload_all_files( $found_files );
		}

		// Remove files that no longer exist locally
		$files_to_process = $this->remove_old_files( $files_to_process, $found_files, $saved_files );

		// Add object version prefix, or update if files modified
		$this->set_object_version_prefix( $location['type'], $location['object'], $purge_location );

		return $files_to_process;
	}

	/**
	 * Remove and upload all files in current location.
	 *
	 * @param array $found_files
	 *
	 * @return array
	 */
	private function remove_and_upload_all_files( $found_files ) {
		$files_to_process = array();

		foreach ( $found_files as $file => $details ) {
			// Remove previous version from S3
			if ( ! empty( $details['s3_version'] ) ) {
				$files_to_process = $this->add_to_process_queue( $files_to_process, 'remove', $file, $details );
			}

			// Upload new version to S3
			$files_to_process = $this->add_to_process_queue( $files_to_process, 'copy', $file, $details );
		}

		return $files_to_process;
	}

	/**
	 * Remove files that don't exist locally anymore.
	 *
	 * @param array $files_to_process
	 * @param array $found_files
	 * @param array $saved_files
	 *
	 * @return array
	 */
	private function remove_old_files( $files_to_process, $found_files, $saved_files ) {
		if ( empty( $saved_files ) ) {
			return $files_to_process;
		}

		foreach ( $saved_files as $file => $details ) {
			if ( ! isset( $found_files[ $file ] ) ) {
				$files_to_process = $this->add_to_process_queue( $files_to_process, 'remove', $file, $details );
			}
		}

		return $files_to_process;
	}

	/**
	 * Add new action to processing queue.
	 *
	 * @param array  $files_to_process
	 * @param string $action
	 * @param string $file
	 * @param array  $details
	 *
	 * @return array
	 */
	private function add_to_process_queue( $files_to_process, $action, $file, $details ) {
		switch ( $action ) {
			case 'copy':
				$files_to_process[] = array(
					'action' => 'copy',
					'file'   => $file,
					'type'   => $details['type'],
					'object' => $details['object'],
				);
				break;
			case 'remove':
				$files_to_process[] = array(
					'action' => 'remove',
					'url'    => $details['url'],
					'key'    => $details['s3_info']['key'],
				);
				break;
		}

		return $files_to_process;
	}

	/**
	 * Remove location version.
	 *
	 * @param array $location
	 */
	private function remove_location_version( $location ) {
		$location_versions = $this->get_location_versions();

		if ( empty( $location['object'] ) ) {
			// Unset location
			unset( $location_versions[ $location['type'] ] );
		} else {
			// Unset object
			unset( $location_versions[ $location['type'] ][ $location['object'] ] );
		}

		$this->update_site_option( static::LOCATION_VERSIONS_KEY, $location_versions );
	}

	/**
	 * Analyse current locations and create batch to remove S3 files from redundant locations.
	 *
	 * @param array $locations
	 */
	private function remove_files_for_redundant_locations( $locations ) {
		$location_versions     = $this->get_location_versions( false );
		$new_location_versions = $location_versions;

		if ( false === $location_versions ) {
			return;
		}

		// Turn current locations into same array key format as location versions record.
		$current_locations = array_reduce(
			$locations,
			function ( $carry, $location ) {
				$carry[ $location['type'] ][ $location['object'] ] = $location;

				return $carry;
			},
			array()
		);

		// Build list of location versions that no longer exist.
		$removed_locations = array();

		foreach ( $location_versions as $type => $objects ) {
			if ( ! array_key_exists( $type, $current_locations ) ) {
				$removed_locations[ $type ] = $objects;
				unset ( $new_location_versions[ $type ] );
			} else {
				foreach ( $objects as $object => $version ) {
					if ( ! array_key_exists( $object, $current_locations[ $type ] ) ) {
						$removed_locations[ $type ][ $object ] = $version;
						unset ( $new_location_versions[ $type ][ $object ] );
					}
				}
			}
		}

		if ( empty( $removed_locations ) ) {
			return;
		}

		// Remove files from S3 where their location has gone away.
		foreach ( $removed_locations as $type => $objects ) {
			foreach ( $objects as $object => $version ) {
				$files_to_process = array();
				$removed_files    = get_site_option( $this->file_locations_key( $type, $object ), array() );

				foreach ( $removed_files as $file => $details ) {
					if ( ! empty( $details['s3_version'] ) && ! empty( $details['s3_info'] ) ) {
						$files_to_process[] = array(
							'action' => 'remove',
							'url'    => $details['url'],
							'key'    => $details['s3_info']['key'],
						);
					}
				}

				$this->process_assets->batch_process( $files_to_process );

				// Remove our record of the location's files on S3.
				delete_site_option( $this->file_locations_key( $type, $object ) );
			}
		}

		// Update location versions with redundant versions removed.
		$this->update_site_option( static::LOCATION_VERSIONS_KEY, $new_location_versions );
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
	protected function get_url_scheme( $url ) {
		$src_parts      = AS3CF_Utils::parse_url( $url );
		$https          = $this->get_setting( 'force-https' );
		$default_scheme = is_ssl() ? 'https' : 'http';

		if ( ! isset( $src_parts['host'] ) ) {
			// not a URL, just path to file
			$scheme = $default_scheme;
		} else {
			// respect the scheme of the src URL
			$scheme = isset( $src_parts['scheme'] ) ? $src_parts['scheme'] : '';
		}

		if ( '1' === $https ) {
			$scheme = 'https';
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
	function remove_files_from_s3( $files, $bucket = null, $region = null, $log_error = false ) {
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
				$key       = $this->minify->prefix_key( $details['s3_info']['key'] );
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

		// Lock and cleanup after set period.
		$this->lock_purging();

		// Get all files to remove from the existing bucket
		$files = $this->get_files();

		if ( ! empty( $files ) ) {
			foreach ( $files as $location_files ) {
				$this->remove_files_from_s3( $location_files, $bucket, $region, $log_error );
			}
		}

		// Remove the cached files and scripts
		delete_site_option( self::FILES_SETTINGS_KEY );
		delete_site_option( self::ENQUEUED_SETTINGS_KEY );
		delete_site_option( self::LOCATION_VERSIONS_KEY );
		delete_site_option( self::FAILURES_KEY );

		// Remove any location specific scan locks.
		$this->unlock_all_scanning_locations();

		// Remove all location-based file keys
		$locations = $this->get_file_locations();
		foreach ( $locations as $location ) {
			delete_site_option( $this->file_locations_key( $location['type'], $location['object'] ) );
		}

		// Clear failure notices
		foreach ( array( 'gzip', 'minify', 'upload' ) as $type ) {
			$this->notices->remove_notice_by_id( "assets_{$type}_failure" );
		}

		$this->unlock_purging();

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
			$prefix = AS3CF_Utils::trailingslash_prefix( $prefix );
		}

		$prefix .= trailingslashit( $details['type'] );
		if ( '' !== $details['object'] ) {
			$prefix .= trailingslashit( $details['object'] );
		}

		$version = $this->get_object_version_prefix( $details['type'], $details['object'] );
		$prefix  .= trailingslashit( $version );

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
			$this->location_versions = $this->get_location_versions( false );
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
	 * @param bool   $update
	 *
	 * @return string
	 */
	public function set_object_version_prefix( $type, $object, $update = false ) {
		if ( is_null( $this->location_versions ) ) {
			$this->location_versions = $this->get_location_versions( false );
		}

		if ( ! $update && isset( $this->location_versions[ $type ][ $object ] ) ) {
			return $this->location_versions[ $type ][ $object ];
		}

		$this->location_versions[ $type ][ $object ] = date( 'YmdHis' );
		$this->update_site_option( static::LOCATION_VERSIONS_KEY, $this->location_versions );

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
	 * Maybe save enqueued files.
	 */
	public function maybe_save_enqueued_files() {
		if ( empty( $this->files_to_enqueue ) ) {
			// Nothing to save, return
			return;
		}

		$this->save_enqueued_files( array_merge_recursive( $this->get_enqueued_files(), $this->files_to_enqueue ) );
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
		if ( is_admin() || ! $this->get_setting( 'enable-addon' ) ) {
			return $src;
		}

		$files = $this->get_files();

		if ( ! $files ) {
			// We haven't scanned any scripts to replace
			return $src;
		}

		$url_parts = AS3CF_Utils::parse_url( $src );
		$host_url  = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] );
		$location  = AS3CF_Utils::parse_url( $host_url );

		if ( isset( $url_parts['host'] ) ) {
			$src_host_length  = strlen( $url_parts['host'] );
			$http_host_domain = substr( $location['host'], 0 - $src_host_length, $src_host_length );

			// Test for scripts served by subdomain subsites in multistie
			// They must have the same domain as the $_SERVER['HTTP_HOST']
			if ( $http_host_domain != $url_parts['host'] ) {
				// External script, ignore

				return $src;
			}
		}

		// Get file absolute path
		$path   = $this->get_file_absolute_path( $src );
		$script = false;

		// Find file's details.
		foreach ( $files as $location_files ) {
			if ( array_key_exists( $path, $location_files ) ) {
				$details = $location_files[ $path ];

				// Location still processing, don't enqueue S3 link
				$locations_processing = $this->get_locations_processing();
				if ( in_array( $details['object'], $locations_processing ) ) {
					return $src;
				}

				$script = $details;

				// Is file already enqueued?
				$enqueued_scripts = $this->get_enqueued_files();
				if ( ! isset( $enqueued_scripts[ $script_type ][ $path ] ) ) {
					// Add the script to the 'enqueued_scripts' mapping for the future
					$this->files_to_enqueue[ $script_type ][ $path ] = array();
				}

				break;
			}
		}
		unset( $files, $locations_processing, $enqueued_scripts );

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
				$expires    = time() + apply_filters( 'as3cf_assets_expires', $expires );
				$secure_url = $this->get_s3client( $region )->getObjectUrl( $bucket, $key, $expires );
			} catch ( Exception $e ) {
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
	 * Get location versions.
	 *
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	protected function get_location_versions( $default = array() ) {
		return get_site_option( static::LOCATION_VERSIONS_KEY, $default );
	}

	/**
	 * Get locations processing
	 *
	 * @return array
	 */
	function get_locations_processing() {
		$locations = array();

		if ( ! ( $files = $this->process_assets->to_process() ) ) {
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
	 * Is file processing.
	 *
	 * @param string     $file
	 * @param null|array $files_processing
	 *
	 * @return bool
	 */
	public function is_file_processing( $file, $files_processing = null ) {
		if ( is_null( $files_processing ) ) {
			$files_processing = $this->process_assets->to_process();
		}

		foreach ( $files_processing as $file_processing ) {
			if ( ! isset( $file_processing['file'] ) ) {
				continue;
			}

			if ( $file === $file_processing['file'] ) {
				return true;
			}
		}

		return false;
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

		$this->update_site_option( self::FAILURES_KEY, $current );
	}

	/**
	 * Get file absolute path
	 *
	 * @param string $url
	 *
	 * @return mixed
	 */
	public function get_file_absolute_path( $url ) {
		global $wp_scripts;

		$url = $this->maybe_fix_local_subsite_url( $url );
		$url = $this->get_url_without_scheme( preg_replace( '@\?.*@', '', $url ) );

		$content_url = $this->maybe_fix_local_subsite_url( $wp_scripts->content_url );
		$content_url = $this->get_url_without_scheme( $content_url );

		if ( 0 === strpos( $url, $content_url ) ) {
			$base_path = untrailingslashit( WP_CONTENT_DIR );
			$base_url  = untrailingslashit( $content_url );
		} else {
			$base_path = untrailingslashit( ABSPATH );
			$base_url  = untrailingslashit( $this->get_url_without_scheme( $wp_scripts->base_url ) );
		}

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
		if ( ! is_null( $this->files ) ) {
			return $this->files;
		}

		$files = array();

		// Get all available locations
		$locations = $this->get_file_locations();

		// Add the files from each location into our files array
		foreach ( $locations as $location ) {
			$location_files = $this->get_saved_files_by_location( $location );

			if ( false === $location_files ) {
				continue;
			}

			$files[ $this->get_location_key( $location ) ] = $location_files;
		}

		$this->files = $files;

		return $files;
	}

	/**
	 * Get location key.
	 *
	 * @param array $location
	 *
	 * @return string
	 */
	public function get_location_key( $location ) {
		$key = $location['type'];

		if ( ! empty( $location['object'] ) ) {
			$key .= '.' . $location['object'];
		}

		return $key;
	}

	/**
	 * Count saved files.
	 *
	 * @return int
	 */
	public function count_files() {
		if ( ! is_null( $this->files_count ) ) {
			return $this->files_count;
		}

		$saved_files = $this->get_files();
		$count       = 0;

		foreach ( $saved_files as $location_files ) {
			$count += count( $location_files );
		}

		$this->files_count = $count;

		return $count;
	}

	/**
	 * Returns an array of files for the given location, or false if non saved for location.
	 *
	 * @param array $location
	 *
	 * @return bool|array
	 */
	public function get_saved_files_by_location( $location ) {
		if ( empty( $location['type'] ) ) {
			return false;
		}

		$location_versions = $this->get_location_versions();

		if ( empty( $location['object'] ) && ! isset( $location_versions[ $location['type'] ] ) ) {
			// Location has no assets, return
			return false;
		}

		if ( ! isset( $location_versions[ $location['type'] ][ $location['object'] ] ) ) {
			// Object has no assets, return
			return false;
		}

		return get_site_option( $this->file_locations_key( $location['type'], $location['object'] ) );
	}

	/**
	 * Save files
	 *
	 * @param array $files
	 */
	public function save_files( $files ) {
		$locations = array();

		// Re-assign files into a location-based array
		foreach ( $files as $file => $details ) {
			if ( ! isset( $details['location'] ) ) {
				continue;
			}

			$locations[ $this->file_locations_key( $details['location'], $details['object'] ) ][ $file ] = $details;
		}

		// Update the key for each location that has files
		foreach ( $locations as $location_key => $location_files ) {
			$this->update_site_option( $location_key, $location_files );
		}

		// Clear saved files cache
		$this->files = null;
	}

	/**
	 * Build the key string for a location
	 *
	 * @param string $location Location type
	 * @param string $object
	 *
	 * @return string Option key
	 */
	private function file_locations_key( $location, $object ) {
		return self::FILES_SETTINGS_KEY . '_' . md5( trim( $location ) . trim( $object ) );
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
		$this->update_site_option( self::ENQUEUED_SETTINGS_KEY, $files );
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

		$this->update_site_option( self::FAILURES_KEY, $failures );

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
	 * Is file processable.
	 *
	 * @param string $file
	 *
	 * @return bool
	 */
	public function is_file_processable( $file ) {
		if ( ! $this->is_failure( 'gzip', $file ) && ! $this->is_failure( 'upload', $file ) ) {
			// File not in failure queue, processable
			return true;
		}

		if ( $this->is_failure( 'gzip', $file, true ) || $this->is_failure( 'upload', $file, true ) ) {
			// File in failure queue but time limit reached, processable
			return true;
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
			'type'              => 'error',
			'flash'             => false,
			'only_show_to_user' => false,
			'only_show_on_tab'  => 'assets',
			'custom_id'         => $id,
			'show_callback'     => array( 'as3cf_assets', 'failure_' . $type . '_notice_callback' ),
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
	 * @param string $utm_content
	 *
	 * @return string
	 */
	public function assets_more_info_link( $hash, $utm_content = '' ) {
		return $this->more_info_link( '/wp-offload-s3/doc/assets-addon-settings/', $utm_content, $hash );
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
			foreach ( $type as $file => $details ) {
				if ( isset( $details['minified'] ) && $details['minified'] ) {
					$minified[] = $file;
				}
			}
		}

		if ( ! $absolute_path ) {
			foreach ( $minified as $key => $value ) {
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
	public function diagnostic_info( $output = '' ) {
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
		$output .= 'Force HTTPS: ';
		$output .= $this->on_off( 'force-https' );
		$output .= "\r\n";
		$output .= 'File Extensions: ';
		$output .= $this->get_setting( 'file-extensions' );
		$output .= "\r\n";
		$output .= 'Minify: ';
		$output .= $this->on_off( 'enable-minify' );
		$output .= "\r\n";
		$output .= 'Exclude Files From Minify: ';
		$output .= $this->on_off( 'enable-minify-excludes' );
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

		if ( $count = $this->count_files() ) {
			$output .= 'Scanned Files: ';
			$output .= $count;
			$output .= "\r\n";
		}

		if ( $processing = $this->process_assets->to_process() ) {
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

		if ( $this->get_setting( 'enable-minify' ) && $this->get_setting( 'enable-minify-excludes' ) ) {
			$output .= "\r\n";
			$output .= 'Minify Excludes: ';
			$output .= "\r\n";
			$output .= $this->get_setting( 'minify-excludes' );
			$output .= "\r\n\r\n";
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

	/**
	 * Takes a local URL and returns the S3 equivalent if it exists.
	 *
	 * @param string $local_url
	 *
	 * @return string
	 */
	public function get_asset( $local_url ) {
		$type = pathinfo( $local_url, PATHINFO_EXTENSION );

		if ( ! empty( $type ) ) {
			return $this->serve_from_s3( $type, $local_url );
		}

		return $local_url;
	}

	/**
	 * Get array of extensions to scan and upload.
	 *
	 * @param array $location
	 *
	 * @return array|string|bool
	 */
	private function get_file_extensions( $location ) {
		$extensions = $this->get_setting( 'file-extensions' );
		$extensions = str_replace( array( '.', ' ' ), '', $extensions );
		$extensions = explode( ',', $extensions );
		$extensions = apply_filters( 'as3cf_assets_file_extensions', $extensions, $location );

		return $extensions;
	}

	/**
	 * Get next scan time.
	 *
	 * @return false|int
	 */
	public function get_next_scan_time() {
		return wp_next_scheduled( $this->scanning_cron_hook );
	}
}
