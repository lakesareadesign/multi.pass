<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Behavior;

use Hammer\Base\Behavior;
use Hammer\Helper\Log_Helper;
use Hammer\Helper\WP_Helper;
use WP_Defender\Module\Hardener\Model\Settings;
use WP_Defender\Module\Scan\Component\Scan_Api;
use WP_Defender\Module\Scan\Model\Result_Item;

class Utils extends Behavior {
	/**
	 * @return bool
	 */
	public function isActivatedSingle() {
		if ( WP_Helper::is_network_activate( wp_defender()->plugin_slug ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @param $endPoint
	 * @param array $bodyArgs
	 * @param array $requestArgs
	 * @param bool $returnRaw
	 *
	 * @return array|mixed|object|\WP_Error
	 */
	public function devCall( $endPoint, $bodyArgs = array(), $requestArgs = array(), $returnRaw = false ) {
		$api_key = $this->getAPIKey();
		if ( $api_key !== false ) {
			$domain                      = network_site_url();
			$post_vars['body']           = $bodyArgs;
			$post_vars['body']['domain'] = $domain;
			$post_vars['timeout']        = 30;
			$post_vars['httpversion']    = '1.1';

			$headers = isset( $post_vars['headers'] ) ? $post_vars['headers'] : array();

			$post_vars['headers'] = array_merge( $headers, array(
				'Authorization' => 'Basic ' . $api_key
			) );

			$post_vars = array_merge( $post_vars, $requestArgs );

			$response = wp_remote_request( $endPoint,
				apply_filters( 'wd_wpmudev_call_request_args',
					$post_vars ) );
			if ( is_wp_error( $response ) ) {
				return $response;
			}

			if ( $returnRaw == true ) {
				return $response;
			}

			if (
				'OK' !== wp_remote_retrieve_response_message( $response )
				OR 200 !== wp_remote_retrieve_response_code( $response )
			) {
				return new \WP_Error( wp_remote_retrieve_response_code( $response ), wp_remote_retrieve_response_message( $response ) );
			} else {
				$data = wp_remote_retrieve_body( $response );

				return json_decode( $data, true );
			}
		} else {
			return new \WP_Error( 'dashboard_required',
				sprintf( esc_html__( "WPMU DEV Dashboard will be required for this action. Please visit <a href=\"%s\">here</a> and install the WPMU DEV Dashboard", wp_defender()->domain )
					, 'https://premium.wpmudev.org/project/wpmu-dev-dashboard/' ) );
		}
	}

	/**
	 * @return string
	 */
	public function getPHPVersion() {
		return phpversion();
	}

	/**
	 * @return string
	 */
	public function getWPVersion() {
		global $wp_version;

		return $wp_version;
	}

	public function getAPIKey() {
		if ( ( $version = $this->isDashboardInstalled() ) !== false ) {
			if ( version_compare( $version, '4.0.0' ) >= 0 ) {
				//this is version 4+
				//instanize once
				\WPMUDEV_Dashboard::instance();
				$api_key = \WPMUDEV_Dashboard::$api->get_key();

				return $api_key;
			} else {
				global $wpmudev_un;
				$api_key = $wpmudev_un->get_apikey();

				return $api_key;
			}
		}

		return false;
	}

	/**
	 * Check if WPMUDEV Dashboard installed, return version, else return false
	 * @return bool|string
	 */
	public function isDashboardInstalled() {
		//check if this is new
		if ( class_exists( 'WPMUDEV_Dashboard' ) ) {
			return \WPMUDEV_Dashboard::$version;
		}

		return false;
	}

	/**
	 * Check if current user qualify for current operation
	 * @return bool
	 */
	public function checkPermission() {
		if ( ! is_user_logged_in() ) {
			return false;
		}
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';

		return current_user_can( $cap );
	}

	/**
	 * @param $timestring string
	 * @param bool $i18n
	 *
	 * @return false|string
	 */
	public function formatDateTime( $timestring, $i18n = true ) {
		if ( strlen( $timestring ) == 0 ) {
			return null;
		}
		if ( ! is_int( $timestring ) ) {
			$timestring = strtotime( $timestring );
		}
		$format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
		if ( $i18n == false ) {
			return date( $format, $timestring );
		} else {
			$time = get_date_from_gmt( date( 'Y-m-d H:i:s', $timestring ), 'Y-m-d H:i:s' );

			return date_i18n( $format, strtotime( $time ) );
		}
	}

	/**
	 * @param null $user_id
	 *
	 * @return string
	 */
	public function getDisplayName( $user_id = null ) {
		if ( ! is_user_logged_in() && is_null( $user_id ) ) {
			return esc_html__( "Guest", wp_defender()->domain );
		}

		if ( is_null( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		$userdata = get_userdata( $user_id );
		if ( ! is_object( $userdata ) ) {
			return __( "Guest", wp_defender()->domain );
		}
		$fullname = trim( $userdata->first_name . ' ' . $userdata->last_name );
		if ( empty( $fullname ) ) {
			$fullname = $userdata->display_name;
		}

		return $fullname;
	}

	/**
	 * @return array
	 */
	public function allowedHtml() {
		return array(
			'p'      => array(),
			'i'      => array(
				'class' => 'wd-text-warning wdv-icon wdv-icon-fw wdv-icon-exclamation-sign'
			),
			'strong' => array(),
			'span'   => array(
				'class' => array(
					'wd-suspicious-strong',
					'wd-suspicious-light',
					'wd-suspicious-medium'
				)
			),
			'img'    => array(
				'class' => 'text-warning',
				'src'   => wp_defender()->getPluginUrl() . 'assets/img/robot.png'
			)
		);
	}

	/**
	 * @param $get_avatar
	 *
	 * @return mixed
	 */
	public function getAvatarUrl( $get_avatar ) {
		preg_match( "/src='(.*?)'/i", $get_avatar, $matches );

		return $matches[1];
	}

	/**
	 * Make filesize friendy with human, src from https://gist.github.com/liunian/9338301#gistcomment-1970661
	 *
	 * @param $bytes
	 *
	 * @return string
	 *
	 */
	public function makeReadable( $size ) {
		$base      = log( $size, 1024 );
		$precision = 2;
		$suffixes  = array( '', 'K', 'M', 'G', 'T' );

		return round( pow( 1024, $base - floor( $base ) ), $precision ) . ' ' . $suffixes[ floor( $base ) ];
	}

	/**
	 * @param $timestamp
	 *
	 * @return false|int
	 */
	public function localToUtc( $timestring ) {
		$tz = get_option( 'timezone_string' );
		if ( ! $tz ) {
			$gmt_offset = get_option( 'gmt_offset' );
			if ( $gmt_offset == 0 ) {
				return strtotime( $timestring );
			}
			$tz = $this->getTimezoneString( $gmt_offset );
		}

		if ( ! $tz ) {
			$tz = 'UTC';
		}
		$timezone = new \DateTimeZone( $tz );
		$time     = new \DateTime( $timestring, $timezone );

		return $time->getTimestamp();
	}

	/**
	 * @param $timezone
	 *
	 * @return false|string
	 */
	public function getTimezoneString( $timezone ) {
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

	/**
	 * Get days of week
	 * @return mixed|void
	 * @access public
	 * @since 1.0
	 */
	public function getDaysOfWeek() {
		$timestamp = strtotime( 'next Sunday' );
		$days      = array();
		for ( $i = 0; $i < 7; $i ++ ) {
			$days[]    = strftime( '%A', $timestamp );
			$timestamp = strtotime( '+1 day', $timestamp );
		}

		return apply_filters( 'wd_scan_get_days_of_week', $days );
	}

	/**
	 * A shorhand function to get user IP
	 * @return mixed|string
	 */
	public function getUserIp() {
		$client      = isset( $_SERVER['HTTP_CLIENT_IP'] ) ? $_SERVER['HTTP_CLIENT_IP'] : null;
		$forward     = isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : null;
		$remote      = $_SERVER['REMOTE_ADDR'];
		$client_real = isset( $_SERVER['HTTP_X_REAL_IP'] ) ? $_SERVER['HTTP_X_REAL_IP'] : null;
		if ( filter_var( $client, FILTER_VALIDATE_IP ) ) {
			return $client;
		} elseif ( filter_var( $client_real, FILTER_VALIDATE_IP ) ) {
			return $client_real;
		} elseif ( ! empty( $forward ) ) {
			$forward = explode( ',', $forward );
			$ip      = array_shift( $forward );
			$ip      = trim( $ip );
			if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
				return $ip;
			}
		}

		return $remote;
	}

	/**
	 * Return times frame for selectbox
	 * @access public
	 * @since 1.0
	 */
	public function getTimes() {
		$data = array();
		for ( $i = 0; $i < 24; $i ++ ) {
			foreach ( apply_filters( 'wd_scan_get_times_interval', array( '00', '30' ) ) as $min ) {
				$time          = $i . ':' . $min;
				$data[ $time ] = apply_filters( 'wd_scan_get_times_hour_min', $time );
			}
		}

		return apply_filters( 'wd_scan_get_times', $data );
	}

	/**
	 * a quick helper for static class
	 * @return Utils
	 */
	public static function instance() {
		return new Utils();
	}

	public function determineServer() {
		$url         = home_url();
		$server_type = get_site_transient( 'wd_util_server' );
		if ( ! is_array( $server_type ) ) {
			$server_type = array();
		}

		if ( isset( $server_type[ $url ] ) && ! empty( $server_type[ $url ] ) ) {
			return strtolower( $server_type[ $url ] );
		}

		//url should be end with php
		global $is_apache, $is_nginx, $is_IIS, $is_iis7;

		$server = null;

		if ( $is_nginx ) {
			$server = 'nginx';
		} elseif ( $is_apache ) {
			//case the url is detecting php file
			if ( pathinfo( $url, PATHINFO_EXTENSION ) == 'php' ) {
				$server = 'apache';
			} else {
				//so the server software is apache, let see what the header return
				$request = wp_remote_head( $url, array( 'user-agent' => $_SERVER['HTTP_USER_AGENT'] ) );
				$server  = wp_remote_retrieve_header( $request, 'server' );
				$server  = explode( '/', $server );
				if ( strtolower( $server[0] ) == 'nginx' ) {
					//proxy case
					$server = 'nginx';
				} else {
					$server = 'apache';
				}
			}
		} elseif ( $is_iis7 || $is_IIS ) {
			$server = 'iis';
		}

		if ( is_null( $server ) ) {
			//if fall in here, means there is st unknowed.
			$request = wp_remote_head( $url, array( 'user-agent' => $_SERVER['HTTP_USER_AGENT'] ) );
			$server  = wp_remote_retrieve_header( $request, 'server' );
			$server  = explode( '/', $server );
			$server  = $server[0];
		}

		$server_type[ $url ] = $server;
		//cache for an hour
		set_site_transient( 'wd_util_server', $server_type, 3600 );

		return $server;
	}

	/**
	 * @return string
	 */
	public function getDefUploadDir() {
		$uploadDir = WP_Helper::getUploadDir();
		$defDir    = $uploadDir . DIRECTORY_SEPARATOR . 'wp-defender';
		if ( ! is_dir( $defDir ) ) {
			wp_mkdir_p( $defDir );
		}

		if ( ! is_file( $defDir . DIRECTORY_SEPARATOR . 'index.php' ) ) {
			//create a blank index file
			file_put_contents( $defDir . DIRECTORY_SEPARATOR . 'index.php', '' );
		}

		return $defDir;
	}

	/**
	 * @return array|void
	 */
	public function submitStatsToDev() {
		if ( ! $this->getAPIKey() ) {
			return;
		}

		$issues = array();
		$rules  = Settings::instance()->getIssues();
		foreach ( $rules as $rule ) {
			$issues[] = array(
				'label' => $rule->getTitle(),
				'url'   => network_admin_url( 'admin.php?page=wdf-hardener' ) . '#' . $rule::$slug
			);
		}

		$model = Scan_Api::getLastScan();
		$count = 0;
		if ( is_object( $model ) ) {
			$timestamp = strtotime( $model->dateFinished );

			$res = array(
				'core_integrity'   => $model->getCount( 'core' ),
				'vulnerability_db' => $model->getCount( 'vuln' ),
				'file_suspicious'  => $model->getCount( 'content' )
			);

			$count = $model->countAll( Result_Item::STATUS_ISSUE );
		} else {
			$timestamp = '';
			$res       = array(
				'core_integrity'   => 0,
				'vulnerability_db' => 0,
				'file_suspicious'  => 0
			);
		}
		$labels = array(
			'core_integrity'   => esc_html__( "WordPress Core Integrity", wp_defender()->domain ),
			'vulnerability_db' => esc_html__( "Plugins & Themes vulnerability", wp_defender()->domain ),
			'file_suspicious'  => esc_html__( "Suspicious Code", wp_defender()->domain )
		);
		$data   = array(
			'domain'       => network_home_url(),
			'timestamp'    => $timestamp,
			'warnings'     => $count,
			'cautions'     => count( $issues ),
			'data_version' => '20160220',
			'scan_data'    => json_encode( array(
				'scan_result'        => $res,
				'hardener_result'    => $issues,
				'scan_schedule'      => array(
					'is_activated' => \WP_Defender\Module\Scan\Model\Settings::instance()->notification,
					'time'         => \WP_Defender\Module\Scan\Model\Settings::instance()->time,
					'day'          => \WP_Defender\Module\Scan\Model\Settings::instance()->day,
					'frequency'    => \WP_Defender\Module\Scan\Model\Settings::instance()->frequency
				),
				'audit_enabled'      => \WP_Defender\Module\Audit\Model\Settings::instance()->enabled,
				'audit_page_url'     => network_admin_url( 'admin.php?page=wdf-logging' ),
				'labels'             => $labels,
				'scan_page_url'      => network_admin_url( 'admin.php?page=wdf-scan' ),
				'hardener_page_url'  => network_admin_url( 'admin.php?page=wdf-hardener' ),
				'new_scan_url'       => network_admin_url( 'admin.php?page=wdf-scan&wdf-action=new_scan' ),
				'schedule_scans_url' => network_admin_url( 'admin.php?page=wdf-schedule-scan' ),
				'settings_page_url'  => network_admin_url( 'admin.php?page=wdf-settings' )
			) ),
		);

		$end_point = "https://premium.wpmudev.org/api/defender/v1/scan-results";
		$this->devCall( $end_point, $data, array(
			'method' => 'POST'
		) );
	}

	/**
	 * @param null $result
	 *
	 * @return bool
	 */
	public function checkRequirement( &$result = null ) {
		$meet = true;

		if ( version_compare( $this->getPHPVersion(), '5.3', '>=' ) == false ) {
			$meet          = false;
			$result['php'] = array(
				'status'  => $this->getPHPVersion(),
				'message' => __( "Please upgrade to 5.3 or later", wp_defender()->domain )
			);
		}

		return $meet;
	}


	/**
	 * @param $freq
	 *
	 * @return string
	 */
	public function frequencyToText( $freq ) {
		$text = '';
		switch ( $freq ) {
			case 1:
				$text = __( "daily", wp_defender()->domain );
				break;
			case 7:
				$text = __( "weekly", wp_defender()->domain );
				break;
			case 30:
				$text = __( "monthly", wp_defender()->domain );
				break;
		}

		return $text;
	}
}