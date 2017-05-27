<?php

class WP_Hummingbird_Module_Performance extends WP_Hummingbird_Module {

	public function init() {}

	public function run() {}

	/**
	 * WP_Hummingbird_Module_Performance constructor.
	 *
	 * @param $slug
	 * @param $name
	 * @since 1.4.5
	 */
	public function __construct( $slug, $name ) {
		parent::__construct( $slug, $name );

		//process scan cron
		add_action( 'wphb_performance_scan', array( $this, 'process_scan_cron' ) );
	}

	/**
	 * Initializes the Performance Scan
	 */
	public static function init_scan() {
		// Start the test
		self::clear_cache();

		// Start the test
		self::set_doing_report( true );
		$api = wphb_get_api();
		$api->performance->ping();
	}

	/**
	 * Return the last Performance scan done data
	 *
	 * @return false|array|WP_Error Data of the last scan or false of there's not such data
	 */
	public static function get_last_report() {

		$report = get_site_option( 'wphb-last-report' );
		if ( $report ) {
			$last_score = get_site_option( 'wphb-last-report-score' );
			if ( $last_score && ! is_wp_error( $report ) ) {
				$report->data->last_score = $last_score;
			}
			elseif ( is_object( $report ) && ! is_wp_error( $report ) ) {
				$report->data->last_score = false;
			}
			return $report;
		}

		return false;
	}


	/**
	 * Check if WP Hummingbird is currently doing a Performance Scan
	 *
	 * @return false|int Timestamp when the report started, false if there's no report being executed
	 */
	public static function is_doing_report() {
		if ( get_site_option( 'wphb-stop-report' ) ) {
			return false;
		}

		return get_site_option( 'wphb-doing-report' );
	}

	/**
	 * Check if Performance Scan is currently halted
	 *
	 * @return bool
	 */
	public static function stopped_report() {
		return (bool)get_site_option( 'wphb-stop-report' );
	}

	/**
	 * Start a new Performance Scan
	 *
	 * It sets the new status for the report
	 *
	 * @param bool $status If set to true, it will start a new Performance Report, otherwise it will stop the current one
	 */
	public static function set_doing_report( $status = true ) {
		if ( ! $status ) {
			delete_site_option( 'wphb-doing-report' );
			update_site_option( 'wphb-stop-report', true );
		}
		else {
			// Set time when we started the report
			update_site_option( 'wphb-doing-report', current_time( 'timestamp' ) );
			delete_site_option( 'wphb-stop-report' );
		}
	}

	/**
	 * Get latest report from server
	 */
	public static function refresh_report() {
		self::set_doing_report( false );
		$api = wphb_get_api();
		$results = $api->performance->results();

		if ( is_wp_error( $results ) ) {
			// It's an error
			$results = new WP_Error(
				'performance-error',
				__( "The performance test didn't return any results. This probably means you're on a local website (which we can't scan) or something went wrong trying to access WPMU DEV. Try again and if this error continues to appear please open a ticket with our support heroes", 'wphb' ),
				array( 'details' => $results->get_error_message() )
			);
		}

		update_site_option( 'wphb-last-report', $results );
		// Send report to admin
		self::send_email_report( $results->data, get_option('admin_email') );
	}

	/**
	 * Check if time enough has passed to make another test ( 5 minutes )
	 *
	 * @return bool|integer True if a new test is available or the time in minutes remaining for next test
	 */
	public static function can_run_test() {
		$last_report = wphb_performance_get_last_report();
		$current_gmt_time = current_time( 'timestamp', true );
		if ( $last_report && ! is_wp_error( $last_report ) ) {
			$data_time = $last_report->data->time;
			if ( ( $data_time + 300 ) < $current_gmt_time ) {
				return true;
			}
			else {
				$remaining = ceil( ( ( $data_time + 300 ) - $current_gmt_time ) / 60 );
				return absint( $remaining );
			}
		}

		return true;
	}

