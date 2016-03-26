<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://ultimatemember.com/
 * @since      1.0.0
 *
 * @package    Um_Instagram
 * @subpackage Um_Instagram/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Um_Instagram
 * @subpackage Um_Instagram/includes
 * @author     Ultimate Member <support@ultimatemember.com>
 */
class Um_Instagram {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Um_Instagram_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'um-instagram';
		$this->version = '1.0.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Um_Instagram_Loader. Orchestrates the hooks of the plugin.
	 * - Um_Instagram_i18n. Defines internationalization functionality.
	 * - Um_Instagram_Admin. Defines all hooks for the admin area.
	 * - Um_Instagram_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-um-instagram-loader.php';

		/**
		 * Licensing
		 */
		if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ). '/EDD_SL_Plugin_Updater.php';
		}

		/**
		 * The UM Connect Instagram
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'providers/instagram/um-connect-instagram.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-um-instagram-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-um-instagram-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-um-instagram-public.php';

		
		$this->loader = new Um_Instagram_Loader();
		
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Um_Instagram_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Um_Instagram_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Um_Instagram_Admin( $this->get_plugin_name(), $this->get_version() );

		// Assets
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// License
		$this->loader->add_action( 'admin_init', 			$plugin_admin, 'plugin_updater' );
		$this->loader->add_filter( 'um_licensed_products_settings', $plugin_admin, 'license_key', 10, 1 );
		$this->loader->add_filter( 'redux/options/um_options/compiler', $plugin_admin, 'license_status', 10, 3 );

		// Settings options
		$this->loader->add_filter( 'um_core_fields_hook', $plugin_admin, 'register_builder_field', 10,1 );
		$this->loader->add_filter( 'redux/options/um_options/sections', $plugin_admin, 'api_config', 1000 );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Um_Instagram_Public( $this->get_plugin_name(), $this->get_version() );

		// Assets
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		$this->loader->add_action( 'um_user_after_updating_profile', $plugin_public, 'user_after_updating_profile' );
		$this->loader->add_filter( 'um_edit_field_profile_instagram_photo', $plugin_public, 'edit_field_profile_instagram_photo', 9.120 ,2 );
		$this->loader->add_filter( 'um_view_field_value_instagram_photo', $plugin_public, 'view_field_profile_instagram_photo', 10 ,2 );
		$this->loader->add_filter( 'body_class', $plugin_public, 'body_class', 999, 1 );
		
		// Ajax
		$this->loader->add_action( 'wp_ajax_nopriv_um_instagram_photos', $plugin_public, 'ajax_get_photos' );
		$this->loader->add_action( 'wp_ajax_um_instagram_photos', 		 $plugin_public, 'ajax_get_photos' );
		
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Um_Instagram_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


	/**
	 * Check plugin requirements
	 * 
	 * @since    1.0.0
	 */
	public function  plugin_check() {

		if ( !class_exists('UM_API') ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>', $this->plugin_name ), 'Ultimate Member - Instagram') );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, $this->version, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.', $this->plugin_name ), 'Ultimate Member - Instagram') );
			$this->plugin_inactive = true;
		
		} else if ( phpversion() < 5.4 ) {
			
			$this->add_notice( sprintf(__('The social extension requires <strong>PHP 5.4 or better</strong> installed on your server.', $this->plugin_name ), 'Ultimate Member - Instagram') );
			$this->plugin_inactive = true;
		
		}
		
	}
	
	/**
	 * Add notice
	 * @param  string $msg 
	 * @since  1.0.0
	 */
	public function  add_notice( $msg ) {
		
		if ( !is_admin() ) return;
		
		echo '<div class="error"><p>' . $msg . '</p></div>';
		
	}
}
