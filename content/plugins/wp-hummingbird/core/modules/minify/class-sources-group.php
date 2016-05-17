<?php

/**
 * Class WP_Hummingbird_Sources_Group
 *
 * Manages a group of sources
 */
class WP_Hummingbird_Sources_Group {

	/**
	 * @var string scripts|styles
	 */
	private $type = '';

	/**
	 * If the group has to be minified
	 *
	 * @var bool
	 */
	private $minify = false;

	/**
	 * If the group has to be combined in a single file
	 *
	 * @var bool
	 */
	private $combine = false;

	/**
	 * Extras like conditionals, who knows
	 *
	 * @var array
	 */
	private $extras = array();

	/**
	 * Enqueues handles IDs,
	 * not the same that WP_Hummingbird_Sources_Group::$sources
	 *
	 * @var array of slugs
	 */
	private $handles = array();

	/**
	 * Array of sources
	 *
	 * Each source has information about version, slug and src
	 *
	 * @var array
	 */
	private $sources = array();

	/**
	 * Only applied for styles, normally is empty or 'all'
	 *
	 * @var string
	 */
	private $media = '';

	/**
	 * The group source URL
	 *
	 * This file has all styles/scripts compressed and combined
	 * By default is empty, must be set manually
	 *
	 * @var string
	 */
	private $group_src = '';

	/**
	 * The group handles that are external sources
	 *
	 * @var array
	 */
	private $externals = array();

	/**
	 * The group position (header|footer)
	 *
	 * @var string
	 */
	private $position = '';


	public function __construct( $type, $handles, $extras = array() ) {
		$this->type = $type;

		// Extract media from extras, put it aside
		if ( isset( $extras['media'] ) ) {
			$this->media = $extras['media'];
			unset( $extras['media'] );
		}

		$this->extras = $extras;

		$this->handles = $handles;
	}

	/**
	 * Add a new source to sources list based on the slug name
	 *
	 * @param $handle
	 */
	public function add_source( $handle ) {

		// Get $wp_styles or $wp_scripts globals
		$wp_sources = $this->get_wp_sources();
		if ( $wp_sources === false )
			return;

		// Get registered dependencies
		$registered = $wp_sources->registered;

		// And create a new source
		$source = array(
			'handle' => $handle,
			'src' => $registered[ $handle ]->src,
			'ver' => $registered[ $handle ]->ver,
		);

		$this->sources[] = $source;
	}

	public function remove_source( $handle ) {
		$wp_sources = $this->get_wp_sources();
		if ( $wp_sources === false )
			return;

		foreach ( $this->get_sources() as $key => $source ) {
			if ( $source['handle'] == $handle ) {
				unset( $this->sources[ $key ] );
				break;
			}
		}
	}

	/**
	 * Return $wp_styles|$wp_scripts WP globals
	 * based on the source group type
	 *
	 * @return false|WP_Scripts|WP_Styles
	 */
	public function get_wp_sources() {
		if ( 'styles' == $this->type ) {
			global $wp_styles;
			return $wp_styles;
		}
		elseif ( 'scripts' == $this->type ) {
			global $wp_scripts;
			return $wp_scripts;
		}
		else {
			return false;
		}
	}

	/**
	 * Set if the group must be minified or not
	 *
	 * @param bool $minify
	 */
	public function set_must_minify( $minify ) {
		$this->minify = $minify;
	}

	/**
	 * Set if the group must be minified or not
	 *
	 * @param bool $combine
	 */
	public function set_must_combine( $combine ) {
		$this->combine = $combine;
	}

	/**
	 * Set the source position (header|footer)
	 *
	 * @param string $position
	 */
	public function set_position( $position ) {
		$this->position = $position;
	}


	/**
	 * Get the source position (header|footer)
	 *
	 * @return string
	 */
	public function get_position() {
		return $this->position;
	}


	/**
	 * Set the external handles for this group
	 *
	 * @param array $externals List of external handles for this group
	 */
	public function set_externals( $externals ) {
		$this->externals = $externals;
	}

	/**
	 * Get the external handles for this group
	 */
	public function get_externals() {
		return $this->externals;
	}

	/**
	 * Check if a handle inside this group is an external resource
	 *
	 * @param string $handle Source handle to check
	 *
	 * @return bool
	 */
	public function is_external( $handle ) {
		return in_array( $handle, $this->get_externals() );
	}

