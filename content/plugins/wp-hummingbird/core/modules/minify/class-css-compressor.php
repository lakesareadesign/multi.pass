<?php


class WP_Hummingbird_CSS_Compressor {

	/**
	 * Code based on:
	 * 	Reinhold Weber's compression method (source: )
	 * 	Manas Tungare's compression method (source: https://gist.github.com/2625128)
	 * @param  string $buffer Raw CSS
	 * @return string Compressed CSS
	 */
	public static function minify( $buffer ) {
		// Let's normalize the non-breaking spaces first
		$buffer = preg_replace('/\xA0/u', ' ', $buffer);

		/* remove comments */
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);	  	 	   	 		 		 		 	

		/* remove tabs, spaces, newlines, etc. */
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '   ', '    '), ' ', $buffer); // Actually, replace them with single space

		/* Whitespaces cleanup */
		// We need this because fixing the issue with the previous statement (dropping whitespace that killed selectors too)
		// leaves way too much whitespace that we know we don't need
		$buffer = preg_replace('/\s+/', ' ', $buffer); // Collapse spaces
		$buffer = preg_replace('/\s(\{|\})/', '$1', $buffer); // Drop leading spaces surrounding braces
		$buffer = preg_replace('/(\{|\})\s/', '$1', $buffer); // Drop trailing spaces surrounding braces
		$buffer = preg_replace('/(\s;|;\s)/', ';', $buffer); // Drop spaces surrounding semicolons, leading or trailing

		// Remove space after colons
		//$buffer = str_replace(': ', ':', $buffer); // Actually, let's not >.<
		// This will wreak havoc on selectors

		return $buffer;
	}
}