	/**
	 * Clear Performance Module cache
	 */
	public static function clear_cache() {
		$last_report = get_site_option( 'wphb-last-report' );
		if ( $last_report && isset( $last_report->data->score ) ) {
			// Save latest score
			update_site_option( 'wphb-last-report-score', array( 'score' => $last_report->data->score ) );
		}

		delete_site_option( 'wphb-last-report' );
		delete_site_option( 'wphb-doing-report' );
		delete_site_option( 'wphb-stop-report' );
	}

	/**
	 * Ajax action for processing a scan on page
	 *
	 * @since 1.4.5
	 */
	public function process_scan_cron() {
		if ( ! wphb_is_member() ) {
			return;
		}

		// Clean all cron
		wp_clear_scheduled_hook( 'wphb_performance_scan' );

		$last_report = wphb_performance_get_last_report();
		if ( ! $last_report ) {
			// Start the test
			wphb_performance_clear_cache();
			wphb_performance_init_scan();

			// This will trigger the popup
			wphb_performance_set_doing_report( true );

			// Reschedule in 1 minute to collect results
			wp_schedule_single_event( strtotime( '+1 minutes' ), 'wphb_performance_scan' );
		} else {
		    // Schedule next test
			$now = current_time( 'timestamp' );
			if ( $now >= ( $last_report->data->time + 10 ) ) {
				// The scan should be completed
				$nextScanTime = self::get_scheduled_scan_time();
				// We will need to requeue the next scan
				wp_schedule_single_event( $nextScanTime, 'wphb_performance_scan' );
				// Send out report
				self::send_email_report( $last_report->data );
			}
        }
	}

	/**
	 * Get the schedule time for a scan
	 *
	 * @param $clearCron bool - force to clear scanning cron
	 * @return false|int
	 * @since 1.4.5
	 */
	public static function get_scheduled_scan_time( $clearCron = true ) {
		if ( $clearCron ) {
			wp_clear_scheduled_hook( 'wphb_performance_scan' );
		}
		$settings = wphb_get_settings();
		switch ( $settings['email-frequency'] ) {
			case '1':
				//check if the time is over or not, then send the date
				$timeString     = date( 'Y-m-d' ) . ' ' . $settings['email-time'] . ':00';
				$nextTimeString = date( 'Y-m-d', strtotime( 'tomorrow' ) ) . ' ' . $settings['email-time'] . ':00';
				break;
			case '7':
			default:
				$timeString     = date( 'Y-m-d', strtotime( $settings['email-day'] . ' this week' ) ) . ' ' . $settings['email-time'] . ':00';
				$nextTimeString = date( 'Y-m-d', strtotime( $settings['email-day'] . ' next week' ) ) . ' ' . $settings['email-time'] . ':00';
				break;
			case '30':
				$timeString     = date( 'Y-m-d', strtotime( $settings['email-day'] . ' this month' ) ) . ' ' . $settings['email-time'] . ':00';
				$nextTimeString = date( 'Y-m-d', strtotime( $settings['email-day'] . ' next month' ) ) . ' ' . $settings['email-time'] . ':00';
				break;
		}

		$toUTC = wphb_local_to_utc( $timeString );
		if ( $toUTC < time() ) {
			return wphb_local_to_utc( $nextTimeString );
		} else {
			return $toUTC;
		}
	}


