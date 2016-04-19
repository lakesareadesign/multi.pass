<?php

/**
 * Class WP_Hummingbird_Cache_File
 *
 * Manages a cached file in WP Hummingbird
 */
class WP_Hummingbird_Cache_File {

	public function __construct( $filename, $type ) {
		$this->filename = $filename;
		$this->type = $type;

		$this->path = self::get_base_path() . $this->filename . $this->get_extension();
		$this->src = self::get_base_url() . $this->filename . $this->get_extension();
	}


	public static function get_base_path() {
		$upload_dir = wp_upload_dir();
		return apply_filters( 'wphb_cache_dir', $upload_dir['basedir'] . '/wp-hummingbird-cache/' );
	}

	public static function get_base_url() {
		$upload_dir = wp_upload_dir();
		$url = set_url_scheme( $upload_dir['baseurl'] );
		return apply_filters( 'wphb_cache_url', $url . '/wp-hummingbird-cache/' );
	}

	/**
	 * Save the compressed content to a new cached file
	 *
	 * @param string $new_content
	 *
	 * @return false|string
	 */
	public function save( $new_content ) {
		// Try to write the file
		$result = file_put_contents( $this->get_path() , $new_content );

		if ( $result ) {
			// Success! let's return the new cache file URL
			return $this->get_src();
		}

		// No luck
		return $result;
	}

	public function delete() {
		@unlink( $this->get_path() );
	}


	public function get_size() {
		return filesize( $this->get_path() );
	}

	public function is_file() {
		return is_file( $this->get_path() );
	}

	public function get_contents() {
		return file_get_contents( $this->get_path() );
	}

	public function get_path() {
		return $this->path;
	}

	public function get_src() {

		if ( is_file( $this->get_path() ) )
			return $this->src;

		return false;
	}

	public function get_extension() {
		return 'styles' === $this->type ? '.css' : '.js';
	}

	/**
	 * Clear all cache files
	 *
	 * If is a multisite, $blog_id will specify which blog_id cache folder
	 * we should clear
	 *
	 */
	public static function clear_files() {
		$cache_files_dir = trailingslashit( self::get_base_path() );
		$files = array_merge( glob("$cache_files_dir*.js"), glob("$cache_files_dir*.css") );
		foreach ( $files as $file ) {
			@unlink( $file );
		}
	}

	/**
	 * Try to create the cache folder
	 * @return bool
	 */
	public static function create_cache_folder() {
		// Try to create an empty index.html in cache folder
		$created = self::create_index_file();

		return $created;
	}

	public static function create_index_file() {
		$cache_dir = wphb_get_cache_dir();
		$index_file = $cache_dir . 'index.html';

		$created = false;
		if ( wp_mkdir_p( $cache_dir ) && ! file_exists( $index_file ) ) {
			if ( $fh = @fopen( $index_file, 'w' ) ) {
				fwrite( $fh, '' );
				fclose( $fh );
				$created = true;
			}
		}

		return $created;
	}

	public static function is_cache_folder_created() {
		$cache_dir = wphb_get_cache_dir();
		$index_file = $cache_dir . 'index.html';

		if ( is_dir( $cache_dir ) ) {
			if ( ! file_exists( $index_file ) ) {
				self::create_index_file();
			}

			return true;
		}

		return false;
	}


}