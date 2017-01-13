<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\IP_Lockout\Component;

use WP_Defender\IP_Lockout\Model\IP_Model;
use WP_Defender\IP_Lockout\Model\Log_Model;
use WP_Defender\IP_Lockout\Model\Settings_Model;

class Login_Protection_Api extends \WD_Component {
	/**
	 * @param Log_Model $log
	 * @param bool $force
	 */
	public static function maybe_lock( Log_Model $log, $force = false ) {
		//find record first
		$model = IP_Model::model()->find_by_attributes( array(
			'ip' => $log->ip
		) );

		if ( is_object( $model ) && $model->status == IP_Model::STATUS_BLOCKED ) {
			//already locked, just return
			return;
		}

		$settings = new Settings_Model();
		//find backward from log date, if there are only log & counter > max attempt, then lock
		$after = strtotime( '- ' . $settings->login_protection_lockout_timeframe . ' seconds', current_time( 'timestamp' ) );

		if ( is_object( $model ) ) {
			//recal release time, if after time smaller than lock time,then we will use last locktime for check
			if ( $after < $model->lock_time ) {
				$after = $model->lock_time;
			}
		}

		$logs = Log_Model::model()->find_all( array(
			'ip'      => $log->ip,
			'type'    => Log_Model::AUTH_FAIL,
			'blog_id' => get_current_blog_id()
		), false, 1, array(
			'date_query' => array(
				'after' => date( 'Y-m-d H:i:s', $after )
			),
			'order'      => 'DESC',
			'orderby'    => 'ID'
		) );
		/*var_dump( date( 'Y-m-d H:i:s', $after ) );
		foreach ( $logs as $log ) {
			var_dump( date( 'Y-m-d H:i:s', $log->date ) );
		}
		die;*/
		$attempt = count( $logs );
		if ( ! is_object( $model ) ) {
			//no record, create one
			$model         = new IP_Model();
			$model->ip     = $log->ip;
			$model->status = IP_Model::STATUS_NORMAL;
		}

		$model->attempt = $attempt;
		if ( $model->attempt >= $settings->login_protection_login_attempt ) {
			$model->status          = IP_Model::STATUS_BLOCKED;
			$model->release_time    = strtotime( '+ ' . $settings->login_protection_lockout_duration . ' seconds' );
			$model->lockout_message = $settings->login_protection_lockout_message;
			if ( is_multisite() ) {
				switch_to_blog( 1 );
			}
			$model->lock_time = current_time( 'timestamp' );
			if ( is_multisite() ) {
				restore_current_blog();
			}
			$model->save();
			//we need to create a log
			$lock_log             = new Log_Model();
			$lock_log->type       = Log_Model::AUTH_LOCK;
			$lock_log->date       = time();
			$lock_log->ip         = $log->ip;
			$lock_log->user_agent = $_SERVER['HTTP_USER_AGENT'];
			$lock_log->log        = esc_html__( "Lockout occurred: Too many failed login attempts", wp_defender()->domain );
			$lock_log->save();
			//if fail2ban, we will add that IP to blacklist
			if ( $settings->login_protection_lockout_ban ) {
				$settings->add_ip_to_list( $model->ip, 'blacklist' );
			}

			//trigger an action
			do_action( 'wd_login_lockout', $model );
		} else {
			$model->save();
		}
	}

	public static function maybe_404_lock( Log_Model $log ) {
		//find record first
		$model = IP_Model::model()->find_by_attributes( array(
			'ip' => $log->ip
		) );

		if ( is_object( $model ) && $model->status == IP_Model::STATUS_BLOCKED ) {
			//already locked, just return
			return;
		}

		$settings = new Settings_Model();
		//find backward from log date, if there are only log & counter > max attempt, then lock
		$after = strtotime( '- ' . $settings->detect_404_timeframe . ' seconds', current_time( 'timestamp' ) );

		if ( is_object( $model ) ) {
			//recal release time, if after time smaller than lock time,then we will use last locktime for check
			if ( $after < $model->lock_time_404 ) {
				$after = $model->lock_time_404;
			}
		}

		$logs = Log_Model::model()->find_all( array(
			'ip'      => $log->ip,
			'type'    => Log_Model::ERROR_404,
			'blog_id' => get_current_blog_id()
		), false, 1, array(
			'date_query' => array(
				'after' => date( 'Y-m-d H:i:s', $after )
			),
			'order'      => 'DESC',
			'orderby'    => 'ID'
		) );

		if ( ! is_object( $model ) ) {
			//no record, create one
			$model         = new IP_Model();
			$model->ip     = $log->ip;
			$model->status = IP_Model::STATUS_NORMAL;
		}
		if ( count( $logs ) >= $settings->detect_404_threshold ) {
			$model->status          = IP_Model::STATUS_BLOCKED;
			$model->release_time    = strtotime( '+ ' . $settings->detect_404_lockout_duration . ' seconds' );
			$model->lockout_message = $settings->detect_404_lockout_message;
			if ( is_multisite() ) {
				switch_to_blog( 1 );
			}
			$model->lock_time_404 = current_time( 'timestamp' );
			if ( is_multisite() ) {
				restore_current_blog();
			}
			$model->save();
			$lock_log             = new Log_Model();
			$lock_log->type       = Log_Model::LOCKOUT_404;
			$lock_log->date       = time();
			$lock_log->ip         = $log->ip;
			$lock_log->user_agent = $_SERVER['HTTP_USER_AGENT'];
			$uri                  = $_SERVER['REQUEST_URI'];
			$lock_log->log        = sprintf( esc_html__( "Lockout occurred:  Too many 404 requests for %s", wp_defender()->domain ), $uri );
			$lock_log->save();
			//if fail2ban, we will add that IP to blacklist
			if ( $settings->detect_404_lockout_ban ) {
				$settings->add_ip_to_list( $model->ip, 'blacklist' );
			}
			do_action( 'wd_404_lockout', $model, $uri );
		}
	}

