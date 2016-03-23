<?php
include_once dirname( __DIR__ ) . '/test-hardener.php';

/**
 * @author: Hoang Ngo
 */
class WPPrefixTest extends Hardener_Test {
	function test_prefix() {
		$test = new WD_DB_Prefix();
		//revert all back
		$prefix      = 'abc_';
		$config_path = "/tmp/wordpress-tests-lib/wp-tests-config.php";
		global $wpdb;

		if ( $wpdb->base_prefix != 'wptests_' ) {
			//revert it back
			$test->update_table_prefix( 'wptests_', $prefix );
			$test->update_table_data( 'wptests_', $prefix );
			$test->update_wpconfig( 'wptests_', $config_path );
			//$test->revert( 'wptests_', $config_path );
			//$test->update_wpconfig( 'wptests_', $config_path );
		} else {
			$this->assertFalse( $test->check( 'wptests_' ) );
			$this->factory->post->create( array( 'post_author' => 1 ) );
			$this->factory->post->create( array( 'post_author' => 1 ) );
			$this->factory->post->create( array( 'post_author' => 1 ) );
			$this->factory->post->create( array( 'post_author' => 1 ) );
			$test->update_table_prefix( $prefix, 'wptests_' );
			$test->update_table_data( $prefix, 'wptests_' );
			$test->update_wpconfig( $prefix, $config_path );
			$sql = "SELECT * FROM abc_posts";
			$this->assertEquals( 4, count( $wpdb->get_results( $sql ) ) );
		}
	}
}