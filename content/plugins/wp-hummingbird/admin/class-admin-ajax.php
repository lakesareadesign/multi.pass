<?php

/**
 * Class WP_Hummingbird_Admin_AJAX
 *
 * Handle all AJAX actions in admin side
 */
class WP_Hummingbird_Admin_AJAX {

	public function __construct() {

		add_action( 'wp_ajax_wphb_ajax', array( $this, 'process' ) );

		add_action( 'wp_ajax_minification_check_url', array( $this, 'minification_check_url' ) );
		add_action( 'wp_ajax_minification_start_check', array( $this, 'minification_start_check' ) );
		add_action( 'wp_ajax_minification_finish_check', array( $this, 'minification_finish_check' ) );


		add_action( 'wp_ajax_caching_toggle_caching', array( $this, 'toggle_caching' ) );
		add_action( 'wp_ajax_caching_clear_cache', array( $this, 'clear_caching_cache' ) );
		add_action( 'wp_ajax_caching_write_htaccess', array( $this, 'write_caching_htaccess' ) );
		add_action( 'wp_ajax_gzip_write_htaccess', array( $this, 'write_gzip_htaccess' ) );

		add_action( 'wp_ajax_cloudflare_connect', array( $this, 'cloudflare_connect' ) );
		add_action( 'wp_ajax_cloudflare_set_expiry', array( $this, 'cloudflare_set_expiry' ) );
		add_action( 'wp_ajax_cloudflare_purge_cache', array( $this, 'cloudflare_purge_cache' ) );
	}

	public function process() {
		if ( ! isset( $_REQUEST['module_action'] ) || ! isset( $_REQUEST['module'] ) ) {
			wp_send_json_error();
		}

		if ( ! isset( $_REQUEST['wphb_nonce'] ) || ! isset( $_REQUEST['nonce_name'] ) ) {
			wp_send_json_error();
		}

		check_ajax_referer( $_REQUEST['nonce_name'], 'wphb_nonce' );

		if ( ! current_user_can( wphb_get_admin_capability() ) )
			wp_send_json_error();

		$method = $_REQUEST['module'] . '_' . $_REQUEST['module_action'];

		if ( ! method_exists( $this, $method ) )
			wp_send_json_error();

		if ( ! isset( $_REQUEST['data'] ) )
			$data = array();
		else
			$data = $_REQUEST['data'];

		call_user_func( array( $this, $method ), $data );
	}


	public function performance_performance_test( $data ) {
		if ( wphb_performance_stopped_report() ) {
			wp_send_json_success();
		}

		$started_at = wphb_performance_is_doing_report();

		if ( ! $started_at ) {
			wphb_performance_init_scan();
			wp_send_json_error();
		}

		$now = current_time( 'timestamp' );
		if ( $now >= ( $started_at + 10 ) ) {
			// The report should be finished by this time, let's get the results
			wphb_performance_refresh_report();
			wp_send_json_success();
		}

		// Just do nothing until teh report is finished
		wp_send_json_error();
	}

	public function uptime_toggle_uptime( $data ) {
		if ( ! isset( $data['value'] ) ) {
			die();
		}

		$value = $data['value'] == 'false' ? false : true;

		$options = wphb_get_settings();
		$options['uptime'] = $value;
		wphb_update_settings( $options );
		die();
	}

	public function caching_set_server_type( $data ) {
		if ( ! isset( $data['type'] ) ) {
			die();
		}

		if ( ! array_key_exists( $data['type'], wphb_get_servers() ) ) {
			die();
		}

		update_user_meta( get_current_user_id(), 'wphb-server-type', $data['type'] );

		die();
	}

	public function gzip_set_server_type( $data ) {
		if ( ! isset( $data['type'] ) ) {
			die();
		}

		if ( ! array_key_exists( $data['type'], wphb_get_servers() ) ) {
			die();
		}

		update_user_meta( get_current_user_id(), 'wphb-server-type', $data['type'] );

		die();
	}


	public function caching_set_expiration( $data ) {
		if ( ! isset( $data['type'] ) || ! isset( $data['value'] ) ) {
			die();
		}

		$frequencies = wphb_get_caching_frequencies();

		if ( ! isset( $frequencies[ $data['value'] ] ) ) {
			die();
		}

		$options = wphb_get_settings();
		$options['caching_expiry_' . $data['type']] = $data['value'];
		wphb_update_settings( $options );

		do_action( 'wphb_caching_set_expiration', $data );
		die();
	}

	public function caching_reload_snippet( $data ) {
		$code = wphb_get_code_snippet( 'caching', $data['type'] );

		$updated_file = false;
		if ( wphb_is_htaccess_written('caching') === true  && $data['type'] === 'apache') {
			$updated_file = wphb_unsave_htaccess( 'caching' );
			$updated_file = wphb_save_htaccess( 'caching' );
		}


		wp_send_json_success( array( 'type' => $data['type'], 'code' => $code, 'updatedFile' => $updated_file ) );
	}