	/**
	 * Return if the group must be minified or not
	 *
	 * @return bool
	 */
	public function must_minify() {
		return $this->minify;
	}

	/**
	 * Return if the group must be combined or not
	 *
	 * @return bool
	 */
	public function must_combine() {
		return $this->combine;
	}

	/**
	 * Return the sources array
	 *
	 * @return array
	 */
	public function get_sources() {
		return $this->sources;
	}

	/**
	 * Return only the Sources URLs
	 *
	 * @return array
	 */
	public function get_sources_srcs() {
		$srcs = array();
		foreach ( $this->sources as $source ) {
			$srcs[ $source['handle'] ] = $source['src'];
		}
		return $srcs;
	}

	/**
	 * Return the dependencies slug names array
	 *
	 * @return array
	 */
	public function get_handles() {
		return $this->handles;
	}

	/**
	 * Return the group extras array
	 *
	 * @return array
	 */
	public function get_extras() {
		return ! empty( $this->extras ) && is_array( $this->extras ) ? $this->extras : array();
	}

	/**
	 * Get the original size given a source handle for this group
	 *
	 * @param $handle
	 *
	 * @return bool|int Size in bytes
	 */
	public function get_original_size( $handle ) {
		$info = $this->get_cache_info();
		if ( isset( $info['original_sizes'][ $handle ] ) )
			return $info['original_sizes'][ $handle ];

		return false;
	}

	/**
	 * Get the compressed size given a source handle for this group
	 *
	 * @param $handle
	 *
	 * @return bool|int Size in bytes
	 */
	public function get_compressed_size( $handle ) {
		$info = $this->get_cache_info();
		if ( isset( $info['compressed_sizes'][ $handle ] ) )
			return $info['compressed_sizes'][ $handle ];

		return false;
	}

	public function set_localization_data() {
		$wp_sources = $this->get_wp_sources();
		$this->extras['data'] = '';

		foreach ( $this->get_handles() as $handle ) {
			if ( ! isset( $wp_sources->registered[ $handle ]->extra['data'] ) )
				continue;

			$this->extras['data'] .= $wp_sources->registered[ $handle ]->extra['data'];
		}

	}

	/**
	 * Return the media type
	 *
	 * Only apply for styles
	 *
	 * @return string
	 */
	public function get_media() {
		return $this->media;
	}

	/**
	 * Get group type
	 *
	 * @return string scripts|styles
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * Return the sources hash
	 *
	 * Useful to make a cached file
	 *
	 * @return string
	 */
	public function get_srcs_hash() {
		return self::get_hash( $this->get_sources_srcs() );
	}

	/**
	 * Return the sources versions hash
	 *
	 * Useful to compare versions
	 *
	 * @return string
	 */
	public function get_versions_hash() {
		return self::get_hash( wp_list_pluck( $this->sources, 'ver' ) );
	}

	/**
	 * Get info about this group
	 *
	 * We save this info in wp_options table
	 * It includes info about version, expiration, hashes...
	 *
	 * @return false|array
	 */
	public function get_cache_info() {
		return get_option( $this->get_cache_key() );
	}

	public function get_cache_key() {
		$key = 'wphb';
		$key .= $this->must_minify() ? '-min-' : '-';
		$key .= $this->type . '-' . $this->get_srcs_hash();
		return $key;
	}

	/**
	 * Cache info about this group
	 *
	 * @param array $info New cache data
	 *
	 * @return array|false
	 */
	public function update_cache_info( $info ) {
		return update_option( $this->get_cache_key(), $info );
	}

	public function delete_cache_info() {
		delete_option( $this->get_cache_key() );
	}

	public function delete_cache_file() {
		wphb_include_file_cache_class();
		$cache_file = new WP_Hummingbird_Cache_File( $this->get_srcs_hash(), $this->type );
		$cache_file->delete();
	}


