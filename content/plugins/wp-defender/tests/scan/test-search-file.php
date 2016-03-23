<?php

/**
 * @group scan
 * @author: Hoang Ngo
 */
class Search_File extends WP_UnitTestCase {
	public function test_search() {
		$path  = wp_defender()->get_plugin_path() . 'tests/scan/file_search';
		$files = WD_Utils::get_dir_tree( $path );
		$this->assertEquals( count( $files ), 4 );
		$files = WD_Utils::get_dir_tree( $path, false );
		$this->assertEquals( count( $files ), 1 );
		$files = WD_Utils::get_dir_tree( $path, true, false );
		$this->assertEquals( count( $files ), 3 );
		$files = WD_Utils::get_dir_tree( $path, true, false, array(
			'ext' => array( 'php', 'js' )
		) );
		$this->assertEquals( count( $files ), 1 );
		$files = WD_Utils::get_dir_tree( $path, true, false, array(), array(
			'ext' => array( 'php', 'js' )
		) );
		$this->assertEquals( count( $files ), 2 );
	}
}