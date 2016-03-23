<?php
/**
 * @author: Hoang Ngo
 */
include_once dirname( __DIR__ ) . '/test-hardener.php';

class ErrorLogTest extends Hardener_Test {
	protected $paths = array();

	public function test_errorlog() {
		$this->create_error_logs();
		$test  = new WD_Error_Log_Scan();
		$files = $test->find_file( ABSPATH . 'wp-admin' );

		$res = array_diff( $this->paths, $files );
		$this->assertTrue( empty( $res ) );
		//delete
		foreach ( $files as $file ) {
			unlink( $file );
		}
		$files = $test->find_file( ABSPATH . 'wp-admin' );
		$this->assertTrue( empty( $files ) );
	}

	private function create_error_logs() {
		//create random files inside wp-admin
		$tree        = WD_Utils::get_dir_tree( ABSPATH . 'wp-admin', false );
		$folder_hide = array_rand( $tree, rand( 1, 10 ) );
		foreach ( $folder_hide as $folder ) {
			$path = $tree[ $folder ] . '/error_log';
			file_put_contents( $path, '' );
			$this->paths[] = $path;
		}
	}
}