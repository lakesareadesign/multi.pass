<?php

/**
 * @group scan
 * @author: Hoang Ngo
 */
class AutoScan extends WP_UnitTestCase {
	public function test_search() {
		$controller = wp_defender()->global['controllers']['scan'];
		//update data
		WD_Utils::update_setting( 'scan->schedule', array(
			'email'     => 'admin@admin.com',
			'frequency' => '1',
			'day'       => 'monday',
			'time'      => '4:00',
		) );
		//test ready for daily scan
		//assume that this is 2:00 and we havent run , this should return false
		$current = mktime( 02, 00, '00', date( 'm' ), date( 'd' ), date( 'Y' ) );
		//last run will be yesterday
		$last_run = date( 'Y-m-d', strtotime( '-1 day' ) );
		$this->assertFalse( $controller->is_on_time( $current, $last_run ) );
		WD_Utils::update_setting( 'scan->schedule', array(
			'email'     => 'admin@admin.com',
			'frequency' => '1',
			'day'       => 'monday',
			'time'      => '4:00',
		) );
		//test ready for daily scan
		//assume that this is 2:00 and we havent run , this should return false
		$current = mktime( 04, 01, '00', date( 'm' ), date( 'd' ), date( 'Y' ) );
		//last run will be yesterday
		$last_run = date( 'Y-m-d', strtotime( '-1 day' ) );
		$this->assertTrue( $controller->is_on_time( $current, $last_run ) );
		////
		WD_Utils::update_setting( 'scan->schedule', array(
			'email'     => 'admin@admin.com',
			'frequency' => '7',
			'day'       => 'monday',
			'time'      => '4:00',
		) );
		//test for weekly scan
		$current = mktime( 02, 00, '00', date( 'm', strtotime( 'monday this week' ) ), date( 'd', strtotime( 'monday this week' ) ), date( 'Y' ) );
		//last run will be in Friday last week
		$last_run = date( 'Y-m-d', strtotime( 'last friday' ) );
		//still get the time yet
		$this->assertFalse( $controller->is_on_time( $current, $last_run ) );
		//now we will try as 04:01 this monday
		$current = mktime( 04, 01, '00', date( 'm', strtotime( 'monday this week' ) ), date( 'd', strtotime( 'monday this week' ) ), date( 'Y' ) );
		//echo date('Y-m-d H:i:s',$current);
		$this->assertTrue( $controller->is_on_time( $current, $last_run ) );
		//this case last scan will be on this week
		$last_run = date( 'Y-m-d', strtotime( 'wednesday this week' ) );
		$current  = strtotime( 'friday this week' );
		//the last run already done, so this should be false
		$this->assertFalse( $controller->is_on_time( $current, $last_run ) );
		//monthly scan
		WD_Utils::update_setting( 'scan->schedule', array(
			'email'     => 'admin@admin.com',
			'frequency' => '30',
			'day'       => 'monday',
			'time'      => '4:00',
		) );
		$current = mktime( 04, 01, '00', date( 'm', strtotime( 'monday this week' ) ), date( 'd', strtotime( 'monday this week' ) ), date( 'Y' ) );
		//last run will be in random day last month
		$last_run = date( 'Y-m-d', mktime( 02, 00, 00, date( 'm', strtotime( '-1 month' ) ), rand( 1, 29 ), date( 'Y' ) ) );
		//should return true
		$this->assertTrue( $controller->is_on_time( $current, $last_run ) );
	}
}