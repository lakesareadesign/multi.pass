<?php

/**
 * Author: Hoang Ngo
 */
class WD_Main_Activator {
	public $wp_defender;

	public function __construct( WP_Defender $wp_defender ) {
		add_action( 'init', array( &$this, 'init' ) );
	}

	/**
	 * Initial
	 */
	public function init() {
		$db_ver = get_site_option( 'wd_db_version' );
		if ( wp_defender()->db_version == "1.4" && $db_ver != false && version_compare( $db_ver, wp_defender()->db_version, '<' ) == true ) {
			$this->maybeUpgrade();
		}
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( &$this, 'addSettingsLink' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'register_styles' ) );
		if ( ! \WP_Defender\Behavior\Utils::instance()->checkRequirement() ) {
		} else {
			if ( \WP_Defender\Behavior\Utils::instance()->getAPIKey() == false ) {
				wp_defender()->isFree = true;
			}
			//start to init navigators
			\Hammer\Base\Container::instance()->set( 'dashboard', new \WP_Defender\Controller\Dashboard() );
			\Hammer\Base\Container::instance()->set( 'hardener', new \WP_Defender\Module\Hardener() );
			\Hammer\Base\Container::instance()->set( 'scan', new \WP_Defender\Module\Scan() );
			\Hammer\Base\Container::instance()->set( 'audit', new \WP_Defender\Module\Audit() );
			\Hammer\Base\Container::instance()->set( 'lockout', new \WP_Defender\Module\IP_Lockout() );
			//no need to set debug
			new \WP_Defender\Controller\Debug();
		}
	}

	/**
	 * Add a setting link in plugins page
	 * @return array
	 */
	public function addSettingsLink( $links ) {
		$mylinks = array(
			'<a href="' . admin_url( 'admin.php?page=wp-defender' ) . '">' . __( "Settings", wp_defender()->domain ) . '</a>',
		);

		return array_merge( $mylinks, $links );
	}

	/**
	 * Register globally css, js will be load on each module
	 */
	public function register_styles() {
		wp_enqueue_style( 'defender-menu', wp_defender()->getPluginUrl() . 'assets/css/defender-icon.css' );

		$css_files = array(
			'defender' => wp_defender()->getPluginUrl() . 'assets/css/styles.css'
		);

		foreach ( $css_files as $slug => $file ) {
			wp_register_style( $slug, $file, array(), wp_defender()->version );
		}

		$js_files = array(
			'defender' => wp_defender()->getPluginUrl() . 'assets/js/scripts.js'
		);

		foreach ( $js_files as $slug => $file ) {
			wp_register_script( $slug, $file, array(), wp_defender()->version );
		}

		do_action( 'defender_enqueue_assets' );
	}

	private function maybeUpgrade() {
		//update can settings
		$option = get_site_option( 'wp_defender' );
		if ( $option ) {
			$setting                  = \WP_Defender\Module\Scan\Model\Settings::instance();
			$setting->scan_core       = isset( $option['use_core_integrity_scan'] ) ? $option['use_core_integrity_scan'] : $setting->scan_core;
			$setting->scan_vuln       = isset( $option['use_vulndb_scan'] ) ? $option['use_vulndb_scan'] : $setting->scan_vuln;
			$setting->scan_content    = isset( $option['use_suspicious_file_scan'] ) ? $option['use_suspicious_file_scan'] : $setting->scan_content;
			$setting->email_all_ok    = isset( $option['completed_scan_email_content_success'] ) ? $option['completed_scan_email_content_success'] : $setting->email_all_ok;
			$setting->email_has_issue = isset( $option['completed_scan_email_content_error'] ) ? $option['completed_scan_email_content_error'] : $setting->email_has_issue;
			$setting->receipts        = isset( $option['recipients'] ) ? $option['recipients'] : $setting->receipts;
			$setting->always_send     = isset( $option['always_notify'] ) ? $option['always_notify'] : $setting->always_send;
			if ( isset( $option['auto_scan'] ) && $option['auto_scan'] == 1 ) {
				$setting->notification = 1;
				$setting->frequency    = $option['schedule']['frequency'];
				$setting->frequency    = $option['schedule']['day'];
				$setting->time         = $option['schedule']['time'];
			} else {
				$setting->notification = 0;
			}
			$setting->save();
			wp_schedule_single_event( strtotime( '+1 minute' ), 'processScanCron' );
		}

		//update audit log setting
		if ( isset( $option['audit_log'] ) ) {
			$setting            = \WP_Defender\Module\Audit\Model\Settings::instance();
			$setting->enabled   = $option['audit_log']['enabled'];
			$setting->frequency = $option['audit_log']['report_email_frequent'];
			$setting->save();
		}
		//hardener disable pingback
		if ( isset( $option['disable_ping_back'] ) && $option['disable_ping_back']['remove_pingback'] == 1 ) {
			$cache = \Hammer\Helper\WP_Helper::getCache();
			$cache->set( \WP_Defender\Module\Hardener\Component\Disable_Trackback_Service::CACHE_KEY, 1, 0 );
		}
		//hardener security check
		if ( isset( $option['wd_security_key'] ) ) {
			\Hammer\Helper\WP_Helper::getCache()->set(
				\WP_Defender\Module\Hardener\Component\Security_Key_Service::CACHE_KEY, $option['wd_security_key']['processed_time'] );
			\Hammer\Helper\WP_Helper::getCache()->set( 'securityReminderDate', strtotime( '+' . $option['remind_interval'], $option['wd_security_key']['processed_time'] ) );
		}
		//merge any ignored of ahrdener
		if ( isset( $option['hardener']['ignores'] ) ) {
			$ignored = $option['hardener']['ignores'];
			if ( is_array( $ignored ) && count( $ignored ) ) {
				$setting = \WP_Defender\Module\Hardener\Model\Settings::instance();
				$mapped  = array(
					'change_default_admin'  => \WP_Defender\Module\Hardener\Component\Change_Admin::$slug,
					'db_prefix'             => \WP_Defender\Module\Hardener\Component\DB_Prefix::$slug,
					'disable_error_display' => \WP_Defender\Module\Hardener\Component\Disable_Trackback::$slug,
					'disable_ping_back'     => \WP_Defender\Module\Hardener\Component\Disable_Trackback::$slug,
					'php_version'           => \WP_Defender\Module\Hardener\Component\PHP_Version::$slug,
					'plugin_theme_editor'   => \WP_Defender\Module\Hardener\Component\Disable_File_Editor::$slug,
					'protect_upload_dir'    => \WP_Defender\Module\Hardener\Component\Prevent_Php::$slug,
					'protect_core_dir'      => \WP_Defender\Module\Hardener\Component\Protect_Information::$slug,
					'wd_security_key'       => \WP_Defender\Module\Hardener\Component\Security_Key::$slug,
					'wp_verify_version'     => \WP_Defender\Module\Hardener\Component\WP_Version::$slug,
				);

				foreach ( $ignored as $oldSlug ) {
					if ( isset( $mapped[ $oldSlug ] ) ) {
						$slug = $mapped[ $oldSlug ];
						$setting->addToIgnore( $slug, false );
					}
				}

			}
		}

		$lockout = get_site_option( 'wd_lockdown_settings' );
		if ( $lockout ) {
			$setting = \WP_Defender\Module\IP_Lockout\Model\Settings::instance();
			if ( $lockout['report_frequency'] == 'daily' ) {
				$setting->report_frequency = 1;
			} elseif ( $lockout['report_frequency'] == 'weekly' ) {
				$setting->report_frequency = 7;
			} elseif ( $lockout['report_frequency'] == 'monthly' ) {
				$setting->report_frequency = 30;
			}
			$setting->save();
		}
		update_site_option( 'wd_db_version', $this->wp_defender->db_version );
	}

	public function activationHook() {
		$settings = \WP_Defender\Module\Scan\Model\Settings::instance();
		if ( $settings->notification ) {
			$nextScanTime = \WP_Defender\Module\Scan\Component\Scan_Api::getScheduledScanTime();
			wp_schedule_single_event( $nextScanTime, 'processScanCron' );
		}
		$settings = \WP_Defender\Module\Audit\Model\Settings::instance();
		if ( $settings->notification ) {
			$reportTime = \WP_Defender\Module\Audit\Component\Audit_API::getReportTime();
			wp_schedule_single_event( $reportTime, 'auditReportCron' );
		}
		$settings = \WP_Defender\Module\IP_Lockout\Model\Settings::instance();
		if ( $settings->report ) {
			$reportTime = \WP_Defender\Module\IP_Lockout\Component\Login_Protection_Api::getReportTime( true );
			wp_schedule_single_event( $reportTime, 'lockoutReportCron' );
		}
	}
}