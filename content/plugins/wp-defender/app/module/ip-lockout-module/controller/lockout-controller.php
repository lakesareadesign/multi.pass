<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\IP_Lockout\Controller;

use WP_Defender\IP_Lockout\Component\Login_Protection_Api;
use WP_Defender\IP_Lockout\Model\IP_Model;
use WP_Defender\IP_Lockout\Model\Log_Model;
use WP_Defender\IP_Lockout\Model\Settings_Model;
use WP_Defender\Vendors\Email_Search;

class Lockout_Controller extends \WD_Controller {
	public $template = 'layouts/main';
	public $email_search;

	public function __construct() {
		//exec lockouts if needed
		$this->maybe_lockouts();

		if ( is_multisite() ) {
			$this->add_action( 'network_admin_menu', 'admin_menu', 12 );
		} else {
			$this->add_action( 'admin_menu', 'admin_menu', 12 );
		}
		$this->add_action( 'admin_enqueue_scripts', 'load_scripts' );
		/**
		 * section page view
		 */
		$this->add_action( 'wd_ip_lockout_view', 'view_login_lockout' );
		$this->add_action( 'wd_ip_lockout_view404', 'view_404_detect' );
		$this->add_action( 'wd_ip_lockout_viewblacklist', 'view_blacklist' );
		$this->add_action( 'wd_ip_lockout_viewlogs', 'view_logs' );
		$this->add_action( 'wd_ip_lockout_viewnotification', 'view_notification' );
		$this->add_action( 'wd_ip_lockout_viewreporting', 'view_reporting' );
		/**
		 * section add/remove receipt
		 */
		$this->add_action( 'wd_add_receipt_lockout', 'save_receipts' );
		$this->add_action( 'wd_remove_receipt_lockout', 'remove_receipts' );

		$this->add_action( 'wd_add_receipt_lockout_report', 'save_receipts' );
		$this->add_action( 'wd_remove_receipt_lockout_report', 'remove_receipts' );
		/**
		 * saving settings, all page
		 */
		$this->add_action( 'wp_loaded', 'save_settings' );
		/**
		 * post type
		 */
		$this->register_post_type();
		/**
		 * activated hook
		 */
		$this->add_action( 'defender_activated', 'settle_settings' );

		//register email search
		$settings     = new Settings_Model();
		$email_search = new Email_Search();
		if ( ! defined( 'DOING_AJAX' ) ) {
			$email_search->id       = 'lockout';
			$email_search->receipts = $settings->receipts;
		} else {
			if ( \WD_Utils::http_post( 'id' ) == 'lockout_report' ) {
				$email_search->id       = 'lockout_report';
				$email_search->receipts = $settings->report_receipts;
			} elseif ( \WD_Utils::http_post( 'id' ) == 'lockout' ) {
				$email_search->id       = 'lockout';
				$email_search->receipts = $settings->receipts;
			}
		}
		$email_search->add_hooks();

		$this->email_search = $email_search;

		/**
		 * ajax for shorthand adding ip to black or white
		 */
		$this->add_ajax_action( 'add_ip_to_list', 'add_ip_to_list' );

		/**
		 * storing log for auth fail
		 */
		$ip = $_SERVER['REMOTE_ADDR'];

		$whitelist = $settings->get_ip_whitelist();
		//whitelist wpmudev checkup
		$whitelist = array_merge( $whitelist, apply_filters( 'ip_lockout_default_whitelist_ip', array(
			'192.241.148.185',
			'104.236.132.222',
			'192.241.140.159',
			'192.241.228.89',
			'198.199.88.192',
			'54.197.28.242',
			'54.221.174.186',
			'54.236.233.244',
			array_key_exists( 'SERVER_ADDR', $_SERVER ) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR']
		) ) );

		if ( in_array( $ip, $whitelist ) ) {
			//this ip white list,w e dont need to check other
			return;
		}
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		/*$this->log( $user_agent, self::ERROR_LEVEL_DEBUG, 'useragent' );
		$this->log( $_SERVER['REQUEST_URI'], self::ERROR_LEVEL_DEBUG, 'uri' );*/
		if ( $settings->login_protection ) {
			$this->add_action( 'wp_login_failed', 'logging_fail_login', 9999 );
			$this->add_filter( 'authenticate', 'show_attempt_left', 9999 );
			$this->add_action( 'wp_login', 'clear_attempt_stats' );
		}

		if ( $settings->detect_404 ) {
			$this->add_action( 'template_redirect', 'record_404' );
		}

		$this->add_action( 'wd_lockout_trigger', 'update_ip_stats' );
		//sending email
		if ( $settings->login_lockout_notification ) {
			$this->add_action( 'wd_login_lockout', 'lockout_login_notification' );
		}
		if ( $settings->ip_lockout_notification ) {
			$this->add_action( 'wd_404_lockout', 'lockout_404_notification', 10, 2 );
		}

		//cron for cleanup
		if ( wp_next_scheduled( 'clean_up_old_log' ) === false ) {
			wp_schedule_event( time(), 'daily', 'clean_up_old_log' );
		}
		$this->add_action( 'clean_up_old_log', 'clean_up_old_log' );
		$this->add_action( 'send_lockout_report', 'send_lockout_report' );
	}

