<?php

/**
 * @author: Hoang Ngo
 */
class WD_Suspicious_Scan extends WD_Scan_Abstract {
	const CACHE_INDEX = 'wd_suspicious_scan_index', CACHE_SIGNATURES = 'wd_signatures_cache',
		FILE_SCANNED = 'wd_suspicious_scanned', RECOUNT_TOTAL = 'wd_suspicious_recount_total', TRY_ATTEMPT = 'wd_sus_file_attempt';

	public $name = '';
	public $chunk_size = 50;

	protected $try_attempt = array();

	protected $tokens;
	protected $tokens_is_php = array();

	public function init() {
		$this->name               = esc_html__( "Suspicious file scan", wp_defender()->domain );
		$this->percentable        = true;
		$this->dashboard_required = true;
		$this->total_files        = WD_Scan_Api::get_content_files();

		if ( $this->total_files === false ) {
			return false;
		}
		$this->file_scanned = WD_Utils::get_cache( self::FILE_SCANNED, array() );

		$this->try_attempt = WD_Utils::get_cache( self::TRY_ATTEMPT, array() );

		if ( is_object( $this->model ) && count( $this->model->result_core_integrity ) ) {
			//this mean the core dir scan just done, and we got some stuff, need to scan that stuff too
			$this->total_files = array_merge( $this->total_files, $this->model->result_core_integrity );
		}
	}

	private function get_function_scan_pattern() {
		$pattern = $this->get_patterns( 'suspicious_function_pattern' );

		return $pattern;
	}

	private function get_base64_scan_pattern() {
		$pattern = $this->get_patterns( 'base64_encode_pattern' );

		return $pattern;
	}

	private function get_concat_scan_pattern() {
		$pattern = $this->get_patterns( 'string_concat_pattern' );

		return $pattern;
	}

	private function get_variable_concat_pattern() {
		//this will greedy get all, we will parse later in php for faster than regex
		$pattern = $this->get_patterns( 'variable_concat_pattern' );

		return $pattern;
	}

	private function get_variable_function_pattern() {
		$pattern = $this->get_patterns( 'variable_function_pattern' );

		return $pattern;
	}

	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	private function get_patterns( $key ) {
		$cache = WD_Utils::get_cache( self::CACHE_SIGNATURES, false );
		if ( $cache !== false && ! is_wp_error( $cache ) ) {
			$defender_signatures = $cache;
		} else {
			$api_endpoint        = "https://premium.wpmudev.org/api/defender/v1/signatures";
			$defender_signatures = $this->wpmudev_call( $api_endpoint, array(), array(
				'method' => 'GET'
			) );
			WD_Utils::cache( self::CACHE_SIGNATURES, $defender_signatures, 900 );
		}

		if ( ! is_wp_error( $defender_signatures ) ) {
			//cache
			if ( isset( $defender_signatures[ $key ] ) ) {
				return $defender_signatures[ $key ];
			}
		} else {
			$model          = WD_Scan_Api::get_active_scan();
			$model->status  = WD_Scan_Result_Model::STATUS_ERROR;
			$model->message = $defender_signatures->get_error_message();
			$model->save();

			return false;
		}
	}

	public function flush_cache() {
		WD_Utils::remove_cache( self::CACHE_SIGNATURES );
	}

