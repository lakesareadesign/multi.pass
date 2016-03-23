<?php

/**
 * @group init
 */
class Test_Init extends WP_Hummingbird_UnitTestCase {

	function test_init_plugin() {
		// replace this with some actual testing code
		$this->assertInstanceOf( 'WP_Hummingbird_Core', wp_hummingbird()->core );

		global $wpdb;
		$table = $wpdb->prefix . 'minification_chart';
		$result = $wpdb->get_var( "SHOW TABLES LIKE '$table'");
		$this->assertEquals( $table, $result );

		$this->assertNotEmpty( get_site_option( 'wphb_version' ) );
	}
}