	public function dashboard_remove_welcome_box() {
		$user_id = get_current_user_id();

		$user = get_userdata( $user_id );
		if ( $user ) {
			update_user_meta( $user_id, 'wphb-hide-welcome-box', true );
		}
	}

	public function dashboard_activate_network_minification( $data ) {
		if ( ! isset( $data['value'] ) ) {
			die();
		}

		switch ( $data['value'] ) {
			case 'false': {
				$value = false;
				break;
			}
			case 'super-admins': {
				$value = 'super-admins';
				break;
			}
			default: {
				$value = true;
				break;
			}
		}

		wphb_toggle_minification( $value, true );
	}

	public function minification_toggle_minification( $data ) {
		if ( ! isset( $data['value'] ) ) {
			die();
		}

		$value = $data['value'] == 'false' ? false : true;

		wphb_toggle_minification( $value );

		die();
	}

	public function dashboard_toggle_use_cdn( $data ) {
		$this->minification_toggle_use_cdn( $data );
	}

	public function minification_toggle_use_cdn( $data ) {
		$value = ( 'true' === $data['value'] );
		wphb_update_setting( 'use_cdn', $value );

		if ( is_multisite() && ! current_user_can( 'manage_network' ) ) {
			die();
		}

		if ( ! is_multisite() && ! current_user_can( 'manage_options' ) ) {
			die();
		}

		// Clear the files
		$groups = WP_Hummingbird_Module_Minify_Group::get_minify_groups();
		foreach ( $groups as $group ) {
			$path = get_post_meta( $group->ID, 'path', true );
			if ( $path ) {
				wp_delete_file( $path );
			}
			wp_delete_post( $group->ID );
		}
		wp_cache_delete( 'wphb_minify_groups' );
		die();
	}

	/**
	 * Get all the URLs that the Minification Check Files button should process
	 */
	public function minification_check_url() {
		check_ajax_referer( 'wphb-minification-check-files', 'wphb_nonce' );

		if ( ! current_user_can( wphb_get_admin_capability() ) )
			wp_send_json_error();

		$data = $_REQUEST['data'];
		$url = $data['url'];
		$results = WP_Hummingbird_Module_Minify::scan( $url );


		wp_send_json_success( $results );

	}

	/**
	 * Set a flag that marks the minification check files as started
	 */
	public function minification_start_check( $data ) {
		if ( ! wphb_minification_is_checking_files() ) {
			wphb_minification_init_scan();
		}
		wp_send_json_success( array( 'finished' => false ) );
	}

	public function minification_check_step( $data ) {
		$check_files = get_option( 'wphb-minification-check-files' );

		if ( false === $check_files ) {
			// We have finished
			wp_send_json_success( array( 'finished' => true ) );
		}

		if ( empty( $check_files['urls_list'] ) ) {
			// We have finished with URLs, just scan home again to gain some time
			WP_Hummingbird_Module_Minify::scan( home_url() );
			delete_option( 'wphb-minification-check-files' );
		}
		else {
			$next_url = array_shift( $check_files['urls_list'] );
			$check_files['urls_done'][] = $next_url;
			update_option( 'wphb-minification-check-files', $check_files );
			WP_Hummingbird_Module_Minify::scan( $next_url );
		}

		$current_time = current_time( 'timestamp' );
		// If more than 4 minutes has passed, kill the process
		if ( empty( $check_files['on'] ) || $current_time > ( $check_files['on'] + 240 ) ) {
			delete_option( 'wphb-minification-check-files' );
		}

		wp_send_json_success( array( 'finished' => false ) );
	}


	public function toggle_caching() {
		check_ajax_referer( 'wphb-caching-toggle', 'wphb_nonce' );

		if ( ! current_user_can( wphb_get_admin_capability() ) )
			die();

		$options = wphb_get_settings();

		$options['caching'] = $_REQUEST['data']['activate'] === 'true';
		wphb_update_settings( $options );

		die();

	}

	public function clear_caching_cache() {
		check_ajax_referer( 'wphb-caching-clear', 'wphb_nonce' );

		if ( ! current_user_can( wphb_get_admin_capability() ) )
			die();

		wphb_clear_caching_cache();

		die();


	}

	function write_gzip_htaccess() {
		check_ajax_referer( 'wphb-write-htacces', 'wphb_nonce' );

		if ( ! current_user_can( wphb_get_admin_capability() ) )
			die();

		wphb_save_htaccess( 'gzip' );
	}

	function write_caching_htaccess() {
		check_ajax_referer( 'wphb-write-htacces', 'wphb_nonce' );

		if ( ! current_user_can( wphb_get_admin_capability() ) )
			die();

		wphb_save_htaccess( 'caching' );
	}