	public function process() {
		if ( ! $this->maybe_run_this_scan( $this->model ) ) {
			return false;
		}
		set_time_limit( - 1 );
		ini_set( 'memory_limit', - 1 );

		if ( WD_Utils::get_cache( self::RECOUNT_TOTAL ) == 0 ) {
			$this->model->message = esc_html__( "Analyzing WordPress content files…", wp_defender()->domain );
			//include the count
			$this->model->result_core_integrity = array_filter( $this->model->result_core_integrity );
			$this->model->total_files           = $this->model->total_files + count( $this->model->result_core_integrity );
			$this->model->current_action        = 'content';
			$this->model->save();
			WD_Utils::cache( self::RECOUNT_TOTAL, 1 );
		}

		//many case this is error, so we have to rebind the message
		if ( $this->model->message != esc_html__( "Analyzing WordPress content files…", wp_defender()->domain ) ) {
			$this->model->message = esc_html__( "Analyzing WordPress content files…", wp_defender()->domain );
			$this->model->save();
		}

		$files_need_scan = array_diff( $this->total_files, $this->file_scanned );
		//because this can too much, so just break it into parts
		$files = WD_Scan_Api::calculate_chunks( $files_need_scan );

		$files = array_filter( $files );
		if ( ! is_array( $files ) ) {
			return;
		}

		$last_scan = $this->last_scan;
		if ( ( $tmp = WD_Utils::get_cache( WD_Scan_Api::CACHE_LAST_MD5, false ) ) !== false ) {
			$last_checksum = $tmp;
		} elseif ( is_object( $last_scan ) ) {
			$last_checksum = $last_scan->md5_tree;
		} else {
			$last_checksum = null;
		}
		$cpu_count    = 0;
		$tmp_checksum = WD_Utils::get_cache( WD_Scan_Api::CACHE_TMP_MD5, array() );
		foreach ( $files as $file ) {
			if ( ! is_file( $file ) ) {
				continue;
			}
			if ( $this->cpu_reach_threshold() ) {
				if ( $this->is_ajax() ) {
					sleep( 3 );
					if ( $cpu_count > 55 ) {
						$this->model->status  = WD_Scan_Result_Model::STATUS_ERROR;
						$this->model->message = esc_html__( "Your server resource usage is too close to your limit. Please try again in 15 minutes.", wp_defender()->domain );
						$this->model->save();

						return;
					}
					$cpu_count += 1;
				} else {
					//this case is in cronjob, the time for next cron is 3-5min, which is enough
					break;
				}
			}

			/**
			 * we need to check if this is still processing, and fault
			 */
			$tried_check = array_count_values( $this->try_attempt );
			if ( isset( $tried_check[ $file ] ) && $tried_check[ $file ] >= 3 ) {
				//skip this
				//todo index this
				$this->file_scanned[] = $file;

				$this->model->current_index += 1;
				$this->model->save();
				WD_Utils::cache( self::FILE_SCANNED, $this->file_scanned );

			} else {
				//process try attempt, we only get 5 last
				$this->try_attempt[] = $file;
				//save right away
				WD_Utils::cache( self::TRY_ATTEMPT, $this->try_attempt );
			}

			$checksum = md5_file( $file );
			//$this->model->md5_tree[ $file ] = $checksum;
			$tmp_checksum[ $file ] = $checksum;
			if ( is_object( $last_scan ) && is_array( $last_checksum ) && isset( $last_checksum[ $file ] ) && strcmp( $checksum, $last_checksum[ $file ] ) === 0 ) {
				$ret = $last_scan->find_result_item_by_file( $file, 'WD_Scan_Result_File_Item_Model' );
				if ( is_object( $ret ) ) {
					//this file is an issue from the last, it still be
					$this->model->item_indexes[ $ret->id ] = $file;
					$this->model->add_item( $ret );
				}

			} else {
				$ret = $this->_scan_a_file( $file );
				if ( $ret instanceof WD_Scan_Result_File_Item_Model ) {
					//found an issue
					$this->model->add_item( $ret );
					$this->model->item_indexes[ $ret->id ] = $file;
					//$this->model->result[] = $ret;
				}
			}

			if ( is_object( $last_scan ) ) {
				$is_ignored = $last_scan->is_file_ignored( $file, 'WD_Scan_Result_File_Item_Model' );
				if ( $is_ignored && $ret instanceof WD_Scan_Result_File_Item_Model ) {
					$this->model->ignore_files[] = $ret->id;
				}
			}

			$this->file_scanned[] = $file;
			$this->model->current_index += 1;

			//$this->log( 'after memory ' . $this->convert_size( memory_get_usage() ), self::ERROR_LEVEL_DEBUG, 'scan' );
			//$this->log( 'after cpu' . $this->get_cpu_usage(), self::ERROR_LEVEL_DEBUG, 'cpu' );
			//$this->log( '=================================' );
		}

		/**
		 * at the end of this loop, we need to calculate
		 * 2. store files scanned
		 * 3. store md5 tree
		 * 4. store result
		 */
		$this->model->save();
		//process file scan
		$this->file_scanned = array_unique( $this->file_scanned );
		//all success
		$this->try_attempt = array();
		WD_Utils::cache( self::TRY_ATTEMPT, $this->try_attempt );
		WD_Utils::cache( self::FILE_SCANNED, $this->file_scanned );
		WD_Utils::cache( WD_Scan_Api::CACHE_TMP_MD5, $tmp_checksum );
	}

