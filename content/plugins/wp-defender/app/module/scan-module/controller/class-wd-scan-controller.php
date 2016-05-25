<?php

/**
 * @author: Hoang Ngo
 */
class WD_Scan_Controller extends WD_Controller {
	/**
	 * constructor of this controller
	 */
	public function __construct() {
		//define the view template
		$this->template = 'layouts/scan';
		if ( is_multisite() ) {
			$this->add_action( 'network_admin_menu', 'admin_menu', 12 );
		} else {
			$this->add_action( 'admin_menu', 'admin_menu', 12 );
		}
		$this->add_action( 'wp_loaded', 'maybe_schedule_cron' );
		$this->add_action( 'wp_loaded', 'retry_scan' );
		$this->add_action( 'admin_enqueue_scripts', 'load_scripts' );
		$this->add_action( 'wd_scanning_hook', 'process_a_scan' );
		$this->add_action( 'wd_scan_completed', 'remove_history' );
		/**
		 * ajax stuff
		 */
		$this->add_ajax_action( 'wd_query_scan_progress', 'check_status' );
		$this->add_ajax_action( 'wd_start_a_scan', 'start_a_scan' );
		$this->add_ajax_action( 'wd_cancel_scan', 'cancel_scan' );
	}

	/**
	 * Pause/continue a scan
	 */
	public function cancel_scan() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_scan_nonce' ), 'wd_cancel_scan' ) ) {
			return;
		}

		$model = WD_Scan_Api::get_active_scan();

		if ( is_object( $model ) ) {
			//remove cronjob
			wp_clear_scheduled_hook( 'wd_scanning_hook' );
			WD_Scan_Api::clear_cache();
			wp_delete_post( $model->id, true );
			$this->unlock();
		}
		wp_send_json( array(
			'status' => 1,
			'url'    => network_admin_url( 'admin.php?page=wdf-scan' )
		) );
	}

	/**
	 * change status of current scan to ongoing
	 */
	public function retry_scan() {
		if ( @$_SERVER['REQUEST_METHOD'] != 'POST' ) {
			return;
		}

		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_scan_nonce' ), 'wd_retry_scan' ) ) {
			return;
		}

		$model = WD_Scan_Api::get_last_scan();
		if ( is_object( $model ) && $model->status == WD_Scan_Result_Model::STATUS_ERROR ) {
			$model->status  = WD_Scan_Result_Model::STATUS_PROCESSING;
			$model->message = __( "Continuing...", wp_defender()->domain );
			$model->save();
			//force to check again
		}
		$this->unlock();
		$this->maybe_schedule_cron();

		$url = network_admin_url( 'admin.php?page=wdf-scan' );
		wp_redirect( $url );
		exit;
	}

	/**
	 * maybe we can schedule a scan
	 */
	public function maybe_schedule_cron() {
		//queue a scan run
		WD_Scan_Api::update_next_run();

		if ( $this->is_ajax() ) {
			return;
		}

		//we dont queue if we in ajax

		if ( wp_get_schedule( 'wd_scanning_hook' ) !== false ) {
			//already queued, just return
			return;
		}

		$maybe_process = false;
		//check the cache
		if ( get_option( 'wd_scan_processing' ) ) {
			//we already having a scanning, just move on
			$maybe_process = true;
		} else {
			//we don't have any scan, just check the cache for improve performance
			$last_check = WD_Utils::get_setting( 'cache->last_check_scan_cron' );
			if ( WD_STRESS_SCAN === true ) {
				//fire immediatly
				$last_check = false;
			}

			if ( $last_check == false || strtotime( '+5 minutes', $last_check ) < time() ) {
				$maybe_process = true;
				WD_Utils::update_setting( 'cache->last_check_scan_cron', time() );
			}
		}

		if ( $maybe_process ) {
			$model = WD_Scan_Api::get_active_scan();
			if ( is_object( $model ) ) {
				$last_modified = $model->get_raw_post()->post_modified;

				if ( strtotime( '+1 minutes', strtotime( $last_modified ) ) > current_time( 'timestamp' ) ) {
					//no queue
					return;
				}
			}
			if ( wp_get_schedule( 'wd_scanning_hook' ) == false && is_object( $model ) ) {
				if ( is_object( $model ) && in_array( $model->status, array(
						WD_Scan_Result_Model::STATUS_ERROR,
						WD_Scan_Result_Model::STATUS_PAUSE
					) )
				) {
					//don't queue if it is error or pause
					return;
				}
				//currently having a on progress scan, but the cron expired. register one
				wp_schedule_single_event( strtotime( '+2 minutes' ), 'wd_scanning_hook' );
			} elseif (
				wp_get_schedule( 'wd_scanning_hook' ) == false &&
				WD_Utils::get_setting( 'scan->auto_scan' ) == 1 &&
				( $this->is_on_time() || WD_STRESS_SCAN === true )
			) {
				if ( WD_Scan_Api::create_scan_record() ) {
					wp_schedule_single_event( strtotime( '+2 minutes' ), 'wd_scanning_hook' );
				}
			}
		}
	}

	/**
	 * Determine if we can enqueue a scan
	 *
	 * @param null $current
	 * @param null $last_run
	 *
	 * @return bool|mixed|void
	 */
	public function is_on_time( $current = null, $last_run = null ) {
		$next_run = WD_Utils::get_setting( 'scan->next_runtime', false );
		if ( $next_run == false ) {
			return false;
		}

		if ( is_null( $current ) ) {
			$current = current_time( 'timestamp' );
		}

		if ( $next_run <= $current ) {
			return true;
		}

		return false;
	}

	/**
	 * an ajax to query scanming progress
	 */
	public function check_status() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_scan_nonce' ), 'query_scan_progress' ) ) {
			return;
		}

		ob_start();
		//clear cache
		//if we has any cron, remove it immediatly
		wp_clear_scheduled_hook( 'wd_scanning_hook' );
		//processing a scan here
		$this->process_a_scan();
		//the rest should act normal

		$model = WD_Scan_Api::get_active_scan( true );
		if ( ! is_object( $model ) ) {
			$model = WD_Scan_Api::get_last_scan();
		} else {
			$model->save();
		}
		ob_clean();

		//trigger
		//$progress = get_site_transient( WD_Scan_Api::CACHE_SCAN_PERCENT ) == false ? 0 : get_site_transient( WD_Scan_Api::CACHE_SCAN_PERCENT );
		$progress = $model->get_percent();
		$alert    = WD_Utils::get_cache( WD_Scan_Api::ALERT_NESTED_WP, false );
		/*if ( $alert ) {
			$alert = implode( '<br/>', $alert );
		} else {
			$alert = 0;
		}*/
		$md5_alert = WD_Utils::get_cache( WD_Scan_Api::ALERT_NO_MD5, false );
		wp_send_json( array(
			'progress'  => $progress,
			'message'   => $model->message,
			'complete'  => $model->status == WD_Scan_Result_Model::STATUS_COMPLETE,
			'error'     => $model->status == WD_Scan_Result_Model::STATUS_ERROR,
			'scanned'   => $this->scanned_to_html( true ),
			'alert'     => $alert,
			'md5_alert' => $md5_alert,
			'abs_path'  => ABSPATH,
			'url'       => network_admin_url( 'admin.php?page=wdf-scan' )
		) );
	}

	/**
	 * @return string
	 */
	public function scanned_to_html( $raw = false ) {
		$core_scanned       = WD_Utils::get_cache( WD_Core_Integrity_Scan::FILE_SCANNED );
		$suspicious_scanned = WD_Utils::get_cache( WD_Suspicious_Scan::FILE_SCANNED );

		if ( ! is_array( $core_scanned ) ) {
			$core_scanned = array();
		}

		if ( ! is_array( $suspicious_scanned ) ) {
			$suspicious_scanned = array();
		}
		$cached = array_merge( $core_scanned, $suspicious_scanned );


		if ( $raw == true ) {
			return $cached;
		}

		return implode( '<br/>', $cached );
	}

	public function process_a_scan() {
		set_time_limit( - 1 );
		//open a memory stream
		$this->open_mem_stream();

		$model = WD_Scan_Api::get_active_scan();

		if ( ! is_object( $model ) ) {
			return false;
		}

		$last_scan = WD_Scan_Api::get_last_scan();
		if ( $this->is_lock() == false ) {
			$this->maybe_lock();
		} else {
			//sometime, the server get halt, and the lock never unlock, we need to check the last time
			//a scan happen to determine if we need to force unlock
			$last_updated = $model->get_raw_post()->post_modified;
			//if the last time is about 20 mins, ignore the lock
			if ( strtotime( '+20 minutes', strtotime( $last_updated ) ) < current_time( 'timestamp' ) ) {
				$this->log( 'lock take so long, ignore', self::ERROR_LEVEL_DEBUG, 'lock' );
			} else {
				return false;
			}
		}

		$scans = array(
			'WD_Vulndb_Scan',
			'WD_Core_Integrity_Scan',
			'WD_Suspicious_Scan',
		);

		if ( empty( $scans ) ) {
			return false;
		}

		/**
		 * cache the scan instance
		 */
		$scans_index = array();

		$total_files = array();

		foreach ( $scans as $key => $class ) {
			$scan            = new $class;
			$scan->model     = $model;
			$scan->last_scan = $last_scan;

			if ( $scan->is_enabled() == false ) {
				unset( $scans[ $key ] );
				continue;
			}

			if ( $scan->init() === false ) {
				//if the init is return false, means something hasn't completed
				return;
			}

			if ( is_array( $scan->total_files ) ) {
				$total_files = array_merge( $total_files, $scan->total_files );
			}

			$scans_index[ $class ] = $scan;
		}

		if ( $model->status == WD_Scan_Result_Model::STATUS_INIT && get_option( 'wd_scan_processing' ) != $model->id ) {
			$model->status = WD_Scan_Result_Model::STATUS_PROCESSING;
			update_option( 'wd_scan_processing', $model->id );
			$model->execute_time = array(
				'start' => current_time( 'timestamp' )
			);
			//total files
			$model->total_files = count( $total_files );
			$model->save();
		}

		$is_done = true;

		/**
		 * Starting scan
		 */
		foreach ( $scans_index as $key => $scan ) {
			//we have to refresh model
			$model           = WD_Scan_Api::get_active_scan();
			$scan->model     = $model;
			$scan->last_scan = $last_scan;
			if ( $scan->check() == false ) {
				//this mean the scan is havent finished yet
				$is_done = false;
				$scan->process();
				//refresh model
				$model = WD_Scan_Api::get_active_scan();
			}

			//recheck again, in case after process
			if ( $scan->check() == false ) {
				//echo 'Processing ' . $key . PHP_EOL;
				//the current step hasn't done yet, break
				break;
			}
		}

		if ( $is_done ) {
			//cleanup
			foreach ( $scans_index as $key => $scan ) {
				$scan->clean_up();
			}
			//done now
			$model->status                  = WD_Scan_Result_Model::STATUS_COMPLETE;
			$model->execute_time['end']     = current_time( 'timestamp' );
			$model->execute_time['end_utc'] = time();
			$model->save();
			delete_option( 'wd_scan_processing' );
			//move tmp md5 to normal
			WD_Utils::cache( WD_Scan_Api::CACHE_LAST_MD5, WD_Utils::get_cache( WD_Scan_Api::CACHE_TMP_MD5 ), 0 );
			WD_Utils::remove_cache( WD_Scan_Api::CACHE_TMP_MD5 );
			//unlock
			$this->unlock();
			//flag it
			WD_Utils::flag_for_submitting();
			WD_Scan_Api::update_next_run( true );
			do_action( 'wd_scan_completed', $model );
		}

		$this->dump_log_from_mem();
		//release lock
		$this->unlock();
		$this->maybe_schedule_cron();
	}

	/**
	 * use ajax to create a scan record
	 */
	public function start_a_scan() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_scan_nonce' ), 'wd_start_a_scan' ) ) {
			return;
		}
		WD_Scan_Api::clear_cache();
		$scan = WD_Scan_Api::create_scan_record();

		if ( ! is_wp_error( $scan ) ) {
			//setup a cronjob
			//wp_schedule_single_event( time(), 'wd_scanning_hook' );
			wp_send_json( array(
				'status'       => 1,
				'redirect_url' => network_admin_url( 'admin.php?page=wdf-scan' )
			) );
		} else {
			wp_send_json( array(
				'status' => 0,
				'error'  => $scan->get_error_message()
			) );
		}
	}

	/**
	 * Lock the scanning process
	 */
	protected function maybe_lock( $model = null ) {
		if ( is_null( $model ) ) {
			$model = WD_Scan_Api::get_active_scan();
		}
		if ( ! is_object( $model ) ) {
			//nos can here, just return
			$this->unlock();

			return;
		}

		if ( strlen( trim( $model->current_action ) ) == 0 ) {
			//model has'nt settle, just return,and unlock if some lock here
			$this->unlock();

			return;
		}
		//now lock
		update_site_option( 'wd_scan_lock', 1 );
	}

	protected function unlock() {
		delete_site_option( 'wd_scan_lock' );
	}

	protected function is_lock() {
		return get_site_option( 'wd_scan_lock', false ) == 1;
	}

	/**
	 * Only keep one record at time
	 *
	 * @param $model
	 */
	public function remove_history( $model ) {
		$models = WD_Scan_Result_Model::model()->find_all( array(), false, 1, array(
			'post__not_in' => array( $model->id )
		) );

		if ( is_array( $models ) && count( $models ) ) {
			foreach ( $models as $item ) {
				wp_delete_post( $item->id, true );
			}
		}

		if ( WD_STRESS_SCAN == true ) {
			$count = WD_Utils::get_cache( 'wd_scan_count' );
			if ( $count == false ) {
				$count = 0;
			}
			$count = $count + 1;
			WD_Utils::cache( 'wd_scan_count', $count );
		}
	}

	/**
	 * check if this page is page of the plugin
	 * @return bool
	 */
	private function is_in_page() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && in_array( $screen->id, array(
				'defender_page_wdf-scan',
				'defender_page_wdf-scan-network'
			) )
		) {
			return true;
		}

		return false;
	}

	/**
	 * Check if in right page, then load assets
	 */
	public function load_scripts() {
		if ( $this->is_in_page() ) {
			wp_localize_script( 'wp-defender', 'wd_scanning', array(
				'show_log'                  => __( "Show Log", wp_defender()->domain ),
				'hide_log'                  => __( "Hide Log", wp_defender()->domain ),
				'ignore_confirm_msg'        => __( "Just a reminder, by ignoring this file Defender will leave it alone and won't warn you about it again unless it changes. You can add it back to the issues list any time.", wp_defender()->domain ),
				'delete_confirm_msg'        => __( "Deleting this file will remove it from your WordPress installation. Make sure you have a backup of your website before continuing, doing this could break your website.", wp_defender()->domain ),
				'delete_plugin_confirm_msg' => __( "Deleting this plugin will remove it from your WordPress installation. Make sure you have a backup of your website before continuing.", wp_defender()->domain ),
				'delete_theme_confirm_msg'  => __( "Deleting this theme will remove it from your WordPress installation. Make sure you have a backup of your website before continuing.", wp_defender()->domain ),
				'cancel_confirm_btn'        => __( "Cancel", wp_defender()->domain ),
				'delete_confirm_btn'        => __( "Delete", wp_defender()->domain ),
				'ignore_confirm_btn'        => __( "Ignore", wp_defender()->domain ),
			) );
			WDEV_Plugin_Ui::load( wp_defender()->get_plugin_url() . 'shared-ui/', false );
			wp_enqueue_style( 'wp-defender' );
			wp_enqueue_script( 'wp-defender' );
			wp_enqueue_script( 'wd-confirm' );
			wp_enqueue_script( 'jquery-effects-highlight' );

		}
	}

	/**
	 * Register admin menu
	 */
	public function admin_menu() {
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';
		add_submenu_page( 'wp-defender', __( "Scan", wp_defender()->domain ), __( "Scan", wp_defender()->domain ), $cap, 'wdf-scan', array(
			$this,
			'display_main'
		) );
	}

	/**
	 * Display the html content
	 */
	public function display_main() {
		if ( WD_Utils::http_get( 'wdf-action', null ) == 'new_scan' ) {
			WD_Scan_Api::create_scan_record();
		}

		$scans = WD_Scan_Result_Model::model()->find_all( array(), 2, 1, array(
			'order'   => 'DESC',
			'orderby' => 'ID'
		) );
		if ( count( $scans ) == 0 ) {
			//haven't scan anything, show the no scan
			$this->render( 'scan/_no_scan', array(), true );
		} else {
			$model = WD_Scan_Api::get_active_scan();
			if ( is_object( $model ) ) {
				$args['model'] = $model;
				//scanning
				$this->render( 'scan/_scanning', $args, true );
			} else {
				//load recents scan
				$model               = WD_Scan_Api::get_last_scan();
				$args['model']       = $model;
				$args['res']         = $model->get_results();
				$args['ignore_list'] = $model->get_ignore_list();
				if ( $model->status == WD_Scan_Result_Model::STATUS_ERROR ) {
					$this->template = false;
					$this->render( 'scan/_scan_error', $args, true );
				} else {
					$this->render( 'scan/_scan_report', $args, true );
				}
			}
		}
	}
}