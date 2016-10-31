<?php

/**
 * @author: Hoang Ngo
 */
class WD_Scan_Result_Model extends WD_Post_Model {
	//constant for scan status
	const STATUS_COMPLETE = 'complete', STATUS_PROCESSING = 'on_going', STATUS_ERROR = 'error', STATUS_PAUSE = 'pause', STATUS_INIT = 'init';
	//scan stage
	const ACTION_INIT = 'init', ACTION_VULNDB = 'vulndb', ACTION_CORE_FILES = 'core_files', ACTION_CONTENT_FILES = 'content_files';
	//result line type, mostly use for display
	const TYPE_CORE = 'core', TYPE_FILE = 'file', TYPE_PLUGIN = 'plugin', TYPE_THEME = 'theme';

	public $table = 'wdscan_result';

	/**
	 * Scan ID
	 *
	 * @var int
	 * @access protected
	 * @since 1.0
	 */
	protected $id;

	/**
	 * @var
	 */
	protected $title;

	/**
	 * Clean file will be stored here, and we will use this to check integrity
	 *
	 * @var array
	 * @access protected
	 * @since 1.0
	 */
	protected $md5_tree = array();

	/**
	 * Scan status
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $status;

	/**
	 * Internal use, only for system
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $current_action;
	/**
	 * Storing the result of WP core files integrity check, for cached
	 *
	 * @var array
	 * @access protected
	 * @since 1.0
	 */
	protected $result_core_integrity = array();
	/**
	 * Count files on the system
	 *
	 * @var int
	 * @access protected
	 * @since 1.0
	 */
	protected $total_files;

	/**
	 * The status message to display on front
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $message;

	/**
	 * Extra information during the scan
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $log;

	/**
	 * Internal use only, indexing the scanning, so we can stop/resume
	 *
	 * @var int
	 * @access protected
	 * @since 1.0
	 */

	protected $current_index;
	/**
	 * Internal use only, ETA for the scan
	 *
	 * @var float
	 * @access protected
	 * @since 1.0
	 */
	public $execute_time;

	/**
	 * Storing files after fix
	 *
	 * @var array
	 * @access protected
	 * @since 1.0
	 */
	protected $fixed = array();

	/**
	 * An array of @see WD_Scan_Result_Item_Model
	 * @var array
	 * @access protected
	 * @since 1.0
	 */
	protected $result = array();

	/**
	 * storing ids of issue
	 * @var array
	 * @since 1.0.4
	 */
	protected $item_indexes = array();

	/**
	 * @var array
	 */
	protected $ignore_files = array();

	/**
	 * Internal use only, storing mapping information from model properties to WP Post properties
	 *
	 * @var array
	 * @access protected
	 * @since 1.0
	 */
	protected $relations = array(
		array(
			'type' => 'native',
			'prop' => 'id',
			'wp'   => 'ID'
		),
		array(
			'type' => 'native',
			'prop' => 'title',
			'wp'   => 'post_title'
		),
		array(
			'type' => 'native',
			'prop' => 'log',
			'wp'   => 'post_content'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'status',
			'wp'   => 'status'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'current_action',
			'wp'   => 'current_action'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'total_files',
			'wp'   => 'total_files'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'message',
			'wp'   => 'message'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'current_index',
			'wp'   => 'current_index'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'md5_tree',
			'wp'   => 'md5_tree'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'execute_time',
			'wp'   => 'execute_time'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'result_core_integrity',
			'wp'   => 'result_core_integrity'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'ignore_files',
			'wp'   => 'ignore_files'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'fixed',
			'wp'   => 'fixed'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'result',
			'wp'   => 'result'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'result',
			'wp'   => 'result'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'item_indexes',
			'wp'   => 'item_indexes'
		)
	);

	/**
	 * Internal use, jsut to store the progress only
	 * @var bool
	 */
	protected $save_progress_only = false;

	/**
	 * Init parameter before insert
	 */
	protected function before_insert() {
		//this is new, update the status
		$this->status         = self::STATUS_INIT;
		$this->current_action = '';
		$this->log            = '<!-- result will show -->';
		$this->title          = date_i18n( WD_Utils::get_date_time_format() );
		$this->message        = '<i class="wdv-icon wdv-icon-fw wdv-icon-refresh spin"></i>' . esc_html__( "Initializing...", wp_defender()->domain );
	}

	/**
	 * prepare values before update
	 */
	protected function before_update() {
		if ( $this->status == self::STATUS_ERROR ) {
			$this->dump_log_from_mem();
		}
	}

	/**
	 * prepare values after model loaded from DB
	 */
	protected function after_load() {
		$properties = array_keys( $this->export() );
		foreach ( $properties as $prop ) {
			$this->$prop = maybe_unserialize( $this->$prop );
			if ( $prop == 'result' && ! is_array( $this->$prop ) ) {
				$this->$prop = array();
			}
			/*if ( is_array( $data = json_decode( $this->$prop, true ) ) ) {
				//$this->$prop = $data;
			}*/
		}
	}

