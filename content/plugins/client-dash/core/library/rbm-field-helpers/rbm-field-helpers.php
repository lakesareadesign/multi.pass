<?php
/**
 * Provides helper functions shared among all RBM plugins.
 *
 * @package RBMFieldHelpers
 */

defined( 'ABSPATH' ) || die();

if ( ! class_exists( 'RBM_FieldHelpers' ) ) {

	define( 'RBM_FIELD_HELPERS_VER', '1.4.12' );
	
	if ( strpos( wp_normalize_path( __FILE__ ), wp_normalize_path( WP_PLUGIN_DIR ) ) !== false ) {
	
		define( 'RBM_FIELD_HELPERS_URI', plugins_url( '', __FILE__ ) );
		define( 'RBM_FIELD_HELPERS_DIR', plugin_dir_path( __FILE__ ) );
		
	}
	else {

		// Default to Parent Theme
		$theme_uri = get_template_directory_uri();
		$theme_dir = get_template_directory();
		
		// Load from Child Theme if appropriate
		if ( strpos( wp_normalize_path( dirname( __FILE__ ) ), wp_normalize_path( get_stylesheet_directory() ) ) !== false ) {
			$theme_uri = get_stylesheet_directory_uri();
			$theme_dir = get_stylesheet_directory();
		}
		
		// Relative path from the Theme Directory to the directory holding RBM FH
		$relative_from_theme_dir = dirname( str_replace( wp_normalize_path( $theme_dir ), '', wp_normalize_path( __FILE__ ) ) );
		
		// Build out our Constants for DIR and URI
		// DIR could have been made using just dirname( __FILE__ ), but we needed the difference to create the URI anyway
		define( 'RBM_FIELD_HELPERS_URI', $theme_uri . $relative_from_theme_dir );
		define( 'RBM_FIELD_HELPERS_DIR', wp_normalize_path( $theme_dir . $relative_from_theme_dir ) );
		
	}

	final class RBM_FieldHelpers {

		/**
		 * Instance properties.
		 *
		 * @since 1.4.0
		 *
		 * @var array
		 */
		public $instance = array();

		/**
		 * Fields instance.
		 *
		 * @since 1.4.0
		 *
		 * @var RBM_FH_Fields
		 */
		public $fields;

		/**
		 * Field Templates instance.
		 *
		 * @since 1.4.0
		 *
		 * @var RBM_FH_FieldTemplates
		 */
		public $templates;

		private function __clone() {
		}

		private function __wakeup() {
		}

		/**
		 * Returns the *Singleton* instance of this class.
		 *
		 * @since 1.1.0
		 *
		 * @staticvar Singleton $instance The *Singleton* instances of this class.
		 *
		 * @return RBM_FieldHelpers The *Singleton* instance.
		 */
		public static function getInstance() {

			static $instance = null;

			if ( null === $instance ) {
				$instance = new static();
			}

			return $instance;
		}

		/**
		 * RBM_FieldHelpers constructor.
		 *
		 * @since 1.1.0
		 *
		 * @param array $instance Instance arugments.
		 */
		function __construct( $instance = array() ) {

			$this->instance = wp_parse_args( $instance, array(
				'ID'   => '_rbm',
				'l10n' => array(
					'field_table'    => array(
						'delete_row'    => __( 'Delete Row', 'rbm-field-helpers' ),
						'delete_column' => __( 'Delete Column', 'rbm-field-helpers' ),
					),
					'field_select'   => array(
						'no_options'       => __( 'No select options.', 'rbm-field-helpers' ),
						'error_loading'    => __( 'The results could not be loaded', 'rbm-field-helpers' ),
						/* translators: %d is number of characters over input limit */
						'input_too_long'   => __( 'Please delete %d character', 'rbm-field-helpers' ),
						/* translators: %d is number of characters under input limit */
						'input_too_short'  => __( 'Please enter %d or more characters', 'rbm-field-helpers' ),
						'loading_more'     => __( 'Loading more results...', 'rbm-field-helpers' ),
						/* translators: %d is maximum number items selectable */
						'maximum_selected' => __( 'You can only select %d item', 'rbm-field-helpers' ),
						'no_results'       => __( 'No results found', 'rbm-field-helpers' ),
						'searching'        => __( 'Searching...', 'rbm-field-helpers' ),
					),
					'field_repeater' => array(
						'collapsable_title'   => __( 'New Row', 'rbm-field-helpers' ),
						'confirm_delete' => __( 'Are you sure you want to delete this element?', 'rbm-field-helpers' ),
						'delete_item'    => __( 'Delete', 'rbm-field-helpers' ),
						'add_item'       => __( 'Add', 'rbm-field-helpers' ),
					),
					'field_media'    => array(
						'button_text'        => __( 'Upload / Choose Media', 'rbm-field-helpers' ),
						'button_remove_text' => __( 'Remove Media', 'rbm-field-helpers' ),
						'window_title'       => __( 'Choose Media', 'rbm-field-helpers' ),
					),
					'field_checkbox' => array(
						'no_options_text' => __( 'No options available.', 'rbm-field-helpers' ),
					),
				),
			) );

			$this->includes();

			add_action( 'admin_init', array( $this, 'register_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_footer', array( $this, 'localize_data' ) );
		}

		/**
		 * Loads all plugin required files.
		 *
		 * @since 1.1.0
		 */
		private function includes() {

			require_once __DIR__ . '/core/class-rbm-fh-fields.php';
			require_once __DIR__ . '/core/class-rbm-fh-field-templates.php';

			$this->fields    = new RBM_FH_Fields( $this->instance );
			$this->templates = new RBM_FH_FieldTemplates( $this->instance );
		}

		/**
		 * Registers all scripts.
		 *
		 * @since 1.1.0
		 * @access private
		 */
		function register_scripts() {

			global $wp_scripts;

			$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.min' : '';

			// Core Admin
			wp_register_style(
				'rbm-fh-admin',
				RBM_FIELD_HELPERS_URI . '/assets/dist/css/rbm-field-helpers-admin.min.css',
				array(),
				RBM_FIELD_HELPERS_VER
			);

			wp_register_script(
				'rbm-fh-admin',
				RBM_FIELD_HELPERS_URI . '/assets/dist/js/rbm-field-helpers-admin.min.js',
				array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ),
				RBM_FIELD_HELPERS_VER,
				true
			);

			// Select2
			wp_register_style(
				'rbm-fh-select2',
				RBM_FIELD_HELPERS_URI . "/assets/dist/css/rbm-fh-select2.min.css",
				array(),
				RBM_FIELD_HELPERS_VER
			);

			wp_register_script(
				'rbm-fh-select2',
				RBM_FIELD_HELPERS_URI . "/assets/dist/js/rbm-fh-select2.js",
				array( 'jquery' ),
				RBM_FIELD_HELPERS_VER,
				true
			);

			// get registered script object for jquery-ui
			$ui = $wp_scripts->query( 'jquery-ui-core' );

			// tell WordPress to load the Smoothness theme from Google CDN
			$url = "http://ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/smoothness/jquery-ui.min.css";
			wp_register_style(
				'jquery-ui-smoothness',
				$url,
				false,
				null
			);
		}

		/**
		 * Enqueues common scripts.
		 *
		 * @since 1.1.0
		 * @access private
		 */
		function enqueue_scripts() {

			/**
			 * Load or don't load the Select2 scripts.
			 *
			 * @since 1.4.0
			 */
			$load_select2 = apply_filters( 'rbm_fieldhelpers_load_select2', false );

			// Legacy
			$legacy_load_select2 = apply_filters( 'rbm_load_select2', false );

			if ( $load_select2 || $legacy_load_select2 ) {

				wp_enqueue_script( 'rbm-fh-select2' );
				wp_enqueue_style( 'rbm-fh-select2' );
			}
			
			wp_enqueue_script( 'jquery-ui-datepicker' );

			wp_enqueue_script( 'rbm-fh-admin' );
			wp_enqueue_style( 'rbm-fh-admin' );
		}

		/**
		 * Localizes data.
		 *
		 * Fired in the footer so that fields can add data to this dynamically.
		 *
		 * @since 1.1.2
		 * @access private
		 */
		function localize_data() {

			// Localize data
			$data = $this->get_localized_data();

			wp_localize_script( 'rbm-fh-admin', 'RBM_FieldHelpers', $data );
		}
		
		/**
		 * Returns the localized data
		 *
		 * This is useful if you need to return the localized data in a non-WP standard way
		 *
		 * @since 1.4.9
		 * @access public
		 */
		function get_localized_data() {
			
			global $wp_version;
			
			return apply_filters( "rbm_field_helpers_admin_data", array(
				'nonce'       => wp_create_nonce( 'rbm-field-helpers' ),
				'wp_version'  => $wp_version,
				'instance_id' => $this->instance['ID'],
				'l10n'        => $this->instance['l10n'],
			) );
			
		}
		
	}

	require_once __DIR__ . '/core/deprecated/rbm-fh-deprecated-functions.php';
	require_once __DIR__ . '/core/deprecated/rbm-fh-deprecated-support.php';
}