<?php
include_once dirname( __DIR__ ) . '/test-hardener.php';

/**
 * @author: Hoang Ngo
 */
class SecurityKeyTest extends Hardener_Test {
	public function test_security_key() {
		//reset the update time
		$config_path = "/tmp/wordpress-tests-lib/wp-tests-config.php";
		WD_Utils::update_setting( 'wd_security_key->last_update', 0 );
		$test = new WD_Security_Key();
		$this->assertFalse( $test->check() );
		//generate
		$const     = array(
			'AUTH_KEY',
			'SECURE_AUTH_KEY',
			'LOGGED_IN_KEY',
			'NONCE_KEY',
			'AUTH_SALT',
			'SECURE_AUTH_SALT',
			'LOGGED_IN_SALT',
			'NONCE_SALT',
		);
		$old_const = array();
		foreach ( $const as $c ) {
			$old_const[ $c ] = constant( $c );
		}
		$test->generate_salt( $config_path );
		//now loop and get and compare
		$config = file( $config_path );
		foreach ( $const as $c ) {
			$pattern = '/^define\s*\(\s*(\'|\")' . $c . '(\'|\"),\s*(\'|\").*(\'|\")\s*\)/';
			if ( ( $matches = preg_grep( $pattern, $config ) ) ) {
				$match  = array_shift( $matches );
				$newkey = preg_replace( array(
					'/^define\s*\(\s*(\'|\")' . $c . '(\'|\"),\s*(\'|\")/',
					'/(\'|\")\s*\)/'
				), '', $match );
				//var_dump( $newkey );
				//var_dump( $old_const[ $c ] );
				$this->assertTrue( strcmp( $old_const[ $c ], $newkey ) !== 0 );
				//var_dump( $matches );
			}
		}
		$this->assertTrue( $test->check() !== false );
	}
}