	/**
	 * Send out an email report
	 *
	 * @param $last_report mixed Last report data.
	 * @param bool $admin_email Administrative email.
	 * @since 1.4.5
	 */
	private static function send_email_report( $last_report, $admin_email = false ) {

	    if ( wphb_performance_is_doing_report() )
	        return;

		$settings = wphb_get_settings();

		$issues = wphb_get_number_of_issues( 'performance' );

		if ( $issues == 0 ) {
			return;
		}

		// Check to see if we need to send out a report to admin
		if ( false === $admin_email ) {
			$recipients = $settings['email-recipients'];
        } else {
		    // Get report
			$user = get_user_by( 'email', $admin_email );
		    $recipients = array( 0 => $user->ID );
        }

		if ( empty( $recipients ) ) {
			return;
		}

		foreach ( $recipients as $user_id ) {
			$user = get_user_by( 'id', $user_id );
			if ( ! is_object( $user ) ) {
				continue;
			}
			// Prepare the parameters
			$email   = $user->user_email;
			$subject = sprintf( __( "Here's your latest performance test results for %s", 'wphb' ), network_site_url() );
			$params  = array(
				'USER_NAME'      => wphb_get_display_name( $user_id ),
				'SCAN_PAGE_LINK' => network_admin_url( 'admin.php?page=wphb-performance' ),
				'SITE_URL'       => network_site_url( 'wp-admin/admin.php?page=wphb' ),
                'SITE_NAME'      => get_bloginfo( 'name' ),
			);
			$email_content = self::issues_list_html( $last_report, $params );
			// Change nl to br
			$email_content = stripslashes( $email_content );
			$no_reply_email = "noreply@" . parse_url( get_site_url(), PHP_URL_HOST );
			$headers        = array(
				'From: Hummingbird <' . $no_reply_email . '>',
				'Content-Type: text/html; charset=UTF-8'
			);

			wp_mail( $email, $subject, $email_content, $headers );
		}

	}

