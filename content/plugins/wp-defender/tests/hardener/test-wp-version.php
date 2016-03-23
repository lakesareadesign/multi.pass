<?php
include_once dirname( __DIR__ ) . '/test-hardener.php';

/**
 * @author: Hoang Ngo
 */
class WPVersion_Test extends Hardener_Test {
	function test_version() {
		$version_hadener = new WD_WP_Version();
		//check if the wp version is old
		if ( ! is_wp_error( $version_hadener->check() ) ) {
			//only can check if the wp can return valid version
			$version_hadener->wp_version = '4.2';
			$this->assertFalse( $version_hadener->check() );
			//this is if the wp version is up to date
			//set to null so the
			$version_hadener->wp_version = '4.3.1';
			$this->assertEquals( true, $version_hadener->check() );
		}
	}
}