	/**
	 * Return scan results
	 *
	 * @return array
	 * @access public
	 * @since 1.0
	 */
	public function get_results( $score = 17 ) {
		//cache result in each request
		if ( isset( wp_defender()->global['results'] ) && ! empty( wp_defender()->global['result'] ) ) {
			return wp_defender()->global['results'];
		}
		if ( ! empty( $this->item_indexes ) ) {
			$this->result = array();
			$this->get_results_104();
		}

		$result = $this->result;
		$md5    = WD_Utils::get_cache( 'wd_md5_checksum', false );
		if ( $md5 == false ) {
			$md5 = WD_Scan_Api::download_md5_files();
			//short cache, as user might update the version anytime
			WD_Utils::cache( 'wd_md5_checksum', $md5, 3600 );
		}
		foreach ( $result as $key => $item ) {
			if ( $item->check( $this ) == true ) {
				unset( $result[ $key ] );
				continue;
			}

			if ( in_array( $item->id, (array) $this->ignore_files ) ) {
				unset( $result[ $key ] );
				continue;
			}

			$detect_core = apply_filters( 'wd_scan_detect_score', $score );
			if ( $item instanceof WD_Scan_Result_File_Item_Model && $item->score < $detect_core ) {
				unset( $result[ $key ] );
			}
			//temp remove unconfirm issue
			if ( $item instanceof WD_Scan_Result_VulnDB_Item_Model && $item->confirmed == false ) {
				unset( $result[ $key ] );
			}
			//sometime, the scan will scan the add/modified file of core and find suspicious, thjis display
			//duplicate, we will hide the suspicios
			if ( $item instanceof WD_Scan_Result_File_Item_Model && in_array( $item->name, $this->result_core_integrity ) ) {
				unset( $result[ $key ] );
			}
		}

		usort( $result, array( &$this, 'sort_priority' ) );

		wp_defender()->global['results'] = $result;

		return $result;
	}

	public function get_results_104() {
		$metas = get_post_meta( $this->id );
		foreach ( $this->item_indexes as $key => $index ) {
			if ( isset( $metas[ 'item_' . $key ] ) ) {
				$raw = array_shift( $metas[ 'item_' . $key ] );
				$raw = maybe_unserialize( $raw );
				if ( is_object( $raw ) ) {
					$this->result[] = $raw;
				}
			}
		}
	}

	/**
	 * @return array
	 */
	public function get_results_raw() {
		$data     = $this->get_results();
		$raw_data = array();
		foreach ( $data as $item ) {
			$raw_data[] = $item->get_raw_data();
		}

		return $raw_data;
	}

	/**
	 * @param $a
	 * @param $b
	 *
	 * @return mixed
	 */
	public function sort_priority( $a, $b ) {
		$priorites = array(
			WD_Scan_Result_Model::TYPE_CORE   => 1,
			WD_Scan_Result_Model::TYPE_PLUGIN => 2,
			WD_Scan_Result_Model::TYPE_THEME  => 3,
			WD_Scan_Result_Model::TYPE_FILE   => 4
		);
		if ( $a->get_system_type() == $b->get_system_type() && $a->get_system_type() == WD_Scan_Result_Model::TYPE_FILE ) {
			return $a->score - $b->score;
		} else {
			return $priorites[ $a->get_system_type() ] - $priorites[ $b->get_system_type() ];
		}
	}

	/**
	 * @param $type
	 *
	 * @return null
	 */
	public static function get_system_type_label( $type ) {
		$labels = array(
			self::TYPE_CORE   => esc_html__( "WordPress Core", wp_defender()->domain ),
			self::TYPE_FILE   => esc_html__( "Other", wp_defender()->domain ),
			self::TYPE_PLUGIN => esc_html__( "Plugin", wp_defender()->domain ),
			self::TYPE_THEME  => esc_html__( "Theme", wp_defender()->domain )
		);

		return isset( $labels[ $type ] ) ? $labels[ $type ] : null;
	}

	public function get_result_by_type( $type, $score = 19 ) {
		;
		$result = array();
		foreach ( $this->get_results( $score ) as $key => $item ) {
			if ( $item->get_system_type() == $type ) {
				$result[] = $item;
			}
		}

		return $result;
	}

	/**
	 * @param $id
	 */
	public function delete_item_from_result( $id ) {
		if ( ! empty( $this->item_indexes ) ) {
			if ( isset( $this->item_indexes[ $id ] ) ) {
				unset( $this->md5_tree[ $this->item_indexes[ $id ] ] );
				delete_post_meta( $this->id, 'item_' . $id );
				//todo fix this bottle neck
				//update_post_meta( $this->id, 'md5_tree', $this->md5_tree );
			}
		} else {
			$index = $this->find_result_item( $id, true );
			$item  = $this->find_result_item( $id );
			unset( $this->md5_tree[ $item->name ] );
			unset( $this->result[ $index ] );
			//unset from md5 tree too
			update_post_meta( $this->id, 'md5_tree', $this->md5_tree );
			update_post_meta( $this->id, 'result', $this->result );
		}
		WD_Utils::flag_for_submitting();
	}

