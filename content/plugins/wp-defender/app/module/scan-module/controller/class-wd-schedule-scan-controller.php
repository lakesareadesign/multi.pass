<?php

/**
 * @author: Hoang Ngo
 */
class WD_Schedule_Scan_Controller extends WD_Controller {

	public function __construct() {
		if ( is_multisite() ) {
			$this->add_action( 'network_admin_menu', 'admin_menu', 12 );
		} else {
			$this->add_action( 'admin_menu', 'admin_menu', 12 );
		}
		$this->add_ajax_action( 'wd_toggle_auto_scan', 'toggle_auto_scan' );
		$this->add_ajax_action( 'wd_schedule_scan', 'schedule_scan' );
		$this->add_action( 'admin_enqueue_scripts', 'load_scripts' );
	}

	/**
	 * Register admin menu
	 */
	public function admin_menu() {
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';
		add_submenu_page( 'wp-defender', __( "Automated Scans", wp_defender()->domain ), __( "Automated Scans", wp_defender()->domain ), $cap, 'wdf-schedule-scan', array(
			$this,
			'display_main'
		) );
	}

	/**
	 * Save setting for schedule a scan to run
	 */
	public function schedule_scan() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_scan_nonce' ), 'wd_schedule_scan' ) ) {
			return;
		}

		/*$email = WD_Utils::http_post( 'email' );
		if ( ! empty( $email ) && ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => __( "Please enter a valid email address", wp_defender()->domain )
			) );
		}*/
		//all good here
		WD_Utils::update_setting( 'scan->schedule', array(
			//'email'     => $email,
			'frequency' => WD_Utils::http_post( 'frequency' ),
			'day'       => WD_Utils::http_post( 'day' ),
			'time'      => WD_Utils::http_post( 'time' ),
		) );
		//we also activate the toggle
		WD_Utils::update_setting( 'scan->auto_scan', 1 );
		WD_Utils::do_submitting( true );
		//next run
		WD_Scan_Api::update_next_run( true );
		wp_send_json( array(
			'status'  => 1,
			'message' => __( "Congratulations. Your scan schedule is saved.", wp_defender()->domain )
		) );
	}

	/**
	 * an ajax function to toggle auto scan
	 */
	public function toggle_auto_scan() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_scan_nonce' ), 'wd_toggle_auto_scan' ) ) {
			return;
		}

		$is_active = WD_Utils::get_setting( 'scan->auto_scan', 0 );
		WD_Utils::update_setting( 'scan->auto_scan', ! $is_active );
		if ( WD_Utils::get_setting( 'scan->auto_scan', false ) == false ) {
			$tooltip = __( "Activate Automatic Scans", wp_defender()->domain );
		} else {
			$tooltip = __( "Deactivate Automatic Scans", wp_defender()->domain );
		}
		WD_Utils::do_submitting( true );
		wp_send_json( array(
			'text'    => WD_Scan_Api::next_run_information(),
			'tooltip' => $tooltip
		) );
	}

	/**
	 * Check if in right page, then load assets
	 */
	public function load_scripts() {
		if ( $this->is_in_page() ) {
			WDEV_Plugin_Ui::load( wp_defender()->get_plugin_url() . 'shared-ui/', false );
			wp_enqueue_style( 'wp-defender' );
			wp_enqueue_script( 'wp-defender' );
		}
	}

	/**
	 * check if this page is page of the plugin
	 * @return bool
	 */
	private function is_in_page() {
		$page = WD_Utils::http_get( 'page' );

		return $page == 'wdf-schedule-scan';
	}

	/**
	 * @return mixed|void
	 * @access public
	 * @since 1.0
	 */
	public function get_frequently() {
		return WD_Scan_Api::get_frequently();
	}

	/**
	 * Get days of week
	 * @return mixed|void
	 * @access public
	 * @since 1.0
	 */
	public function get_days_of_week() {
		return WD_Scan_Api::get_days_of_week();
	}

	/**
	 * Return times frame for selectbox
	 * @access public
	 * @since 1.0
	 */
	public function get_times() {
		return WD_Scan_Api::get_times();
	}

	/**
	 *
	 */
	public function display_main() {
		$args  = WD_Utils::get_automatic_scan_settings();
		$names = array();
		foreach ( WD_Utils::get_setting( 'recipients', array() ) as $user_login ) {
			$user    = get_user_by( 'id', $user_login );
			$names[] = $user->display_name;
		}
		$args['names'] = $names;
		$this->render( 'schedule', $args, true );
	}
}