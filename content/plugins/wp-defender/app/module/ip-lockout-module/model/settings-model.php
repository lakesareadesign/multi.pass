<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\IP_Lockout\Model;

class Settings_Model extends \WD_Option_Model {
	public $id = 'wd_lockdown_settings';

	public $login_protection = false;
	public $login_protection_login_attempt = 5;
	public $login_protection_lockout_timeframe = 300;
	public $login_protection_lockout_duration = 300;
	public $login_protection_lockout_message = "You have been locked out due to too many invalid login attempts.";
	public $login_protection_ban_admin_brute = false;
	public $login_protection_lockout_ban = false;

	public $detect_404 = false;
	public $detect_404_threshold = 20;
	public $detect_404_timeframe = 300;
	public $detect_404_lockout_duration = 300;
	public $detect_404_whitelist;
	public $detect_404_ignored_filetypes;
	public $detect_404_lockout_message = "You have been locked out due to too many attempts to access a file that doesn’t exist.";
	public $detect_404_lockout_ban = false;
	public $detect_404_logged = true;

	public $ip_blacklist;
	public $ip_whitelist;
	public $ip_lockout_message = 'The administrator has blocked your IP from accessing this website.';

	public $login_lockout_notification = true;
	public $ip_lockout_notification = true;

	public $report = true;
	public $report_frequency = 'weekly';
	public $report_day = 'sunday';
	public $report_time = '0:00';


	public $receipts = array();
	public $report_receipts = array();

	public $rules = array(
		'login_protection_login_attempt'     => array( 'integer', 'scenario' => 'login_protect' ),
		'login_protection_lockout_timeframe' => array( 'integer', 'scenario' => 'login_protect' ),
		'detect_404_threshold'               => array( 'integer', 'scenario' => '404_detect' ),
		'detect_404_timeframe'               => array( 'integer', 'scenario' => '404_detect' )
	);

	/**
	 * @return array
	 */
	public function get_404_whitelist() {
		$arr = array_filter( explode( PHP_EOL, $this->detect_404_whitelist ) );;
		$arr = array_map( 'trim', $arr );

		return $arr;
	}

	/**
	 * @return array
	 */
	public function get_404_ignorelist() {
		$arr = array_filter( explode( PHP_EOL, $this->detect_404_ignored_filetypes ) );
		$arr = array_map( 'trim', $arr );

		return $arr;
	}

	public function get_ip_blacklist() {
		$arr = array_filter( explode( PHP_EOL, $this->ip_blacklist ) );
		$arr = array_map( 'trim', $arr );

		return $arr;
	}

	public function get_ip_whitelist() {
		$arr = array_filter( explode( PHP_EOL, $this->ip_whitelist ) );
		$arr = array_map( 'trim', $arr );

		//whitelist wpmudev checkup
		return $arr;
	}