	/**
	 * @return array
	 */
	public function get_ignore_list() {
		$res = array();
		foreach ( (array) $this->ignore_files as $id ) {
			$item = $this->find_result_item( $id );
			if ( is_object( $item ) ) {
				$res[] = $item;
			}
		}

		return $res;
	}

	/**
	 * @param $id
	 * @param bool|false $return_index
	 *
	 * @return int|null|string
	 */
	public function find_result_item( $id, $return_index = false ) {
		if ( ! empty( $this->item_indexes ) ) {
			$model = get_post_meta( $this->id, 'item_' . $id, true );
			if ( ! is_object( $model ) ) {
				$model = maybe_unserialize( $model );
			}

			if ( is_object( $model ) ) {
				return $model;
			} else {
				//model got issue
				return null;
			}
		} else {
			foreach ( $this->result as $key => $item ) {
				if ( $item->id == $id ) {
					if ( $return_index ) {
						return $key;
					} else {
						return $item;
					}
				}
			}

			return null;
		}
	}

	/**
	 * @param $file
	 * @param $scan_type
	 *
	 * @return null
	 */
	public function find_result_item_by_file( $file, $scan_type ) {
		if ( ! empty( $this->item_indexes ) ) {
			$count_value = array_count_values( $this->item_indexes );
			if ( isset( $count_value[ $file ] ) && $count_value[ $file ] > 1 ) {
				//multiple, need to check scan type
				foreach ( $this->item_indexes as $key => $val ) {
					if ( $file == $val ) {
						$m = get_post_meta( $this->id, 'item_' . $key, true );
						if ( ! is_object( $m ) ) {
							$m = maybe_unserialize( $m );
						}
						if ( is_object( $m ) && get_class( $m ) == $scan_type ) {
							return $m;
						} else {
							return null;
						}
					}
				}
			} elseif ( ( $id = array_search( $file, $this->item_indexes ) ) !== false ) {
				$model = get_post_meta( $this->id, 'item_' . $id, true );
				if ( ! is_object( $model ) ) {
					$model = maybe_unserialize( $model );
				}

				if ( is_object( $model ) ) {
					return $model;
				} else {
					//model got issue
					return null;
				}
			}
		} else {
			foreach ( $this->result as $key => $item ) {
				if ( $item->name == $file && get_class( $item ) == $scan_type ) {
					return $item;
				}
			}
		}

		return null;
	}

	/**
	 * Compare an Result_Item_Model class to ignore list
	 *
	 * @param $item
	 *
	 * @return bool
	 */
	public function is_issue_ignored( $item ) {
		$ignore_list = $this->get_ignore_list();
		foreach ( $ignore_list as $ignore ) {
			if ( $ignore->get_name() == $item->get_name() && get_class( $ignore ) == get_class( $item ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 *  Check if a file has ignored
	 *
	 * @param $file
	 * @param $scan_type
	 *
	 * @return bool
	 */
	public function is_file_ignored( $file, $scan_type ) {
		$ignore_list = $this->get_ignore_list();
		foreach ( $ignore_list as $ignore ) {
			if ( $ignore->name == $file && get_class( $ignore ) == $scan_type ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param $asb_path
	 *
	 * @return array
	 */
	public function group_result_by_file( $asb_path ) {
		$groups = array();
		if ( ! empty( $this->item_indexes ) ) {
			$tmp = $this->item_indexes;
			while ( ( $id = array_search( $asb_path, $tmp ) ) !== false ) {
				$item = $this->find_result_item( $id );
				if ( is_object( $item ) ) {
					$groups[] = $item;
				}
				unset( $tmp[ $id ] );
			}
		} else {
			foreach ( $this->result as $key => $item ) {
				$result_file_path = $item->name;
				if ( ! file_exists( $result_file_path ) ) {
					continue;
				}

				if ( $result_file_path == $asb_path ) {
					//catch
					$groups[] = $item;
				}
			}
		}

		return $groups;
	}

	/**
	 * @return float|int
	 * @since 1.0.3
	 */
	public function get_percent() {
		if ( $this->total_files == 0 ) {
			return 0;
		}

		$progress = round( ( $this->current_index * 100 ) / $this->total_files, 2 );
		if ( $progress > 100 ) {
			$progress = 100;
		}

		return $progress;
	}

	public function add_item( $item ) {
		add_post_meta( $this->id, 'item_' . $item->id, $item );
	}

	/**
	 * @param string $class_name
	 *
	 * @return WD_Scan_Result_Model
	 */
	public static function model( $class_name = __CLASS__ ) {
		return parent::model( $class_name );
	}
}