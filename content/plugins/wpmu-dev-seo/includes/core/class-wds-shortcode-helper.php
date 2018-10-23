<?php

class Smartcrawl_Shortcode_Helper {
	/**
	 * @var Smartcrawl_Shortcode_Helper
	 */
	private static $_instance;
	/**
	 * @var array
	 */
	private $cache;

	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public static function do_shortcode( $string ) {
		$string = trim( $string );
		if (
			empty( $string )
			|| false === strpos( $string, '[' )
		) {
			return $string;
		}

		$me = self::get();
		$processed = $me->get_cached( $string );
		if ( $processed === null ) {
			$processed = $me->safe_do_shortcode( $string );
			$me->add_to_cache( $string, $processed );
		}

		return $processed;
	}

	public static function purge_cache() {
		$me = self::get();
		$me->cache = array();
	}

	private function get_cached( $string ) {
		return smartcrawl_get_array_value( $this->cache, $this->key( $string ) );
	}

	private function add_to_cache( $raw, $processed ) {
		$this->cache[ $this->key( $raw ) ] = $processed;
	}

	private function key( $string ) {
		return md5( trim( $string ) );
	}

	/**
	 * Expands shortcodes without enqueuing any resources
	 */
	function safe_do_shortcode( $string ) {
		$original_styles = $GLOBALS['wp_styles'];
		$original_scripts = $GLOBALS['wp_scripts'];

		$GLOBALS['wp_styles'] = new WP_Styles();
		$GLOBALS['wp_scripts'] = new WP_Scripts();

		$processed = do_shortcode( $string );

		$GLOBALS['wp_styles'] = $original_styles;
		$GLOBALS['wp_scripts'] = $original_scripts;

		return $processed;
	}
}