<?php

class WP_Hummingbird_Dashboard_Page extends WP_Hummingbird_Admin_Page {

	private static $current_uptime_report;


	public function __construct( $slug, $page_title, $menu_title, $parent = false, $render = true  ) {
		parent::__construct( $slug, $page_title, $menu_title, $parent, $render );
	}

	public function on_load() {
		if ( is_multisite() && ! is_network_admin() ) {
			wphb_minification_maybe_stop_checking_files();
		}
	}

	public function render_header() {
		?>
		<section id="header">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<div class="actions label-and-button">
				<p class="actions-label"><?php _e( 'Having problems? Start fresh and go back to the defaults <strong>[Reset Settings]</strong>', 'wphb' ); ?></p>
				<a href="<?php echo esc_url( add_query_arg( 'wphb-clear', 'true' ) ); ?>" class="button button-small button-app actions-button"><?php _e( 'Clear', 'wphb' ); ?></a>
			</div>
		</section><!-- end header -->
		<?php
	}

	/**
	 * Run Performance, Minification, Uptime...
	 *
	 * @param string $type
	 */
	private function run_actions( $type ) {

		check_admin_referer( 'wphb-run-dashboard' );

		if ( ! current_user_can( wphb_get_admin_capability() ) )
			return;

		if ( 'performance' === $type && wphb_is_member() ) {
			// Start performance test
			wphb_performance_init_scan();
			wp_redirect( remove_query_arg( array( 'run', '_wpnonce' ) ) );
			exit;
		}

		if ( 'minification' === $type ) {
			// Minification scan
			wphb_minification_init_scan();
			wp_redirect( remove_query_arg( array( 'run', '_wpnonce' ) ) );
			exit;
		}

		if ( 'uptime' === $type ) {
			// Minification scan
			wphb_uptime_get_last_report( 'week', true );
			wp_redirect( remove_query_arg( array( 'run', '_wpnonce' ) ) );
			exit;
		}

		if ( 'cf-deactivate' === $type ) {
			wphb_cloudflare_disconnect();
			wp_redirect( remove_query_arg( array( 'run', '_wpnonce' ) ) );
			exit;
		}
	}


