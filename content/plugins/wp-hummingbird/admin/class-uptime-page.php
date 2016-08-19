<?php

class WP_Hummingbird_Uptime_Page extends WP_Hummingbird_Admin_Page {

	private $current_report;

	public function register_meta_boxes() {

		$this->run_actions();

		/** @var WP_Hummingbird_Module_Uptime $module */
		$module = wphb_get_module( 'uptime' );
		$is_active = $module->is_active();
		$uptime_report = wphb_uptime_get_last_report( $this->get_current_data_range() );

		if ( is_wp_error( $uptime_report ) && $is_active ) {
			$this->add_meta_box( 'uptime', __( 'Uptime', 'wphb' ), array( $this, 'uptime_metabox' ), null, null, 'main', null );
		}
		elseif ( ! $is_active ) {
			$this->add_meta_box( 'uptime-disabled', __( 'Uptime', 'wphb' ), array( $this, 'uptime_disabled_metabox' ), null, null, 'box-uptime-disabled', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		}
		else {
			$this->add_meta_box( 'uptime', __( 'Uptime', 'wphb' ), array( $this, 'uptime_metabox' ), array( $this, 'uptime_metabox_header' ), null, 'main', null );
		}

	}

	private function run_actions() {
		$action = isset( $_GET['action'] ) ? $_GET['action'] : false;

		if ( 'enable' === $action ) {
			check_admin_referer( 'wphb-toggle-uptime' );

			if ( ! current_user_can( wphb_get_admin_capability() ) )
				return;

			$result = wphb_uptime_enable();
			if ( is_wp_error( $result ) ) {
				$redirect_to = add_query_arg( 'error', 'true', wphb_get_admin_menu_url( 'uptime' ) );
				$redirect_to = add_query_arg( array(
					'code' => $result->get_error_code(),
					'message' => urlencode( $result->get_error_message() )
				), $redirect_to );
				wp_redirect( $redirect_to );
				exit;
			}

			$redirect_to = add_query_arg( 'run', 'true', wphb_get_admin_menu_url( 'uptime' ) );
			$redirect_to = add_query_arg( '_wpnonce', wp_create_nonce( 'wphb-run-uptime' ), $redirect_to );

			wp_redirect( $redirect_to );
			exit;
		}

		if ( 'disable' === $action ) {
			check_admin_referer( 'wphb-toggle-uptime' );

			if ( ! current_user_can( wphb_get_admin_capability() ) )
				return;

			wphb_uptime_disable();

			wp_redirect( wphb_get_admin_menu_url( 'uptime' ) );
		}

		if ( isset( $_GET['run'] ) ) {
			check_admin_referer( 'wphb-run-uptime' );

			if ( ! current_user_can( wphb_get_admin_capability() ) )
				return;

			// Start the test
			wphb_uptime_clear_cache();

			// Start the test
			wphb_uptime_get_last_report( 'week', true );

			wp_redirect( remove_query_arg( array( 'run', '_wpnonce' ) ) );
			exit;
		}
	}

	public function on_load() {
		if ( isset( $_GET['activate'] ) && current_user_can( wphb_get_admin_capability() ) ) {
			check_admin_referer( 'activate-uptime' );

			$options = wphb_get_settings();
			$options['uptime'] = true;
			wphb_update_settings( $options );

			wp_redirect( esc_url( wphb_get_admin_menu_url( 'uptime' ) ) );
			exit;
		}
	}

	public function enqueue_scripts( $hook ) {
		parent::enqueue_scripts( $hook );
		wp_enqueue_script( 'wphb-google-chart', "https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['line']}]}", array( 'jquery' ) );
	}

	public function uptime_disabled_metabox() {
		// Get current user name
		$user = wphb_get_current_user_info();
		$activate_url = add_query_arg( 'action', 'enable', wphb_get_admin_menu_url( 'uptime' ) );
		$activate_url = wp_nonce_url( $activate_url, 'wphb-toggle-uptime' );
		$this->view( 'uptime/disabled-meta-box', array( 'user' => $user, 'activate_url' => $activate_url ) );
	}

	private function get_data_ranges() {
		return array(
			'day' => __( 'Last Day', 'wphb' ),
			'week' => __( 'Last Week', 'wphb' ),
			'month' => __( 'Last Month', 'wphb' )
		);
	}

	private function get_current_data_range() {
		return isset( $_GET['data-range'] ) && array_key_exists( $_GET['data-range'], $this->get_data_ranges() ) ? $_GET['data-range'] : 'week';
	}

	protected function render_inner_content() {
		$data_ranges = $this->get_data_ranges();
		$data_range = $this->get_current_data_range();

		$error = false;

		/** @var WP_Hummingbird_Module_Uptime $module */
		$module = wphb_get_module( 'uptime' );
		$is_active = $module->is_active();

		if ( $is_active ) {
			$uptime_stats = wphb_uptime_get_last_report( $data_range );
			if ( isset( $uptime_stats->code ) && $is_active ) {
				$error = $uptime_stats->message;
			}
			elseif ( false === $uptime_stats ) {
				$is_active = false;
			}
		}

		$retry_url = add_query_arg(
			array(
				'_wpnonce' => wp_create_nonce( 'wphb-toggle-uptime' ),
				'action' => 'enable'
			),
			wphb_get_admin_menu_url( 'uptime' )
		);


		$args = array(
			'error' => $error,
			'retry_url' => $retry_url
		);

		$this->view( $this->slug . '-page', $args );
	}

	public function get_current_report() {
		if ( ! is_null( $this->current_report ) ) {
			return $this->current_report;
		}

		$data_ranges = $this->get_data_ranges();
		$data_range = isset( $_GET['data-range'] ) && array_key_exists( $_GET['data-range'], $data_ranges ) ? $_GET['data-range'] : 'week';
		$this->current_report = wphb_uptime_get_last_report( $data_range );
		return $this->current_report;
	}

	public function uptime_metabox_header() {
		$stats = $this->get_current_report();
		$manage_link = 'https://premium.wpmudev.org/dashboard/my-websites';
		if ( is_object( $stats ) && isset( $stats->manage_link ) ) {
			$manage_link = $stats->manage_link;
		}

		$this->view( 'uptime/meta-box-header', array( 'title' => __( 'Uptime', 'wphb' ), 'manage_link' => $manage_link ) );
	}

	public function uptime_metabox() {

		if ( ! wphb_is_member() ) {
			$this->view( 'uptime/summary-membership-meta-box' );
			return;
		}

		$error = '';

		$stats = wphb_uptime_get_last_report( $this->get_current_data_range() );
		if ( is_wp_error( $stats ) ) {
			$error = $stats->get_error_message();
			$error_type = 'error';
		}
		else {
			if ( isset( $_GET['error'] ) ) {
				$error = urldecode($_GET['message'] );
				$error_type = 'error';
			}
		}

		$retry_url = add_query_arg( 'run', 'true' );
		$retry_url = wp_nonce_url( $retry_url, 'wphb-run-uptime' );

		$support_url = 'https://premium.wpmudev.org/forums/forum/support#question';

		$args = array(
			'uptime_stats' => $stats,
			'data_ranges' => $this->get_data_ranges(),
			'data_range_selected' => isset( $_GET['data-range'] ) && array_key_exists( $_GET['data-range'], $this->get_data_ranges() ) ? $_GET['data-range'] : 'week',
			'error' => $error,
			'retry_url' => $retry_url,
			'support_url' => $support_url
		);

		if ( ! empty( $error_type ) ) {
			$args['error_type'] = $error_type;
		}

		$this->view( 'uptime/meta-box', $args );
	}

}