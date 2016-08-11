<?php

/**
 * @author: Hoang Ngo
 */
class WD_Core_Integrity_Scan extends WD_Scan_Abstract {
	const CACHE_INDEX = 'wd_core_scan_index', CACHE_MD5 = 'wd_core_cache_md5', FILE_SCANNED = 'wd_core_file_scanned';
	public $name = '';

	//public $chunk_size = 200;

	public function init() {
		$this->name = __( "core integrity scan", wp_defender()->domain );

		$this->percentable        = true;
		$this->dashboard_required = false;
		$this->total_files        = WD_Scan_Api::get_core_files();
		$this->file_scanned       = WD_Utils::get_cache( self::FILE_SCANNED, array() );
		if ( ! is_array( $this->file_scanned ) ) {
			$this->file_scanned = array();
		}
	}

	public function process() {
		if ( ! $this->maybe_run_this_scan( $this->model ) ) {
			return false;
		}

		if ( count( $this->file_scanned ) == 0 ) {
			$this->model->message = __( "Analyzing WordPress core files…", wp_defender()->domain );
			$this->model->save();
		}

		$files_need_scan = array_diff( $this->total_files, $this->file_scanned );

		/**
		 * check md5 cache from prev scan
		 */
		if ( ( $tmp = WD_Utils::get_cache( WD_Scan_Api::CACHE_LAST_MD5, false ) ) !== false ) {
			$last_checksum = $tmp;
		} elseif ( is_object( $this->last_scan ) ) {
			$last_checksum = $this->last_scan->md5_tree;
		} else {
			$last_checksum = null;
		}

		if ( $this->is_ajax() ) {
			/**
			 * ajax case we will break chunk down
			 */
			$chunks          = array_chunk( $files_need_scan, 200 );
			$files_need_scan = array_shift( $chunks );
		}
		$cpu_count    = 0;
		$tmp_checksum = WD_Utils::get_cache( WD_Scan_Api::CACHE_TMP_MD5, array() );
		foreach ( $files_need_scan as $file ) {
			if ( $this->cpu_reach_threshold() ) {
				if ( $this->is_ajax() ) {
					sleep( 3 );
					if ( $cpu_count > 55 ) {
						$this->model->status  = WD_Scan_Result_Model::STATUS_ERROR;
						$this->model->message = __( "Your server resource usage is too close to your limit. Please try again in 15 minutes.", wp_defender()->domain );
						$this->model->save();

						return;
					}
					$cpu_count += 1;
				} else {
					//this case is in cronjob, the time for next cron is 3-5min, which is enough
					break;
				}
			}
			$checksum = md5_file( $file );
			//$this->model->md5_tree[ $file ] = $checksum;
			$tmp_checksum[ $file ] = $checksum;
			if ( is_object( $this->last_scan ) && is_array( $last_checksum ) && isset( $last_checksum[ $file ] ) && strcmp( $checksum, $last_checksum[ $file ] ) === 0 ) {
				/**
				 * this file content doesn't change from previous scan, so we just get the last scan result of this item
				 */
				$result = $this->last_scan->find_result_item_by_file( $file, 'WD_Scan_Result_Core_Item_Model' );
				if ( is_object( $result ) ) {
					//this file is an issue from the last, it still be
					$this->model->item_indexes[ $result->id ] = $file;
					$this->model->add_item( $result );
				}
				//if it is not, we don't do anythng
			} else {
				$result = $this->scan_a_file( $file, $checksum );
				if ( is_wp_error( $result ) ) {
					/**
					 * case error, we halt this scan
					 */
					$this->model->status  = WD_Scan_Result_Model::STATUS_ERROR;
					$this->model->message = $result->get_error_message();
					$this->model->save();

					return false;
				} elseif ( $result instanceof WD_Scan_Result_Core_Item_Model ) {
					/**
					 * issue found, we saving
					 */
					$this->model->item_indexes[ $result->id ] = $file;
					$this->model->add_item( $result );
					$this->model->result_core_integrity[] = $file;
				} elseif ( $result === - 1 ) {
					//this mean no signatures
					WD_Utils::cache( WD_Scan_Api::ALERT_NO_MD5, __( "There are no available checksums for your WordPress version, the scan will skip the core integrity check.", wp_defender()->domain ) );
					$this->model->current_index = count( $this->total_files );
					WD_Utils::cache( self::FILE_SCANNED, $this->total_files );
					$this->model->save();

					return true;
				}
			}
			/**
			 * now we have to check, if the file is ignored
			 */
			if ( is_object( $this->last_scan ) ) {
				$is_ignored = $this->last_scan->is_file_ignored( $file, 'WD_Scan_Result_Core_Item_Model' );
				//if it is ingnored, we add it to the list
				if ( $is_ignored && $result instanceof WD_Scan_Result_Core_Item_Model ) {
					$this->model->ignore_files[] = $result->id;
				}
			}


			//cache scanned file
			$this->file_scanned[] = $file;
			//we need this for calculate percent
			$this->model->current_index += 1;
		}
		/**
		 * at the end of this loop, we need to calculate
		 * 2. store files scanned
		 * 3. store md5 tree
		 * 4. store result
		 */
		$this->model->save();
		$this->file_scanned = array_unique( $this->file_scanned );
		WD_Utils::cache( self::FILE_SCANNED, $this->file_scanned );
		WD_Utils::cache( WD_Scan_Api::CACHE_TMP_MD5, $tmp_checksum );
	}

