<?php
/**
 * Customizer Sanization
 *
 * @package FeastcoCustomizer
 */

/**
 * Sanitize a value from a list of allowed values.
 *
 * @since 1.0.0.
 *
 * @param  mixed    $value      The value to sanitize.
 * @param  mixed    $setting    The setting for which the sanitizing is occurring.
 * @return mixed                The sanitized value.
 */
function feastco_customizer_sanitize_choices( $value, $setting ) {
	if ( is_object( $setting ) ) {
		$setting = $setting->id;
	}

	$choices = feastco_customizer_get_choices( $setting );
	$allowed_choices = array_keys( $choices );

	if ( ! in_array( $value, $allowed_choices ) ) {
		$value = feastco_customizer_get_default( $setting );
	}

	return $value;
}

/**
 * Sanitize the url of uploaded media.
 *
 * @since 1.0.0.
 *
 * @param  string    $value      The url to sanitize
 * @return string    $output     The sanitized url.
 */
function feastco_customizer_sanitize_file_url( $url ) {
	$output = '';

	$filetype = wp_check_filetype( $url );
	if ( $filetype['ext'] ) {
		$output = esc_url_raw( $url );
	}

	return $output;
}

/**
 * Sanitizes a hex color.
 *
 * Returns either '', a 3 or 6 digit hex color (with #), or null.
 * For sanitizing values without a #, see sanitize_hex_color_no_hash().
 *
 * @since 3.4.0
 *
 * @param string $color
 * @return string|null
 */
function feastco_customizer_sanitize_hex_color( $color ) {
	if ( function_exists( 'sanitize_hex_color' ) ) {
		return sanitize_hex_color( $color );
	}

	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}

/**
 * Sanitizes a range value
 *
 * @since 1.3.0
 *
 * @param string $color
 * @return string|null
 */
function feastco_customizer_sanitize_range( $value ) {
	if ( is_numeric( $value ) ) {
		return $value;
	}

	return 0;
}

/**
 * Get default sanitization function for option type
 *
 * @since  1.2.0.
 *
 * @param  array $option
 *
 * @return void
 */
function feastco_customizer_get_sanitization( $type ) {
	if ( 'select' === $type || 'radio' === $type ) {
		return 'feastco_customizer_sanitize_choices';
	}

	if ( 'dropdown-pages' === $type || 'checkbox' === $type ) {
		return 'absint';
	}

	if ( 'color' === $type ) {
		return 'feastco_customizer_sanitize_hex_color';
	}

	if ( 'upload' === $type || 'image' === $type ) {
		return 'feastco_customizer_sanitize_file_url';
	}

	if ( 'text' === $type || 'textarea' === $type ) {
		return 'wp_kses_post';
	}

	if ( 'url' === $type ) {
		return 'esc_url';
	}

	if ( 'range' === $type ) {
		return 'feastco_customizer_sanitize_range';
	}

	return false;
}
