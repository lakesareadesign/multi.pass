<?php

/**
 * Helper class for font settings.
 *
 * @class FLFonts
 */
final class FLFonts {

	/**
	 * @method json
	 */
	static public function js() {
		$system = json_encode( FLFontFamilies::get_system() );
		$google = json_encode( FLFontFamilies::get_google() );

		echo 'var FLFontFamilies = { system: ' . $system . ', google: ' . $google . ' };';
	}

	/**
	 * @method display_select_options
	 */
	static public function display_select_options( $selected ) {
		echo '<optgroup label="System">';

		foreach ( FLFontFamilies::get_system() as $name => $variants ) {
			echo '<option value="' . $name . '" ' . selected( $name, $selected ) . '>' . $name . '</option>';
		}

		echo '<optgroup label="Google">';

		foreach ( FLFontFamilies::get_google() as $name => $variants ) {
			echo '<option value="' . $name . '" ' . selected( $name, $selected ) . '>' . $name . '</option>';
		}
	}
}

/**
 * Font info class for system and Google fonts.
 *
 * @class FLFontFamilies
 */
final class FLFontFamilies {

	/**
	 * @property system
	 */
	static public $system = array(
		'Helvetica' => array(
			'fallback' => 'Verdana, Arial, sans-serif',
			'weights'  => array(
				'300',
				'400',
				'700',
			),
		),
		'Verdana' => array(
			'fallback' => 'Helvetica, Arial, sans-serif',
			'weights'  => array(
				'300',
				'400',
				'700',
			),
		),
		'Arial' => array(
			'fallback' => 'Helvetica, Verdana, sans-serif',
			'weights'  => array(
				'300',
				'400',
				'700',
			),
		),
		'Times' => array(
			'fallback' => 'Georgia, serif',
			'weights'  => array(
				'300',
				'400',
				'700',
			),
		),
		'Georgia' => array(
			'fallback' => 'Times, serif',
			'weights'  => array(
				'300',
				'400',
				'700',
			),
		),
		'Courier' => array(
			'fallback' => 'monospace',
			'weights'  => array(
				'300',
				'400',
				'700',
			),
		),
	);

	/**
	 * @method get_system
	 */
	static function get_system() {
		return apply_filters( 'fl_theme_system_fonts', FLFontFamilies::$system );
	}

	/**
	 * @method get_google
	 */
	static function get_google() {
		$fonts = array();
		$json = (array) json_decode( file_get_contents( trailingslashit( FL_THEME_DIR ) . 'json/fonts.json' ), true );

		foreach ( $json as $k => $font ) {

			$name = key( $font );

			foreach ( $font[ $name ] as $key => $variant ) {
				if ( stristr( $variant, 'italic' ) ) {
							unset( $font[ $name ][ $key ] );
				}
				if ( 'regular' == $variant ) {
					$font[ $name ][ $key ] = '400';
				}
			}

			$fonts[ $name ] = array_values( $font[ $name ] );
		}
		return apply_filters( 'fl_theme_google_fonts', $fonts );
	}

}
