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
		add_action( 'wp_ajax_chart_switch_chart_area', array( $this, 'switch_chart_area' ) );
	}

	public function process() {
		if ( ! isset( $_REQUEST['module_action'] ) || ! isset( $_REQUEST['module'] ) )
			wp_send_json_error();

		if ( ! isset( $_REQUEST['wphb_nonce'] ) || ! isset( $_REQUEST['nonce_name'] ) )
			wp_send_json_error();

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

	public function switch_chart_area() {
		check_ajax_referer( 'wphb-chart', 'wphb_nonce' );

		if ( ! current_user_can( wphb_get_admin_capability() ) )
			wp_send_json_error();

		$area = $_REQUEST['data']['area'];

		$chart = wphb_get_chart( get_home_url() );
		$data = $chart['data'];

		if ( $area == 'all' ) {
			$sources = $chart['sources_number'];
		}
		elseif ( $area == 'core' ) {
			$data = wphb_filter_chart_data( $data, false );
			$sources = 0;
			$sources += count( $data['header']['core'] );
			$sources += count( $data['footer']['core'] );
		}
		else {
			$data = wphb_filter_chart_data( $data, $area );

			$sources = 0;
			if ( isset( $data['header']['themes'][ $area ] ) )
				$sources += count( $data['header']['themes'][ $area ] );

			if ( isset( $data['footer']['themes'][ $area ] ) )
				$sources += count( $data['footer']['themes'][ $area ] );

			if ( isset( $data['header']['plugins'][ $area ] ) )
				$sources += count( $data['header']['plugins'][ $area ] );

			if ( isset( $data['footer']['plugins'][ $area ] ) )
				$sources += count( $data['footer']['plugins'][ $area ] );
		}

		$data = WP_Hummingbird_Minification_Chart::prepare_for_javascript( $data );
		$data = json_decode( $data );

		wp_send_json_success( array( 'chartData' => $data, 'sourcesNumber' => $sources ) );
	}

}