<?php
/**
Plugin Name: WP Hummingbird
Version: 1.3.5
Plugin URI:  https://premium.wpmudev.org/project/1081721/
Description: Hummingbird zips through your site finding new ways to make it load faster, from file compression and minification to browser caching – because when it comes to pagespeed, every millisecond counts.
Author: WPMU DEV
Author URI: http://premium.wpmudev.org
Network: true
Text Domain: wphb
Domain Path: /languages/
WDP ID: 1081721
*/

/*
Copyright 2007-2016 Incsub (http://incsub.com)
Author – Ignacio Cruz (igmoweb), Ricardo Freitas (rtbfreitas)
Contributors –

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 – GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

define( 'WPHB_VERSION', '1.3.5' );
/**
 * Class WP_Hummingbird
 *
 * Main Plugin class. Acts as a loader of everything else and intializes the plugin
 */
class WP_Hummingbird {

	/**
	 * Plugin instance
	 *
	 * @var null
	 */
	private static $instance = null;

	/**
	 * Admin main class
	 *
	 * @var WP_Hummingbird_Admin
	 */
	public $admin;

	/**
	 * @var WP_Hummingbird_Core
	 */
	public $core;

	/**
	 * Return the plugin instance
	 *
	 * @return WP_Hummingbird
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}


		return self::$instance;
	}

	public function __construct() {
		$this->includes();
		$this->init();

		if ( is_admin() ) {
			WP_Hummingbird_Installer::maybe_upgrade();
		}

		$this->load_textdomain();

		add_action( 'init', array( $this, 'maybe_clear_all_cache' ) );

	}

	public function maybe_clear_all_cache() {
		if ( isset( $_GET['wphb-clear'] ) && current_user_can( wphb_get_admin_capability() ) ) {
			wphb_flush_cache();

			delete_site_option( 'wphb-last-report-score' );

			if ( 'all' === $_GET['wphb-clear'] ) {
				wphb_update_settings( wphb_get_default_settings() );
			}

			if ( wphb_is_htaccess_written( 'gzip' ) ) {
				wphb_unsave_htaccess( 'gzip' );
			}

			if ( wphb_is_htaccess_written( 'caching' ) ) {
				wphb_unsave_htaccess( 'caching' );
			}

			wp_redirect( remove_query_arg( 'wphb-clear' ) );
			exit;
		}
	}

	private function load_textdomain() {
		load_plugin_textdomain( 'wphb', false, 'wp-hummingbird/languages' );
	}

	/**
	 * Load needed files for the plugin
	 */
	private function includes() {
		// Core files
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'core/class-installer.php' );
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'core/class-core.php' );
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'core/integration.php' );

		// Helpers files
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'helpers/wp-hummingbird-helpers-core.php' );
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'helpers/wp-hummingbird-helpers-cache.php' );
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'helpers/wp-hummingbird-helpers-settings.php' );
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'helpers/wp-hummingbird-helpers-modules.php' );


		if ( is_admin() ) {
			// Load only admin files
			/** @noinspection PhpIncludeInspection */
			include_once( wphb_plugin_dir() . 'admin/class-admin.php' );
		}

		// Dashboard Shared UI Library
		require_once( wphb_plugin_dir() . 'externals/shared-ui/plugin-ui.php');

		//load dashboard notice
		global $wpmudev_notices;
		$wpmudev_notices[] = array(
			'id'      => 1081721,
			'name'    => 'WP Hummingbird',
			'screens' => array(
				'toplevel_page_wphb',
				'hummingbird_page_wphb-performance',
				'hummingbird_page_wphb-minification',
				'hummingbird_page_wphb-caching',
				'hummingbird_page_wphb-gzip',
				'hummingbird_page_wphb-uptime'
			)
		);
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . '/externals/dash-notice/wpmudev-dash-notification.php' );

	}

	/**
	 * Initialize the plugin
	 */
	private function init() {
		// Initialize the plugin core
		$this->core = new WP_Hummingbird_Core();

		if ( is_admin() ) {
			// Initialize admin core files
			$this->admin = new WP_Hummingbird_Admin();
		}


		/**
		 * Triggered when WP Hummingbird is totally loaded
		 */
		do_action( 'wp_hummingbird_loaded' );
	}
}


function wp_hummingbird() {
	return WP_Hummingbird::get_instance();
}

/**
 * Get Current username info
 */
function wphb_get_current_user_info() {

	$current_user = wp_get_current_user();

	if ( !($current_user instanceof WP_User) )
    	return false;

	if ( ! empty( $current_user->user_firstname ) ) { // First we try to grab user First Name
		$display_name = $current_user->user_firstname;
	} else { // Grab user nicename
		$display_name = $current_user->user_nicename;
	}

	return $display_name;

}

/**
 * Init the plugin and load the plugin instance for the first time
 */
add_action( 'plugins_loaded', 'wp_hummingbird' );

/**
 * Return WP Hummingbird plugin URL
 *
 * @return string
 */
function wphb_plugin_url() {
	return trailingslashit( plugin_dir_url( __FILE__ ) );
}

/**
 * Return WP Hummingbird plugin path
 *
 * @return string
 */
function wphb_plugin_dir() {
	return trailingslashit( plugin_dir_path( __FILE__ ) );
}


/**
 * Activate the plugin
 */
function wphb_activate() {
	if ( ! class_exists( 'WP_Hummingbird_Installer' ) ) {
		include_once( 'core/class-installer.php' );
	}
	WP_Hummingbird_Installer::activate();
}
register_activation_hook( __FILE__, 'wphb_activate' );


/**
 * Deactivate the plugin
 */
function wphb_deactivate() {
	if ( ! class_exists( 'WP_Hummingbird_Installer' ) ) {
		include_once( 'core/class-installer.php' );
	}
	WP_Hummingbird_Installer::deactivate();
}
register_deactivation_hook( __FILE__, 'wphb_deactivate' );