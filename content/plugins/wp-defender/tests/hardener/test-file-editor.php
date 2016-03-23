<?php
include_once dirname( __DIR__ ) . '/test-hardener.php';

/**
 * @author: Hoang Ngo
 */
class FileEditorTest extends Hardener_Test {
	public function test_file_editor() {
		$config_path = "/tmp/wordpress-tests-lib/wp-tests-config.php";
		$config      = file( $config_path );
		//disable all the file editor
		$test    = new WD_Plugin_Theme_Editor();
		$pattern = "/^define\(\s*(\'|\")DISALLOW_FILE_EDIT(\'|\"),\s*.*\s*\)/";
		foreach ( $config as $key => $line ) {
			$line = trim( $line );
			if ( preg_match( $pattern, $line ) ) {
				unset( $config[ $key ] );
			}
		}
		file_put_contents( $config_path, implode( '', $config ) );
		$this->assertFalse( $test->check( $config_path ) );
		$test->write_to_config( $config_path );
		$this->assertTrue( $test->check( $config_path ) );
	}
}