	/**
	 * @param $ip
	 *
	 * @return bool
	 */
	public function isWhitelist( $ip ) {
		$whitelist = $this->get_ip_whitelist();
		foreach ( $whitelist as $wip ) {
			$ips = explode( '-', $wip );
			if ( count( $ips ) == 1 && trim( $wip ) == $ip ) {
				return true;
			} elseif ( count( $ips ) == 2 ) {
				$high = sprintf( "%u", ip2long( $ips[1] ) );
				$low  = sprintf( "%u", ip2long( $ips[0] ) );

				$cip = sprintf( "%u", ip2long( $ip ) );
				if ( $high >= $cip && $cip >= $low ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * @param $ip
	 *
	 * @return bool
	 */
	public function isBlacklist( $ip ) {
		$blacklist = $this->get_ip_blacklist();
		foreach ( $blacklist as $wip ) {
			$ips = explode( '-', $wip );
			if ( count( $ips ) == 1 && trim( $wip ) == $ip ) {
				return true;
			} elseif ( count( $ips ) == 2 ) {
				$high = sprintf( "%u", ip2long( $ips[1] ) );
				$low  = sprintf( "%u", ip2long( $ips[0] ) );
				$cip  = sprintf( "%u", ip2long( $ip ) );
				if ( $high >= $cip && $cip >= $low ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * @param $ip
	 * @param $list
	 */
	public function add_ip_to_list( $ip, $list ) {
		$ips  = array();
		$type = '';
		if ( $list == 'blacklist' ) {
			$ips  = $this->get_ip_blacklist();
			$type = 'ip_blacklist';
		} else if ( $list == 'whitelist' ) {
			$ips  = $this->get_ip_whitelist();
			$type = 'ip_whitelist';
		}
		if ( empty( $type ) ) {
			return;
		}

		$ips[]       = $ip;
		$ips         = array_unique( $ips );
		$this->$type = implode( PHP_EOL, $ips );
		$this->save();
	}

	/**
	 * @param $ip
	 * @param $list
	 */
	public function remove_ip_from_list( $ip, $list ) {
		$ips  = array();
		$type = '';
		if ( $list == 'blacklist' ) {
			$ips  = $this->get_ip_blacklist();
			$type = 'ip_blacklist';
		} else if ( $list == 'whitelist' ) {
			$ips  = $this->get_ip_whitelist();
			$type = 'ip_whitelist';
		}
		if ( empty( $type ) ) {
			return;
		}

		$key = array_search( $ip, $ips );
		if ( $key !== false ) {
			unset( $ips[ $key ] );
			$ips         = array_unique( $ips );
			$this->$type = implode( PHP_EOL, $ips );
			$this->save();
		}
	}

	public function before_update() {
		$data = $this->export();
		foreach ( array_keys( $data ) as $key ) {
			$this->$key = wp_kses( $this->$key, \WD_Utils::allowed_html() );
		}
		//validate ips
		$remove_ips = array();
		if ( isset( $_POST['ip_blacklist'] ) ) {
			$blacklist = \WD_Utils::http_post( 'ip_blacklist' );
			$blacklist = explode( PHP_EOL, $blacklist );
			foreach ( $blacklist as $k => $ip ) {
				$ip = trim( $ip );
				if ( $this->validate_ip( $ip ) === false || ($ip == \WD_Utils::get_user_ip()) ) {
					unset( $blacklist[ $k ] );
					$remove_ips[] = $ip;
				}
			}
			$this->ip_blacklist = implode( PHP_EOL, $blacklist );
		}

		if ( isset( $_POST['ip_whitelist'] ) ) {
			$whitelist = \WD_Utils::http_post( 'ip_whitelist' );
			$whitelist = explode( PHP_EOL, $whitelist );
			foreach ( $whitelist as $k => $ip ) {
				$ip = trim( $ip );
				if ( $this->validate_ip( $ip ) === false ) {
					unset( $whitelist[ $k ] );
					$remove_ips[] = $ip;
				}
			}
			$this->ip_whitelist = implode( PHP_EOL, $whitelist );
		}
		$remove_ips = array_filter( $remove_ips );

		if ( ! empty( $remove_ips ) && count( $remove_ips ) ) {
			wp_defender()->global['false_ips'] = $remove_ips;
		}
	}

	/**
	 * $ip an be single ip, or a range like xxx.xxx.xxx.xxx - xxx.xxx.xxx.xxx or a using network subnet mask
	 *
	 * @param $ip
	 *
	 * @return bool
	 */
	private function validate_ip( $ip ) {
		if ( ( ! stristr( $ip, '-' ) || ! stristr( $ip, '/' ) ) && filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {

			return true;
		} elseif ( stristr( $ip, '-' ) ) {
			$ips = explode( '-', $ip );
			foreach ( $ips as $ip ) {
				if ( ! filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
					return false;
				}
			}
			if ( sprintf( "%u", ip2long( $ips[1] ) ) - sprintf( "%u", ip2long( $ips[0] ) ) > 0 ) {
				return true;
			}
		}

		return false;
	}
}