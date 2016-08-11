<?php

class AS3CF_Minify {

	/**
	 * @var Amazon_S3_And_CloudFront_Assets
	 */
	protected $as3cf;

	/**
	 * @var AS3CF_Minify_Background_Process
	 */
	protected $background_process;

	/**
	 * @var bool
	 */
	protected $save_on_shutdown = false;

	/**
	 * Error constants
	 */
	const ERROR_SCRIPT_DEBUG = 1;
	const ERROR_EXCLUDE_FILTER = 2;
	const ERROR_TYPE_NOT_SUPPORTED = 3;
	const ERROR_EXTENSION_NOT_SUPPORTED = 4;
	const ERROR_FILE_PREFIXED = 5;
	const ERROR_FILE_DOES_NOT_EXIST = 6;
	const ERROR_CREATING_TMP_DIR = 7;
	const ERROR_CREATING_TMP_FILE = 8;
	const ERROR_NO_PROVIDER = 9;
	const ERROR_EXCEPTION = 10;

	/**
	 * AS3CF_Minify constructor.
	 *
	 * @param Amazon_S3_And_CloudFront_Assets $as3cf
	 * @param AS3CF_Minify_Background_Process $background_process
	 */
	public function __construct( $as3cf, $background_process ) {
		$this->as3cf              = $as3cf;
		$this->background_process = $background_process;

		add_action( 'shutdown', array( $this, 'save_queue' ) );
		add_filter( 'as3cf_minify_exclude_files', array( $this, 'as3cf_minify_exclude_files' ), 10, 2 );
	}

	/**
	 * Maybe prefix key
	 *
	 * @param array  $details
	 * @param string $file
	 *
	 * @return string
	 */
	public function maybe_prefix_key( $details, $file ) {
		$key = $details['s3_info']['key'];

		if ( ! $this->maybe_enqueue_minified_version( $details, $file ) ) {
			return $key;
		}

		return $this->prefix_key( $key );
	}

	/**
	 * Maybe enqueue minified version
	 *
	 * @param array  $details
	 * @param string $file
	 *
	 * @return bool
	 */
	protected function maybe_enqueue_minified_version( $details, $file ) {
		if ( is_wp_error( $this->is_script_debug() ) ) {
			// Serve uncompressed in debug mode
			return false;
		}

		if ( is_wp_error( $this->is_file_excluded( $file ) ) ) {
			// File is excluded by user
			return false;
		}

		if ( is_wp_error( $this->is_file_supported( $details ) ) ) {
			// Not a valid file type or extension
			return false;
		}

		if ( is_wp_error( $this->is_file_prefixed( $details ) ) ) {
			// File already prefixed
			return false;
		}

		if ( ! $this->is_file_minified( $file, true, $details ) ) {
			// File not minified
			return false;
		}

		return true;
	}

	/**
	 * Is script debug
	 *
	 * @return WP_Error|bool
	 */
	public function is_script_debug() {
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			return $this->as3cf->_throw_error( self::ERROR_SCRIPT_DEBUG );
		}

