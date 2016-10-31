<?php

/**
 * @author: Hoang Ngo
 */
class WD_Audit_Logging_Controller extends WD_Controller {
	public $warning = false;

	const CACHE_THEME_TRANSIENT = 'wd_cache_theme_transient';

	public function __construct() {
		if ( is_multisite() ) {
			$this->add_action( 'network_admin_menu', 'admin_menu', 12 );
		} else {
			$this->add_action( 'admin_menu', 'admin_menu', 12 );
		}
		$this->add_action( 'admin_enqueue_scripts', 'load_scripts' );

		//cache for theme deleted
		$this->add_ajax_action( 'wd_toggle_audit_log', 'toggle_audit' );
		if ( WD_Utils::get_setting( 'audit_log->enabled', 0 ) == 1 ) {
			$this->add_ajax_action( 'wd_audit_suggest_user_name', 'suggest_user_name' );
			$this->add_action( 'delete_site_transient_update_themes', 'cache_theme_transient' );
			$this->add_action( 'wp_loaded', 'setup_events', 1 );
			$this->add_action( 'shutdown', 'submit_events' );
			$this->add_ajax_action( 'wd_audit_email_report', 'toggle_email_report' );
			$this->add_action( 'wd_audit_send_report', 'send_report_email' );
			$this->add_action( 'wp_loaded', 'listen_for_plugins_themes_content' );
			$this->add_ajax_action( 'wd_audit_get_events', 'get_events_ajax' );
			$this->add_action( 'wp_loaded', 'udp_check', 999 );
		}
	}

	public function udp_check() {
		if ( defined( 'WD_DONT_CHECK_UDP' ) && constant( 'WD_DONT_CHECK_UDP' ) == true ) {
			return;
		}

		if ( WD_Utils::get_cache( 'udp_status', null ) !== null ) {
			return;
		}

		$socket_ip    = '54.82.203.19';
		$socket_ports = array(
			80,
			3244
		);

		foreach ( $socket_ports as $socket_port ) {
			$socket = @stream_socket_client( 'udp://' . $socket_ip . ':' . $socket_port, $errno, $errstr,
				1,
				STREAM_CLIENT_ASYNC_CONNECT );

			fwrite( $socket, json_encode( array(
				'site_url' => network_site_url(),
				'apikey'   => WD_Utils::get_dev_api()
			) ) );
			@fclose( $socket );
		}

		$ret = $this->wpmudev_call( 'http://' . $socket_ip . '/udp_status', array(
			'site_url' => network_site_url()
		), array(
			'headers' => array(
				'apikey' => WD_Utils::get_dev_api()
			),
			'timeout' => 1
		) );

		if ( is_array( $ret ) && isset( $ret['status'] ) ) {
			WD_Utils::cache( 'udp_status', $ret['status'], HOUR_IN_SECONDS * 1 );
		}
	}

	public function get_events_ajax() {
		if ( ! WD_Utils::check_permission() ) {
			die;
		}

		$table = new WD_Audit_Table();
		$table->prepare_items();
		ob_start();
		$table->display();
		$table_html = ob_get_clean();
		ob_start();
		$table->display_tablenav( 'bottom' );
		$table_nav = ob_get_clean();
		wp_send_json( array(
			'table' => $table_html,
			'nav'   => $table_nav
		) );
		die;
	}

