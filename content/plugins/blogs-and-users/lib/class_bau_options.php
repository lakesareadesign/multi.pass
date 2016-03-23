<?php
/**
 * Handles options access.
 */
class Bau_Options {
	/**
	 * Gets a single option from options storage.
	 */
	function get_option ($key) {
		$opts = get_site_option('bau');
		return @$opts[$key];
	}

	/**
	 * Sets all stored options.
	 */
	function set_options ($opts) {
		return update_site_option('bau', $opts);
	}

}