	public function register_meta_boxes() {

		if ( isset( $_GET['run'] ) && isset( $_GET['type'] ) ) {
			$this->run_actions( $_GET['type'] );
		}


		if ( ! get_user_meta( get_current_user_id(), 'wphb-hide-welcome-box' ) ) {
			//$user = wp_get_current_user();
			//$user = $user->user_nicename;
			$user = wphb_get_current_user_info();
			$this->add_meta_box( 'dashboard/welcome', sprintf( __( 'Welcome %s', 'wphb' ), $user) , array( $this, 'dashboard_welcome_metabox' ), null, null, 'main', array( 'box_class' => 'dev-box can-close content-box content-box-two-cols-image-left' ) );
		}

		/* Performance */
		$last_report = wphb_performance_get_last_report();
		if ( ! wphb_is_member() ) {
			$this->add_meta_box( 'dashboard/performance/no-membership', __( 'Performance Report', 'wphb' ), null, null, null, 'box-dashboard-left', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		} elseif ( wphb_is_member() && wphb_performance_is_doing_report() ) {
			$this->add_meta_box( 'dashboard/performance/running-test', __( 'Performance test in progress', 'wphb' ), null, null, null, 'box-dashboard-left' );
		}
		elseif ( wphb_is_member() && ! wphb_performance_is_doing_report() && $last_report && ! is_wp_error( $last_report ) ) {
			$this->add_meta_box( 'dashboard-performance-module-resume', __( 'Performance Report', 'wphb' ), array( $this, 'dashboard_performance_module_resume_metabox' ), array( $this, 'dashboard_performance_module_resume_metabox_header' ), null, 'main', array( 'box_content_class' => 'box-content no-vertical-padding' ) );
			$this->add_meta_box( 'dashboard-performance-module', __( 'Performance Report', 'wphb' ), array( $this, 'dashboard_performance_module_metabox' ), array( $this, 'dashboard_performance_module_metabox_header' ), array( $this, 'dashboard_performance_module_metabox_footer' ), 'box-dashboard-left', array( 'box_class' => 'dev-box content-box content-box-one-col-center', 'box_footer_class' => 'box-footer buttons') );
		}
		elseif ( is_wp_error( $last_report ) ) {
			$this->add_meta_box( 'dashboard-performance-module-error', __( 'Performance Report', 'wphb' ), array( $this, 'dashboard_performance_module_error_metabox' ), null, null, 'box-dashboard-left', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		}
		else {
			$this->add_meta_box( 'dashboard-performance-disabled', __( 'Performance Report', 'wphb' ), array( $this, 'dashboard_performance_disabled_metabox' ), null, null, 'box-dashboard-left', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		}


		/* Minification */
		$collection = wphb_minification_get_resources_collection();
		$module = wphb_get_module( 'minify' );

		if ( ! $module->can_execute_php() ) {
			$this->add_meta_box( 'dashboard/minification/cant-execute-php', __( 'Minification', 'wphb' ), null, null, null, 'box-dashboard-right', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		}
		elseif ( is_multisite() && is_network_admin() ) {
			// Minification metabox is different on network admin
			$this->add_meta_box( 'dashboard/minification/network-module', __( 'Minification', 'wphb' ), array( $this, 'dashboard_minification_network_module_metabox' ), null, null, 'box-dashboard-right', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		}
		else {
			if ( wphb_minification_is_checking_files() ) {
				$this->add_meta_box( 'dashboard-minification-checking-files', __( 'File check in progress', 'wphb' ), array( $this, 'dashboard_minification_checking_files_metabox' ), null, null, 'box-dashboard-right' );
			}
			elseif ( ! wphb_minification_is_checking_files() && ( ! empty( $collection['styles'] ) || ! empty( $collection['scripts'] ) ) ) {
				$this->add_meta_box( 'dashboard-minification-module', __( 'Minification', 'wphb' ), array( $this, 'dashboard_minification_module_metabox' ), array( $this, 'dashboard_minification_module_metabox_header' ), null, 'box-dashboard-right' );
			}
			else {
				$this->add_meta_box( 'dashboard-minification-disabled', __( 'Minification', 'wphb' ), array( $this, 'dashboard_minification_disabled_metabox' ), null, null, 'box-dashboard-right', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
			}
		}

		/* Caching */
		$caching_status = wphb_get_caching_status();
		if ( is_array( $caching_status ) && array_sum( $caching_status ) ) {
			$this->add_meta_box( 'dashboard-caching-module', __( 'Browser Caching', 'wphb' ), array( $this, 'dashboard_caching_module_metabox' ), array( $this, 'dashboard_caching_module_metabox_header' ), null, 'box-dashboard-left' );
		}
		else {
			$this->add_meta_box( 'dashboardcaching-disabled', __( 'Browser Caching', 'wphb' ), array( $this, 'dashboard_caching_disabled_metabox' ), null, null, 'box-dashboard-left', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		}

		/* GZIP */
		$gzip_status = wphb_get_gzip_status();
		if ( is_array( $gzip_status ) && array_sum( $gzip_status ) ) {
			$this->add_meta_box( 'dashboard-gzip-module', __( 'GZIP Compression', 'wphb' ), array( $this, 'dashboard_gzip_module_metabox' ), array( $this, 'dashboard_gzip_module_metabox_header' ), null, 'box-dashboard-right' );
		}
		else {
			$this->add_meta_box( 'dashboard-gzip-disabled', __( 'GZIP Compression', 'wphb' ), array( $this, 'dashboard_gzip_disabled_metabox' ), null, null, 'box-dashboard-right', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		}

		/* Uptime */
		$uptime_module = wphb_get_module( 'uptime' );
		$is_active = $uptime_module->is_active();
		$report = wphb_uptime_get_last_report( 'week' );

		if ( ! wphb_is_member() ) {
			$this->add_meta_box( 'dashboard/uptime/no-membership', __( 'Uptime Monitoring', 'wphb' ), null, null, null, 'box-dashboard-left', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		}
		elseif ( is_wp_error( $report ) && $is_active ) {
			$this->add_meta_box( 'uptime-error', __( 'Uptime', 'wphb' ), array( $this, 'dashboard_uptime_error_metabox' ), null, null, 'box-dashboard-left', null );
		}
		elseif ( ! $is_active ) {
			$this->add_meta_box( 'uptime-disabled', __( 'Uptime', 'wphb' ), array( $this, 'dashboard_uptime_disabled_metabox' ), null, null, 'box-dashboard-left', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		}
		else {
			$this->add_meta_box( 'uptime', __( 'Uptime', 'wphb' ), array( $this, 'dashboard_uptime_metabox' ), array( $this, 'dashboard_uptime_module_metabox_header' ), array( $this, 'dashboard_uptime_module_metabox_footer' ), 'box-dashboard-left', null );
		}

		/* Smush */
		$this->add_meta_box( 'dashboard-smush', __( 'Image Optimization', 'wphb' ), array( $this, 'dashboard_smush_metabox' ), array( $this, 'dashboard_smush_metabox_header' ), null, 'box-dashboard-right', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );

		/* CloudFlare */
		$this->add_meta_box( 'dashboard/cloudflare', 'CloudFlare', array( $this, 'dashboard_cloudflare_metabox' ), null, null, 'box-dashboard-right', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
	}

	public function dashboard_welcome_metabox() {
		//$user = wp_get_current_user();
		//$user = $user->user_nicename;
		$user = wphb_get_current_user_info();
		$this->view( 'dashboard/welcome/meta-box', array( 'user' => $user ) );
	}

	public function dashboard_welcome_metabox_header() {
		//$user = wp_get_current_user();
		//$user = $user->user_nicename;
		$user = wphb_get_current_user_info();
		$this->view( 'dashboard/welcome/meta-box-header', array( 'title' => sprintf( __( 'Welcome %s', 'wphb' ), $user) ) );
	}

	/*******************
	 * CACHING         *
	 *******************/
	public function dashboard_caching_module_metabox() {
		$caching_status = wphb_get_caching_status();
		$human_results = array_map( 'wphb_human_read_time_diff', $caching_status );
		$recommended = wphb_get_recommended_caching_values();

		/** @var WP_Hummingbird_Module_Cloudflare $cf_module */
		$cf_module = wphb_get_module( 'cloudflare' );
		$cf_active = false;
		$cf_current_human = '';
		$cf_tooltip = '';
		$cf_current = '';
		if ( $cf_module->is_active() && $cf_module->is_connected() && $cf_module->is_zone_selected() ) {
			$cf_active = true;
			$cf_current = $cf_module->get_caching_expiration();
			if ( is_wp_error( $cf_current ) ) {
				$cf_current = '';
			}

			$cf_tooltip = $cf_current == 691200 ? __('Caching is enabled', 'wphb') : __('Caching is enabled but you aren\'t using our recommended value', 'wphb');
			$cf_current_human = wphb_human_read_time_diff( $cf_current );
		}

		$args = array(
			'results'       => $caching_status,
			'recommended'   => $recommended,
			'human_results' => $human_results,
			'cf_tooltip' => $cf_tooltip,
			'cf_current' => $cf_current,
			'cf_current_human' => $cf_current_human,
			'cf_active' => $cf_active
		);
		$this->view( 'dashboard/caching/module-meta-box', $args );
	}

	public function dashboard_caching_disabled_metabox() {
		$caching_url = wphb_get_admin_menu_url( 'caching' );
		$this->view( 'dashboard/caching/disabled-meta-box', array( 'caching_url' => $caching_url ) );
	}

	public function dashboard_caching_module_metabox_header() {
		$caching_url = wphb_get_admin_menu_url( 'caching' );
		$this->view( 'dashboard/caching/module-meta-box-header', array( 'caching_url' => $caching_url, 'title' => __( 'Browser Caching', 'wphb' ) ) );
	}

	/*******************
	 * UPTIME          *
	 *******************/
	public function dashboard_uptime_module_metabox_header() {
		$this->view( 'dashboard/uptime/module-meta-box-header', array( 'title' => __( 'Uptime Monitoring', 'wphb' ) ) );
	}
	public function dashboard_uptime_metabox() {
		$uptime_stats = wphb_uptime_get_last_report( 'week' );
		$this->view( 'dashboard/uptime/module-meta-box', array( 'uptime_stats' => $uptime_stats ) );
	}
	public function dashboard_uptime_module_metabox_footer() {
		$viewreport_link = wphb_get_admin_menu_url( 'uptime' );
		$this->view( 'dashboard/uptime/module-meta-box-footer', array( 'viewreport_link' => $viewreport_link ) );
	}
	public function dashboard_uptime_disabled_metabox() {
		$user = wphb_get_current_user_info();
		$enable_url = add_query_arg( 'action', 'enable', wphb_get_admin_menu_url( 'uptime' ) );
		$enable_url = wp_nonce_url( $enable_url, 'wphb-toggle-uptime' );
		$this->view( 'dashboard/uptime/disabled-meta-box', array( 'enable_url' => $enable_url, 'current_user' => $user ) );
	}
	public function dashboard_uptime_error_metabox() {
		$report = wphb_uptime_get_last_report();
		$retry_url = add_query_arg(
			array(
				'run' => 'true',
				'type' => 'uptime'
			),
			wphb_get_admin_menu_url( '' )
		);
		$retry_url = wp_nonce_url( $retry_url, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-uptime-module';
		$support_url = wphb_support_link();
		$error = $report->get_error_message();

		$this->view( 'dashboard/uptime/error-meta-box', array( 'retry_url' => $retry_url, 'support_url' => $support_url, 'error' => $error ) );
	}

	/*******************
	 * MINIFICATION    *
	 *******************/
	public function dashboard_minification_module_metabox() {
		$collection = wphb_minification_get_resources_collection();
		// Remove those assets that we don't want to display
		foreach ( $collection['styles'] as $key => $item ) {
			if ( ! apply_filters( 'wphb_minification_display_enqueued_file', true, $item, 'styles' ) ) {
				unset( $collection['styles'][ $key ] );
			}
		}
		foreach ( $collection['scripts'] as $key => $item ) {
			if ( ! apply_filters( 'wphb_minification_display_enqueued_file', true, $item, 'scripts' ) ) {
				unset( $collection['scripts'][ $key ] );
			}
		}

		$enqueued_files = count( $collection['scripts'] ) + count( $collection['styles'] );

		$original_size_styles = array_sum( wp_list_pluck( $collection['styles'], 'original_size' ) );
		$original_size_scripts = array_sum( wp_list_pluck( $collection['scripts'], 'original_size' ) );
		$original_size = number_format_i18n( $original_size_scripts + $original_size_styles, 1 );

		$compressed_size_styles = array_sum( wp_list_pluck( $collection['styles'], 'compressed_size' ) );
		$compressed_size_scripts = array_sum( wp_list_pluck( $collection['scripts'], 'compressed_size' ) );
		$compressed_size = number_format_i18n( $compressed_size_scripts + $compressed_size_styles, 1 );

		if ( ( $original_size_scripts + $original_size_styles ) <= 0 ) {
			$percentage = 0;
		}
		else {
			$percentage = 100 - ( ( $compressed_size * 100 ) / $original_size );
		}
		$percentage = number_format_i18n( $percentage, 2 );

		$compressed_size_styles = number_format( $compressed_size_styles / 100, 1 );
		$compressed_size_scripts = number_format( $compressed_size_scripts / 100, 1 );

		$args = compact( 'enqueued_files', 'original_size', 'compressed_size', 'compressed_size_scripts', 'compressed_size_styles', 'percentage' );
		$this->view( 'dashboard-minification-module-meta-box', $args );
	}

	public function dashboard_minification_network_module_metabox() {
		$args = array(
			'use_cdn' => wphb_get_setting( 'use_cdn' ),
			'use_cdn_disabled' => ! wphb_is_member(),
		);
		$this->view( 'dashboard/minification/network-module-meta-box', $args );
	}

	public function dashboard_minification_module_metabox_header() {
		$minification_url = wphb_get_admin_menu_url( 'minification' );
		$this->view( 'dashboard-minification-module-meta-box-header', array( 'minification_url' => $minification_url, 'title' => __( 'Minification', 'wphb' ) ) );
	}

	public function dashboard_minification_disabled_metabox() {
		$minification_url = add_query_arg(
			array(
				'run' => 'true',
				'type' => 'minification'
			),
			wphb_get_admin_menu_url( '' )
		);
		$minification_url = wp_nonce_url( $minification_url, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-minification-checking-files';
		$this->view( 'dashboard-minification-disabled-meta-box', array( 'minification_url' => $minification_url ) );
	}

	/*******************
	 * GZIP            *
	 *******************/
	public function dashboard_gzip_module_metabox() {
		$status = wphb_get_gzip_status();
		$this->view( 'dashboard/gzip/module-meta-box', array( 'status' => $status ) );
	}

	public function dashboard_gzip_module_metabox_header() {
		$gzip_url = wphb_get_admin_menu_url( 'gzip' );
		$this->view( 'dashboard/gzip/module-meta-box-header', array( 'gzip_url' => $gzip_url, 'title' => __( 'GZIP Compression', 'wphb' ) ) );
	}

	public function dashboard_gzip_disabled_metabox() {
		$gzip_url = wphb_get_admin_menu_url( 'gzip' );
		$this->view( 'dashboard/gzip/disabled-meta-box', array( 'gzip_url' => $gzip_url ) );
	}

	/********************
	 * PERFORMANCE      *
	 ********************/
	public function dashboard_performance_disabled_metabox() {
		if ( wphb_is_member() ) {
			$run_url = add_query_arg(
				array(
					'run' => 'true',
					'type' => 'performance'
				),
				wphb_get_admin_menu_url( '' )
			);
			$run_url = wp_nonce_url( $run_url, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-performance-running-test';
		}
		else {
			// Just redirect to dashboard page
			$run_url = wphb_get_admin_menu_url( 'performance' );
		}

		$this->view( 'dashboard/performance/disabled-meta-box', array( 'run_url' => $run_url ) );
	}

	public function dashboard_performance_module_metabox() {
		$last_report = wphb_performance_get_last_report();
		$last_report = $last_report->data;

		$this->view( 'dashboard/performance/module-meta-box', array( 'report' => $last_report ) );
	}

	public function dashboard_performance_module_metabox_header() {
		$title =  __( 'Performance Report', 'wphb' );
		$last_report = wphb_performance_get_last_report();
		if ( $last_report && ! is_wp_error( $last_report ) ) {
			$last_report = $last_report->data;
		}

		$this->view( 'dashboard/performance/module-meta-box-header', array( 'title' => $title, 'last_report' => $last_report ) );
	}

	public function dashboard_performance_module_metabox_footer() {
		$viewreport_link = wphb_get_admin_menu_url( 'performance' );
		$scan_link = add_query_arg( array(
				'run' => 'true',
				'type' => 'performance'
			),
			wphb_get_admin_menu_url( '' )
		);
		$scan_link = wp_nonce_url( $scan_link, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-performance-running-test';
		$this->view( 'dashboard/performance/module-meta-box-footer', array( 'viewreport_link' => $viewreport_link, 'scan_link' => $scan_link ) );
	}

	public function dashboard_performance_module_resume_metabox() {
		$last_report = wphb_performance_get_last_report();
		$last_report = $last_report->data;
		$run_url = add_query_arg(
			array(
				'run' => 'true',
				'type' => 'performance'
			),
			wphb_get_admin_menu_url( '' )
		);
		$run_url = wp_nonce_url( $run_url, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-performance-module-resume';

		$improvement = 0;
		$last_score = false;
		$improve_class = '';
		if ( $last_report->last_score ) {
			$improvement = $last_report->score - $last_report->last_score['score'];
			$last_score = $last_report->last_score['score'];
			if ( $improvement > 0 ) {
				$improve_class = 'success';
			}
			elseif ( $improvement < 0 ) {
				$improve_class = 'error';
			}
			else {
				$improve_class = 'warning';
			}
		}

		$this->view( 'performance/module-resume-meta-box', array( 'last_report' => $last_report, 'run_url' => $run_url, 'improve_class' => $improve_class, 'improvement' => $improvement, 'last_score' => $last_score ) );
	}

	public function dashboard_performance_module_resume_metabox_header() {}

	public function dashboard_performance_module_error_metabox() {
		/** @var WP_Error $last_report */
		$last_report = wphb_performance_get_last_report();
		$retry_url = add_query_arg( array(
				'run' => 'true',
				'type' => 'performance'
			),
			wphb_get_admin_menu_url( '' )
		);
		$retry_url = wp_nonce_url( $retry_url, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-performance-running-test';

		$support_url = wphb_support_link();
		$error = $last_report->get_error_message();
		$this->view( 'dashboard/performance/module-error-meta-box', compact( 'error', 'retry_url', 'support_url' ) );
	}

	/*********************************
	/** SMUSH                        *
	 *********************************/
	public function dashboard_smush_metabox() {
		global $wpsmushit_admin;
		$smush_data = array( 'human' => '', 'percent' => 0 );
		$total_saving = '';
		if ( is_a( $wpsmushit_admin, 'WpSmushitAdmin' ) ) {
			$smush_data = $wpsmushit_admin->global_stats();
		}
		$this->view(
			'dashboard/smush/meta-box',
			array(
				'update_membership_url' => wphb_update_membership_link(),
				'activate_url' => wp_nonce_url( 'plugins.php?action=activate&amp;plugin=wp-smush-pro/wp-smush.php', 'activate-plugin_wp-smush-pro/wp-smush.php' ),
				'is_active' => wphb_smush_is_smush_active(),
				'is_installed' => wphb_smush_is_smush_installed(),
				'smush_data' => $smush_data
			)
		);
	}
	public function dashboard_smush_metabox_header() {
		$title =  __( 'Image Optimization', 'wphb' );
		$this->view( 'dashboard/smush/meta-box-header', array( 'title' => $title, 'is_active' => wphb_smush_is_smush_active(), 'is_installed' => wphb_smush_is_smush_installed() ) );
	}

	/**
	 * CLOUDFLARE
	 */
	public function dashboard_cloudflare_metabox() {
		$this->view( 'dashboard/cloudflare/meta-box' );
	}
}