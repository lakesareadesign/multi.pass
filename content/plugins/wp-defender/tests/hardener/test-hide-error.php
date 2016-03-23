<?php
include_once dirname( __DIR__ ) . '/test-hardener.php';

/**
 * @author: Hoang Ngo
 */
class HideErrorTest extends Hardener_Test {

	function test_hide() {
		$test = new WD_Disable_Error_Display();

		$config_path = "/tmp/wordpress-tests-lib/wp-tests-config.php";
		//reset all to off
		$this->reset_wp_debug( 'off' );
		//everything is off => true
		$this->assertTrue( $test->check( $config_path ) );
		$this->reset_wp_debug( 'debug_on' );
		//debug is on, display is off => false
		$this->assertFalse( $test->check( $config_path ) );
		$test->write_wp_config( $config_path );
		$this->assertTrue( $test->check( $config_path ) );
		$this->reset_wp_debug( 'display_on' );
		//only dislay is on, debug off => free
		$this->assertTrue( $test->check( $config_path ) );
		$test->write_wp_config( $config_path );
		$this->assertTrue( $test->check( $config_path ) );
		//both is on => false
		$this->reset_wp_debug( 'on' );
		$this->assertFalse( $test->check( $config_path ) );
		$test->write_wp_config( $config_path );
		$this->assertTrue( $test->check( $config_path ) );
	}

	function reset_wp_debug( $case ) {
		$config_path = "/tmp/wordpress-tests-lib/wp-tests-config.php";
		$config      = file( $config_path );
		$pattern1    = "/define\(\s*('|\")WP_DEBUG('|\"),\s*.*\s*\)/";
		$pattern2    = "/define\(\s*('|\")WP_DEBUG_DISPLAY('|\"),\s*.*\s*\)/";
		switch ( $case ) {
			case 'off':
				//first we need to enable wp debug on
				foreach ( $config as $key => $line ) {
					if ( preg_match( $pattern1, $line ) ) {
						$config[ $key ] = 'define("WP_DEBUG",false);' . PHP_EOL;
						break;
					}
				}

				foreach ( $config as $key => $line ) {
					if ( preg_match( $pattern2, $line ) ) {
						//$config[ $key ] = 'define("WP_DEBUG_DISPLAY",false);' . PHP_EOL;
						unset( $config[ $key ] );
						break;
					}
				}
				break;
			case 'debug_on':
				//first we need to enable wp debug on
				foreach ( $config as $key => $line ) {
					if ( preg_match( $pattern1, $line ) ) {
						$config[ $key ] = 'define("WP_DEBUG",true);' . PHP_EOL;
						break;
					}
				}

				foreach ( $config as $key => $line ) {
					if ( preg_match( $pattern2, $line ) ) {
						$config[ $key ] = 'define("WP_DEBUG_DISPLAY",false);' . PHP_EOL;
						break;
					}
				}
				break;
			case 'display_on':
				//first we need to enable wp debug on
				$hook_line = 0;
				foreach ( $config as $key => $line ) {
					if ( preg_match( $pattern1, $line ) ) {
						$config[ $key ] = 'define("WP_DEBUG",false);' . PHP_EOL;
						$hook_line      = $key;
						break;
					}
				}
				$met_debug_display = false;
				foreach ( $config as $key => $line ) {
					if ( preg_match( $pattern2, $line ) ) {
						$config[ $key ]    = 'define("WP_DEBUG_DISPLAY",true);' . PHP_EOL;
						$met_debug_display = true;
						break;
					}
				}
				//if still here mean no debug display
				if ( $met_debug_display == false ) {
					array_splice( $config, $hook_line, 0, array( 'define("WP_DEBUG_DISPLAY",true);' . PHP_EOL ) );
				}
				break;
			case 'on':
				$hook_line = 0;
				//first we need to enable wp debug on
				foreach ( $config as $key => $line ) {
					if ( preg_match( $pattern1, $line ) ) {
						$config[ $key ] = 'define("WP_DEBUG",true);' . PHP_EOL;
						$hook_line      = $key;
						break;
					}
				}
				$met_debug_display = false;
				foreach ( $config as $key => $line ) {
					if ( preg_match( $pattern2, $line ) ) {
						$config[ $key ]    = 'define("WP_DEBUG_DISPLAY",true);' . PHP_EOL;
						$met_debug_display = true;
						break;
					}
				}
				//if still here mean no debug display
				if ( $met_debug_display == false ) {
					array_splice( $config, $hook_line, 0, array( 'define("WP_DEBUG_DISPLAY",true);' . PHP_EOL ) );
				}
				break;
		}
		file_put_contents( $config_path, implode( '', $config ) );
	}
}