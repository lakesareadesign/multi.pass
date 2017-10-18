<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization and hooks.
 *
 * @since        5.0.0
 * @package      Shortcodes_Ultimate
 * @subpackage   Shortcodes_Ultimate/includes
 */
class Shortcodes_Ultimate {

	/**
	 * The path to the main plugin file.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @var      string      $plugin_file   The path to the main plugin file.
	 */
	private $plugin_file;

	/**
	 * The current version of the plugin.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @var      string      $plugin_version   The current version of the plugin.
	 */
	private $plugin_version;

	/**
	 * The path to the plugin folder.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @var      string      $plugin_path   The path to the plugin folder.
	 */
	private $plugin_path;

	/**
	 * The plugin text domain.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @var      string      $textdomain   The plugin text domain.
	 */
	private $textdomain;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since   5.0.0
	 * @param string  $plugin_file    The path to the main plugin file.
	 * @param string  $plugin_version The current version of the plugin.
	 */
	public function __construct( $plugin_file, $plugin_version ) {

		$this->plugin_file    = $plugin_file;
		$this->plugin_version = $plugin_version;
		$this->plugin_path    = plugin_dir_path( $plugin_file );
		$this->textdomain     = 'shortcodes-ultimate';

		$this->load_dependencies();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for the plugin.
	 *
	 *
	 * @since    5.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for plugin upgrades.
		 */
		require_once $this->plugin_path . 'includes/class-shortcodes-ultimate-upgrade.php';

		/**
		 * Classes responsible for defining admin menus.
		 */
		require_once $this->plugin_path . 'admin/class-shortcodes-ultimate-admin.php';
		require_once $this->plugin_path . 'admin/class-shortcodes-ultimate-admin-top-level.php';
		require_once $this->plugin_path . 'admin/class-shortcodes-ultimate-admin-shortcodes.php';
		require_once $this->plugin_path . 'admin/class-shortcodes-ultimate-admin-settings.php';
		require_once $this->plugin_path . 'admin/class-shortcodes-ultimate-admin-addons.php';

		/**
		 * Classes responsible for displaying admin notices.
		 */
		require_once $this->plugin_path . 'admin/class-shortcodes-ultimate-notice.php';
		require_once $this->plugin_path . 'admin/class-shortcodes-ultimate-notice-rate.php';

	}

	/**
	 * Register all of the hooks related to the admin area functionality of the
	 * plugin.
	 *
	 * @since    5.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		/**
		 * Run upgrades.
		 */
		$upgrade = new Shortcodes_Ultimate_Upgrade( $this->plugin_file, $this->plugin_version );

		add_action( 'admin_init', array( $upgrade, 'maybe_upgrade' ) );


		/**
		 * Top-level menu: Shortcodes
		 * admin.php?page=shortcodes-ultimate
		 */
		$top_level = new Shortcodes_Ultimate_Admin_Top_Level( $this->plugin_file, $this->plugin_version );

		add_action( 'admin_menu', array( $top_level, 'admin_menu' ), 5 );


		/**
		 * Submenu: Available shortcodes
		 * admin.php?page=shortcodes-ultimate
		 */
		$shortcodes = new Shortcodes_Ultimate_Admin_Shortcodes( $this->plugin_file, $this->plugin_version );

		add_action( 'admin_menu',            array( $shortcodes, 'admin_menu' ), 5   );
		add_action( 'current_screen',        array( $shortcodes, 'add_help_tab' )    );
		add_action( 'admin_enqueue_scripts', array( $shortcodes, 'enqueue_scripts' ) );


		/**
		 * Submenu: Settings
		 * admin.php?page=shortcodes-ultimate-settings
		 */
		$settings = new Shortcodes_Ultimate_Admin_Settings( $this->plugin_file, $this->plugin_version );

		add_action( 'admin_menu',     array( $settings, 'admin_menu' ), 20    );
		add_action( 'admin_init',     array( $settings, 'register_settings' ) );
		add_action( 'current_screen', array( $settings, 'add_help_tab' )      );


		/**
		 * Submenu: Add-ons
		 * admin.php?page=shortcodes-ultimate-addons
		 */
		$addons = new Shortcodes_Ultimate_Admin_Addons( $this->plugin_file, $this->plugin_version );

		add_action( 'admin_menu',                       array( $addons, 'admin_menu' ), 30     );
		add_action( 'admin_enqueue_scripts',            array( $addons, 'enqueue_scripts' )    );
		add_action( 'current_screen',                   array( $addons, 'add_help_tab' )       );
		add_action( 'admin_post_su_activate_license',   array( $addons, 'activate_license' )   );
		add_action( 'admin_post_su_deactivate_license', array( $addons, 'deactivate_license' ) );


		/**
		 * Notice: Rate plugin
		 */
		$rate = new Shortcodes_Ultimate_Notice_Rate( 'rate', $this->plugin_path . 'admin/partials/notices/rate.php' );

		add_action( 'load-plugins.php',             array( $rate, 'defer_first_time' ) );
		add_action( 'admin_notices',                array( $rate, 'display_notice' )   );
		add_action( 'admin_post_su_dismiss_notice', array( $rate, 'dismiss_notice' )   );

	}

}
