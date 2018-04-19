<?php
/**
 * shortcodes class
 *
 * @since 1.7
 */
final class FLThemeShortcodes {

	/**
	 * Add shortcodes available in theme.
	 */
	static public function init() {
		add_shortcode( 'fl_year', array( 'FLThemeShortcodes', 'fl_year_callback' ) );
	}

	/**
	 * Year shortcode.
	 */
	static function fl_year_callback( $atts ) {

		$atts = shortcode_atts( array(
			'format' => 'Y',
		), $atts );

		return date( $atts['format'] );
	}

}
FLThemeShortcodes::init();
