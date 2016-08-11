<?php

class AS3CF_Assets_Upgrade {

	/**
	 * @var Amazon_S3_And_CloudFront_Assets
	 */
	protected $assets;

	/**
	 * @var int
	 */
	protected $upgrade_id;

	/**
	 * @var string
	 */
	protected $settings_key = 'upgrade_routine';

	/**
	 * @var string
	 */
	protected $status_option = 'as3cf_assets_upgrade_session';

	/**
	 * @var string
	 */
	protected $cron_hook = 'as3cf_assets_upgrade_routine';

	/**
	 * @var string
	 */
	protected $cron_schedule_key = 'as3cf_assets_upgrade_routine_interval';

	/**
	 * Routine constants
	 */
	const GZIP_MINIFY = 1;
	const LOCATION_SCANS = 2;

	/**
	 * AS3CF_Assets_Upgrade constructor.
	 *
	 * @param Amazon_S3_And_CloudFront_Assets $assets
	 */
	public function __construct( $assets ) {
		$this->assets     = $assets;
		$this->upgrade_id = self::LOCATION_SCANS;

		add_filter( 'cron_schedules', array( $this, 'cron_schedules' ) );
		add_action( $this->cron_hook, array( $this, 'maybe_start_scan' ) );

		// Do default checks if the upgrade can be started
		if ( $this->maybe_init() ) {
			$this->init();
		}
	}

	/**
	 * Add custom cron interval schedules
	 *
	 * @param array $schedules
	 *
	 * @return array
	 */
	public function cron_schedules( $schedules ) {
		$schedules[ $this->cron_schedule_key ] = array(
			'interval' => 60,
			'display'  => __( 'Every 1 Minute', 'as3cf-assets' ),
		);

		return $schedules;
	}

	/**
	 * Maybe start scan
	 */
	public function maybe_start_scan() {
		if ( $this->assets->is_purging() ) {
			return false;
		}

		$this->assets->scan_files_for_s3();
		$this->assets->clear_scheduled_event( $this->cron_hook );
		$this->save_upgrade_id();

		// Delete status
		delete_site_option( $this->status_option );

		return true;
	}

	/**
	 * Save upgrade ID
	 */
	protected function save_upgrade_id() {
		$this->assets->set_setting( $this->settings_key, $this->upgrade_id );
		$this->assets->save_settings();
	}

	/**
	 * Can we start the upgrade using default checks
	 *
	 * @return bool
	 */
	protected function maybe_init() {
		if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			return false;
		}

		// Make sure this only fires inside the network admin for multisites
		if ( is_multisite() && ! is_network_admin() ) {
			return false;
		}

		// Don't fire on fresh install
		if ( $this->is_fresh_install() ) {
			return false;
		}

		// Have we completed the upgrade?
		if ( $this->assets->get_setting( $this->settings_key, 0 ) >= $this->upgrade_id ) {
			return false;
		}

		// Is upgrade already running
		if ( $this->is_running() ) {
			return false;
		}

		return true;
	}

	/**
	 * Is fresh install
	 *
	 * @return bool
	 */
	protected function is_fresh_install() {
		if ( false !== $this->assets->get_settings() ) {
			return false;
		}

		// Save upgrade id
		$this->save_upgrade_id();

		return true;
	}

	/**
	 * Is running
	 *
	 * @return bool
	 */
	protected function is_running() {
		return get_site_option( $this->status_option, false );
	}

	/**
	 * Init
	 */
	protected function init() {
		// Update status
		update_site_option( $this->status_option, true );

		// Remove unused legacy file process queue.
		if ( $this->assets->get_setting( $this->settings_key, 0 ) < self::LOCATION_SCANS ) {
			delete_site_option( Amazon_S3_And_CloudFront_Assets::TO_PROCESS_SETTINGS_KEY );
		}

		// Purge
		$bucket = $this->assets->get_setting( 'bucket' );
		$region = $this->assets->get_setting( 'region' );

		$this->assets->remove_all_files_from_s3( $bucket, $region );

		// Schedule cron
		$this->assets->schedule_event( $this->cron_hook, $this->cron_schedule_key );

		// Show notice
		$msg = __( '<strong>WP Offload S3 Assets Addon</strong> &mdash; This update requires your assets to be re-uploaded to S3.', 'as3cf-assets' );
		$msg .= '<br>' . __( 'A purge and re-scan has been initiated.', 'as3cf-assets' );
		$this->assets->notices->add_notice( $msg );
	}

}
