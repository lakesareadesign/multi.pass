<?php

/**
 * Author: Hoang Ngo
 */
class WD_Detect_File_Change extends WD_Component {
	const SITE_MD5 = 'fc_schecksum', LAST_CHECK = 'fc_last_check', CHECK_STATUS = 'fc_status', CHECK_RESULT = 'fc_result',
		CHECKSUM_ALL_FILES = 'fc_all_files';
	const STATUS_PROCESS_WP = 'process_wp', STATUS_COMPLETED = 'completed', STATUS_PROCESS_CONTENT = 'process_content', STATUS_CREATE_CHECKSUM = 'create_checksum';

	/**
	 * contains last checksum, to compare which files are changed
	 * @var array
	 */
	private $last_md5;
	/**
	 * unix timestamp, last check
	 * @var int
	 */
	private $last_check;
	/**
	 * contains all files of whole setup
	 * @var array
	 */
	private $all_files;
	/**
	 * status of checksum
	 * @var string
	 */
	public $status;
	/**
	 * internal use, when to break out the cron
	 * @var bool
	 */
	private $need_break;

	public function __construct() {
		$this->maybe_queue_check();
		$this->add_action( 'wd_check_checksum', 'do_checksum' );
	}

	public function do_checksum() {
		$this->status = WD_Utils::get_cache( self::CHECK_STATUS );

		if ( ! in_array( $this->status, array(
			self::STATUS_PROCESS_CONTENT,
			self::STATUS_PROCESS_WP,
			self::STATUS_CREATE_CHECKSUM
		) )
		) {
			//if status is complted, or status is empty, then we will trigger
			$this->status = self::STATUS_PROCESS_WP;
			WD_Utils::cache( self::CHECK_STATUS, self::STATUS_PROCESS_WP );
		}

		$this->get_wordpress_files();
		if ( $this->need_break ) {
			return;
		}
		$this->get_content_files();
		if ( $this->need_break ) {
			return;
		}
		$this->create_checksum();
	}

	private function create_checksum() {
		if ( $this->status != self::STATUS_CREATE_CHECKSUM ) {
			return;
		}
		$this->load_last_md5();
		$this->all_files = WD_Utils::get_cache( self::CHECKSUM_ALL_FILES, array() );
		$checksum        = array();
		foreach ( $this->all_files as $file ) {
			$checksum[ $file ] = md5_file( $file );
		}
		$results = array(
			'added'    => array(),
			'modified' => array()
		);
		if ( ! empty( $this->last_md5 ) ) {
			//we need to compare
			foreach ( $checksum as $file => $md5 ) {
				if ( ! isset( $this->last_md5[ $file ] ) ) {
					//this is new file
					do_action( 'wd_checksum/new_file', $file );
					$results['added'][] = $file;
				} elseif ( isset( $this->last_md5[ $file ] ) && strcmp( $this->last_md5[ $file ], $checksum[ $file ] ) !== 0 ) {
					do_action( 'wd_checksum_file_modified', $file );
					$results['modified'][] = $file;
				}
			}
		}

		$this->last_md5   = $checksum;
		$this->last_check = time();
		WD_Utils::cache( self::SITE_MD5, $this->last_md5, 31536000 );
		WD_Utils::cache( self::LAST_CHECK, $this->last_check, 31536000 );
		WD_Utils::cache( self::CHECK_STATUS, self::STATUS_COMPLETED, 31536000 );
		WD_Utils::cache( self::CHECK_RESULT, $results, 31536000 );

		//cleanup
		WD_Utils::remove_cache( self::CHECKSUM_ALL_FILES );
	}

	private function get_wordpress_files() {
		if ( $this->status != self::STATUS_PROCESS_WP ) {
			return;
		}
		//files inside wp-admin and wp-includes
		$files        = new WD_Dir_Tree( ABSPATH, true, false, array(
			'dir' => array(
				ABSPATH . 'wp-admin',
				ABSPATH . 'wp-includes'
			)
		) );
		$all_in_files = $files->get_dir_tree();
		//next is file around root
		$files           = new WD_Dir_Tree( ABSPATH, true, false, array(), array(), false );
		$root_files      = $files->get_dir_tree();
		$this->all_files = array_merge( $root_files, $all_in_files );
		//update status
		WD_Utils::cache( self::CHECKSUM_ALL_FILES, $this->all_files );
		WD_Utils::cache( self::CHECK_STATUS, self::STATUS_CREATE_CHECKSUM );

		$this->need_break = true;
	}

	private function get_content_files() {
		if ( $this->status != self::STATUS_PROCESS_CONTENT ) {
			return;
		}

		$this->all_files = WD_Utils::get_cache( self::CHECKSUM_ALL_FILES, array() );

		$content_files = WD_Utils::get_dir_tree( WP_CONTENT_DIR, true, false );
		list( $content_files, $wp_installs ) = WD_Scan_Api::is_nested_wp_install( $content_files );
		//just for debug
		//WD_Utils::cache( self::CACHE_CONTENT_FILES . 'count', count( $content_files ) );
		$this->all_files = array_merge( $this->all_files, $content_files );
		//$this->log( var_export( $this->all_files, true ), self::ERROR_LEVEL_DEBUG, 'asd' );
		$this->all_files = array_unique( $this->all_files );
		WD_Utils::cache( self::CHECKSUM_ALL_FILES, $this->all_files );
		WD_Utils::cache( self::CHECK_STATUS, self::STATUS_CREATE_CHECKSUM );
		$this->need_break = true;

		return $content_files;
	}

	private function load_last_md5() {
		$last_md5 = WD_Utils::get_cache( self::SITE_MD5 );
		if ( $last_md5 == null ) {
			$last_md5 = WD_Utils::get_cache( WD_Scan_Api::CACHE_LAST_MD5 );
		}

		$this->last_md5 = $last_md5;
	}

	private function maybe_queue_check() {
		if ( $this->is_cron_scheduled() ) {
			return;
		}

		$this->last_check = WD_Utils::get_cache( self::LAST_CHECK, null );
		$this->status     = WD_Utils::get_cache( self::CHECK_STATUS );

		$can_queue = false;
		if ( ! is_null( $this->status ) && $this->status != self::STATUS_COMPLETED && $this->is_cron_scheduled() == false ) {
			//is already queue, and running but the cron is out
			$can_queue = true;
		} elseif ( $this->last_check == null ) {
			//check never run
			$can_queue = true;
		} elseif ( $this->status == self::STATUS_COMPLETED ) {
			//we run this each 6 hours
			if ( strtotime( apply_filters( 'wd_file_change_interval', '+6 hours' ), $this->last_check ) < time() ) {
				$can_queue = true;
			}
		}

		if ( $can_queue == false ) {
			return false;
		}

		wp_schedule_single_event( strtotime( 'now' ), 'wd_check_checksum' );
	}

	private function is_cron_scheduled() {
		$crons = _get_cron_array();
		foreach ( (array) $crons as $timestamp => $cron ) {
			if ( isset( $cron['wd_check_checksum'] ) ) {
				return true;
			}
		}

		return false;
	}
}