	/**
	 * @param $file
	 *
	 * @return bool|WD_Scan_Result_File_Item_Model
	 */
	public function _scan_a_file( $file ) {
		if ( ! file_exists( $file ) ) {
			return;
		}

		$content             = $this->read_file_content( $file );
		$item                = true;
		$this->tokens        = null;
		$this->tokens_is_php = null;
		if ( $content === false || strlen( $content ) == 0 ) {
			//quickly skip this, but we still need to record the index & info
		} else {
			//break in new line for easier trace
			$content = trim( preg_replace( '/\s\s+/', '', $content ) );
			$content = str_replace( ';', ';' . PHP_EOL, $content );
			$content = preg_replace( "/\n+/", "\n", $content );
			/**
			 * need to gather information about
			 * 1. base 64 encode
			 * 2. repeatly concat string
			 * 3. repeatly concat array element
			 * 4. variable function
			 * 5. suspicious function pattern
			 */
			try {
				$b64_res = $this->detect_encode_code( $content, $file );
				//$this->log( 'done detect encode', self::ERROR_LEVEL_INFO, 'scan' );
				$sconcat_res = $this->detect_concat_string( $content, $file );
				//$this->log( 'done detect concat string', self::ERROR_LEVEL_INFO, 'scan' );
				$vconcat_res = $this->detect_variable_concat( $content, $file );
				//$this->log( 'done detect variable concat', self::ERROR_LEVEL_INFO, 'scan' );
				$vfunction_res = $this->detect_variable_function( $content, $file );
				//$this->log( 'done detect variable function', self::ERROR_LEVEL_INFO, 'scan' );
				$sfunction_res = $this->detect_suspicious_functions( $content, $file );
				//$this->log( 'done detect suspicious function', self::ERROR_LEVEL_INFO, 'scan' );
			} catch ( Exception $e ) {
				//unlock
				delete_option( 'wd_scan_lock' );

				return;
			}

			$res = WD_Scan_Api::virus_weight( array(
				'b64_res'       => $b64_res,
				'sconcat_res'   => $sconcat_res,
				'vconcat_res'   => $vconcat_res,
				'vfunction_res' => $vfunction_res,
				'sfunction_res' => $sfunction_res
			) );

			/*$res = WD_Scan_Api::calculate_scores( array(
				'b64_res'       => $b64_res,
				'sconcat_res'   => $sconcat_res,
				'vconcat_res'   => $vconcat_res,
				'vfunction_res' => $vfunction_res,
				'sfunction_res' => $sfunction_res
			) );*/

			$score = $res['score'];
			$log   = $res['detail'];
			if ( $score > 0 ) {
				//means we got some issue here
				$tmp = array(
					'file'  => $file,
					'score' => $score,
					'log'   => $log,
				);
				//check if this is inside theme or folder
				if ( strpos( $file, WP_CONTENT_DIR . 'themes/' ) === 0 ||
				     strpos( $file, WP_CONTENT_DIR . 'plugins/' ) === 0
				) {
					//maybe we can fix this
					$tmp['can_fix'] = true;
				} else {
					//this is something outside, only delete
					$tmp['can_fix'] = false;
				}
				//items
				$item         = new WD_Scan_Result_File_Item_Model();
				$item->score  = $score;
				$item->id     = uniqid( "", true );
				$item->name   = $file;
				$item->detail = $tmp;
				//$model->result[] = $item;
			}
		}
		//release memory
		$content = null;
		unset( $content );

		return $item;
	}