	public function settle_settings() {
		$settings = new Settings_Model();
		if ( ! get_option( 'wd_lockdown_settings' ) ) {
			$settings->report_frequency = 'weekly';
			$settings->report_day       = date( 'l' );
			$settings->report_time      = '0:00';
		}
		if ( empty( $settings->receipts ) ) {
			$settings->receipts[] = get_current_user_id();
			$settings->save();
		}
		if ( empty( $settings->report_receipts ) ) {
			$settings->report_receipts[] = get_current_user_id();
			$settings->save();
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		if ( ! in_array( $ip, $settings->get_ip_whitelist() ) ) {
			$settings->add_ip_to_list( $ip, 'whitelist' );
		}
	}

	public function add_ip_to_list() {
		if ( \WD_Utils::check_permission() == false ) {
			return;
		}

		$id   = \WD_Utils::http_post( 'id' );
		$log  = Log_Model::model()->find( $id );
		$type = \WD_Utils::http_post( 'type' );
		if ( ! is_object( $log ) || empty( $type ) ) {
			return;
		}
		$settings = new Settings_Model();
		$ip       = $log->ip;
		switch ( $type ) {
			case 'blacklist':
				$settings->remove_ip_from_list( $ip, 'whitelist' );
				$settings->add_ip_to_list( $ip, 'blacklist' );
				wp_send_json( array(
					'status'       => 1,
					'html'         => Login_Protection_Api::get_logs_actions_text( $log ),
					'notification' => sprintf( __( "IP %s was added to the blacklist", wp_defender()->domain ), $log->ip )
				) );
				break;
			case 'unblacklist':
				$settings->remove_ip_from_list( $ip, 'blacklist' );
				wp_send_json( array(
					'status'       => 1,
					'html'         => Login_Protection_Api::get_logs_actions_text( $log ),
					'notification' => sprintf( __( "IP %s was removed from the blacklist", wp_defender()->domain ), $log->ip )
				) );
				break;
			case 'whitelist':
				$settings->remove_ip_from_list( $ip, 'blacklist' );
				$settings->add_ip_to_list( $ip, 'whitelist' );
				wp_send_json( array(
					'status'       => 1,
					'html'         => Login_Protection_Api::get_logs_actions_text( $log ),
					'notification' => sprintf( __( "IP %s was added to the whitelist", wp_defender()->domain ), $log->ip )
				) );
				break;
			case 'unwhitelist':
				$settings->remove_ip_from_list( $ip, 'whitelist' );
				wp_send_json( array(
					'status'       => 1,
					'html'         => Login_Protection_Api::get_logs_actions_text( $log ),
					'notification' => sprintf( __( "IP %s was removed from the whitelist", wp_defender()->domain ), $log->ip )
				) );
				break;
		}
	}

	/**
	 * send lockout report, base on cron
	 */
	public function send_lockout_report() {
		$this->template = false;
		$settings       = new Settings_Model();
		$after_time     = '';
		$time_unit      = '';
		switch ( $settings->report_frequency ) {
			case 'daily':
				$after_time = 'yesterday midnight';
				$time_unit  = __( "In the past 24 hours", wp_defender()->domain );
				break;
			case 'weekly':
				$after_time = '-7 days';
				$time_unit  = __( "In the past week", wp_defender()->domain );
				break;
			case 'monthly':
				$after_time = '-30 days';
				$time_unit  = __( "In the month", wp_defender()->domain );
				break;
		}

		foreach ( $settings->report_receipts as $user_id ) {
			$user = get_user_by( 'id', $user_id );
			if ( is_object( $user ) ) {
				$content        = $this->render( 'emails/report', array(
					'admin'         => $user->display_name,
					'count_total'   => Login_Protection_Api::get_all_lockouts( $after_time ),
					'last_lockout'  => Login_Protection_Api::get_last_lockout(),
					'lockout_404'   => Login_Protection_Api::get_404_lockouts( $after_time ),
					'lockout_login' => Login_Protection_Api::get_login_lockouts( $after_time ),
					'time_unit'     => $time_unit
				), false );
				$no_reply_email = "noreply@" . parse_url( get_site_url(), PHP_URL_HOST );
				$headers        = array(
					'From: WP Defender <' . $no_reply_email . '>',
					'Content-Type: text/html; charset=UTF-8'
				);
				wp_mail( $user->user_email, sprintf( __( "Defender Lockouts Report for %s", wp_defender()->domain ), network_site_url() ), $content, $headers );
			}
		}
	}

	/**
	 * clean up logs older than 30 days
	 */
	public function clean_up_old_log() {
		$logs = Log_Model::model()->find_all( array(), false, false, array(
			'date_query' => array(
				'before' => apply_filters( 'ip_lockout_logs_store_backward', '-30 days' )
			)
		) );

		if ( count( $logs ) ) {
			foreach ( $logs as $log ) {
				wp_delete_post( $log->id );
			}
		}
	}

	/**
	 * sending email when any lockout triggerd
	 *
	 * @param $model
	 * @param $uri
	 */
	public function lockout_404_notification( $model, $uri ) {
		$this->template = false;
		$settings       = new Settings_Model();
		foreach ( $settings->receipts as $user_id ) {
			$user = get_user_by( 'id', $user_id );
			if ( is_object( $user ) ) {
				$content        = $this->render( 'emails/404-lockout', array(
					'admin' => $user->display_name,
					'ip'    => $model->ip,
					'uri'   => $uri
				), false );
				$no_reply_email = "noreply@" . parse_url( get_site_url(), PHP_URL_HOST );
				$headers        = array(
					'From: WP Defender <' . $no_reply_email . '>',
					'Content-Type: text/html; charset=UTF-8'
				);
				wp_mail( $user->user_email, sprintf( __( "404 lockout alert for %s", wp_defender()->domain ), network_site_url() ), $content, $headers );
			}
		}
	}

	/**
	 * @param IP_Model $model
	 */
	public function lockout_login_notification( IP_Model $model ) {
		$this->template = false;
		$settings       = new Settings_Model();
		foreach ( $settings->receipts as $user_id ) {
			$user = get_user_by( 'id', $user_id );
			if ( is_object( $user ) ) {
				$content        = $this->render( 'emails/login-lockout', array(
					'admin' => $user->display_name,
					'ip'    => $model->ip,
				), false );
				$no_reply_email = "noreply@" . parse_url( get_site_url(), PHP_URL_HOST );
				$headers        = array(
					'From: WP Defender <' . $no_reply_email . '>',
					'Content-Type: text/html; charset=UTF-8'
				);
				wp_mail( $user->user_email, sprintf( __( "Login lockout alert for %s", wp_defender()->domain ), network_site_url() ), $content, $headers );
			}
		}
	}

	/**
	 *
	 */
	public function clear_attempt_stats() {
		$ip    = $_SERVER['REMOTE_ADDR'];
		$model = IP_Model::model()->find_by_attributes( array(
			'ip' => $ip
		) );
		if ( is_object( $model ) ) {
			$model->attempt   = 1;
			$model->lock_time = current_time( 'timestamp' );
			$model->save();
		}
	}

	/**
	 * @param $user
	 *
	 * @return mixed
	 */
	public function show_attempt_left( $user ) {
		if ( is_wp_error( $user ) && $_SERVER['REQUEST_METHOD'] == 'POST' && ! in_array( $user->get_error_code(), array(
				'empty_username',
				'empty_password'
			) )
		) {
			$ip    = $_SERVER['REMOTE_ADDR'];
			$model = IP_Model::model()->find_by_attributes( array(
				'ip' => $ip
			) );
			if ( is_object( $model ) ) {
				if ( $model->is_locked() ) {
					//redirect
					wp_redirect( get_site_url() );
					exit;
				}
				$settings = new Settings_Model();
				$attempt  = $model->attempt + 1;
				if ( $settings->login_protection_login_attempt - $attempt == 0 ) {
					$user->add( 'def_warning', $settings->login_protection_lockout_message );
				} else {
					$user->add( 'def_warning', sprintf( esc_html__( "%d login attempts remaining", wp_defender()->domain ), $settings->login_protection_login_attempt - $attempt ) );
				}
			} else {
				$settings = new Settings_Model();
				//becase authenticate hook fire before wp_login_fail, so at this state, we dont have any data
				$user->add( 'def_warning', sprintf( esc_html__( "%d login attempts remaining", wp_defender()->domain ), $settings->login_protection_login_attempt - 1 ) );
			}
		}

		return $user;
	}

	public function update_ip_stats( Log_Model $log ) {
		if ( $log->type == Log_Model::AUTH_FAIL ) {
			Login_Protection_Api::maybe_lock( $log );
		} elseif ( $log->type == Log_Model::ERROR_404 ) {
			Login_Protection_Api::maybe_404_lock( $log );
		}
	}

	public function maybe_lockouts() {
		$settings = new Settings_Model();
		if ( \WD_Utils::http_get( 'def-lockout-demo' ) == 1 ) {
			$this->template = false;
			switch ( \WD_Utils::http_get( 'type' ) ) {
				case 'login':
					$message = $settings->login_protection_lockout_message;
					break;
				case '404':
					$message = $settings->detect_404_lockout_message;
					break;
				case 'blacklist':
					$message = $settings->ip_lockout_message;
					break;
				default:
					$message = __( "Demo", wp_defender()->domain );
			}
			$this->render( 'locked', array(
				'message' => $message
			) );
			die;
		}

		$ip = $_SERVER['REMOTE_ADDR'];
		if ( in_array( $ip, $settings->get_ip_whitelist() ) ) {
			return;
		} elseif ( in_array( $ip, $settings->get_ip_blacklist() ) ) {
			$this->template = false;
			$this->render( 'locked', array(
				'message' => $settings->ip_lockout_message
			) );
			die;
		} else {
			$model = IP_Model::model()->find_by_attributes( array(
				'ip' => $ip
			) );

			if ( is_object( $model ) && $model->is_locked() ) {
				$this->template = false;
				$this->render( 'locked', array(
					'message' => $model->lockout_message
				) );
				die;
			}
		}
	}

	public function record_404() {
		if ( is_404() ) {
			$settings = new Settings_Model();

			if ( $settings->detect_404_logged == false && is_user_logged_in() ) {
				return;
			}

			$uri = $_SERVER['REQUEST_URI'];
			if ( in_array( $uri, $settings->get_404_whitelist() ) ) {
				//it is white list, just return
				return;
			}

			$ext               = pathinfo( $uri, PATHINFO_EXTENSION );
			$ext               = trim( $ext );
			$model             = new Log_Model();
			$model->ip         = $_SERVER['REMOTE_ADDR'];
			$model->user_agent = $_SERVER['HTTP_USER_AGENT'];
			//$model->log        = sprintf( esc_html__( "Request for file %s which doesn't exist", wp_defender()->domain ), $_SERVER['REQUEST_URI'] );
			$model->log  = $_SERVER['REQUEST_URI'];
			$model->date = time();
			if ( strlen( $ext ) > 0 && in_array( $ext, $settings->get_404_ignorelist() ) ) {
				$model->type = Log_Model::ERROR_404_IGNORE;
			} else {
				$model->type = '404_error';
			}
			$model->save();

			do_action( 'wd_lockout_trigger', $model );
		}
	}

	/**
	 * @param $username
	 */
	public function logging_fail_login( $username ) {
		$model             = new Log_Model();
		$model->ip         = $_SERVER['REMOTE_ADDR'];
		$model->user_agent = $_SERVER['HTTP_USER_AGENT'];
		$model->log        = sprintf( esc_html__( "Failed login attempt with username %s", wp_defender()->domain ), $username );
		$model->date       = time();
		$model->type       = 'auth_fail';
		$model->save();

		$settings = new Settings_Model();
		if ( $settings->login_protection_ban_admin_brute && strtolower( $username ) == 'admin' ) {
			//lock now
			Login_Protection_Api::maybe_lock( $model, true );
		} else {
			do_action( 'wd_lockout_trigger', $model );
		}
	}

	public function register_post_type() {
		register_post_type( 'wd_iplockout_log', array(
			'labels'          => array(
				'name'          => __( "Lockout Logs", wp_defender()->domain ),
				'singular_name' => __( "Lockout Log", wp_defender()->domain )
			),
			'public'          => false,
			'show_ui'         => false,
			'show_in_menu'    => false,
			'capability_type' => array( 'wd_iplockout_log', 'wd_iplockout_logs' ),
			'map_meta_cap'    => true,
			'hierarchical'    => false,
			'rewrite'         => false,
			'query_var'       => false,
			'supports'        => array( '' ),
		) );
		register_post_type( 'wd_ip_lockout', array(
			'labels'          => array(
				'name'          => __( "IP Lockouts", wp_defender()->domain ),
				'singular_name' => __( "IP Lockout", wp_defender()->domain )
			),
			'public'          => false,
			'show_ui'         => false,
			'show_in_menu'    => false,
			'capability_type' => array( 'wd_ip_lockout', 'wd_ip_lockouts' ),
			'map_meta_cap'    => true,
			'hierarchical'    => false,
			'rewrite'         => false,
			'query_var'       => false,
			'supports'        => array( '' ),
		) );
	}

	/**
	 * @param $user_id
	 */
	public function remove_receipts( $user_id ) {
		$settings = new Settings_Model();
		$user     = get_user_by( 'id', $user_id );
		$id       = \WD_Utils::http_post( 'id' );
		if ( is_object( $user ) ) {
			if ( $id == 'lockout' ) {
				$index = array_search( $user_id, $settings->receipts );
				if ( $index !== false ) {
					unset( $settings->receipts[ $index ] );
					$settings->save();
				}
			} elseif ( $id == 'lockout_report' ) {
				$index = array_search( $user_id, $settings->report_receipts );
				if ( $index !== false ) {
					unset( $settings->report_receipts[ $index ] );
					$settings->save();
				}
			}
		}
	}

	/**
	 * @param $user_name
	 */
	public function save_receipts( $user_name ) {
		$settings = new Settings_Model();
		$user     = get_user_by( 'login', $user_name );
		$id       = \WD_Utils::http_post( 'id' );
		if ( is_object( $user ) ) {
			if ( $id == 'lockout' ) {
				$settings->receipts[] = $user->ID;
			} else {
				$settings->report_receipts[] = $user->ID;
			}
			$settings->save();
			wp_send_json( array(
				'status'     => 1,
				'avatar'     => \WD_Utils::get_avatar_url( get_avatar( $user->ID, 30 ) ),
				'name'       => \WD_Utils::get_display_name( $user->ID ),
				'is_current' => get_current_user_id() == $user->ID,
				'user_id'    => $user->ID
			) );
		} else {
			wp_send_json( array(
				'status' => 0
			) );
		}
	}

	public function view_blacklist() {
		wp_enqueue_script( 'def-lockout-logs', wp_defender()->get_plugin_url() . 'app/module/ip-lockout-module/assets/js/script.js', array(
			'jquery'
		) );
		$settings = new Settings_Model();
		$this->render( 'blacklist/enabled', array(
			'settings' => $settings
		) );
	}

	public function view_logs() {
		wp_enqueue_script( 'def-lockout-logs', wp_defender()->get_plugin_url() . 'app/module/ip-lockout-module/assets/js/script.js', array(
			'jquery'
		) );
		wp_enqueue_script( 'def-notify', wp_defender()->get_plugin_url() . 'app/module/ip-lockout-module/assets/js/notify.min.js', array(
			'jquery'
		) );
		$this->render( 'logging/enabled' );
	}

	public function view_reporting() {
		wp_enqueue_script( 'def-lockout-logs', wp_defender()->get_plugin_url() . 'app/module/ip-lockout-module/assets/js/script.js', array(
			'jquery'
		) );
		$settings = new Settings_Model();
		if ( empty( $settings->report_receipts ) ) {
			$settings->report_receipts[] = get_current_user_id();
			$settings->save();
		}
		$this->email_search->receipts = $settings->report_receipts;
		$this->email_search->id       = 'lockout_report';
		$this->render( 'notification/report', array(
			'email_search' => $this->email_search,
			'settings'     => $settings
		) );
	}

	public function view_notification() {
		wp_enqueue_script( 'def-lockout-logs', wp_defender()->get_plugin_url() . 'app/module/ip-lockout-module/assets/js/script.js', array(
			'jquery'
		) );
		$settings = new Settings_Model();
		if ( empty( $settings->receipts ) ) {
			$settings->receipts[] = get_current_user_id();
			$settings->save();
			$this->email_search->receipts = $settings->receipts;
		}
		$this->render( 'notification/enabled', array(
			'email_search' => $this->email_search,
			'settings'     => $settings
		) );
	}

	public function view_404_detect() {
		wp_enqueue_script( 'def-lockout-logs', wp_defender()->get_plugin_url() . 'app/module/ip-lockout-module/assets/js/script.js', array(
			'jquery'
		) );
		$settings = new Settings_Model();
		if ( $settings->detect_404 ) {
			$this->render( 'detect-404/enabled', array(
				'settings' => $settings,
				'errors'   => isset( wp_defender()->global['error'] ) ? wp_defender()->global['error'] : null
			) );
		} else {
			$this->render( 'detect-404/disabled', array(
				'settings' => $settings
			) );
		}
	}

	public function save_settings() {
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && \WD_Utils::http_post( 'scenario' ) ) {
			if ( ! \WD_Utils::check_permission() ) {
				return;
			}

			if ( ! wp_verify_nonce( \WD_Utils::http_post( '_wdnonce' ), 'save_lockout_settings' ) ) {
				return;
			}

			$settings  = new Settings_Model();
			$screnario = \WD_Utils::http_post( 'scenario' );
			switch ( $screnario ) {
				case 'login_protect':
					$settings->scenario = 'login_protect';
					$data               = wp_unslash( $_POST );
					$settings->import( $data );
					if ( $settings->validate() ) {
						$settings->save();
						$this->flash( 'success', esc_attr__( "Login Protection settings have been updated.", wp_defender()->domain ) );
						wp_redirect( network_admin_url( 'admin.php?page=wdf-ip-lockout' ) );
						exit;
					} else {
						wp_defender()->global['error'] = $settings->get_errors();
					}
					break;
				case 'detect_404':
					$settings->scenario = 'detect_404';
					$data               = wp_unslash( $_POST );
					$settings->import( $data );
					if ( $settings->validate() ) {
						$settings->save();
						$this->flash( 'success', esc_attr__( "404 Detection settings have been updated.", wp_defender()->domain ) );
						wp_redirect( network_admin_url( 'admin.php?page=wdf-ip-lockout&view=404' ) );
						exit;
					} else {
						wp_defender()->global['error'] = $settings->get_errors();
					}
					break;
				case 'blacklist':
				case 'notification':
				case 'reporting':
					$data = wp_unslash( $_POST );
					$settings->import( $data );
					$settings->save();

					if ( $screnario == 'reporting' ) {
						if ( $settings->report == true ) {
							wp_clear_scheduled_hook( 'send_lockout_report' );
							$timestamp = Login_Protection_Api::get_report_sending_time();
							wp_schedule_single_event( Login_Protection_Api::local_to_utc( date( 'Y-m-d H:i:s', $timestamp ) ), 'send_lockout_report' );
						} else {
							wp_clear_scheduled_hook( 'send_lockout_report' );
						}
					}
					if ( isset( wp_defender()->global['false_ips'] ) ) {
						$this->flash( 'warning', sprintf( esc_attr__( "Those IPs %s were removed because invalid format", wp_defender()->domain ), implode( ',', wp_defender()->global['false_ips'] ) ) );
					}

					$this->flash( 'success', sprintf( esc_attr__( "%s settings have been updated.", wp_defender()->domain ), ucwords( str_replace( '_', ' ', $screnario ) ) ) );
					wp_redirect( network_admin_url( 'admin.php?page=wdf-ip-lockout&view=' . $screnario ) );
					exit;
					break;
			}
		}
	}