	/**
	 * @param $file
	 * @param bool|false $checksum
	 *
	 * @return bool|WD_Scan_Result_Core_Item_Model
	 */
	private function scan_a_file( $file, $checksum = false ) {
		//we need to download md5 from wp
		if ( ( $md5_files = WD_Utils::get_cache( self::CACHE_MD5, false ) ) == false ) {
			$md5_files = WD_Scan_Api::download_md5_files();
			$md5_files = array_filter( $md5_files );
			if ( is_wp_error( $md5_files ) ) {
				return $md5_files;
			}

			if ( empty( $md5_files ) ) {
				//this mean no signatures return,we will skip
				return - 1;
			}
			WD_Utils::cache( self::CACHE_MD5, $md5_files );
		}
		if ( DIRECTORY_SEPARATOR == '\\' ) {
			$abs_path = rtrim( ABSPATH, '/' );
			$abs_path = $abs_path . '\\';
		} else {
			$abs_path = ABSPATH;
		}
		$relative_path = str_replace( $abs_path, '', $file );
		if ( DIRECTORY_SEPARATOR == '\\' ) {
			$relative_path = str_replace( '\\', '/', $relative_path );
		}
		$detail = false;
		if ( isset( $md5_files[ $relative_path ] ) ) {
			$ochecksum = $md5_files[ $relative_path ];
			if ( $checksum == false ) {
				$checksum = md5_file( $file );
			}
			if ( strcmp( $checksum, $ochecksum ) !== 0 ) {
				//not good
				$detail = array(
					'file'     => $file,
					'is_added' => false,
					'detail'   => sprintf( __( "File size %s, modified at %s", wp_defender()->domain ), $this->convert_size( filesize( $file ) ), date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), filemtime( $file ) ) ),
					'md5'      => $checksum,
					'md5_org'  => $ochecksum
				);
			}
		} else {
			//new files added
			$excludes = array( '.htaccess', 'wp-config.php' );
			if ( in_array( $relative_path, $excludes ) ) {
				//by pass this for now, but this sill need indexing
			} else {
				$detail = array(
					'file'     => $file,
					'is_added' => true,
					'detail'   => sprintf( __( "File size %s, added at %s", wp_defender()->domain ), $this->convert_size( filesize( $file ) ), date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), filemtime( $file ) ) ),
				);
			}
		}
		if ( is_array( $detail ) && count( $detail ) ) {
			$item         = new WD_Scan_Result_Core_Item_Model();
			$item->id     = uniqid();
			$item->name   = $file;
			$item->detail = $detail;

			return $item;
		}

		return true;
	}

	public function check() {
		$files_need_scan = array_diff( $this->total_files, $this->file_scanned );
		if ( count( $files_need_scan ) == 0 ) {
			return true;
		}

		return false;
	}

	public function clean_up() {
		WD_Utils::remove_cache( self::CACHE_MD5 );
		WD_Utils::remove_cache( self::FILE_SCANNED );
	}

	public function is_enabled() {
		if ( WD_Utils::get_setting( 'use_' . WD_Scan_Api::SCAN_CORE_INTEGRITY . '_scan' ) != 1 ) {
			return false;
		}

		if ( $this->dashboard_required && WD_Utils::get_dev_api() == false ) {
			return false;
		}

		return true;
	}
}