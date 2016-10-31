<?php

/**
 * Author: Hoang Ngo
 */
class Test_Plugin_Theme_Editor extends WP_UnitTestCase {
	private $component;
	private $config_path;

	public function __construct() {
		$this->component = new WD_Plugin_Theme_Editor();
		global $_tests_dir;
		$this->config_path = $_tests_dir . '/wp-tests-config.php';
		$this->revert();
	}

	public function testMain() {
		$this->log( 'test plugin theme editor' );
		//in unit test, it on by default
		$this->assertFalse( $this->component->check( $this->config_path ) );
		$this->component->write_to_config( $this->config_path );
		$this->assertTrue( $this->component->check( $this->config_path ) );
		//revert it
		$this->revert();
	}

	public function testAfterRevert() {
		$this->assertFalse( $this->component->check( $this->config_path ) );
	}

	public function revert() {
		if ( ( $res = $this->is_file_edit_off( $this->config_path ) ) != - 1 ) {
			if ( is_array( $res ) ) {
				$line = $res[1];
			} else {
				$line = $res;
			}

			$config = file( $this->config_path );
			unset( $config[ $line ] );
			//revert
			file_put_contents( $this->config_path, implode( '', $config ) );
		}
	}

	public function log( $log ) {
		fwrite( STDERR, print_r( $log, true ) );
	}

	function is_file_edit_off( $path ) {
		$config  = file( $path );
		$pattern = "/^define\(\s*(\'|\")DISALLOW_FILE_EDIT(\'|\"),\s*.*\s*\)/";
		foreach ( $config as $key => $line ) {
			$line = trim( $line );
			if ( preg_match( $pattern, $line ) ) {
				if ( preg_match( "/^define\(\s*(\'|\")DISALLOW_FILE_EDIT(\'|\"),\s*true\s*\)/", $line ) ) {
					//disabled
					return array( true, $key );
				} else {
					//return the position
					return $key;
				}
			}
		}

		//no key here, return -1
		return - 1;
	}
}