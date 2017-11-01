<?php

/**
 * The Add-ons menu component.
 *
 * @since        5.0.0
 *
 * @package      Shortcodes_Ultimate
 * @subpackage   Shortcodes_Ultimate/admin
 */
final class Shortcodes_Ultimate_Admin_Addons extends Shortcodes_Ultimate_Admin {

	/**
	 * The plugin add-ons collection.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @var      array     $plugin_addons   The plugin add-ons collection.
	 */
	private $plugin_addons;

	/**
	 * The URL of the add-ons store.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @var      array     $store_url   The URL of the add-ons store.
	 */
	private $store_url;

	/**
	 * Messages for license activation screen.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @var      array     $license_messages   Messages for license activation screen.
	 */
	private $license_messages;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  5.0.0
	 * @param string  $plugin_file    The path of the main plugin file
	 * @param string  $plugin_version The current version of the plugin
	 */
	public function __construct( $plugin_file, $plugin_version ) {

		parent::__construct( $plugin_file, $plugin_version );

		$this->addons_api_url = 'https://getshortcodes.com/api/v1/add-ons/';
		$this->plugin_addons = array();

	}


	/**
	 * Add menu page.
	 *
	 * @since   5.0.0
	 */
	public function admin_menu() {

		/**
		 * Submenu: Add-ons
		 * admin.php?page=shortcodes-ultimate-addons
		 */
		$this->add_submenu_page(
			'shortcodes-ultimate',
			__( 'Add-ons', 'shortcodes-ultimate' ),
			__( 'Add-ons', 'shortcodes-ultimate' ),
			$this->get_capability(),
			'shortcodes-ultimate-addons',
			array( $this, 'the_menu_page' )
		);

	}


	/**
	 * Add help tab and set help sidebar at Add-ons page.
	 *
	 * @since  5.0.0
	 * @param WP_Screen $screen WP_Screen instance.
	 */
	public function add_help_tab( $screen ) {

		if ( !$this->is_component_page() ) {
			return;
		}

		$screen->add_help_tab( array(
				'id'      => 'shortcodes-ultimate-addons',
				'title'   => __( 'Add-ons', 'shortcodes-ultimate' ),
				'content' => $this->get_template( 'help/addons' ),
			) );

		$screen->set_help_sidebar( $this->get_template( 'help/sidebar' ) );

	}


	/**
	 * Enqueue JavaScript(s) and Stylesheet(s) for the component.
	 *
	 * @since   5.0.0
	 */
	public function enqueue_scripts() {

		if ( ! $this->is_component_page() ) {
			return;
		}

		wp_enqueue_style( 'shortcodes-ultimate-admin', $this->get_plugin_url() . 'admin/css/admin.css', array(), $this->get_plugin_version() );

	}

	/**
	 * Retrieve the collection of plugin add-ons.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @return  array The plugin add-ons collection.
	 */
	protected function get_plugin_addons() {

		if ( empty( $this->plugin_addons ) ) {
			$this->plugin_addons = $this->load_plugin_addons();
		}

		return apply_filters( 'su/admin/addons', $this->plugin_addons );

	}