	/**
	 * Enqueue the new group (only one file)
	 *
	 * @param string $new_handle new dependency slug
	 * @param bool $in_footer if must be enqueued on footer
	 */
	public function enqueue( $new_handle, $in_footer ) {
		if ( 'scripts' == $this->type ) {
			wp_enqueue_script( $new_handle, $this->get_group_src(), array(), null, $in_footer );
		}
		elseif ( 'styles' == $this->type ) {
			wp_enqueue_style( $new_handle, $this->get_group_src(), array(), null, $this->get_media() );
		}

		$wp_sources = $this->get_wp_sources();
		if ( false === $wp_sources )
			return;

		// If there's any localization data for this script, set it up now
		$this->set_localization_data();

		// Add extras to the dependency
		foreach ( $this->get_extras() as $extra_key => $extra_value ) {
			$wp_sources->add_data( $new_handle, $extra_key, $extra_value );
		}

		// @TODO: Maybe set group???

		// Mark all handles as done so WP does not enqueue them by itself
		foreach ( $this->get_handles() as $handle ) {
			$wp_sources->done[] = $handle;
		}
		$wp_sources->done[] = $new_handle;
	}

	/**
	 * Set the new group URL
	 *
	 * @param string $group_src
	 */
	public function set_group_src( $group_src ) {
		$this->group_src = $group_src;
	}

	/**
	 * Get the new group URL
	 *
	 * @return string
	 */
	public function get_group_src() {
		return $this->group_src;
	}