	/**
	 * @param null $time
	 *
	 * @return array
	 */
	public static function get_404_lockouts( $time = null ) {
		$logs = Log_Model::model()->find_all( array(
			'type' => Log_Model::LOCKOUT_404
		), false, 1, array(
			'date_query' => array(
				'after' => $time
			),
			'order'      => 'DESC',
			'orderby'    => 'ID'
		) );

		return $logs;
	}

	/**
	 * @param null $time
	 *
	 * @return array
	 */
	public static function get_login_lockouts( $time = null ) {
		$logs = Log_Model::model()->find_all( array(
			'type' => Log_Model::AUTH_LOCK
		), false, 1, array(
			'date_query' => array(
				'after' => $time
			)
		) );

		return $logs;
	}

	/**
	 * @param null $time
	 *
	 * @return array
	 */
	public static function get_all_lockouts( $time = null ) {
		$logs = Log_Model::model()->find_all( array(
			'type' => array(
				Log_Model::LOCKOUT_404,
				Log_Model::AUTH_LOCK
			)
		), false, 1, array(
			'date_query' => array(
				'after' => $time
			)
		) );

		return $logs;
	}

	/**
	 * @return array|mixed|null
	 */
	public static function get_last_lockout() {
		$log = Log_Model::model()->find_all( array(
			'type' => array(
				Log_Model::LOCKOUT_404,
				Log_Model::AUTH_LOCK
			)
		), 1 );
		$log = array_shift( $log );
		if ( is_object( $log ) ) {
			return $log;
		}

		return null;
	}

	/**
	 * @param $timestamp
	 *
	 * @return false|int
	 */
	public static function local_to_utc( $timestring ) {
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

		$timezone = new \DateTimeZone( $tz );
		$time     = new \DateTime( $timestring, $timezone );

		return $time->getTimestamp();
	}

	/**
	 * @param $timezone
	 *
	 * @return false|string
	 */
	public static function get_timezone_string( $timezone ) {
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
	 * this will return report sending timestamp in UTC
	 * @return false|int
	 */
	public static function get_report_sending_time() {
		$settings = new Settings_Model();
		$time     = current_time( 'timestamp' );
		switch ( $settings->report_frequency ) {
			case 'daily':
				if ( $time > strtotime( 'today ' . $settings->report_time, $time ) ) {
					//should be tomorrow
					return strtotime( 'tomorrow ' . $settings->report_time, $time );
				} else {
					return strtotime( 'today ' . $settings->report_time, $time );
				}
				break;
			case 'weekly':
				if ( $time > strtotime( $settings->report_day . ' ' . $settings->report_time . ' this week', $time ) ) {
					return strtotime( $settings->report_day . ' ' . $settings->report_time . ' next week', $time );
				} else {
					return strtotime( $settings->report_day . ' ' . $settings->report_time . ' this week', $time );
				}
				break;
			case 'monthly':
				if ( $time > strtotime( $settings->report_time . ' first ' . $settings->report_day . ' of this month', $time ) ) {
					return strtotime( $settings->report_time . ' first ' . $settings->report_day . ' of next month', $time );
				} else {
					return strtotime( $settings->report_time . ' first ' . $settings->report_day . ' of this month', $time );

				}
				break;
		}
	}

	/**
	 * @return string
	 */
	public static function get_logs_actions_text( $log ) {
		$links     = array();
		$settings  = new Settings_Model();
		$blacklist = $settings->get_ip_blacklist();
		$whitelist = $settings->get_ip_whitelist();

		$ip = $_SERVER['REMOTE_ADDR'];
		if ( $ip != $log->ip ) {
			if ( ! in_array( $log->ip, $blacklist ) ) {
				$links[] = '<a class="ip-action" data-type="blacklist" data-id="' . $log->id . '" href="#">' . __( "Ban", wp_defender()->domain ) . '</a>';
			} else {
				$links[] = '<a class="ip-action" data-type="unblacklist" data-id="' . $log->id . '" href="#">' . __( "Unban", wp_defender()->domain ) . '</a>';
			}
		}

		if ( ! in_array( $log->ip, $whitelist ) ) {
			$links[] = '<a class="ip-action" data-type="whitelist" data-id="' . $log->id . '" href="#">' . __( "Whitelist", wp_defender()->domain ) . '</a>';
		} else {
			$links[] = '<a class="ip-action" data-type="unwhitelist" data-id="' . $log->id . '" href="#">' . __( "Unwhitelist", wp_defender()->domain ) . '</a>';
		}

		return implode( ' ', $links );
	}
}