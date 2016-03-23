<?php
/**
 * Plugin Name: WP Defender
 * Plugin URI: https://premium.wpmudev.org/project/wp-defender/
 * Version:     1.0.3
 * Description: Get regular security scans, vulnerability reports, safety recommendations and customized hardening for your site in just a few clicks. Defender is the analyst and enforcer who never sleeps.
 * Author:      WPMU DEV
 * Author URI:  http://premium.wpmudev.org/
 * WDP ID:      1081723
 * License:     GNU General Public License (Version 2 - GPLv2)
 * Text Domain: wpdef
 * Network: true
 */

/**
 * @copyright Incsub (http://incsub.com/)
 *
 * Authors: Hoang Ngo, Aaron Edwards
 *
 * @license http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston,
 * MA 02110-1301 USA
 */

if ( ! defined( 'WD_STRESS_SCAN' ) ) {
	define( 'WD_STRESS_SCAN', 0 );
}

if ( ! defined( 'WD_DEBUG_LOG' ) ) {
	define( 'WD_DEBUG_LOG', 0 );
}

class WP_Defender {
	const INDEX_CONTROLLER = 'controllers', INDEX_MODULE_MANAGER = 'module_manager';
	/**
	 * Singleton instance of the plugin.
	 *
	 * @var WP_Defender
	 * @access private
	 * @since 1.0
	 */
	private static $_instance;
	/**
	 * @var string
	 */
	private $plugin_path;
	/**
	 * @var string
	 */
	private $plugin_url;
	/**
	 * @var string
	 */
	public $domain = 'wpdef';
	/**
	 * @var array
	 */
	public $global = array();

	/**
	 * @var string
	 */
	private $version = "1.0.3";

	/**
	 * @var string
	 */
	public $db_version = '1.0.2';

	/**
	 * @var string
	 */
	public $slug = 'wp-defender/wp-defender.php';

	/**
	 * must be *db* if in production, else it can be *file*, the log file will be appear inside the /vault folder
	 * @var string
	 */
	public $log_type = 'file';

	/**
	 * this will cache all the files structure in plugin scope
	 * @var array
	 */
	public $files_mapped = array();