	/**
	 * Build issues html table
	 *
	 * @access private
	 * @param $last_test mixed Latest test data.
     * @param $params array Additional data for report.
	 * @return string HTML for email.
	 * @since 1.4.5
	 */
	private static function issues_list_html( $last_test, $params ) {
		ob_start();
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width">
            <title><?php _e( 'Test results from Hummingbird', 'wphb' ); ?></title>
            <style>
                a:hover {
                    color: #333 !important;
                }
                a.brand-button:hover,
                button.brand-button:hover,
                a.brand-button:focus,
                button.brand-button:focus {
                    background: #008FCA !important;
                    color: #ffffff !important;
                }
                /* reports list */
                table.reports-list td.ok { color: #1ABC9C; }
                table.reports-list td.critical { color: #FF6D6D; }
                table.reports-list td.warning { color: #FECF2F; }

                @media only screen {
                    html {
                        min-height: 100%;
                        background: #e9ebe7;
                    }
                }

                @media only screen and (max-width: 596px) {
                    .small-float-center {
                        margin: 0 auto !important;
                        float: none !important;
                        text-align: center !important;
                    }
                    .small-text-center {
                        text-align: center !important;
                    }
                    .small-text-left {
                        text-align: left !important;
                    }
                    .small-text-right {
                        text-align: right !important;
                    }
                }

                @media only screen and (max-width: 596px) {
                    .hide-for-large {
                        display: block !important;
                        width: auto !important;
                        overflow: visible !important;
                        max-height: none !important;
                        font-size: inherit !important;
                        line-height: inherit !important;
                    }
                }

                @media only screen and (max-width: 596px) {
                    table.body table.container .hide-for-large,
                    table.body table.container .row.hide-for-large {
                        display: table !important;
                        width: 100% !important;
                    }
                }

                @media only screen and (max-width: 596px) {
                    table.body table.container .callout-inner.hide-for-large {
                        display: table-cell !important;
                        width: 100% !important;
                    }
                }

                @media only screen and (max-width: 596px) {
                    table.body table.container .show-for-large {
                        display: none !important;
                        width: 0;
                        mso-hide: all;
                        overflow: hidden;
                    }
                }

                @media only screen and (max-width: 596px) {
                    table.body img {
                        width: auto;
                        height: auto;
                    }
                    table.body center {
                        min-width: 0 !important;
                    }
                    table.body .container {
                        width: 95% !important;
                    }
                    table.body .columns,
                    table.body .column {
                        height: auto !important;
                        -moz-box-sizing: border-box;
                        -webkit-box-sizing: border-box;
                        box-sizing: border-box;
                        padding-left: 16px !important;
                        padding-right: 16px !important;
                    }
                    table.body .columns .column,
                    table.body .columns .columns,
                    table.body .column .column,
                    table.body .column .columns {
                        padding-left: 0 !important;
                        padding-right: 0 !important;
                    }
                    table.body .collapse .columns,
                    table.body .collapse .column {
                        padding-left: 0 !important;
                        padding-right: 0 !important;
                    }
                    td.small-1,
                    th.small-1 {
                        display: inline-block !important;
                        width: 8.33333% !important;
                    }
                    td.small-2,
                    th.small-2 {
                        display: inline-block !important;
                        width: 16.66667% !important;
                    }
                    td.small-3,
                    th.small-3 {
                        display: inline-block !important;
                        width: 25% !important;
                    }
                    td.small-4,
                    th.small-4 {
                        display: inline-block !important;
                        width: 33.33333% !important;
                    }
                    td.small-5,
                    th.small-5 {
                        display: inline-block !important;
                        width: 41.66667% !important;
                    }
                    td.small-6,
                    th.small-6 {
                        display: inline-block !important;
                        width: 50% !important;
                    }
                    td.small-7,
                    th.small-7 {
                        display: inline-block !important;
                        width: 58.33333% !important;
                    }
                    td.small-8,
                    th.small-8 {
                        display: inline-block !important;
                        width: 66.66667% !important;
                    }
                    td.small-9,
                    th.small-9 {
                        display: inline-block !important;
                        width: 75% !important;
                    }
                    td.small-10,
                    th.small-10 {
                        display: inline-block !important;
                        width: 83.33333% !important;
                    }
                    td.small-11,
                    th.small-11 {
                        display: inline-block !important;
                        width: 91.66667% !important;
                    }
                    td.small-12,
                    th.small-12 {
                        display: inline-block !important;
                        width: 100% !important;
                    }
                    .columns td.small-12,
                    .column td.small-12,
                    .columns th.small-12,
                    .column th.small-12 {
                        display: block !important;
                        width: 100% !important;
                    }
                    table.body td.small-offset-1,
                    table.body th.small-offset-1 {
                        margin-left: 8.33333% !important;
                        Margin-left: 8.33333% !important;
                    }
                    table.body td.small-offset-2,
                    table.body th.small-offset-2 {
                        margin-left: 16.66667% !important;
                        Margin-left: 16.66667% !important;
                    }
                    table.body td.small-offset-3,
                    table.body th.small-offset-3 {
                        margin-left: 25% !important;
                        Margin-left: 25% !important;
                    }
                    table.body td.small-offset-4,
                    table.body th.small-offset-4 {
                        margin-left: 33.33333% !important;
                        Margin-left: 33.33333% !important;
                    }
                    table.body td.small-offset-5,
                    table.body th.small-offset-5 {
                        margin-left: 41.66667% !important;
                        Margin-left: 41.66667% !important;
                    }
                    table.body td.small-offset-6,
                    table.body th.small-offset-6 {
                        margin-left: 50% !important;
                        Margin-left: 50% !important;
                    }
                    table.body td.small-offset-7,
                    table.body th.small-offset-7 {
                        margin-left: 58.33333% !important;
                        Margin-left: 58.33333% !important;
                    }
                    table.body td.small-offset-8,
                    table.body th.small-offset-8 {
                        margin-left: 66.66667% !important;
                        Margin-left: 66.66667% !important;
                    }
                    table.body td.small-offset-9,
                    table.body th.small-offset-9 {
                        margin-left: 75% !important;
                        Margin-left: 75% !important;
                    }
                    table.body td.small-offset-10,
                    table.body th.small-offset-10 {
                        margin-left: 83.33333% !important;
                        Margin-left: 83.33333% !important;
                    }
                    table.body td.small-offset-11,
                    table.body th.small-offset-11 {
                        margin-left: 91.66667% !important;
                        Margin-left: 91.66667% !important;
                    }
                    table.body table.columns td.expander,
                    table.body table.columns th.expander {
                        display: none !important;
                    }
                    table.body .right-text-pad,
                    table.body .text-pad-right {
                        padding-left: 10px !important;
                    }
                    table.body .left-text-pad,
                    table.body .text-pad-left {
                        padding-right: 10px !important;
                    }
                    table.menu {
                        width: 100% !important;
                    }
                    table.menu td,
                    table.menu th {
                        width: auto !important;
                        display: inline-block !important;
                    }
                    table.menu.vertical td,
                    table.menu.vertical th,
                    table.menu.small-vertical td,
                    table.menu.small-vertical th {
                        display: block !important;
                    }
                    table.menu[align="center"] {
                        width: auto !important;
                    }
                    table.button.small-expand,
                    table.button.small-expanded {
                        width: 100% !important;
                    }
                    table.button.small-expand table,
                    table.button.small-expanded table {
                        width: 100%;
                    }
                    table.button.small-expand table a,
                    table.button.small-expanded table a {
                        text-align: center !important;
                        width: 100% !important;
                        padding-left: 0 !important;
                        padding-right: 0 !important;
                    }
                    table.button.small-expand center,
                    table.button.small-expanded center {
                        min-width: 0;
                    }
                }

                @media screen and (max-width: 596px) {
                    /* hero */
                    table.hero td.hero-title h1 {
                        font-size: 35px !important;
                    }
                    table.hero td.hero-title h2 {
                        font-size: 24px !important;
                    }
                    table.hero td.hero-image img {
                        margin-left: 0 !important;
                        max-width: 100% !important;
                    }
                }

                @media screen and (max-width: 540px) {
                    /* hero */
                    table.hero table.hero-content {
                        width: 100%;
                    }
                    table.hero td.hero-title h1,
                    table.hero td.hero-title h2 {
                        padding: 0 !important;
                        text-align: center !important;
                    }
                    table.hero td.hero-title h1 {
                        font-size: 40px !important;
                    }
                    table.hero td.hero-image {
                        display: none;
                    }
                    /* buttons */
                    a.brand-button,
                    button.brand-button {
                        display: block !important;
                    }
                    /* main */
                    table.main td.main-inner {
                        padding: 30px !important;
                    }
                }
            </style>
        </head>

        <body style="-moz-box-sizing: border-box; -ms-text-size-adjust: 100%; -webkit-box-sizing: border-box; -webkit-text-size-adjust: 100%; Margin: 0; background-color: #e9ebe7; box-sizing: border-box; color: #555555; font-family: Arial, sans-serif; font-size: 15px; font-weight: normal; line-height: 26px; margin: 0; min-width: 100%; padding: 0; text-align: left; width: 100% !important;">

        <table class="body" style="Margin: 0; background-color: #e9ebe7; border-collapse: collapse; border-spacing: 0; color: #555555; font-family: Arial, sans-serif; font-size: 15px; font-weight: normal; height: 100%; line-height: 26px; margin: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
            <tbody>
            <tr style="padding: 0; text-align: left; vertical-align: top;">
                <td class="center" align="center" valign="top" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 15px; font-weight: normal; hyphens: auto; line-height: 26px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word;">

                    <center style="min-width: 600px; width: 100%;">

                        <table class="container" style="Margin: 0 auto; background: #fefefe; background-color: #fff; border-collapse: collapse; border-spacing: 0; margin: 0 auto; padding: 0; text-align: inherit; vertical-align: top; width: 600px;">
                            <tbody>
                            <tr style="padding: 0; text-align: left; vertical-align: top;">
                                <td style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 15px; font-weight: normal; hyphens: auto; line-height: 26px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word;">

                                    <table class="wrapper hero" align="left" style="background-color: #e9ebe7; border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
                                        <tbody>
                                        <tr style="padding: 0; text-align: left; vertical-align: top;">
                                            <td class="wrapper-inner hero-inner" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 15px; font-weight: normal; hyphens: auto; line-height: 26px; margin: 0; padding: 20px 0 0; text-align: left; vertical-align: top; word-wrap: break-word;">

                                                <table class="hero-content" align="left" style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
                                                    <tbody>
                                                    <tr style="padding: 0; text-align: left; vertical-align: top;">
                                                        <td class="hero-title" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 15px; font-weight: normal; hyphens: auto; line-height: 26px; margin: 0; padding: 0; padding-bottom: 18px; text-align: left; vertical-align: bottom; word-wrap: break-word;">
                                                            <h2 style="Margin: 0; Margin-bottom: 0; color: #555555; font-family: Arial, sans-serif; font-size: 30px; font-weight: 700; line-height: 1em; margin: 0; margin-bottom: 0; padding: 0; text-align: left; text-transform: uppercase; word-wrap: normal;"><?php _e( 'Test results from', 'wphb' ); ?></h2>
                                                            <h1 class="plugin-brand" style="Margin: 0; Margin-bottom: 0; color: #939699; font-family: Arial, sans-serif; font-size: 45px; font-weight: 700; line-height: 1em; margin: 0; margin-bottom: 0; padding: 0; text-align: left; text-transform: uppercase; word-wrap: normal;"><?php _e( 'Hummingbird!', 'wphb' ); ?></h1>
                                                        </td>
                                                        <td class="hero-image" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 15px; font-weight: normal; hyphens: auto; line-height: 26px; margin: 0; padding: 0; text-align: right; vertical-align: top; word-wrap: break-word;">
                                                            <a href="https://premium.wpmudev.org/" style="display: inline-block; Margin: 0; color: #555555; font-family: Arial, sans-serif; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; text-decoration: none;"><img src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/eb80f47a-e296-4974-930a-d4c62c08f68d.png" alt="<?php _e( 'Hummingbird Performance Report', 'wphb' ); ?>" style="-ms-interpolation-mode: bicubic; border: none; clear: both; display: inline-block; outline: none; text-decoration: none; width: auto;"></a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="wrapper main" align="center" style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
                                        <tbody>
                                        <tr style="padding: 0; text-align: left; vertical-align: top;">
                                            <td class="wrapper-inner main-inner" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; padding: 30px 60px; text-align: left; vertical-align: top; word-wrap: break-word;">

                                                <table class="main-content" style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
                                                    <tbody>
                                                    <tr style="padding: 0; text-align: left; vertical-align: top;">
                                                        <td class="main-content-text" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 15px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word;">
                                                            <p style="color: #555555;font-family: Arial, sans-serif;font-size: 32px;font-weight: normal;line-height: 37px;margin: 0;margin-bottom: 30px;padding: 0;text-align: left"><?php printf( __( 'Hi %s,', 'wphb' ), $params['USER_NAME'] ); ?></p>

                                                            <p style="color: #555555;font-family: Arial, sans-serif;font-size: 15px;font-weight: normal;line-height: 30px;margin: 0;margin-bottom: 30px;padding: 0;text-align: left"><?php _e( 'It’s Hummingbird here, straight from the', 'wphb' ); ?> <strong><a class="brand" href="<?php echo $params['SITE_URL']; ?>" target="_blank" style="color: #333;font: inherit;font-family: Arial, sans-serif;font-weight: inherit;line-height: 30px;margin: 0;padding: 0;text-align: left;text-decoration: none"><?php echo $params['SITE_NAME']; ?></a></strong> <?php _e( 'engine room. Here’s your latest Performance Test summary.', 'wphb' ); ?></p>

                                                            <table class="reports-list" align="center" style="border-collapse: collapse;border-spacing: 0;border-top: 1px solid #e6e6e6;margin: 0 0 30px;padding: 0;text-align: left;vertical-align: top;width: 100%">
                                                                <tbody>
                                                                <?php foreach ( $last_test->rule_result as $rule => $rule_result ): ?>
                                                                    <tr class="report-list-item" style="border-bottom: 1px solid #E6E6E6;padding: 0;text-align: left;vertical-align: top">
                                                                        <td class="report-list-item-info" style="border-collapse: collapse !important;color: #555555;font-family: Arial, sans-serif;font-size: 15px;font-weight: 700;line-height: 30px;margin: 0;padding: 10px 0;text-align: left;vertical-align: top">
                                                                            <?php if ( $rule_result->impact_score_class === 'aplus' || $rule_result->impact_score_class === 'a' || $rule_result->impact_score_class === 'b' ): ?>
                                                                                <img src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/34cde184-d615-4efa-8b74-60768d703662.png" alt="Ok" style="-ms-interpolation-mode: bicubic; border: none; clear: both; display: inline-block; margin: 0 10px 0 0; outline: none; text-decoration: none; width: auto; vertical-align: middle;" /><span style="color: inherit; display: inline-block; font-size: inherit; font-family: inherit; line-height: inherit; vertical-align: middle;"><?php echo $rule_result->label; ?></span>
                                                                            <?php elseif ( $rule_result->impact_score_class === 'c' || $rule_result->impact_score_class === 'd' ): ?>
                                                                                <img src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/49edb97d-870a-46b2-aed3-4db6e3a561af.png" alt="Warning" style="-ms-interpolation-mode: bicubic; border: none; clear: both; display: inline-block; margin: 0 10px 0 0; outline: none; text-decoration: none; width: auto; vertical-align: middle;" /><span style="color: inherit; display: inline-block; font-size: inherit; font-family: inherit; line-height: inherit; vertical-align: middle;"><?php echo $rule_result->label; ?></span>
                                                                            <?php elseif ( $rule_result->impact_score_class === 'e' || $rule_result->impact_score_class === 'f' ): ?>
                                                                                <img src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/71d485a5-0b0b-4c08-8b19-3caa106c7995.png" alt="Critical" style="-ms-interpolation-mode: bicubic; border: none; clear: both; display: inline-block; margin: 0 10px 0 0; outline: none; text-decoration: none; width: auto; vertical-align: middle;" /><span style="color: inherit; display: inline-block; font-size: inherit; font-family: inherit; line-height: inherit; vertical-align: middle;"><?php echo $rule_result->label; ?></span>
                                                                            <?php endif; ?>
                                                                        </td>
	                                                                    <?php if ( $rule_result->impact_score_class === 'aplus' || $rule_result->impact_score_class === 'a' || $rule_result->impact_score_class === 'b' ): ?>
                                                                            <td class="report-list-item-result ok" style="border-collapse: collapse !important;color: #1ABC9C;font-family: Arial, sans-serif;font-size: 15px;font-weight: 700;line-height: 30px;margin: 0;min-width: 65px;padding: 10px 0;text-align: right;vertical-align: top"><?php echo $rule_result->impact_score; ?>/100</td>
	                                                                    <?php elseif ( $rule_result->impact_score_class === 'c' || $rule_result->impact_score_class === 'd' ): ?>
                                                                            <td class="report-list-item-result warning" style="border-collapse: collapse !important;color: #FECF2F;font-family: Arial, sans-serif;font-size: 15px;font-weight: 700;line-height: 30px;margin: 0;min-width: 65px;padding: 10px 0;text-align: right;vertical-align: top"><?php echo $rule_result->impact_score; ?>/100</td>
	                                                                    <?php elseif ( $rule_result->impact_score_class === 'e' || $rule_result->impact_score_class === 'f' ): ?>
                                                                            <td class="report-list-item-result critical" style="border-collapse: collapse !important;color: #FF6D6D;font-family: Arial, sans-serif;font-size: 15px;font-weight: 700;line-height: 30px;margin: 0;min-width: 65px;padding: 10px 0;text-align: right;vertical-align: top"><?php echo $rule_result->impact_score; ?>/100</td>
	                                                                    <?php endif; ?>
                                                                    </tr>
                                                                <?php endforeach; ?>

                                                                </tbody>
                                                            </table>

                                                            <p style="color: #555555;font-family: Arial, sans-serif;font-size: 15px;font-weight: normal;line-height: 30px;margin: 0;margin-bottom: 30px;padding: 0;text-align: left"><a href="<?php echo $params['SCAN_PAGE_LINK']; ?>" class="brand-button" style="background: #17A8E3;color: #ffffff;font-family: Arial, sans-serif;font-size: 12px;font-weight: normal;line-height: 20px;margin: 0;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;border-radius: 4px;text-transform: uppercase"><?php _e( 'View full report', 'wphb' ); ?></a></p>

                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="wrapper logo-bottom" align="center" style="background-color: #e9ebe7; border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
                                        <tbody>
                                        <tr style="padding: 0; text-align: left; vertical-align: top;">
                                            <td class="wrapper-inner logo-bottom-inner" align="center" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 1em; margin: 0; padding: 30px 0 0; text-align: center; vertical-align: top; word-wrap: break-word;">
                                                <a href="https://local.wpmudev.org" target="_blank" class="logo-link" style="Margin: 0; color: #555555; display: inline-block; font-family: Arial, sans-serif; font-weight: normal; line-height: 1.3; margin: 0; padding: 0; text-align: left; text-decoration: none;">
                                                    <img src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/b36b06a4-d5c5-460f-a041-cb2ede6f8073.png" alt="<?php _e( 'WPMU DEV', 'wphb' ); ?>" style="-ms-interpolation-mode: bicubic; border: none; clear: both; display: block; max-width: 100%; outline: none; text-decoration: none; width: auto;" />
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="wrapper footer" align="center" style="background-color: #e9ebe7; border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
                                        <tbody>
                                        <tr style="padding: 0; text-align: left; vertical-align: top;">
                                            <td class="wrapper-inner footer-inner" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; padding: 30px 30px 0; text-align: center; vertical-align: top; word-wrap: break-word;">

                                                <table class="footer-content" align="center" style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
                                                    <tbody>
                                                    <tr style="padding: 0; text-align: left; vertical-align: top;">
                                                        <td class="footer-content-inner" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word;">
                                                            <p style="Margin: 0; Margin-bottom: 0; color: #555555; font-family: Arial, sans-serif; font-size: 10px; font-weight: normal; line-height: 26px; margin: 0; margin-bottom: 0; padding: 0; text-align: center;"><?php _e( 'EVERYTHING YOU NEED FOR WORDPRESS', 'wphb' ); ?></p>
                                                            <p style="Margin: 0; Margin-bottom: 0; color: #555555; font-family: Arial, sans-serif; font-size: 10px; font-weight: normal; line-height: 26px; margin: 0; margin-bottom: 0; padding: 0; text-align: center;"><i><?php _e( 'One place, one low price, unlimited sites', 'wphb' ); ?></i></p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="wrapper address" align="center" style="background-color: #e9ebe7; border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
                                        <tbody>
                                        <tr style="padding: 0; text-align: left; vertical-align: top;">
                                            <td class="wrapper-inner address-inner" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; padding: 30px; text-align: center; vertical-align: top; word-wrap: break-word;">

                                                <table class="address-content" align="center" style="border-collapse: collapse; border-spacing: 0; padding: 0; text-align: left; vertical-align: top; width: 100%;">
                                                    <tbody>
                                                    <tr style="padding: 0; text-align: left; vertical-align: top;">
                                                        <td class="address-content-inner" style="-moz-hyphens: auto; -webkit-hyphens: auto; Margin: 0; border-collapse: collapse !important; color: #555555; font-family: Arial, sans-serif; font-size: 14px; font-weight: normal; hyphens: auto; line-height: 30px; margin: 0; padding: 0; text-align: left; vertical-align: top; word-wrap: break-word;">
                                                            <p style="Margin: 0; Margin-bottom: 0; color: #888888; font-family: Arial, sans-serif; font-size: 11px; font-weight: normal; line-height: 26px; margin: 0; margin-bottom: 0; padding: 0; text-align: center; text-transform: uppercase;"><?php _e( 'Incsub, PO Box 163 Albert Park, Victoria, 3206, Australia.', 'wphb' ); ?></p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </center>

                </td>
            </tr>
            </tbody>
        </table>
        <!-- end body -->
        </body>
        </html>
		<?php
		return ob_get_clean();
	}

}