	/**
	 * Load the collection of plugin add-ons from remote API.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @return  array The plugin add-ons collection.
	 */
	private function load_plugin_addons() {

		$cache = get_transient( 'su_transient_addons' );

		if ( ! empty( $cache ) ) {
			return $cache;
		}

		$response = wp_remote_get(
			$this->addons_api_url,
			array( 'timeout' => 10, 'sslverify' => false, )
		);
		$response = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $response[0]['id'] ) ) {
			return array();
		}

		$addons = array();

		foreach ( $response as $item ) {

			$addons[ $item['id'] ] = $item;
			$addons[ $item['id'] ]['is_installed'] = false;

		}

		set_transient( 'su_transient_addons', $addons, 3 * DAY_IN_SECONDS );

		return $addons;

	}

	/**
	 * Retrieve installed add-ons collection.
	 *
	 * @since    5.0.0
	 * @access   protected
	 * @return  array Installed add-ons collection.
	 */
	protected function get_installed_addons() {

		$addons    = $this->get_plugin_addons();
		$installed = array();

		foreach ( $addons as $addon ) {
			if ( isset( $addon['installed'] ) && $addon['installed'] ) {
				$installed[] = $addon;
			}
		}

		return $installed;

	}


	/**
	 * Display various notices at licenses page.
	 *
	 * @since   5.0.0
	 * @access  protected
	 */
	protected function the_licenses_notices() {

		if ( !isset( $_GET['message'] ) ) {
			return;
		}

		$message = sanitize_title( $_GET['message'] );

		$messages = $this->get_license_messages();

		if ( !isset( $messages[$message] ) ) {
			return;
		}

		$this->the_template( 'notices/licenses', $messages[$message] );

	}


	/**
	 * License activation handler.
	 *
	 * @since  5.0.0
	 */
	public function activate_license() {

		// Check permission
		if ( ! current_user_can( $this->get_capability() ) ) {
			return;
		}

		// Check referer
		if ( ! wp_get_referer() ) {
			return;
		}

		// Verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'su_activate_license' ) ) {
			return;
		}

		// Check add-on ID, name and license key
		if ( ! isset( $_POST['id'], $_POST['name'], $_POST['license_key'] ) ) {
			return;
		}

		// Don't do anything with empty license key
		if ( empty( $_POST['license_key'] ) ) {

			wp_safe_redirect( add_query_arg( 'message', 'empty_key', wp_get_referer() ) );
			exit;

		}

		// Sanitize input
		$addon_id    = sanitize_title( $_POST['id'] );
		$addon_name  = sanitize_text_field( $_POST['name'] );
		$license_key = sanitize_title( $_POST['license_key'] );

		// Call the remote API
		$response = $this->call_remote_api( 'activate_license', $license_key, $addon_name );

		// Make sure we've received correct json
		if ( is_null( $response ) ) {

			wp_safe_redirect( add_query_arg( 'message', 'no_connection', wp_get_referer() ) );
			exit;

		}

		// Delete previous license
		delete_option( "su_option_license_$addon_id" );

		// Successful validation
		if ( isset( $response->license, $response->expires ) && $response->license === 'valid' ) {

			$license = array(
				'key'     => $license_key,
				'expires' => $response->expires,
			);

			add_option( "su_option_license_$addon_id", $license, false );

			wp_safe_redirect( add_query_arg( 'message', 'activated', wp_get_referer() ) );
			exit;

		}

		// Get license (de)activation messages
		$messages = $this->get_license_messages();

		// Activation failed, we have description of the error
		if ( isset( $response->error, $messages[$response->error] ) ) {

			wp_safe_redirect( add_query_arg( 'message', $response->error, wp_get_referer() ) );
			exit;

		}

		// Default behavior
		wp_safe_redirect( add_query_arg( 'message', 'error', wp_get_referer() ) );
		exit;

	}


	/**
	 * License deactivation handler.
	 *
	 * @since  5.0.0
	 */
	public function deactivate_license() {

		// Check permission
		if ( ! current_user_can( $this->get_capability() ) ) {
			return;
		}

		// Check referer
		if ( ! wp_get_referer() ) {
			return;
		}

		// Verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'su_deactivate_license' ) ) {
			return;
		}

		// Check add-on ID, name and license key
		if ( ! isset( $_POST['id'], $_POST['name'] ) ) {
			return;
		}

		// Sanitize input
		$addon_id    = sanitize_title( $_POST['id'] );
		$addon_name  = sanitize_text_field( $_POST['name'] );
		$license     = $this->get_license( $addon_id );

		// Exit if there is no license
		if ( empty( $license['key'] ) ) {

			wp_safe_redirect( add_query_arg( 'message', 'deactivated', wp_get_referer() ) );
			exit;

		}

		// Call the remote API
		$response = $this->call_remote_api( 'deactivate_license', $license['key'], $addon_name );

		// Make sure we've received correct json
		if ( is_null( $response ) ) {

			wp_safe_redirect( add_query_arg( 'message', 'no_connection', wp_get_referer() ) );
			exit;

		}

		// Successful validation
		if ( isset( $response->license ) ) {

			// Delete the license
			delete_option( "su_option_license_$addon_id" );

			wp_safe_redirect( add_query_arg( 'message', 'deactivated', wp_get_referer() ) );
			exit;

		}

		// Default behavior
		wp_safe_redirect( add_query_arg( 'message', 'error', wp_get_referer() ) );
		exit;

	}


	/**
	 * Call the store API.
	 *
	 * @since  5.0.0
	 * @param string  $action    Action name, 'activate_license' or 'deactivate_license'
	 * @param string  $license   License key
	 * @param string  $item_name Store item name
	 * @return mixed             Response
	 */
	private function call_remote_api( $action, $license, $item_name ) {

		// Prepare store API params
		$store_api_params = array(
			'edd_action' => $action,
			'license'    => $license,
			'item_name'  => urlencode( $item_name ),
			'url'        => home_url(),
		);

		// Call remote API
		$response = wp_remote_post(
			$this->get_store_url(),
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $store_api_params,
			)
		);

		// Extract and try to parse the response body
		$response = json_decode( wp_remote_retrieve_body( $response ) );

		return $response;

	}


	/**
	 * Retrieve license data.
	 *
	 * @since  5.0.0
	 * @param string  $addon Add-on ID
	 * @return mixed          Array with license data (key, expiration date), or FALSE if license not found
	 */
	protected function get_license( $addon ) {

		$license = get_option( "su_option_license_$addon" );

		return isset( $license['key'], $license['expires'] ) ? $license : false;

	}


	/**
	 * Retrieve the license expiration date.
	 *
	 * @since  5.0.0
	 * @param string  $addon Add-on ID
	 * @return string        The license expiration date, or 'Not activated'
	 */
	protected function get_license_expiration_date( $addon ) {

		$license = $this->get_license( $addon );

		if ( !isset( $license['expires'] ) ) {
			return __( 'Not activated', 'shortcodes-ultimate' );
		}

		if ( $license['expires'] === 'lifetime' ) {
			return __( 'Never', 'shortcodes-ultimate' );
		}

		$format  = get_option( 'date_format' );
		$expires = strtotime( $license['expires'], current_time( 'timestamp' ) );

		return date_i18n( $format, $expires );

	}


	/**
	 * Retrieve the URL of the add-ons store.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @return   string     The URL of the add-ons store.
	 */
	private function get_store_url() {
		return $this->store_url;
	}


	/**
	 * Retrieve messages for license activation screen.
	 *
	 * @since    5.0.0
	 * @access   private
	 * @return   array     Messages for license activation screen.
	 */
	private function get_license_messages() {

		return array(
			'activated' => array(
				'text'  => __( 'License succefully activated.', 'shortcodes-ultimate' ),
				'class' => 'success',
			),
			'error' => array(
				'text'  => __( 'An error occurred. Please try again later.', 'shortcodes-ultimate' ),
				'class' => 'error',
			),
			'missing' => array(
				'text'  => __( 'Invalid license key', 'shortcodes-ultimate' ),
				'class' => 'error',
			),
			'license_not_activable' => array(
				'text'  => __( 'This license key is not suitable for selected add-on.', 'shortcodes-ultimate' ),
				'class' => 'warning',
			),
			'item_name_mismatch' => array(
				'text'  => __( 'This license key is not suitable for selected add-on.', 'shortcodes-ultimate' ),
				'class' => 'warning',
			),
			'revoked' => array(
				'text'  => __( 'License revoked.', 'shortcodes-ultimate' ),
				'class' => 'error',
			),
			'no_activations_left' => array(
				'text'  => __( 'This license reached the limit of activations and connot be activated.', 'shortcodes-ultimate' ),
				'class' => 'error',
			),
			'expired' => array(
				'text'  => __( 'License expired', 'shortcodes-ultimate' ),
				'class' => 'error',
			),
			'no_connection' => array(
				'text'  => __( 'Unable to connect to the activation server. Please try again later.', 'shortcodes-ultimate' ),
				'class' => 'warning',
			),
			'empty_key' => array(
				'text'  => __( 'Invalid license key', 'shortcodes-ultimate' ),
				'class' => 'warning',
			),
			'deactivated' => array(
				'text'  => __( 'License successfully deactivated', 'shortcodes-ultimate' ),
				'class' => 'success',
			),
		);

	}

}
