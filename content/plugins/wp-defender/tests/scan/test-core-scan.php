<?php

/**
 * Author: Hoang Ngo
 * @group scan
 */
class Test_Core_Scan extends WP_UnitTestCase {
	private $component;

	public function __construct() {
		$this->component = new WD_Core_Integrity_Scan();
		//$this->revert();
	}

	private function revert() {
		@unlink( ABSPATH . 'info.php' );
		$index = file_get_contents( ABSPATH . 'index.php' );
		str_replace( 'just a new line', '', $index );
		file_put_contents( ABSPATH . 'index.php', $index );
	}

	public function testOkay() {
		$core_files = WD_Scan_Api::get_core_files();
		foreach ( $core_files as $file ) {
			$ret = $this->component->scan_a_file( $file );
			//this should always true in thsi test
			$this->assertTrue( $ret );
		}
	}

	public function teNotOkay() {
		$original_index = file_get_contents( ABSPATH . 'index.php' );
		//we will modify one, and add one
		file_put_contents( ABSPATH . 'info.php', 'just a sample test' );
		//append
		file_put_contents( ABSPATH . 'index.php', 'just a new line', FILE_APPEND | LOCK_EX );
		$core_files = WD_Scan_Api::get_core_files();
		$new_added  = null;
		$modified   = null;
		foreach ( $core_files as $file ) {
			$ret = $this->component->scan_a_file( $file );
			//this should always true in thsi test
			if ( in_array( $file, array() ) ) {
				$this->assertTrue( is_object( $ret ) );
				$rw_data = $ret->get_raw_data();
				if ( $rw_data['behavior'] == 'added' ) {
					$new_added = $ret;
				} else {
					$modified = $ret;
				}

			} else {
				$this->assertTrue( $ret );
			}
		}
		//remove the new add
		$new_added->remove();
		//if it is modify, restore
		$modified->automate_resolve();
		//now rescan
		$core_files = WD_Scan_Api::get_core_files();
		foreach ( $core_files as $file ) {
			$ret = $this->component->scan_a_file( $file );
			//should all true
			$this->assertTrue( $ret );
		}
		file_put_contents( ABSPATH . 'index.php', $original_index );
		@unlink( ABSPATH . 'info.php' );
	}
}