	public function suggest_user_name() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}
		$args    = array(
			'search'         => '*' . WD_Utils::http_post( 'term' ) . '*',
			'search_columns' => array( 'user_login' ),
			'number'         => 10,
			'orderby'        => 'user_login',
			'order'          => 'ASC'
		);
		$query   = new WP_User_Query( $args );
		$results = array();
		foreach ( $query->get_results() as $row ) {
			$results[] = array(
				'id'    => $row->user_login,
				'label' => '<span class="name title">' . WD_Utils::get_full_name( $row->user_email ) . '</span> <span class="email">' . $row->user_email . '</span>',
				'thumb' => WD_Utils::get_avatar_url( get_avatar( $row->user_email ) )
			);
		}
		echo json_encode( $results );
		exit;
	}

	public function listen_for_plugins_themes_content() {
		if ( ! isset( $_SERVER['REQUEST_METHOD'] ) ) {
			return;
		}

		if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
			return;
		}

		if ( ! ( is_admin() || is_network_admin() ) ) {
			return;
		}

		$newcontent = WD_Utils::http_post( 'newcontent' );
		$action     = WD_Utils::http_post( 'action' );
		$theme      = WD_Utils::http_post( 'theme' );
		$plugin     = WD_Utils::http_post( 'plugin' );
		$file       = WD_Utils::http_post( 'file' );
		$type       = $theme !== false ? 'theme' : ( $plugin !== false ? 'plugin' : null );


		if ( $action == 'update' && $newcontent !== false && ( $theme !== false || $plugin !== false ) && $file !== false ) {
			if ( $type == 'plugin' ) {
				$folder = array_shift( explode( '/', $plugin ) );

				$plugins = get_plugins();
				$data    = null;
				foreach ( $plugins as $k => $p ) {
					if ( strpos( $k, $folder ) === 0 ) {
						//this mean work
						$data = $p;
						break;
					}
				}

				if ( is_array( $data ) ) {
					$object = $data['Name'];
				} else {
					return false;
				}
			} elseif ( $type == 'theme' ) {
				$theme = wp_get_theme( $theme );
				if ( is_object( $theme ) && $theme->exists() ) {
					$object = $theme->Name;
				} else {
					return false;
				}
			}
			if ( ! empty( $object ) ) {
				do_action( 'wd_plugin/theme_changed', $type, $object, $file );
			}
		}
	}

	public function send_report_email() {
		$recipients = WD_Utils::get_setting( 'recipients', array() );
		if ( empty( $recipients ) ) {
			return;
		}
		/**
		 * report data should contains
		 * summaries each event types
		 * If the interval is 1 day, we get in 24 hours
		 * if it is 7 days, we will query a week
		 * if this is 30 days, we will query data in a month
		 * data will be summaries by event types, by percent
		 * we will report user activity by percent too
		 */

		$frequency = WD_Utils::get_setting( 'audit_log->report_email_frequent', 7 );
		switch ( $frequency ) {
			case 1:
				$date_from = strtotime( '-24 hours' );
				$date_to   = time();
				break;
			case 7:
				$date_from = strtotime( '-7 days' );
				$date_to   = time();
				break;
			case 30:
				$date_from = strtotime( '-30 days' );
				$date_to   = time();
				break;
		}

		if ( ! isset( $date_from ) && ! isset( $date_to ) ) {
			//something wrong
			return;
		}

		$date_from = date( 'Y-m-d', $date_from );
		$date_to   = date( 'Y-m-d', $date_to );

		$logs = WD_Audit_API::get_logs( array(
			'date_from' => $date_from,
			'date_to'   => $date_to,
			//no paging
			'paged'     => - 1
		) );

		$data       = $logs['data'];
		$email_data = array();
		foreach ( $data as $row => $val ) {
			if ( ! isset( $email_data[ $val['event_type'] ] ) ) {
				$email_data[ $val['event_type'] ] = array(
					'count' => 0
				);
			}

			if ( ! isset( $email_data[ $val['event_type'] ][ $val['action_type'] ] ) ) {
				$email_data[ $val['event_type'] ][ $val['action_type'] ] = 1;
			} else {
				$email_data[ $val['event_type'] ][ $val['action_type'] ] += 1;
			}
			$email_data[ $val['event_type'] ]['count'] += 1;
		}

		if ( WD_Utils::get_setting( 'always_notify', 0 ) == 0 && count( $email_data ) == 0 ) {
			//dont send email here
			return;
		}

		uasort( $email_data, array( &$this, 'sort_email_data' ) );
		//now we create a table
		if ( count( $email_data ) ) {
			$table = '<p>' . sprintf( __( "{USER_NAME}, here's a quick summary of your audit events for {SITE_URL}! View the full report <a href=\"%s\">here</a>.", wp_defender()->domain ),
					network_admin_url( 'admin.php?page=wdf-logging' ) ) . '</p>';
			$table .= '<table style="width: 100%;"  border="0" cellpadding="0" cellspacing="0">';
			$table .= '<thead><tr>';
			$table .= '<th style="padding-bottom: 5px;">' . '<span style="width:100%;display:inline-block;border-bottom: solid 1px #EEEEEE;padding-bottom: 10px">' . esc_html__( "Event Type", wp_defender()->domain ) . ' </span></th>';
			$table .= '<th style="padding-bottom: 5px;">' . '<span style="width:100%;display:inline-block;border-bottom: solid 1px #EEEEEE;padding-bottom: 10px">' . esc_html__( "Action Summaries", wp_defender()->domain ) . '</span></th>';
			$table .= '</tr></thead>';
			$table .= '<tbody>';
			foreach ( $email_data as $row => $val ) {
				$table .= '<tr>';
				$table .= '<td valign="top"  style="padding: 5px;vertical-align: top;border-bottom: solid 1px #EEEEEE">' . '<span>' . ucfirst( WD_Audit_API::get_action_text( $row ) ) . '</span>' . '</td>';
				$table .= '<td style="padding: 5px;border-bottom: solid 1px #EEEEEE">';
				foreach ( $val as $k => $v ) {
					if ( $k == 'count' ) {
						continue;
					}
					$table .= '<span style="display: block;padding-bottom: 5px">' . ucwords( WD_Audit_API::get_action_text( $k ) ) . ': ' . $v . '</span>';
				}
				$table .= '</td>';
				$table .= '</tr>';
			}
			$table .= '</tbody>';
			$table .= '</table><br/>';
			$table .= '<p>' . sprintf( __( "View the full report <a href=\"%s\">here</a>.", wp_defender()->domain ),
					network_admin_url( 'admin.php?page=wdf-logging' ) ) . '</p>';
		} else {
			$table = '<p>' . sprintf( esc_html__( "There were no events logged for %s", wp_defender()->domain ), network_site_url() ) . '</p>';
		}

		$template = $this->render( 'email_template', array(
			'message' => $table,
			'subject' => sprintf( esc_html__( "Audit Log Report for %s", wp_defender()->domain ), network_site_url() )
		), false );

		foreach ( $recipients as $user_id ) {
			$user = get_user_by( 'id', $user_id );
			if ( ! is_object( $user ) ) {
				continue;
			}
			//prepare the parameters
			$email = $user->user_email;

			$no_reply_email = "noreply@" . parse_url( get_site_url(), PHP_URL_HOST );
			$headers        = array(
				'From: WP Defender <' . $no_reply_email . '>',
				'Content-Type: text/html; charset=UTF-8'
			);
			$params         = array(
				'USER_NAME' => WD_Utils::get_display_name( $user_id ),
				'SITE_URL'  => network_site_url(),
			);
			foreach ( $params as $key => $val ) {
				$template = str_replace( '{' . $key . '}', $val, $template );
			}
			wp_mail( $email, sprintf( esc_html__( "Audit Log Report for %s", wp_defender()->domain ), network_site_url() ), $template, $headers );
		}
		//reqqueue
		wp_clear_scheduled_hook( 'wd_audit_send_report' );
		wp_schedule_single_event( strtotime( '+' . WD_Utils::get_setting( 'audit_log->report_email_frequent', 7 ) . ' days' ), 'wd_audit_send_report' );
	}

	public function sort_email_data( $a, $b ) {
		return $a['count'] < $b['count'];
	}

	public function toggle_email_report() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_audit_nonce' ), 'wd_audit_email_report' ) ) {
			return;
		}

		$frequency = WD_Utils::http_post( 'frequency', null );
		$next_send = null;
		if ( ! is_null( $frequency ) ) {
			WD_Utils::update_setting( 'audit_log->report_email_frequent', $frequency );
			WD_Utils::update_setting( 'audit_log->report_email', 1 );
			wp_clear_scheduled_hook( 'wd_audit_send_report' );
			$next_send = strtotime( '+' . $frequency . ' days', strtotime( 'today midnight' ) );
			wp_schedule_single_event( $next_send, 'wd_audit_send_report' );
		} elseif ( WD_Utils::get_setting( 'audit_log->report_email' ) == 0 ) {
			//this mean turn on
			WD_Utils::update_setting( 'audit_log->report_email', 1 );
			wp_clear_scheduled_hook( 'wd_audit_send_report' );
			$next_send = strtotime( '+' . WD_Utils::get_setting( 'audit_log->report_email_frequent', 7 ) . ' days', strtotime( 'today midnight' ) );
			wp_schedule_single_event( $next_send, 'wd_audit_send_report' );
		} else {
			WD_Utils::update_setting( 'audit_log->report_email', 0 );
			wp_clear_scheduled_hook( 'wd_audit_send_report' );
		}
		$html = '';
		if ( $next_send != null ) {
			WD_Utils::update_setting( 'audit_log->next_report_time', $next_send );
			$html = $this->get_next_report_time_info( $next_send );
		} else {
			WD_Utils::update_setting( 'audit_log->next_report_time', false );
		}
		wp_send_json( array(
			'status' => 1,
			'html'   => $html
		) );
	}

	public function get_next_report_time_info( $next_send = null ) {
		if ( $next_send == null ) {
			$next_send = WD_Utils::get_setting( 'audit_log->next_report_time', false );
		}

		if ( $next_send === false ) {
			return '';
		}

		$emails = array();
		foreach ( WD_Utils::get_setting( 'recipients', array() ) as $user_id ) {
			$user     = get_user_by( 'id', $user_id );
			$emails[] = $user->user_email;
		}
		$html = sprintf( __( "Audit Logging has been enabled. Expect your next report on <strong>%s</strong> to <strong>%s</strong> %s", wp_defender()->domain ),
			date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $next_send ),
			implode( ', ', $emails ), ' <a href="' . network_admin_url( 'admin.php?page=wdf-settings#email-recipients-frm' ) . '">' . esc_html__( "edit", wp_defender()->domain ) . '</a>' );

		return $html;
	}

	public function submit_events() {
		$data = array();
		if ( isset( wp_defender()->global['events_queue'] ) && ! empty( wp_defender()->global['events_queue'] ) ) {
			$data = wp_defender()->global['events_queue'];
		}

		if ( count( $data ) ) {
			/**
			 * if data is more than one, means various event happened at once, we will need to group each by type
			 * and submit at bulk
			 */
			if ( count( $data ) > 1 ) {
				$groups     = array();
				$socket_log = array();
				foreach ( $data as $k => $val ) {
					if ( ! isset( $groups[ $val['event_type'] ] ) ) {
						$groups[ $val['event_type'] ] = array();
					}
					$groups[ $val['event_type'] ][] = $val;
				}
				//now regroup, and start to submit
				$new_data = array();
				foreach ( $groups as $k => $val ) {
					$tmp = array();
					foreach ( $val as $v ) {
						$tmp[] = $v['msg'];
					}
					$first        = array_shift( $val );
					$first['msg'] = implode( '; ', $tmp );
					$socket_log[] = $first['msg'];
					$new_data[]   = $first;
				}

				$data = $new_data;
			} elseif ( count( $data ) == 1 ) {
				$socket_log[] = $data[0]['msg'];
			}

			if ( WD_Audit_API::submit_to_api_socket( $data ) == false ) {
				//fallback to curl
				WD_Audit_API::submit_to_api( $data );
			}
		}

		unset( wp_defender()->global['events_queue'] );
	}

	public function setup_events() {
		//we only queue for
		if ( defined( 'DOING_CRON' ) && constant( 'DOING_CRON' ) == true ) {
			$events_class = array(
				new WD_Core_Audit()
			);
		} else {
			$events_class = array(
				new WD_Users_Audit(),
				new WD_Media_Audit(),
				new WD_Core_Audit(),
				new WD_Options_Audit(),
				new WD_Comment_Audit(),
				new WD_Post_Audit(),
			);
		}

		//we will build up the dictionary here
		$dictionary  = WD_Audit_API::dictionary();
		$event_types = array();

		foreach ( $events_class as $class ) {
			$hooks      = $class->get_hooks();
			$dictionary = array_merge( $class->dictionary(), $dictionary );
			foreach ( $hooks as $key => $hook ) {
				if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
					include_once wp_defender()->get_plugin_path() . 'app/module/audit-log-module/include/php53_setup_event.php';
				} else {
					include_once wp_defender()->get_plugin_path() . 'app/module/audit-log-module/include/php52_setup_event.php';
				}
				$func = wd_get_callable_event( $key, $hook, $class );
				add_action( $key, $func, 11, count( $hook['args'] ) );
				$event_types[] = $hook['event_type'];
			}
		}
		wp_defender()->global['event_types'] = array_unique( $event_types );
		wp_defender()->global['dictionary']  = $dictionary;
	}

	public function toggle_audit() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_audit_nonce' ), 'wd_toggle_audit_log' ) ) {
			return;
		}

		if ( WD_Utils::get_setting( 'audit_log->enabled', 0 ) == 0 ) {
			WD_Utils::update_setting( 'audit_log->enabled', 1 );
			WD_Utils::flag_for_submitting();
		} else {
			WD_Utils::flag_for_submitting();
			WD_Utils::update_setting( 'audit_log->enabled', 0 );
		}
		wp_send_json( array(
			'status' => 1,
			'state'  => WD_Utils::get_setting( 'audit_log->enabled', 0 )
		) );
	}

	/**
	 * before delete a theme, we placed a cache, and after theme
	 */
	public function cache_theme_transient() {
		set_site_transient( self::CACHE_THEME_TRANSIENT, get_transient( 'update_themes' ) );
	}

	public function admin_menu() {
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';
		add_submenu_page( 'wp-defender', esc_html__( "Audit Logging", wp_defender()->domain ), esc_html__( "Audit Logging", wp_defender()->domain ), $cap, 'wdf-logging', array(
			$this,
			'display_main'
		) );
	}

	public function display_main() {
		if ( WD_Utils::get_dev_api() == false ) {
			$this->render( 'subscribe', array(), true );

			return;
		}

		if ( WD_Utils::get_setting( 'audit_log->enabled', 0 ) == 0 ) {
			$this->_render_activate_screen();
		} else {
			$this->_render_logs_screen();
		}
	}

	private function _render_logs_screen() {
		$this->render( 'logs' );
	}

	private function _render_activate_screen() {
		$this->render( 'activate' );
	}

	/**
	 * Check if in right page, then load assets
	 */
	public function load_scripts() {
		if ( $this->is_in_page() ) {
			WDEV_Plugin_Ui::load( wp_defender()->get_plugin_url() . 'shared-ui/', false );
			wp_enqueue_style( 'wp-defender' );
			$data = array(
				'date_format'              => WD_Utils::convert_date_format_jQuery( WD_Audit_API::get_date_format() ),
				'load_event_text_singular' => esc_html__( "Load %s new event", wp_defender()->domain ),
				'load_event_text_plural'   => esc_html__( "Load %s new events", wp_defender()->domain ),
			);
			if ( WD_Utils::http_get( 'user_id', false ) !== false ) {
				$user_id = WD_Utils::http_get( 'user_id' );
				if ( ! filter_var( $user_id, FILTER_VALIDATE_INT ) ) {
					$user = get_user_by( 'login', $user_id );
				} else {
					$user = get_user_by( 'id', $user_id );
				}
				if ( is_object( $user ) ) {
					$user_label         = sprintf( '<span style="background-image:url(%s)" class="thumb"></span><span class="name title">%s</span>',
						WD_Utils::get_avatar_url( get_avatar( $user->ID ) ), WD_Utils::get_user_name( $user->ID ) );
					$data['user_label'] = $user_label;
				}
			}
			wp_localize_script( 'wp-defender', 'audit_logging', $data );
			wp_enqueue_script( 'wp-defender' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
		}
	}

	/**
	 * check if this page is page of the plugin
	 * @return bool
	 */
	private function is_in_page() {
		$page = WD_Utils::http_get( 'page' );

		return $page == 'wdf-logging';
	}
}