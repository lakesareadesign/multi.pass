<?php

/**
 * @author: Hoang Ngo
 */
Class Hardener_Test extends WP_UnitTestCase {
	function __construct() {
		$files = WD_Utils::scan_dir( wp_defender()->get_plugin_path() . 'app/component/hardener/' );
		foreach ( $files as $file ) {
			include_once $file;
		}
	}

	function test_load() {

	}
}