	public function cloudflare_connect() {
		$form_data = $_POST['formData'];
		$form_data = wp_parse_args( $form_data, array( 'cloudflare-email' => '', 'cloudflare-api-key' => '', 'cloudflare-zone' => '' ) );

		$step = $_POST['step'];
		$cfData = $_POST['cfData'];

		/** @var WP_Hummingbird_Module_Cloudflare $cloudflare */
		$cloudflare = wphb_get_module( 'cloudflare' );

		$settings = wphb_get_settings();

		switch ( $step ) {
			case 'credentials': {
				$settings['cloudflare-email'] = sanitize_email( $form_data['cloudflare-email'] );
				$settings['cloudflare-api-key'] = sanitize_text_field( $form_data['cloudflare-api-key'] );
				$settings['cloudflare-zone'] = sanitize_text_field( $form_data['cloudflare-zone'] );
				$settings['cloudflare-zone-name'] = isset( $form_data['cloudflare-zone-name'] ) ? sanitize_text_field( $form_data['cloudflare-zone-name'] ) : '';
				wphb_update_settings( $settings );

				$zones = $cloudflare->get_zones_list();

				if ( is_wp_error( $zones ) ) {
					wp_send_json_error( array( 'error' => sprintf( '<strong>%s</strong> [%s]', $zones->get_error_message(), $zones->get_error_code() ) ) );
				}


				$cfData['email'] = $settings['cloudflare-email'];
				$cfData['apiKey'] = $settings['cloudflare-api-key'];
				$cfData['zones'] = $zones;


				$settings['cloudflare-connected'] = true;
				wphb_update_settings( $settings );

				// Try to auto select domain
				$site_url = network_site_url();
				$site_url = rtrim( preg_replace( '/^https?:\/\//', '', $site_url ), '/' );
				$plucked_zones = wp_list_pluck( $zones, 'label' );
				$found = preg_grep( '/.*' . $site_url . '.*/', $plucked_zones );
				if ( is_array( $found ) && count( $found ) === 1 && isset( $zones[ key( $found ) ]['value'] ) ) {
					// Select the domain and cheat this function
					$zone_found = $zones[ key( $found ) ]['value'];
					$_POST['formData'] = array(
						'cloudflare-zone' => $zone_found
					);
					$_POST['step'] = 'zone';
					$_POST['cfData'] = $cfData;
					$this->cloudflare_connect();
				}

				wp_send_json_success( array( 'nextStep' => 'zone', 'newData' => $cfData ) );
				break;
			}
			case 'zone': {
				$settings['cloudflare-zone'] = sanitize_text_field( $form_data['cloudflare-zone'] );

				if ( empty( $settings['cloudflare-zone'] ) ) {
					wp_send_json_error( array( 'error' => __( 'Please, select a CloudFlare zone. Normally, this is your website', 'wphb' ) ) );
				}

				// Check that the zone exists
				$zones = $cloudflare->get_zones_list();
				if ( is_wp_error( $zones ) ) {
					wp_send_json_error( array( 'error' => sprintf( '<strong>%s</strong> [%s]', $zones->get_error_message(), $zones->get_error_code() ) ) );
				}
				else {
					$filtered = wp_list_filter( $zones, array( 'value' => $settings['cloudflare-zone'] ) );
					if ( ! $filtered ) {
						wp_send_json_error( array( 'error' => __( 'The selected zone is not valid', 'wphb' ) ) );
					}
					$settings['cloudflare-zone-name'] = $filtered[0]['label'];
					$settings['cloudflare-plan'] = $filtered[0]['plan'];
				}

				$settings['cloudflare-connected'] = true;

				wphb_update_settings( $settings );
				$cfData['zone'] = $settings['cloudflare-zone'];
				$cfData['zoneName'] = $settings['cloudflare-zone-name'];
				$cfData['plan'] = $settings['cloudflare-plan'];

				update_site_option( 'wphb-is-cloudflare', 1 );

				// And set the new CF setting
				$cloudflare->set_caching_expiration( 691200 );

				wp_send_json_success( array( 'nextStep' => 'final', 'newData' => $cfData ) );
				break;
			}
		}

		wp_send_json_error( array( 'error' => '' ) );
	}

	public function cloudflare_set_expiry() {
		check_ajax_referer( 'wphb-cloudflare-expiry', 'security' );

		$value = absint( $_POST['value'] );
		/** @var WP_Hummingbird_Module_Cloudflare $cf */
		$cf = wphb_get_module( 'cloudflare' );

		$cf->set_caching_expiration( $value );

		die();
	}

	public function cloudflare_purge_cache() {
		/** @var WP_Hummingbird_Module_Cloudflare $cf */
		$cf = wphb_get_module( 'cloudflare' );
		$cf->purge_cache();
		die();
	}

}