	/**
	 * plugin constructor
	 *
	 * @access private
	 * @since 1.0
	 */
	private function __construct() {
		/**
		 * init plugin parameters
		 */
		$this->plugin_path = plugin_dir_path( __FILE__ );
		$this->plugin_url  = plugin_dir_url( __FILE__ );

		$this->includes();

		spl_autoload_register( array( $this, 'class_loader' ) );
		add_action( 'init', array( &$this, 'init' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_action( 'plugins_loaded', array( &$this, 'register_language_hook' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( &$this, 'add_settings_link' ) );
		add_action( 'wp_loaded', array( &$this, 'maybe_upgrade' ), 9999 );
	}

	/**
	 * enqueue scripts/styles
	 */
	public function enqueue_scripts() {
		//todo merge into one
		wp_enqueue_style( 'wp-defender-icon', $this->plugin_url . 'assets/defender-icon.css', array(), $this->version );
		wp_register_style( 'wp-defender', $this->plugin_url . 'assets/wp-defender.css', array(), $this->version );
		wp_register_script( 'wp-defender', $this->plugin_url . 'assets/javascripts/wp-defender.js', array(
			'jquery',
			'jquery-color'
		), $this->version );
		wp_register_script( 'wd-rotate', $this->plugin_url . 'assets/javascripts/jquery.rotate.js', array( 'wp-defender' ), $this->version );
		wp_register_script( 'wd-confirm', $this->plugin_url . 'assets/javascripts/wd-confirm.js', array( 'wp-defender' ), $this->version );
		wp_register_script( 'wd-tag', $this->plugin_url . 'assets/jquery.textext/js/textext.core.js', array( 'wp-defender' ), $this->version );
		wp_register_script( 'wd-tag-plugin', $this->plugin_url . 'assets/jquery.textext/js/textext.plugin.tags.js', array( 'wp-defender' ), $this->version );
		wp_register_script( 'wd-highlight', $this->plugin_url . 'assets/javascripts/highlight.pack.js' );
	}

	public function maybe_upgrade() {
		$db_version = get_site_option( 'wd_db_version' );
		if ( $db_version == false || version_compare( $db_version, $this->db_version, '<' ) ) {
			//from version 1.0.2, we clean up the htaccess
			//need to check if has httacces in wp-include
			$hardeners = WD_Hardener_Module::find_controller( 'hardener' );
			$rules     = $hardeners->get_loaded_modules();
			foreach ( $rules as $rule ) {
				if ( $rule->id == 'protect_core_dir' ) {
					$done_all = true;
					$path     = ABSPATH . WPINC . '/.htaccess';
					if ( file_exists( $path ) ) {
						if ( $rule->revert( $path, true ) !== true ) {
							$done_all = false;

							return;
						}
					}
					$path = WP_CONTENT_DIR . '/.htaccess';
					if ( file_exists( $path ) ) {
						if ( $rule->revert( $path, true ) !== true ) {
							$done_all = false;

							return;
						}
					}

					if ( $done_all == true ) {
						update_site_option( 'wd_db_version', $this->db_version );
					}
				}
			}
		}
	}

	public function add_settings_link( $links ) {
		$mylinks = array(
			'<a href="' . admin_url( 'admin.php?page=wdf-settings' ) . '">' . __( "Settings", wp_defender()->domain ) . '</a>',
		);

		return array_merge( $mylinks, $links );
	}

	public function register_language_hook() {
		load_plugin_textdomain( $this->domain, false, $this->plugin_path . '\languages' );
	}

	protected function includes() {
		require_once $this->plugin_path . 'shared-ui/plugin-ui.php';
		include_once $this->plugin_path . 'app/class-wd-utils.php';
		include_once $this->plugin_path . 'app/class-wd-component.php';

		//load dashboard notice
		global $wpmudev_notices;
		$wpmudev_notices[] = array(
			'id'      => 1081723,
			'name'    => 'WP Defender',
			'screens' => array(
				'toplevel_page_wp-defender',
				'toplevel_page_wp-defender-network',
				'defender_page_wdf-settings',
				'defender_page_wdf-settings-network',
				'defender_page_wdf-backup',
				'defender_page_wdf-backup-network',
				'defender_page_wdf-logging',
				'defender_page_wdf-logging-network',
				'defender_page_wdf-hardener',
				'defender_page_wdf-hardener-network',
				'defender_page_wdf-debug',
				'defender_page_wdf-debug-network',
				'defender_page_wdf-scan',
				'defender_page_wdf-scan-network',
				'defender_page_wdf-schedule-scan',
				'defender_page_wdf-schedule-scan-network'
			)
		);
		/** @noinspection PhpIncludeInspection */
		include_once( $this->get_plugin_path() . 'dash-notice/wpmudev-dash-notification.php' );
	}

	/**
	 * initial plugin scripts
	 */
	public function init() {
		$this->files_mapped = WD_Utils::get_dir_tree( $this->plugin_path, true, false, array(), array(
			'ext' => array( 'php' )
		) );
		/**
		 * includes necessary controllers
		 */
		$module_manager = new WD_Module_Manager();
		$module_manager->attach( WD_Hardener_Module::get_instance() );
		$module_manager->attach( new WD_Scan_Module() );
		//listen to membership status
		$this->global['module_manager'] = $module_manager;

		//include the rest controller
		$controllers = array(
			'admin'   => new WD_Admin_Controller(),
			'backup'  => new WD_Backup_Controller(),
			'logging' => new WD_Logging_Controller(),
		);
		//store for later use
		$this->global['controllers'] = $controllers;
		//now inits the widgets, this will lookup all the widgets in over plugin scope, in modules and outside
		WD_Widget_Manager::get_instance()->prepare_widgets();
	}

	public function register_post_type() {
		register_post_type( 'wdscan_result', array(
			'public'          => false,
			'show_ui'         => false,
			'show_in_menu'    => false,
			'capability_type' => array( 'wdscan_result', 'wdscan_results' ),
			'map_meta_cap'    => true,
			'hierarchical'    => false,
			'rewrite'         => false,
			'query_var'       => false,
			'supports'        => array( '' ),
		) );
	}

	/**
	 * @param $class
	 *
	 * @return bool|void
	 */
	public function class_loader( $class ) {
		$class = strtolower( $class );
		if ( substr( $class, 0, 3 ) != 'wd_' ) {
			return false;
		}
		//build file name
		$file_name = 'class-' . str_replace( '_', '-', $class ) . '.php';

		foreach ( $this->files_mapped as $mapped ) {
			//this should not handle file inside module folder
			if ( pathinfo( $mapped, PATHINFO_BASENAME ) == $file_name
			     && ( strpos( $mapped, '/module/' ) === false || ( count( explode( DIRECTORY_SEPARATOR, str_replace( $this->plugin_path . 'app/module/', '', $mapped ) ) ) == 1 ) )
			) {
				include_once $mapped;
			}
		}
	}

	/**
	 * Return URL to the plugin root
	 * @return string
	 */
	public function get_plugin_url() {
		return $this->plugin_url;
	}

	/**
	 * Return PATH to the plugin root
	 * @return string
	 */
	public function get_plugin_path() {
		return $this->plugin_path;
	}

	/**
	 * Singleton instance of the plugin
	 *
	 * @access public
	 * @return WP_Defender
	 * @since 1.0
	 */
	public static function get_instance() {
		if ( ! self::$_instance instanceof WP_Defender ) {
			self::$_instance = new WP_Defender();
		}

		return self::$_instance;
	}
}

if ( ! function_exists( 'wp_defender' ) ) {
	function wp_defender() {
		return WP_Defender::get_instance();
	}
}
wp_defender();

function wp_defender_activate() {
	//settle settings
	WD_Utils::settle_settings();
}

register_activation_hook( __FILE__, 'wp_defender_activate' );

function wp_defender_deactivate() {
	//we disable any cron running
	wp_clear_scheduled_hook( 'wd_scanning_hook' );
	wp_clear_scheduled_hook( 'error_log_scanscan_files' );
}

register_deactivation_hook( __FILE__, 'wp_defender_deactivate' );