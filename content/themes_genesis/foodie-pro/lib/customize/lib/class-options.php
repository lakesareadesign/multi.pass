<?php
/**
 * The customizer library options class.
 *
 * @package FeastcoCustomizer
 */

/**
 * Class wrapper with useful methods for interacting with the theme customizer.
 */
class Feastco_Customizer_Options {
	/**
	 * The array for storing $options.
	 *
	 * @since 1.0.0.
	 * @var   array Holds the options array.
	 */
	private static $options = array();

	public static function add_options( $options = array() ) {
		self::$options = array_merge_recursive( $options, self::$options );
	}

	public static function get_options() {
		$options = self::$options;

		if ( empty( $options ) ) {
			return false;
		}

		return $options;
	}

	public static function get_option( $option ) {
		$options = self::$options;

		if ( ! isset( $options[ $option ] ) ) {
			return false;
		}

		return $options[ $option ];
	}
}