	/**
	 * @param $file
	 *
	 * @return bool|string
	 */
	private function read_file_content( $file ) {
		//check file size
		$content     = "";
		$file_handle = @fopen( $file, "r" );
		if ( $file_handle ) {
			while ( ! feof( $file_handle ) ) {
				$content .= fgets( $file_handle );
			}
			fclose( $file_handle );
		} else {
			return false;
		}

		//$content = trim( $content );

		return $content;
	}

	public function detect_variable_function( $content, $file ) {
		$file = pathinfo( $file, PATHINFO_FILENAME );
		$res  = array();
		//$this->log( var_export( $content, true ), self::ERROR_LEVEL_DEBUG, $file );
		if ( preg_match_all( $this->get_variable_function_pattern(), $content, $matches, PREG_OFFSET_CAPTURE ) ) {
			if ( is_null( $this->tokens ) ) {
				$tokens = @token_get_all( $content );
			} else {
				$tokens = $this->tokens;
			}
			foreach ( $matches[1] as $match ) {
				$line = $this->find_line_number( $content, $match[1] );
				foreach ( $tokens as $token ) {
					if ( is_array( $token ) && $token[2] == $line && $token[1] == $match[0] ) {
						//this mean this file having some variable functions
						$res[] = array(
							'line'   => $line,
							'code'   => $match[0],
							'offset' => array( $match[1], $match[1] + strlen( $match[0] ) ),
							'file'   => $file,
							'type'   => 'variable_function'
						);
					}
				}
			}
			$tokens = null;
			unset( $tokens );
		}

		return $res;
	}


	/**
	 * @param $content
	 * @param $offset
	 *
	 * @return int
	 */
	private function find_line_number( $content, $offset ) {
		list( $before ) = str_split( $content, $offset ); // fetches all the text before the match

		$line_number = strlen( $before ) - strlen( str_replace( "\n", "", $before ) ) + 1;

		return $line_number;
	}

	/**
	 * @param $content
	 * @param $file
	 *
	 * @return array
	 */
	public function detect_variable_concat( $content, $file ) {
		$res = array();
		if ( preg_match_all( $this->get_variable_concat_pattern(), $content, $matches, PREG_OFFSET_CAPTURE ) ) {
			foreach ( $matches[0] as $found ) {
				$match = $found[0];
				$match = explode( '.', $match );
				$match = array_filter( $match );
				if ( count( $match ) > 3 ) {
					$res[] = array(
						'line'   => $this->find_line_number( $content, $found[1] ),
						'code'   => $match,
						'offset' => array( $found[1], $found[1] + strlen( $found[0] ) ),
						'file'   => $file,
						'type'   => 'variable_concat'
					);
				}
			}
		}

		return $res;
	}

	/**
	 *
	 * @param $content
	 * @param $file
	 *
	 * @return array
	 */
	public function detect_concat_string( $content, $file ) {
		$res = array();
		if ( preg_match_all( $this->get_concat_scan_pattern(), $content, $matches, PREG_OFFSET_CAPTURE ) ) {
			foreach ( $matches[0] as $found ) {
				$match = $found[0];
				//join the match
				$match = str_replace( array(
					PHP_EOL,
					"'.'",
					'"."',
					"' . '",
					'" . "',
				), '', $match );
				if ( ( $decoded = base64_decode( $match, true ) ) !== false ) {
					//if this is a normal script, it should been here
					if ( $this->maybe_danger_decoded_code( $decoded ) ) {
						//if gone here that must be something
						$res[] = array(
							'line'   => $this->find_line_number( $content, $found[1] ),
							'offset' => array( $found[1], $found[1] + strlen( $found[0] ) ),
							'code'   => $match,
							//'decoded' => $decoded,
							'file'   => $file,
							'type'   => 'string_concat'
						);
					}
				} else {
					//can't decode, might be some deeper encrypt, and likely unfriendly
					$res[] = array(
						'line'   => $this->find_line_number( $content, $found[1] ),
						'code'   => $match,
						//'decoded' => false,
						'offset' => array( $found[1], $found[1] + strlen( $found[0] ) ),
						'file'   => $file,
						'type'   => 'string_concat'
					);
				}
			}
		}

		return $res;
	}

