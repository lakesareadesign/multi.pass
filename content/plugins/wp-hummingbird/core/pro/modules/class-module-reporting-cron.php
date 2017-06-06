<?php

/**
 * Class WP_Hummingbird_Module_Cron is used for cron functionality.
 * Only for premium members.
 *
 * @since 1.5.0
 */
class WP_Hummingbird_Module_Reporting_Cron extends WP_Hummingbird_Module {

    /**
     * Initialize the module
     *
     * @since 1.5.0
     */
    public function init() {

        // Process scan cron
        add_action( 'wphb_performance_scan', array( $this, 'process_scan_cron' ) );

        // Default settings
        add_filter( 'wp_hummingbird_default_options', array( $this, 'add_default_options' ) );

        add_action( 'wphb_init_performance_scan', array( $this, 'on_init_performance_scan' ) );

        add_action( 'wphb_activate', array( $this, 'on_activate' ) );
    }

    public function run() {}

	/**
	 * Triggered during plugin activation
	 */
    public function on_activate() {

	    if ( ! wphb_is_member() ) {
	        return;
	    }

        // Try to schedule next scan
        if ( wphb_get_setting( 'email-notifications' ) ) {
            wp_schedule_single_event( WP_Hummingbird_Module_Reporting_Cron::get_scheduled_scan_time(), 'wphb_performance_scan' );
        }

    }

	/**
	 * Triggered when a performance scan is initialized
	 */
    public function on_init_performance_scan() {

	    if ( wphb_is_member() ) {
		    // Schedule first scan
		    wp_schedule_single_event( WP_Hummingbird_Module_Reporting_Cron::get_scheduled_scan_time(), 'wphb_performance_scan' );
	    }
	    else {
	    	wphb_update_setting( 'email-notifications', false );
	    }

    }

	/**
	 * Add a set of default options to Hummingbird settings
	 *
	 * @param array $settings List of default Hummingbird settings
	 * @return array
     * @since 1.5.0
	 */
    public function add_default_options( $settings ) {

	    $settings['email-notifications'] = false;
		$settings['email-recipients'] = array();
		$settings['email-frequency'] = 7;
		$settings['email-day'] = ( '1' === get_option('start_of_week') ) ? 'Monday' : 'Sunday';
		$settings['email-time'] = '1:00';

		return $settings;

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

                // If can't send then return
                if ( ! self::maybe_send() ) {
                    return;
                }
                // Get the recipient list
                $recipients = wphb_get_setting( 'email-recipients' );

                // Send the report
                WP_Hummingbird_Module_Reporting::send_email_report( $last_report->data, $recipients );

                // Store the last send time
                wphb_update_setting( 'wphb-last-sent-report', $now );

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

        $toUTC = self::local_to_utc( $timeString );
        if ( $toUTC < time() ) {
            return self::local_to_utc( $nextTimeString );
        } else {
            return $toUTC;
        }

    }

    /**
     * Check to see if a previous report was already sent
     *
     * We use this check, because on installations with caching plugins, the emails are being sent
     * multiple times. We compare if the period after the last sent report is less then the planned period.
     * For example, if scans are done daily at 3:00pm, the earliest time possible to send a report would
     * be 2:00pm (an hour before the actual report time).
     *
     * @return bool
     * @since 1.5.0
     */
    private static function maybe_send() {

        // Check to see it the email has been sent already
        $last_sent_report = wphb_get_setting( 'wphb-last-sent-report' );
        if ( empty( $last_sent_report ) ) {
            $last_sent_report = 0;
        }

        $settings = wphb_get_settings();
        switch ( $settings['email-frequency'] ) {
            case '1':
                $timeString     = date( 'Y-m-d' ) . ' ' . $settings['email-time'] . ':00';
                break;
            case '7':
            default:
                $timeString     = date( 'Y-m-d', strtotime( $settings['email-day'] . ' this week' ) ) . ' ' . $settings['email-time'] . ':00';
                break;
            case '30':
                $timeString     = date( 'Y-m-d', strtotime( $settings['email-day'] . ' this month' ) ) . ' ' . $settings['email-time'] . ':00';
                break;
        }
        $toUTC = self::local_to_utc( $timeString );
        $now = current_time( 'timestamp' );

        if ( ( $now - $last_sent_report + 3600 ) < $toUTC ) {
            return false;
        }

        return true;

    }

    /**
     * @param $timestring
     * @return false|int
     * @since 1.4.5
     */
    private static function local_to_utc( $timestring ) {

        $tz = get_option( 'timezone_string' );
        if ( ! $tz ) {
            $gmt_offset = get_option( 'gmt_offset' );
            if ( $gmt_offset == 0 ) {
                return strtotime( $timestring );
            }
            $tz = self::get_timezone_string( $gmt_offset );
        }

        if ( ! $tz ) {
            $tz = 'UTC';
        }
        $timezone = new DateTimeZone( $tz );
        $time     = new DateTime( $timestring, $timezone );

        return $time->getTimestamp();

    }

    /**
     * @param $timezone
     * @return false|string
     * @since 1.4.5
     */
    private static function get_timezone_string( $timezone ) {

        $timezone = explode( '.', $timezone );
        if ( isset( $timezone[1] ) ) {
            $timezone[1] = 30;
        } else {
            $timezone[1] = '00';
        }
        $offset = implode( ':', $timezone );
        list( $hours, $minutes ) = explode( ':', $offset );
        $seconds = $hours * 60 * 60 + $minutes * 60;
        $tz      = timezone_name_from_abbr( '', $seconds, 1 );
        if ( $tz === false ) {
            $tz = timezone_name_from_abbr( '', $seconds, 0 );
        }

        return $tz;

    }

}