	public function view_login_lockout() {
		wp_enqueue_script( 'def-lockout-logs', wp_defender()->get_plugin_url() . 'app/module/ip-lockout-module/assets/js/script.js', array(
			'jquery'
		) );
		$settings = new Settings_Model();
		if ( $settings->login_protection ) {
			$this->render( 'login-lockouts/enabled', array(
				'settings' => $settings,
				'errors'   => isset( wp_defender()->global['error'] ) ? wp_defender()->global['error'] : null
			) );
		} else {
			$this->render( 'login-lockouts/disabled', array(
				'settings' => $settings
			) );
		}
	}

	public function admin_menu() {
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';
		add_submenu_page( 'wp-defender', esc_html__( "IP Lockouts", wp_defender()->domain ), esc_html__( "IP Lockouts", wp_defender()->domain ), $cap, 'wdf-ip-lockout', array(
			$this,
			'display_main'
		) );
	}

	public function display_main() {
		$view = \WD_Utils::http_get( 'view', null );

		do_action( 'wd_ip_lockout_view' . $view );
	}

	/**
	 * check if this page is page of the plugin
	 * @return bool
	 */
	private function is_in_page() {
		$page = \WD_Utils::http_get( 'page' );

		return $page == 'wdf-ip-lockout';
	}

	public function load_scripts() {
		if ( $this->is_in_page() ) {
			\WDEV_Plugin_Ui::load( wp_defender()->get_plugin_url() . 'shared-ui/', false );
			wp_enqueue_style( 'lockdown', wp_defender()->get_plugin_url() . 'app/module/ip-lockout-module/assets/css/styles.css' );
		}
	}
}