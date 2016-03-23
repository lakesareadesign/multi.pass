<?php


/**
 * @group helpers
 */
class Test_Helpers extends WP_Hummingbird_UnitTestCase {

	function test_wphb_human_read_time_diff() {
		$this->assertEquals( '1 second', wphb_human_read_time_diff( 1 ) );
		$this->assertEquals( '15 seconds', wphb_human_read_time_diff( 15 ) );
		$this->assertEquals( '1 minute', wphb_human_read_time_diff( 60 ) );
		$this->assertEquals( '1 minute', wphb_human_read_time_diff( 65 ) );
		$this->assertEquals( '2 minutes', wphb_human_read_time_diff( 130 ) );
		$this->assertEquals( '59 minutes', wphb_human_read_time_diff( 3599 ) );
		$this->assertEquals( '1 hour', wphb_human_read_time_diff( 3600 ) );
		$this->assertEquals( '1 hour', wphb_human_read_time_diff( 3700 ) );
		$this->assertEquals( '1 day', wphb_human_read_time_diff( 3600 * 24 ) );
		$this->assertEquals( '2 days', wphb_human_read_time_diff( 3600 * 48 ) );
		$this->assertEquals( '1 month', wphb_human_read_time_diff( 3600 * 24 * 31 ) );
		$this->assertEquals( '3 months', wphb_human_read_time_diff( 3600 * 24 * 31 * 3 ) );
		$this->assertEquals( '1 year', wphb_human_read_time_diff( 3600 * 24 * 31 * 12 ) );
		$this->assertEquals( '2 years', wphb_human_read_time_diff( 3600 * 24 * 31 * 12 * 2 ) );
	}
}