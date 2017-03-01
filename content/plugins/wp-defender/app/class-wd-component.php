<?php

/**
 * Base class, other class should extend this
 *
 * @since 1.0
 */
class WD_Component {
	const ERROR_LEVEL_INFO = 'INFO', ERROR_LEVEL_WARNING = 'WARNING', ERROR_LEVEL_ERROR = 'ERROR', ERROR_LEVEL_DEBUG = 'DEBUG';

	/**
	 * Returns the callback array for the specified method
	 *
	 * @since  1.0.0
	 *
	 * @param  string $tag The tag that is addressed by the callback.
	 * @param  string|array $method The callback method.
	 *
	 * @return array A working callback.
	 */
	private function get_callback( $tag, $method ) {
		if ( is_array( $method ) ) {
			$callback = $method;
		} else {
			$callback = array( $this, ! empty( $method ) ? $method : $tag );
		}

		return $callback;
	}

	/**
	 * Registers an action hook.
	 *
	 * @since  1.0.0
	 *
	 * @uses add_action() To register action hook.
	 *
	 * @param  string $tag The name of the action to which the $method is hooked.
	 * @param  string $method The name of the method to be called.
	 * @param  int $priority optional. Used to specify the order in which the
	 *         functions associated with a particular action are executed
	 *         (default: 10). Lower numbers correspond with earlier execution,
	 *         and functions with the same priority are executed in the order in
	 *         which they were added to the action.
	 * @param  int $accepted_args optional. The number of arguments the function
	 *         accept (default 1).
	 *
	 * @return WD_Component The Object.
	 */
	protected function add_action( $tag, $method = '', $priority = 10, $accepted_args = 1 ) {
		add_action(
			$tag,
			$this->get_callback( $tag, $method ),
			$priority,
			$accepted_args
		);

		return $this;
	}

	/**
	 * Executes the callback function instantly if the specified action was
	 * already fired. If the action was not fired yet then the action handler
	 * is registered via add_action().
	 *
	 * Important note:
	 * If the callback is executed instantly, then the functionr receives NO
	 * parameters!
	 *
	 * @since  1.0.0
	 *
	 * @uses add_action() To register action hook.
	 *
	 * @param  string $tag
	 * @param  string $method
	 * @param  int $priority
	 * @param  int $accepted_args
	 *
	 * @return WD_Component
	 */
	protected function run_action( $tag, $method = '', $priority = 10, $accepted_args = 1 ) {
		$callback = $this->get_callback( $tag, $method );

		if ( did_action( $tag ) ) {
			// Note: No argument is passed to the callback!
			call_user_func( $callback );
		} else {
			add_action(
				$tag,
				$callback,
				$priority,
				$accepted_args
			);
		}

		return $this;
	}

	/**
	 * Removes an action hook.
	 *
	 * @since  1.0.0
	 * @uses remove_action() To remove action hook.
	 *
	 * @param  string $tag The name of the action to which the $method is hooked.
	 * @param  string $method The name of the method to be called.
	 * @param  int $priority optional. Used to specify the order in which the
	 *         functions associated with a particular action are executed
	 *         (default: 10). Lower numbers correspond with earlier execution,
	 *         and functions with the same priority are executed in the order in
	 *         which they were added to the action.
	 *
	 * @return WD_Component
	 */
	protected function remove_action( $tag, $method = null, $priority = 10 ) {
		if ( null === $method ) {
			remove_all_actions( $tag );
		} else {
			remove_action(
				$tag,
				$this->get_callback( $tag, $method ),
				$priority
			);
		}

		return $this;
	}

	/**
	 * Registers AJAX action hook.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $tag The name of the AJAX action to which the $method is
	 *         hooked.
	 * @param  string $method Optional. The name of the method to be called.
	 *         If the name of the method is not provided, tag name will be used
	 *         as method name.
	 * @param  boolean $private Optional. Determines if we should register hook
	 *         for logged in users.
	 * @param  boolean $public Optional. Determines if we should register hook
	 *         for not logged in users.
	 *
	 * @return WD_Component
	 */
	protected function add_ajax_action( $tag, $method = '', $private = true, $public = false ) {
		if ( $private ) {
			$this->run_action( 'wp_ajax_' . $tag, $method );
		}

		if ( $public ) {
			$this->run_action( 'wp_ajax_nopriv_' . $tag, $method );
		}

		return $this;
	}

