<?php
$_tests_dir = '/tmp/wordpress-tests-lib';


require_once $_tests_dir . '/includes/functions.php';

function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/wp-hummingbird.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . '/includes/bootstrap.php';


class WP_Hummingbird_UnitTestCase extends WP_UnitTestCase {}

class WP_Hummingbird_Multisite_UnitTestCase extends WP_UnitTestCase {
	protected $suppress = false;

	function setUp() {
		global $wpdb;
		parent::setUp();
		$this->suppress = $wpdb->suppress_errors();
	}

	function tearDown() {
		global $wpdb;
		$wpdb->suppress_errors( $this->suppress );
		parent::tearDown();
	}
}