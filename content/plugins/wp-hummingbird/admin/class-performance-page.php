<?php

class WP_Hummingbird_Performance_Report_Page extends WP_Hummingbird_Admin_Page {

	public function render_header() {
		$last_report = wphb_performance_get_last_report();
		$run_url = add_query_arg( 'run', 'true', wphb_get_admin_menu_url( 'performance' ) );
		$run_url = wp_nonce_url( $run_url, 'wphb-run-performance-test' );
		$next_test_on = WP_Hummingbird_Module_Performance::can_run_test();
		?>
		<section id="header">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<div class="actions label-and-button">
				<?php if ( $last_report && ! is_wp_error( $last_report ) ): ?>
					<?php
						$data_time = strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $last_report->data->time ) ) );
						$disabled = true !== $next_test_on;
					?>
					<p class="actions-label">
						<?php printf( __('Your last performance test was on <strong>%s</strong> at <strong>%s</strong>', 'wphb' ), date_i18n( get_option( 'date_format' ), $data_time ), date_i18n( get_option( 'time_format' ), $data_time ) ); ?>
						<?php if ( $disabled ): ?>
							<br/><?php printf( __( 'Hummingbird is just catching her breath. <strong>Run again in %d minutes</strong>', 'wphb' ), $next_test_on ) ;?>
						<?php endif; ?>
					</p>
					<?php if ( ! $disabled ): ?>
						<a href="<?php echo esc_url( $run_url ); ?>" <?php disabled( $disabled ); ?> class="button button-small button-app actions-button"><?php _e( 'Run Test', 'wphb' ); ?></a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</section><!-- end header -->

		<?php
	}

	public function register_meta_boxes() {

		if ( isset( $_GET['run'] ) ) {
			check_admin_referer( 'wphb-run-performance-test' );

			if ( ! current_user_can( wphb_get_admin_capability() ) )
				return;

			// Start the test
			wphb_performance_clear_cache();
			wphb_performance_init_scan();

			// This will trigger the popup
			wphb_performance_set_doing_report( true );

			wp_redirect( remove_query_arg( array( 'run', '_wpnonce' ) ) );
			exit;
		}

		$last_test = wphb_performance_get_last_report();

		$is_member = wphb_is_member();

		if ( ( !$is_member) || ( !$last_test && $is_member ) ) {
			$this->add_meta_box( 'performance-summary', __( 'Summary', 'wphb' ), array( $this, 'performance_summary_metabox' ), array( $this, 'performance_summary_metabox_header' ), null, 'main', array( 'box_class' => 'dev-box content-box-one-col-center' ) );
		}
		elseif ( is_wp_error( $last_test ) ) {
			$this->add_meta_box( 'performance-summary', __( 'Summary', 'wphb' ), array( $this, 'performance_summary_metabox' ), array( $this, 'performance_summary_metabox_header' ), null, 'main', array( 'box_class' => 'dev-box content-box-one-col-center', 'box_content_class' => 'box-content no-side-padding' ) );
		}
		else {
			$this->add_meta_box( 'dashboard-performance-module-resume', __( 'Performance Report', 'wphb' ), array( $this, 'performance_module_resume_metabox' ), array( $this, 'dashboard_performance_module_resume_metabox_header' ), null, 'main', array( 'box_content_class' => 'box-content no-vertical-padding' ) );
			$this->add_meta_box( 'performance-summary', __( 'Summary', 'wphb' ), array( $this, 'performance_summary_metabox' ), array( $this, 'performance_summary_metabox_header' ), null, 'main', array( 'box_class' => 'dev-box content-box-one-col-center', 'box_content_class' => 'box-content no-side-padding' ) );
		}

	}

	public function performance_summary_metabox() {
		$last_test = wphb_performance_get_last_report();
		$doing_report = wphb_performance_is_doing_report();

		$is_member = wphb_is_member();

		$error_details = '';
		if ( ! $is_member ) {
			$this->view( 'performance/summary-membership-meta-box' );
		} elseif ( $last_test && $is_member ) {
			if ( is_wp_error( $last_test ) ) {
				$error = $last_test->get_error_message();
				$error_details = $last_test->get_error_data();
				if ( is_array( $error_details ) && isset( $error_details['details'] ) ) {
					$error_details = $error_details['details'];
				}
				else {
					$error_details = '';
				}
			}
			else {
				$last_test = $last_test->data;
				$error = false;
			}

			$retry_url = add_query_arg( 'run', 'true', wphb_get_admin_menu_url( 'performance' ) );
			$retry_url = wp_nonce_url( $retry_url, 'wphb-run-performance-test' );

			$this->view( 'performance/summary-meta-box', array( 'last_test' => $last_test, 'error' => $error, 'error_details' => $error_details, 'retry_url' => $retry_url ) );
		} else {
			$this->view( 'performance/empty-summary-meta-box', array( 'doing_report' => $doing_report ) );
		}

	}

	public function performance_module_resume_metabox() {
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

	public function performance_module_resume_metabox_header() {}


	public function performance_summary_metabox_header() {
		$title =  __( 'Summary', 'wphb' );
		$last_report = wphb_performance_get_last_report();
		if ( $last_report && ! is_wp_error( $last_report ) ) {
			$last_report = $last_report->data;
		}
		$this->view( 'performance/summary-meta-box-header', array( 'title' => $title, 'last_report' => $last_report ) );
	}


}