		return true;
	}

	/**
	 * Is file excluded
	 *
	 * @param string $file
	 *
	 * @return WP_Error|bool
	 */
	public function is_file_excluded( $file ) {
		$minify_excludes_enabled = $this->as3cf->get_setting( 'enable-minify-excludes', false );

		if ( empty( $minify_excludes_enabled ) ) {
			return true;
		}

		if ( in_array( $file, apply_filters( 'as3cf_minify_exclude_files', array(), $file ) ) ) {
			return $this->as3cf->_throw_error( self::ERROR_EXCLUDE_FILTER );
		}

		return true;
	}

	/**
	 * Is file supported
	 *
	 * @param array $details
	 *
	 * @return WP_Error|bool
	 */
	public function is_file_supported( $details ) {
		if ( 'core' === $details['type'] ) {
			return $this->as3cf->_throw_error( self::ERROR_TYPE_NOT_SUPPORTED );
		}

		if ( 'css' !== $details['extension'] && 'js' !== $details['extension'] ) {
			return $this->as3cf->_throw_error( self::ERROR_EXTENSION_NOT_SUPPORTED );
		}

		return true;
	}

	/**
	 * Is file prefixed
	 *
	 * @param array $details
	 *
	 * @return WP_Error|bool
	 */
	public function is_file_prefixed( $details ) {
		$key      = $details['s3_info']['key'];
		$pathinfo = pathinfo( $key );
		$filename = preg_replace( '@\.min$@', '', $pathinfo['filename'] );
		$filename .= '.min.' . $pathinfo['extension'];

		if ( false === strpos( $key, $filename ) ) {
			return true;
		}

		return $this->as3cf->_throw_error( self::ERROR_FILE_PREFIXED );
	}

	/**
	 * Is file minified
	 *
	 * @param string     $file
	 * @param bool       $queue
	 * @param null|array $details
	 *
	 * @return bool
	 */
	public function is_file_minified( $file, $queue = false, $details = null ) {
		$files  = $this->as3cf->get_enqueued_files();
		$type   = pathinfo( $file, PATHINFO_EXTENSION );
		$return = false;

		if ( isset( $files[ $type ][ $file ]['minified'] ) ) {
			$return = $files[ $type ][ $file ]['minified'];
		}

		if ( ! isset( $files[ $type ][ $file ]['minified'] ) || $this->as3cf->is_failure( 'minify', $file, true ) ) {
			$this->maybe_trigger_background_process( $file, $queue, $details );
		}

		return $return;
	}

	/**
	 * Maybe trigger background process
	 *
	 * @param string     $file
	 * @param bool       $queue
	 * @param null|array $details
	 */
	private function maybe_trigger_background_process( $file, $queue, $details ) {
		$files = $this->as3cf->get_enqueued_files();
		$type  = pathinfo( $file, PATHINFO_EXTENSION );

		if ( $queue && ! is_null( $details ) ) {
			$this->save_on_shutdown = true;

			// Set minified to false so as not to queue multiple times
			$files[ $type ][ $file ]['minified'] = false;
			$this->as3cf->save_enqueued_files( $files );

			$this->background_process->push_to_queue( array(
				'file'    => $file,
				'details' => $details,
			) );
		}
	}

	/**
	 * Prefix key
	 *
	 * @param string $key
	 *
	 * @return string
	 */
	public function prefix_key( $key ) {
		$pathinfo = pathinfo( $key );
		$filename = $pathinfo['filename'] . '.min.' . $pathinfo['extension'];

		return str_replace( $pathinfo['basename'], $filename, $key );
	}

	/**
	 * Save queue
	 */
	public function save_queue() {
		if ( $this->save_on_shutdown ) {
			$this->background_process->save()->dispatch();
		}
	}

	/**
	 * Handle file
	 *
	 * @param string $file
	 * @param array  $details
	 *
	 * @return string
	 */
	public function handle_file( $file, $details ) {
		if ( ! file_exists( $file ) ) {
			return $this->as3cf->_throw_error( self::ERROR_FILE_DOES_NOT_EXIST );
		}

		$input = file_get_contents( $file );

		switch ( $details['extension'] ) {
			case 'css':
				$output = $this->minify_css( $input, $details['url'] );
				break;
			case 'js':
				$output = $this->minify_js( $input, $details['url'] );
				break;
			default:
				$output = $this->as3cf->_throw_error( self::ERROR_NO_PROVIDER );
		}

		if ( is_wp_error( $output ) ) {
			$this->handle_minify_failure( $file );
		} elseif ( $this->as3cf->is_failure( 'minify', $file ) ) {
			$this->as3cf->remove_failure( 'minify', $file );
		}

		return $output;
	}

	/**
	 * Upload file
	 *
	 * @param string $body
	 * @param array  $details
	 * @param string $key
	 * @param string $file
	 *
	 * @return bool
	 */
	public function upload_file( $body, $details, $key, $file ) {
		$bucket    = $this->as3cf->get_setting( 'bucket' );
		$region    = $this->as3cf->get_setting( 'region' );
		$s3client  = $this->as3cf->get_s3client( $region );
		$gzip      = false;
		$gzip_body = $this->as3cf->maybe_gzip_file( $file, $details, $body );

		if ( ! is_wp_error( $gzip_body ) ) {
			$body = $gzip_body;
			$gzip = true;
		}
		$upload = $this->as3cf->copy_body_to_s3( $s3client, $bucket, $body, $details, $gzip, $key );

		if ( is_wp_error( $upload ) ) {
			$this->handle_minify_failure( $file );

			return false;
		} elseif ( $this->as3cf->is_failure( 'minify', $file ) ) {
			$this->as3cf->remove_failure( 'minify', $file );
		}

		return true;
	}

	/**
	 * Minify CSS
	 *
	 * @param string $css
	 * @param string $url
	 *
	 * @return string
	 */
	protected function minify_css( $css, $url ) {
		return $this->call_provider( 'css', 'AS3CF_Minify_CssMin_Provider', $css, $url );
	}

	/**
	 * Minify JS
	 *
	 * @param string $js
	 * @param string $url
	 *
	 * @return string
	 */
	protected function minify_js( $js, $url ) {
		return $this->call_provider( 'js', 'AS3CF_Minify_JShrink_Provider', $js, $url );
	}

	/**
	 * Call provider
	 *
	 * @param string $type
	 * @param string $default_class
	 * @param string $input
	 * @param string $url
	 *
	 * @return string
	 */
	protected function call_provider( $type, $default_class, $input, $url ) {
		$class = apply_filters( 'as3cf_minify_' . $type . '_provider', $default_class );

		if ( ! class_exists( $class ) ) {
			$error_msg = sprintf( __( 'Error attempting to minify %s, class not found: %s', 'as3cf-assets' ), $url, $class );
			AS3CF_Error::log( $error_msg, 'ASSETS' );

			return $input;
		}

		try {
			$provider = new $class( $input );
			$output   = $provider->minify();
		} catch ( Exception $e ) {
			$error_msg = sprintf( __( 'Error attempting to minify %s: %s', 'as3cf-assets' ), $url, $e->getMessage() );
			AS3CF_Error::log( $error_msg, 'ASSETS' );

			return $this->as3cf->_throw_error( self::ERROR_EXCEPTION, $error_msg );
		}

		return $output;
	}

	/**
	 * Handle minify failure
	 *
	 * @param string $file
	 *
	 * @return int
	 */
	protected function handle_minify_failure( $file ) {
		return $this->as3cf->handle_failure( $file, 'minify' );
	}

	/**
	 * Handle `as3cf_minify_exclude_files` filter to apply minify-excludes setting.
	 *
	 * @param array  $excludes
	 * @param string $file
	 *
	 * @return array
	 */
	public function as3cf_minify_exclude_files( $excludes, $file ) {
		$excluded_files = $this->as3cf->get_setting( 'minify-excludes' );

		if ( empty( $excluded_files ) ) {
			return $excludes;
		}

		// Split settings string by newline regardless of platform setting saved on.
		$excluded_files = preg_split( '/\R/', $excluded_files, null, PREG_SPLIT_NO_EMPTY );

		if ( ! is_array( $excluded_files ) ) {
			return $excludes;
		}

		// Test whether the given file path ends with a match to an excluded path.
		$excluded = array_reduce( $excluded_files, function ( $carry, $exclude ) use ( $file ) {
			if ( ! $carry && substr( $file, -strlen( trim( $exclude ) ) ) === trim( $exclude ) ) {
				return true;
			}

			return $carry;
		}, false );

		if ( $excluded ) {
			$excludes[] = $file;
		}

		return $excludes;
	}
}