	/**
	 * Detect base64 encoding code in a file
	 *
	 * @param $content
	 * @param $file
	 *
	 * @return array
	 */
	public function detect_encode_code( $content, $file ) {
		//do a regex check ifrst
		$res = array();
		if ( preg_match_all( $this->get_base64_scan_pattern(), $content, $matches, PREG_OFFSET_CAPTURE ) ) {
			//init tokens
			try {
				$tokens = $this->get_file_tokens( $content );
			} catch ( Exception $e ) {

			}

			/**
			 * things need to be done here
			 * 1. Found base 64 encoding
			 * 2. make sure it is php code
			 * 3. check if the code harmful or not
			 */

			foreach ( $matches[1] as $found ) {
				$match = $found[0];
				//first we need to check, if this code is actual php code, or commente
				$line = $this->find_line_number( $content, $found[1] );
				//is this line?
				if ( ! in_array( $line, $this->tokens_is_php() ) ) {
					//no, next
					continue;
				}
				if ( ( $decoded = base64_decode( $match ) ) !== false ) {
					//can decode, need to check some case
					if ( $this->maybe_danger_decoded_code( $decoded ) ) {
						//if gone here that must be something
						$res[] = array(
							'line'   => $line,
							//'code'   => $match,
							//'decoded' => $decoded,
							'offset' => array( $found[1], $found[1] + strlen( $found[0] ) ),
							'file'   => $file,
							'type'   => 'base64'
						);
					}
				} else {
					//can't decode, might be some deeper encrypt, and likely unfriendly
					$res[] = array(
						'line'   => $line,
						//'code'   => $match,
						//'decoded' => false,
						'offset' => array( $found[1], $found[1] + strlen( $found[0] ) ),
						'file'   => $file,
						'type'   => 'base64'
					);
				}
			}
		}

		return $res;
	}

	/**
	 * This function will return an array, which is php code line
	 * @return array
	 * @since 1.0.2
	 */
	private function tokens_is_php() {
		if ( empty( $this->tokens_is_php ) ) {
			$no_include = array( T_DOC_COMMENT, T_EMPTY, T_END_HEREDOC, T_INLINE_HTML, T_COMMENT );
			foreach ( $this->tokens as $token ) {
				if ( ! is_array( $token ) ) {
					continue;
				}
				if ( ! in_array( $token[0], $no_include ) ) {
					$this->tokens_is_php[] = $token[2];
				}
			}
		}
		if ( empty( $this->tokens_is_php ) ) {
			$this->tokens_is_php = array();
		}

		return $this->tokens_is_php;
	}

	/**
	 * @param $line
	 *
	 * @return array|null
	 * @since 1.0.3
	 */
	protected function find_token_by_line( $line ) {
		if ( empty( $this->tokens ) ) {
			return null;
		}

		$ret = array();

		foreach ( $this->tokens as $token ) {
			if ( is_array( $token ) && $token[2] == $line ) {
				$ret[] = $token;
			}
		}

		return $ret;
	}

	/**
	 * @param $content
	 *
	 * @return array
	 * @since 1.0.3
	 */
	protected function get_file_tokens( $content ) {
		if ( empty( $this->tokens ) ) {
			$this->tokens = token_get_all( $content );
		}

		return $this->tokens;
	}

	/**
	 * @param $decoded
	 *
	 * @return bool
	 */
	private function maybe_danger_decoded_code( $decoded ) {
		$decoded = trim( $decoded );

		if ( empty( $decoded ) ) {
			return false;
		}
		if ( filter_var( $decoded, FILTER_VALIDATE_URL ) ) {
			//just an url, nothing to do
			return false;
		}

		if ( is_array( maybe_unserialize( $decoded ) ) ) {
			//an array, by pass for now
			return false;
		}

		if ( json_decode( $decoded ) ) {
			//just a json, pass
			return false;
		}

		$doc = new DOMDocument();
		if ( @$doc->loadXML( $decoded ) ) {
			//xml go through too
			return false;
		}

		return true;
	}