	/**
	 * Removes AJAX action hook.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $tag The name of the AJAX action to which the $method is
	 *         hooked.
	 * @param  string $method Optional. The name of the method to be called. If
	 *         the name of the method is not provided, tag name will be used as
	 *         method name.
	 * @param  boolean $private Optional. Determines if we should register hook
	 *         for logged in users.
	 * @param  boolean $public Optional. Determines if we should register hook
	 *         for not logged in users.
	 *
	 * @return WD_Component
	 */
	protected function remove_ajax_action( $tag, $method = null, $private = true, $public = false ) {
		if ( $private ) {
			$this->remove_action( 'wp_ajax_' . $tag, $method );
		}

		if ( $public ) {
			$this->remove_action( 'wp_ajax_nopriv_' . $tag, $method );
		}

		return $this;
	}

	/**
	 * Registers a filter hook.
	 *
	 * @since  1.0.0
	 *
	 * @uses add_filter() To register filter hook.
	 *
	 * @param  string $tag The name of the filter to hook the $method to.
	 * @param  string $method The name of the method to be called when the
	 *         filter is applied.
	 * @param  int $priority optional. Used to specify the order in which the
	 *         functions associated with a particular action are executed
	 *         (default: 10). Lower numbers correspond with earlier execution,
	 *         and functions with the same priority are executed in the order in
	 *         which they were added to the action.
	 * @param  int $accepted_args optional. The number of arguments the function
	 *         accept (default 1).
	 *
	 * @return WD_Component
	 */
	protected function add_filter( $tag, $method = '', $priority = 10, $accepted_args = 1 ) {
		$args = func_get_args();

		add_filter(
			$tag,
			$this->get_callback( $tag, $method ),
			$priority,
			$accepted_args
		);

		return $this;
	}

	/**
	 * Removes a filter hook.
	 *
	 * @since  1.0.0
	 *
	 * @uses remove_filter() To remove filter hook.
	 *
	 * @param  string $tag The name of the filter to remove the $method to.
	 * @param  string $method The name of the method to remove.
	 * @param  int $priority optional. The priority of the function (default: 10).
	 *
	 * @return WD_Component
	 */
	protected function remove_filter( $tag, $method = null, $priority = 10 ) {
		if ( null === $method ) {
			remove_all_filters( $tag );
		} else {
			remove_filter(
				$tag,
				$this->get_callback( $tag, $method ),
				$priority
			);
		}

		return $this;
	}

	/**
	 * Unbinds all hooks previously registered for actions and/or filters.
	 *
	 * @since  1.0.0
	 *
	 * @param boolean $actions Optional. TRUE to unbind all actions hooks.
	 * @param boolean $filters Optional. TRUE to unbind all filters hooks.
	 */
	public function unbind( $actions = true, $filters = true ) {
		$types = array();

		if ( $actions ) {
			$types['actions'] = 'remove_action';
		}

		if ( $filters ) {
			$types['filters'] = 'remove_filter';
		}

		foreach ( $types as $hooks => $method ) {
			foreach ( $this->$hooks as $hook ) {
				call_user_func_array( $method, $hook );
			}
		}
	}

	/**
	 * Register a shortcode
	 *
	 * @param $tag
	 * @param $method
	 */
	public function add_shortcode( $tag, $method ) {
		add_shortcode( $tag, $this->get_callback( $tag, $method ) );
	}

