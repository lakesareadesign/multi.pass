<?php
/**
 * @author: WPMUDEV, Ignacio Cruz (igmoweb)
 * @version:
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Hummingbird_Installer' ) ) {
	/**
	 * Class WP_Hummingbird_Installer
	 *
	 * Manages activation/deactivation and upgrades of Hummingbird
	 */
	class WP_Hummingbird_Installer {

		/**
		 * Plugin activation
		 */
		public static function activate() {
			if ( ! defined( 'WPHB_ACTIVATING' ) ) {
				define( 'WPHB_ACTIVATING', true );
			}

			/** @noinspection PhpIncludeInspection */
			include_once( wphb_plugin_dir() . 'helpers/wp-hummingbird-helpers-core.php' );
			/** @noinspection PhpIncludeInspection */
			include_once( wphb_plugin_dir() . 'helpers/wp-hummingbird-helpers-settings.php' );
			/** @noinspection PhpIncludeInspection */
			include_once( wphb_plugin_dir() . 'helpers/wp-hummingbird-helpers-cache.php' );
			/** @noinspection PhpIncludeInspection */
			include_once( wphb_plugin_dir() . 'helpers/wp-hummingbird-helpers-modules.php' );
			/** @noinspection PhpIncludeInspection */
			include_once( wphb_plugin_dir() . 'core/class-abstract-module.php' );
			/** @noinspection PhpIncludeInspection */
			include_once( wphb_plugin_dir() . 'core/modules/class-module-uptime.php' );
			/** @noinspection PhpIncludeInspection */
			include_once( wphb_plugin_dir() . 'core/modules/class-module-cloudflare.php' );

			wphb_include_file_cache_class();

			$model = wphb_get_model();
			$model->create_minification_chart_table();

			// Check if Uptime is active in the server
			if ( WP_Hummingbird_Module_Uptime::is_remotely_enabled() ) {
				WP_Hummingbird_Module_Uptime::enable_locally();
			}
			else {
				WP_Hummingbird_Module_Uptime::disable_locally();
			}

			if ( wphb_is_member() ) {
				// Try to get a performance report
				wphb_performance_init_scan();
				wphb_performance_set_doing_report( true );
			}

			update_site_option( 'wphb_version', WPHB_VERSION );

			wphb_has_cloudflare( true );
		}

		/**
		 * Plugin activation in a blog (if the site is a multisite)
		 */
		public static function activate_blog() {
			/** @noinspection PhpIncludeInspection */
			include_once( wphb_plugin_dir() . 'helpers/wp-hummingbird-helpers-core.php' );
			/** @noinspection PhpIncludeInspection */
			include_once( wphb_plugin_dir() . 'helpers/wp-hummingbird-helpers-cache.php' );
			wphb_include_file_cache_class();

			// Create cache folders
			$created = WP_Hummingbird_Cache_File::create_cache_folder();

			$model = wphb_get_model();
			$model->create_minification_chart_table();

			if ( ! $created ) {
				// Something went wrong
				update_option( 'wphb_cache_folder_error', true );
			}
			else {
				delete_option( 'wphb_cache_folder_error' );
			}

			update_option( 'wphb_version', WPHB_VERSION );
		}

		/**
		 * Plugin deactivation
		 */
		public static function deactivate() {
			wphb_flush_cache( false );
			delete_site_option( 'wphb_version' );
			delete_option( 'wphb_cache_folder_error' );
			delete_option( 'wphb-minification-check-files' );
			delete_site_option( 'wphb-last-report' );
			delete_site_option( 'wphb-last-report-score' );
			delete_site_option( 'wphb-server-type' );
			delete_site_transient( 'wphb-uptime-last-report' );
			delete_site_option( 'wphb-is-cloudflare' );
			wphb_cloudflare_disconnect();
		}

		/**
		 * Plugin upgrades
		 */
		public static function maybe_upgrade() {
			if ( defined( 'WPHB_ACTIVATING' ) ) {
				// Avoid to execute this over an over in same thread execution
				return;
			}

			if ( defined( 'WPHB_UPGRADING' ) && WPHB_UPGRADING ) {
				return;
			}

			$version = get_site_option( 'wphb_version' );

			if ( false === $version ) {
				self::activate();
				if ( ! is_multisite() ) {
					self::activate_blog();
				}
			}

			if ( is_multisite() ) {
				$blog_version = get_option( 'wphb_version' );
				if ( false === $blog_version ) {
					self::activate_blog();
				}
			}

			if ( $version != WPHB_VERSION ) {

				define( 'WPHB_UPGRADING', true );

				if ( version_compare( $version, '1.0-RC-7', '<' ) ) {
					delete_site_option( 'wphb-server-type' );
				}

				if ( version_compare( $version, '1.1', '<' ) ) {
					$options = wphb_get_settings();
					$defaults = wphb_get_default_settings();

					if ( isset ( $options['caching_expiry_css/javascript'] ) ) {
						$options['caching_expiry_css'] = $options['caching_expiry_css/javascript'];
						$options['caching_expiry_javascript'] = $options['caching_expiry_css/javascript'];
						unset( $options['caching_expiry_css/javascript'] );
					}
					else {
						$options['caching_expiry_css'] = $defaults['caching_expiry_css'];
						$options['caching_expiry_javascript'] = $defaults['caching_expiry_javascript'];
					}

					wphb_update_settings( $options );
					$module = new WP_Hummingbird_Module_Caching( 'caching', 'caching' );
					$module->get_analysis_data( true );
				}

				if ( version_compare( $version, '1.1.1', '<' ) ) {
					$options = wphb_get_setting( 'network_version' );
					if ( empty( $options ) ) {
						wphb_update_settings( wphb_get_default_settings() );
					}
				}

				if ( version_compare( $version, '1.3', '<' ) ) {
					wphb_has_cloudflare( true );
				}

				update_site_option( 'wphb_version', WPHB_VERSION );
			}
		}
	}
}