	/**
	 * Try to minify the group into one single file
	 *
	 * @return string|WP_Error return the new group URL or WP_Error if something fails
	 */
	public function process_group() {
		/** @var WP_Hummingbird_Module_Minify $minification_module */
		$minification_module = wphb_get_module( 'minify' );

		if ( 'scripts' === $this->type )
			require_once( 'class-jshrink-minifier.php' );
		elseif ( 'styles' === $this->type )
			require_once( 'class-css-compressor.php' );
		else
			return new WP_Error( 'wphb', __( 'Minification Error: Incorrect type for the group', 'wphb' ) );

		$original_sizes = array();
		$compressed_sizes = array();

		$group_original_size = 0;
		$srcs = $this->get_sources_srcs();
		$contents = array();
		$errors = array();
		$css_imports = array();

		WP_Hummingbird_Module_Minify::log( "Processing Group : " . $this->get_cache_key() );

		foreach ( $srcs as $handle => $src ) {
			if ( ! $src )
				continue;

			// Get the full URL
			if ( ! preg_match( '|^(https?:)?//|', $src ) ) {
				$src = site_url( $src );
			}

			$content = false;
			$is_local = ! $this->is_external( $handle );

			if ( $is_local ) {
				$path = wphb_src_to_path( $src );
				if ( is_file( $path ) ) {
					$content = file_get_contents( $path );
				}
			}

			if ( false === $content ) {
				WP_Hummingbird_Module_Minify::log( "Content empty, trying remote HTTP" );
				// Try to get the file remotely
				if ( ! preg_match( '/^http:/', $src ) ) {
					// Rooted URL
					$src = 'http:' . $src;
				}
				$request = wp_remote_get( $src, array( 'sslverify' => false ) );
				$content = wp_remote_retrieve_body( $request );
				if ( is_wp_error( $request ) ) {
					WP_Hummingbird_Module_Minify::log( $request->get_error_message() );
				} elseif ( wp_remote_retrieve_response_code( $request ) !== 200 ) {
					WP_Hummingbird_Module_Minify::log( "Code different from 200. Truncated content:" );
					WP_Hummingbird_Module_Minify::log( substr( $content, 0, 1000 ) );
				}

			}

			// If nothing worked do not minify and do not combine file
			if ( empty( $content ) ) {
				WP_Hummingbird_Module_Minify::log( "Empty Content detected, do not process" );
				$minification_module->errors_controller->add_error( $handle, $this->type, 'empty-content', __( 'It looks like this file is empty or there was an error trying to get its content.', 'wphb' ), array( 'minify', 'combine' ) );
				continue;
			}
			else {
				$minification_module->errors_controller->clear_handle_error( $handle, $this->type );
			}

			$original_file_size = absint( mb_strlen( $content ) );
			$original_sizes[ $handle ] = $original_file_size;
			$group_original_size += $original_file_size;

			// Remove BOM
			$content = preg_replace( "/^\xEF\xBB\xBF/", '', $content );

			// Concatenate and minify scripts/styles!
			if ( 'scripts' === $this->type ) {
				WP_Hummingbird_Module_Minify::log( "Minify script" );
				include_once( 'class-jshrink-minifier.php' );
				if ( $this->must_minify() ) {
					try {
						$content = WP_Hummingbird_JShrink_Minifier::minify( $content );
					}
					catch ( Exception $e ) {
						WP_Hummingbird_Module_Minify::log( "Minification failed: " . $e->getMessage() );
						$minification_module->errors_controller->add_error( $handle, $this->type, 'shrink-error', sprintf( __( 'Javascript compression failed: %s', 'wphb' ), $e->getMessage() ), array( 'minify', 'combine' ) );
						continue;
					}

					$minification_module->errors_controller->clear_handle_error( $handle, $this->type );
				}
			}
			elseif ( 'styles' === $this->type ) {
				WP_Hummingbird_Module_Minify::log( "Minify style" );
				if ( $is_local ) {
					$content = self::replace_relative_urls( dirname( $path ), $content );
				}

				if ( preg_match_all( '/(?<fullImport>@import\s?.*?;)/', $content, $matches ) ) {
					// We need to find @import directives
					if ( isset( $matches['fullImport'] ) ) {
						foreach ( $matches['fullImport'] as $match ) {
							$content = str_replace( $match, '', $content );
							$css_imports[] = $match;
						}

					}
				}

				include_once( 'class-css-compressor.php' );
				if ( $this->must_minify() ) {
					$content = WP_Hummingbird_CSS_Compressor::minify( $content );
				}
			}

			if ( empty( $content ) ) {
				WP_Hummingbird_Module_Minify::log( "Empty content after minification" );
				// Something happened to compression
				$minification_module->errors_controller->add_error( $handle, $this->type, 'after-compression', __( 'Minification failed.', 'wphb' ), array( 'minify', 'combine' ) );
			}
			else {
				$minification_module->errors_controller->clear_handle_error( $handle, $this->type );
				$compressed_sizes[ $handle ] = mb_strlen( $content );
				$contents[] = $content;
			}

		}

		unset( $content );

		if ( 'scripts' === $this->type ) {
			$contents = join( "\n;;\n", $contents );
		}
		elseif ( 'styles' === $this->type ) {
			$contents = join( "\n\n", $contents );
			if ( ! empty( $css_imports ) ) {
				// Put the imports on top
				$contents = implode( ';', $css_imports ) . $contents;
			}
		}

		if ( empty( $contents ) ) {
			WP_Hummingbird_Module_Minify::log( "Empty content after combine" );
			$minification_module->errors_controller->add_error( $this->get_handles(), $this->type, 'empty-content', __( 'It looks like this file is empty or there was an error trying to get its content.', 'wphb' ), array( 'minify', 'combine' ) );
		}
		else {
			WP_Hummingbird_Module_Minify::log( "Handles:" );
			WP_Hummingbird_Module_Minify::log( $this->get_handles() );
			// Put new contents in file
			$contents = '/** handles (' . $this->type . ') :' . join( ' | ', $this->get_handles() ) . '  */' . $contents;
			wphb_include_file_cache_class();
			$cache_file = new WP_Hummingbird_Cache_File( $this->get_srcs_hash(), $this->type );
			$result = $cache_file->save( $contents );

			if ( ! $result ) {
				$minification_module->errors_controller->add_error( array_keys( $srcs ), $this->type, 'file-save', __( 'Error saving compressed file', 'wphb' ), array( 'minify', 'combine' ) );
			}
			else {
				$minification_module->errors_controller->clear_handle_error( array_keys( $srcs ), $this->type );

				$options = wphb_get_settings();
				$expire_on = $options['file_age'] + time();

				$this->set_group_src( $cache_file->get_src() );

				$cache_info = array(
					'expires' => $expire_on,
					'ver_hash' => $this->get_versions_hash(),
					'src' => $this->get_group_src(),
					'last_modified' => current_time( 'timestamp' ),
					'compressed_sizes' => $compressed_sizes,
					'original_sizes' => $original_sizes
				);

				$this->update_cache_info( $cache_info );

				return $cache_file->get_src();
			}
		}

		return false;
	}

	/**
	 * General purpose function. Returns an array hashed
	 *
	 * @param array $list Array of strings
	 *
	 * @return string
	 */
	public static function get_hash( $list ) {
		return md5( maybe_serialize( $list ) );
	}


	public static function replace_relative_urls( $file_url, $css_content ) {
		return WP_Hummingbird_CSS_UriRewriter::rewrite( $css_content, $file_url );
	}

	/**
	 * The @import directive may casue troubles when is not at the top of the stylesheet
	 *
	 * @param $css
	 *
	 * @return mixed
	 */
	public static function move_imports_to_top( $css ) {
		return $css;
	}

	public static function _replace_relative_url( $match ) {

	}

}