	/**
	 * Logging function, write to db or file depend on server. Only use when development only
	 *
	 * @param $message
	 * @param string $level
	 */
	public function log( $message, $level = self::ERROR_LEVEL_INFO, $log_name = 'log' ) {
		if ( ! defined( 'WD_DEBUG_LOG' ) || WD_DEBUG_LOG != true ) {
			return;
		}

		$is_apache = true;
		//create log string
		if ( is_null( $level ) ) {
			$log = $message;
		} else {
			$log = sprintf( "[%s] [%s] %s", date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ), $level, $message );
		}
		//load the logs
		if ( isset( wp_defender()->global['memory_stream'] ) ) {
			/**
			 * if fall here, means we in a scan, this is heaviest function, but we
			 * still need the log to see what happens underground. To prevent frying
			 * server resource, we store in memory streams chunks by chunks at end of each
			 * scan period
			 */
			$weird_delimiter         = "-{{_}}-";
			$weird_newline_delimiter = "-{{eol}}-";
			$stream                  = wp_defender()->global['memory_stream'];
			fwrite( $stream, $log . $weird_delimiter . $log_name . $weird_newline_delimiter );
		} else {
			$log         = $log . PHP_EOL;
			$upload_dirs = wp_upload_dir();
			$log_dir     = $upload_dirs['basedir'] . DIRECTORY_SEPARATOR . 'wp-defender/';
			if ( ! is_dir( $log_dir ) ) {
				wp_mkdir_p( $log_dir );
				//we need to create an htaccess to protect
				file_put_contents( $log_dir . '.htaccess', 'Deny from all' );
				file_put_contents( $log_dir . 'index.php', '' );
			}
			if ( $is_apache ) {
				$log_path = $log_dir . $log_name . '.log';
				if ( ! file_exists( $log_path ) ) {
					$handle = fopen( $log_path, 'w' );
				} else {
					$handle = fopen( $log_path, 'a' );
				}

				if ( $handle ) {
					fwrite( $handle, $log );
					fclose( $handle );
				}
			} else {
				//case nginx, iis, log will be store in db
				global $wpdb;
				$log_name = 'wd_log_' . $log_name;
				$indexs   = self::get_log_index();
				if ( ! in_array( $log_name, $indexs ) ) {
					//new key
					update_site_option( $log_name, $log );
				} else {
					//write
					$table = is_multisite() ? $wpdb->sitemeta : $wpdb->options;
					$key   = is_multisite() ? 'meta_key' : 'option_name';
					$value = is_multisite() ? 'meta_value' : 'option_value';
					$sql   = "UPDATE $table SET $value = CONCAT($value, %s) WHERE $key = %s;";
					$wpdb->query( $wpdb->prepare( $sql, $log, $log_name ) );
				}
			}
		}
	}

	public function open_mem_stream() {
		$stream                                = fopen( 'php://memory', 'w' );
		wp_defender()->global['memory_stream'] = $stream;
	}

	/**
	 * use only in dev
	 */
	public function dump_log_from_mem() {
		if ( isset( wp_defender()->global['memory_stream'] ) ) {
			$stream = wp_defender()->global['memory_stream'];
			rewind( $stream );
			$content = stream_get_contents( $stream );
			fclose( $stream );
			unset( wp_defender()->global['memory_stream'] );
			if ( ! empty( $content ) ) {
				//todo case content too long
				$weird_delimiter         = "-{{_}}-";
				$weird_newline_delimiter = "-{{eol}}-";
				$content                 = explode( $weird_newline_delimiter, $content );
				$result                  = array();
				$content                 = array_filter( $content );
				//comebine into one
				foreach ( $content as $line ) {
					$tmp = explode( $weird_delimiter, $line );
					if ( count( $tmp ) > 1 ) {
						$log  = $tmp[0];
						$name = $tmp[1];
						if ( ! isset( $result[ $name ] ) ) {
							$result[ $name ] = '';
						}
						$result[ $name ] .= $log . PHP_EOL;
					} else {
						$this->log( $line, self::ERROR_LEVEL_DEBUG, 'weird' );
					}
				}

				foreach ( $result as $key => $val ) {
					$this->log( $val, null, $key );
				}
			}
		}
	}

	/**
	 * base on env, we will load the log index
	 * @return array
	 */
	public static function get_log_index() {
		$is_apache = true;

		$result = array();
		if ( $is_apache ) {
			$upload_dirs = wp_upload_dir();
			$log_dir     = $upload_dirs['basedir'] . DIRECTORY_SEPARATOR . 'wp-defender/';
			if ( is_dir( $log_dir ) ) {
				$result = WD_Utils::get_dir_tree( $log_dir, true, false, array(), array(
					'ext' => array( 'log' )
				) );
			}
		} else {
			global $wpdb;
			$table  = is_multisite() ? $wpdb->sitemeta : $wpdb->options;
			$key    = is_multisite() ? 'meta_key' : 'option_name';
			$sql    = "SELECT $key FROM $table WHERE $key LIKE %s";
			$result = $wpdb->get_col( $wpdb->prepare( $sql, 'wd_log%' ) );
		}

		return $result;
	}

	/**
	 * remove all logs
	 */
	public function remove_logs() {
		$is_apache = true;
		$indexes   = $this->get_log_index();
		foreach ( $indexes as $index ) {
			if ( $is_apache ) {
				unlink( $index );
			} else {
				delete_site_option( $index );
			}
		}
	}

	/**
	 * @return bool
	 */
	public function is_ajax() {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return true;
		}

		return false;
	}


	/**
	 * @param $path string absolute path or key
	 *
	 * @return string
	 */
	public function get_log( $path ) {
		$server = WD_Utils::determine_server( content_url( 'index.php' ) );
		if ( $server == 'apache' ) {
			$is_apache = true;
		} else {
			$is_apache = false;
		}

		if ( $is_apache ) {
			return file_get_contents( $path );
		} else {
			return get_site_option( $path );
		}
	}

	/**
	 * @param $a
	 * @param $b
	 *
	 * @return bool
	 */
	public static function sort_log( $a, $b ) {
		return $a['time'] < $b['time'];
	}

	/**
	 * @param $end_point
	 * @param array $body_args
	 * @param array $request_args
	 *
	 * @return array|mixed|object|WP_Error
	 */
	public function wpmudev_call( $end_point, $body_args = array(), $request_args = array(), $return_raw = false ) {
		$api_key = WD_Utils::get_dev_api();
		if ( $api_key !== false ) {
			$domain                      = network_site_url();
			$post_vars['body']           = $body_args;
			$post_vars['body']['domain'] = $domain;
			$post_vars['timeout']        = 30;
			$post_vars['httpversion']    = '1.1';

			$headers = isset( $post_vars['headers'] ) ? $post_vars['headers'] : array();

			$post_vars['headers'] = array_merge( $headers, array(
				'Authorization' => 'Basic ' . $api_key
			) );

			$post_vars = array_merge( $post_vars, $request_args );
			$this->log( $end_point, self::ERROR_LEVEL_DEBUG, 'request' );
			$response = wp_remote_request( $end_point,
				apply_filters( 'wd_wpmudev_call_request_args',
					$post_vars ) );

			if ( is_wp_error( $response ) ) {
				return $response;
			}

			if ( $return_raw == true ) {
				return $response;
			}

			if (
				'OK' !== wp_remote_retrieve_response_message( $response )
				OR 200 !== wp_remote_retrieve_response_code( $response )
			) {
				return new WP_Error( wp_remote_retrieve_response_code( $response ), wp_remote_retrieve_response_message( $response ) );
			} else {
				$data = wp_remote_retrieve_body( $response );
				$data = json_decode( $data, true );
				//this mostly come to our server and back, should not be false
				if ( $data == false ) {
					return new WP_Error( 0, __( "There is an issue with API endpoint, please try again later!", wp_defender()->domain ) );
				}

				return $data;
			}
		} else {
			return new WP_Error( 'dashboard_required',
				sprintf( esc_html__( "WPMU DEV Dashboard will be required for this action. Please visit <a href=\"%s\">here</a> and install the WPMU DEV Dashboard", wp_defender()->domain )
					, 'https://premium.wpmudev.org/project/wpmu-dev-dashboard/' ) );
		}
	}

	/**
	 * Check if this plugin activate for network wide
	 * @return bool
	 */
	public function is_network_activate() {
		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}

		return is_plugin_active_for_network( wp_defender()->slug );
	}

	/**
	 * Returns property associated with the render.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $property The name of a property.
	 *
	 * @return mixed Returns mixed value of a property or NULL if a property
	 *         doesn't exist.
	 */
	public function &__get( $property ) {
		if ( property_exists( $this, $property ) ) {
			return $this->$property;
		}
	}

	/**
	 * Associates the render with specific property.
	 *
	 * @since  1.0.0
	 *
	 * @param string $property The name of a property to associate.
	 * @param mixed $value The value of a property.
	 */
	public function __set( $property, $value ) {
		if ( property_exists( $this, $property ) ) {
			$this->$property = $value;
		}
	}

	/**
	 * @param $size
	 *
	 * @return string
	 */
	public static function convert_size( $size ) {
		$unit = array( 'b', 'kb', 'mb', 'gb', 'tb', 'pb' );
		if ( $size == false ) {
			return esc_html__( "N/A", wp_defender()->domain );
		}

		return @round( $size / pow( 1024, ( $i = floor( log( $size, 1024 ) ) ) ), 2 ) . ' ' . $unit[ $i ];
	}
}