	function base64_to_jpeg( $base64_string, $output_file ) {
		$tmp_path = wp_defender()->get_plugin_path() . 'vault/';
		$ifp      = fopen( $tmp_path . $output_file, "wb" );

		$data = explode( ',', $base64_string );

		fwrite( $ifp, base64_decode( $data[1] ) );
		fclose( $ifp );

		return $tmp_path . $output_file;
	}


	/**
	 * Checking the file content to find if we have any function match the pattern
	 *
	 * @param $content
	 *
	 * @return array
	 */
	public function detect_suspicious_functions( $content, $file = null ) {
		$catches = array();
		$parts   = explode( PHP_EOL, $content );
		//we need to make sure no shortopen tag here
		//wont use regex here, as it will broken if file too large
		$parts   = array_map( array( &$this, 'avoid_short_tag' ), $parts );
		$content = implode( PHP_EOL, $parts );
		//tokenize the code
		$analysis = array();
		if ( preg_match( $this->get_function_scan_pattern(), $content ) ) {
			if ( is_null( $this->tokens ) ) {
				$tokens = @token_get_all( $content );
			} else {
				$tokens = $this->tokens;
			}

			foreach ( $tokens as $token ) {
				if ( ! is_array( $token ) ) {
					continue;
				}
				//only catch if function
				//var_dump( $this->debug_token( $token ) );
				if ( in_array( $token[0], array(
					T_STRING,
					T_EVAL,
				) ) ) {
					//put the preg match here to reduce the times it run in loop, also not pregmatch big data
					if ( preg_match( $this->get_function_scan_pattern(), $token[1] ) ) {
						$catches[] = array(
							'function' => $token[1],
							'line'     => $token[2],
						);
					}
				}
			}
			unset( $tokens );
			if ( ! empty( $catches ) ) {
				foreach ( $catches as $catch ) {
					if ( ! isset( $analysis[ $catch['line'] ] ) ) {
						$analysis[ $catch['line'] ] = array();
					}

					$analysis[ $catch['line'] ][] = $catch['function'];
				}
			}
		}

		return $analysis;
	}

	/**
	 * detect if the code havig short open tag and replace with full open
	 *
	 * @param $content
	 *
	 * @return mixed
	 */
	public function avoid_short_tag( $content ) {
		$last_pos = 0;
		while ( ( $last_pos = strpos( $content, '<?', $last_pos ) ) !== false ) {
			$last_pos = $last_pos + strlen( '<?' );
			$is_tag   = strtolower( substr( $content, $last_pos, 3 ) );
			if ( ! in_array( $is_tag, array( 'php', 'xml' ) ) ) {
				//this mean the next to <? not php or xml, we will append a php in there
				$content = substr_replace( $content, 'php ', $last_pos, 0 );
			}
		}

		return $content;
	}

	public function debug_token( $token ) {
		return array(
			token_name( $token[0] ),
			$token[1],
			$token[2]
		);
	}

	public function check() {
		$files_need_scan = array_diff( $this->total_files, $this->file_scanned );
		if ( count( $files_need_scan ) == 0 ) {
			return true;
		}

		return false;
	}

	public function clean_up() {
		WD_Utils::remove_cache( self::FILE_SCANNED );
		WD_Utils::remove_cache( self::TRY_ATTEMPT );
		WD_Utils::remove_cache( self::RECOUNT_TOTAL );
		WD_Utils::remove_cache( self::CACHE_SIGNATURES );
	}

	public function is_enabled() {
		if ( WD_Utils::get_setting( 'use_' . WD_Scan_Api::SCAN_SUSPICIOUS_FILE . '_scan', false ) != 1 ) {
			return false;
		}
		if ( $this->dashboard_required && WD_Utils::get_dev_api() == false ) {
			return false;
		}

		return true;
	}
}