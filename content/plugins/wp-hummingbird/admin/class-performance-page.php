<?php

class WP_Hummingbird_Performance_Report_Page extends WP_Hummingbird_Admin_Page {

	/**
	 * Number of recommended improvements.
	 *
	 * @since 1.4.5
	 * @var int $recommendations Number of recommendations.
	 */
    public $recommendations;

	/**
     * Status of error. If true, than we have some error.
     *
	 * @var bool $has_error True if error present.
	 */
    public $has_error;

	/**
	 * WP_Hummingbird_Performance_Report_Page constructor.
	 *
	 * @param $slug
	 * @param $page_title
	 * @param $menu_title
	 * @param bool $parent
	 * @param bool $render
	 */
    public function __construct( $slug, $page_title, $menu_title, $parent = false, $render = true ) {
	    parent::__construct( $slug, $page_title, $menu_title, $parent, $render );

	    //$this->recommendations = wphb_get_number_of_issues( 'performance' );
	    //$this->get_error_status();
    }

	public function render_header() {
		$this->recommendations = wphb_get_number_of_issues( 'performance' );
		$this->get_error_status();

		$last_report = wphb_performance_get_last_report();
		$run_url = add_query_arg( 'run', 'true', wphb_get_admin_menu_url( 'performance' ) );
		$run_url = wp_nonce_url( $run_url, 'wphb-run-performance-test' );
		$next_test_on = WP_Hummingbird_Module_Performance::can_run_test();
		?>
        <div class="wphb-notice wphb-notice-success hidden" id="wphb-notice-performance-report-settings-updated">
            <p><?php _e( 'Settings updated', 'wphb' ); ?></p>
        </div>
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
						<a href="<?php echo esc_url( $run_url ); ?>" <?php disabled( $disabled ); ?> class="button"><?php _e( 'Run Test', 'wphb' ); ?></a>
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

		if ( ! $last_test ) {
			$this->add_meta_box( 'performance-summary', __( 'Summary', 'wphb' ), array( $this, 'performance_summary_metabox' ), array( $this, 'performance_summary_metabox_header' ), null, 'main', array( 'box_class' => 'dev-box content-box-one-col-center' ) );
		}
		elseif ( is_wp_error( $last_test ) ) {
			$this->add_meta_box( 'performance-summary', __( 'Summary', 'wphb' ), array( $this, 'performance_summary_metabox' ), array( $this, 'performance_summary_metabox_header' ), null, 'main', array( 'box_class' => 'dev-box content-box-one-col-center', 'box_content_class' => 'box-content no-side-padding' ) );
		}
		else {
			$this->add_meta_box( 'performance-welcome', null , array( $this, 'performance_welcome_metabox' ), null, null, 'summary', array( 'box_class' => 'dev-box content-box content-box-two-cols-image-left' ) );
			$this->add_meta_box( 'performance-summary', __( 'Improvements', 'wphb' ), array( $this, 'performance_summary_metabox' ), array( $this, 'performance_summary_metabox_header' ), null, 'main', array( 'box_class' => 'dev-box content-box-one-col-center', 'box_content_class' => 'box-content no-side-padding' ) );
			if ( ! wphb_is_member() ) {
				$this->add_meta_box( 'performance-summary', __( 'Reporting', 'wphb' ), array( $this, 'reporting_metabox' ), array( $this, 'reporting_metabox_header' ), array( $this, 'reporting_metabox_footer' ), 'reports', array( 'box_class' => 'dev-box content-box-one-col-center', 'box_content_class' => 'box-content no-padding' ) );
            } else {
				$this->add_meta_box( 'performance-summary', __( 'Reporting', 'wphb' ), array( $this, 'reporting_metabox' ), array( $this, 'reporting_metabox_header' ), null, 'reports', array( 'box_class' => 'dev-box content-box-one-col-center', 'box_content_class' => 'box-content no-padding' ) );
            }

		}

	}

	public function performance_summary_metabox() {
		$last_test = wphb_performance_get_last_report();
		$doing_report = wphb_performance_is_doing_report();

		$error_details = '';
		$error_text = '';
		if ( $last_test ) {
			if ( is_wp_error( $last_test ) ) {
				$error_text = $last_test->get_error_message();
				$error_details = $last_test->get_error_data();
				if ( is_array( $error_details ) && isset( $error_details['details'] ) ) {
					$error_details = $error_details['details'];
				}
				else {
					$error_details = '';
				}

				$this->has_error = true;
			}
			else {
				$last_test = $last_test->data;
				/*$this->has_error = false;*/
			}

			$retry_url = add_query_arg( 'run', 'true', wphb_get_admin_menu_url( 'performance' ) );
			$retry_url = wp_nonce_url( $retry_url, 'wphb-run-performance-test' );

			$this->view( 'performance/summary-meta-box', array( 'last_test' => $last_test, 'error' => $this->has_error, 'error_details' => $error_details, 'error_text' => $error_text, 'retry_url' => $retry_url ) );
		} else {
			$this->view( 'performance/empty-summary-meta-box', array( 'doing_report' => $doing_report ) );
		}

	}

	public function performance_welcome_metabox() {
		$last_report = wphb_performance_get_last_report();
		$last_report = $last_report->data;

		$improvement = 0;
		$last_score = false;
		if ( $last_report->last_score ) {
			$improvement = $last_report->score - $last_report->last_score['score'];
			$last_score = $last_report->last_score['score'];
		}

		$this->view( 'performance/module-resume-meta-box', array( 'last_report' => $last_report, 'improvement' => $improvement, 'last_score' => $last_score, 'recommendations' => $this->recommendations ) );
    }

	public function performance_summary_metabox_header() {
		$title =  __( 'Improvements', 'wphb' );
		$last_report = wphb_performance_get_last_report();
		if ( $last_report && ! is_wp_error( $last_report ) ) {
			$last_report = $last_report->data;
		}
		$this->view( 'performance/summary-meta-box-header', array( 'title' => $title, 'last_report' => $last_report ) );
	}

	/**
	 * Reporting meta box.
     *
     * @since 1.4.5
	 */
	public function reporting_metabox() {
	    $settings = wphb_get_settings();

	    $notification = $settings['email-notifications'];
	    $frequency = $settings['email-frequency'];
	    $send_day = $settings['email-day'];
	    $send_time = $settings['email-time'];
	    $recipients = $settings['email-recipients'];

		$args = compact( 'notification', 'frequency', 'send_day', 'send_time', 'recipients' );
        $this->view( 'performance/reporting-meta-box', $args );
    }

	/**
	 * Reporting meta box header.
     *
     * @since 1.5.0
	 */
    public function reporting_metabox_header() {
	    $title = __( 'Reports', 'wphb' );
	    $this->view( 'performance/reporting-meta-box-header', array( 'title' => $title ) );
    }

	/**
	 * Reporting meta box footer.
     *
     * @since 1.5.0
	 */
    public function reporting_metabox_footer() {
        $this->view( 'performance/reporting-meta-box-footer', array() );
    }

	/**
	 * See if there are any errors. Set the variable to true if some errors are found.
     *
     * @since 1.4.5
	 */
    private function get_error_status() {
	    $this->has_error = false;
	    $last_test = wphb_performance_get_last_report();
	    if ( is_wp_error( $last_test ) ) {
		    $this->has_error = true;
	    }
    }

}