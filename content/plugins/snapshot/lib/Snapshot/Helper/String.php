<?php

/**
 * String helper class
 */
class Snapshot_Helper_String {

	/**
	 * Converts name to something not as easily guessable
	 *
	 * @param string $string Base name to use
	 *
	 * @return string
	 */
	public static function conceal ($string) {
		if (empty($string)) return false;

		$base = pathinfo($string, PATHINFO_FILENAME);
		$ext = pathinfo($string, PATHINFO_EXTENSION);

		$out = bin2hex(self::_apply_codec($base));
		if (!empty($ext)) $out .= '.' . $ext;

		return $out;
	}

	/**
	 * Converts encoded name back to base.
	 *
	 * Reverse of `conceal`
	 *
	 * @param string $string Name to revert
	 *
	 * @return string
	 */
	public static function reveal ($string) {
		if (empty($string)) return false;

		$name = pathinfo($string, PATHINFO_FILENAME);
		$ext = pathinfo($string, PATHINFO_EXTENSION);

		$out = self::_apply_codec(hex2bin($name));
		if (!empty($ext)) $out .= '.' . $ext;

		return $out;
	}

	/**
	 * Key generation helper
	 *
	 * @return string
	 */
	private static function _get_key () {
		$key = '';
		if (defined('NONCE_KEY')) $key .= NONCE_KEY;
		$key .= SNAPSHOT_I18N_DOMAIN;
		if (defined('NONCE_SALT')) $key .= NONCE_SALT;

		return sha1($key);
	}

	/**
	 * Apply codec to a string
	 *
	 * @param string $string Target string
	 *
	 * @return string
	 */
	private static function _apply_codec ($string) {
		if (empty($string)) return $string;

		$key = self::_get_key();
		if (empty($key)) return $string;

		$out = '';
		for ($i=0; $i<strlen($string); $i++) {
			$out .= $string[$i] ^ $key;
		}

		return $out;
	}
}

if ( !function_exists( 'hex2bin' ) ) {
	/**
	 * Fallback implementation for old setups
	 *
	 * @param string $str Hexadecimal representation of data
	 *
	 * @return mixed Binary representation of the given data, or (bool)false on failure
	 */
	function hex2bin( $str ) {
		$sbin = "";
		$len = strlen( $str );
		for ( $i = 0; $i < $len; $i += 2 ) {
			$sbin .= pack( "H*", substr( $str, $i, 2 ) );
		}

		return $sbin;
	}
}