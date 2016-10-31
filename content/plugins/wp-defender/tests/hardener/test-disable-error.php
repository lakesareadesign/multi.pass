<?php

/**
 * Author: Hoang Ngo
 */
class Test_Disable_Error extends WP_UnitTestCase {
	private $component;
	private $config_path;

	public function __construct() {
		$this->component = new WD_Disable_Error_Display();
		global $_tests_dir;
		$this->config_path = $_tests_dir . '/wp-tests-config.php';
		//force to oringal state at beginging
		$this->revert();
	}

	public function testMain() {
		//in unit test, it on by default
		$this->assertFalse( $this->component->check( $this->config_path ) );
		$this->component->write_wp_config( $this->config_path );
		$this->assertTrue( $this->component->check( $this->config_path ) );
		//revert
		$this->revert();
	}

	public function testAfterRevert() {
		//after revert, this should be false again
		$this->assertFalse( $this->component->check( $this->config_path ) );
	}

	private function revert() {
		$debug_on = $this->find_debug_line( $this->config_path );
		if ( $debug_on !== false ) {
			//revert it
			$config              = file( $this->config_path );
			$config[ $debug_on ] = 'define("WP_DEBUG",true);';
			file_put_contents( $this->config_path, implode( '', $config ), LOCK_EX );
		}
	}

	private function find_debug_line( $path ) {
		$config  = file( $path );
		$pattern = "/^define\(\s*('|\")WP_DEBUG('|\"),\s*false\s*\)/";
		foreach ( $config as $key => $line ) {
			$line = trim( $line );
			if ( preg_match( $pattern, $line ) ) {
				return $key;
			}
		}

		return false;
	}
}