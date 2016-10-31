<?php

/**
 * Author: Hoang Ngo
 * @group upgrader
 */
class Test_Plugin_Theme_Version extends WP_UnitTestCase {
	private $component;

	public function __construct() {
		$this->component = new WD_Plugin_Theme_Version();
	}

	private function download_old_plugin() {
		//download hello dolly for test
		if ( ! function_exists( 'download_url' ) ) {
			include ABSPATH . 'wp-admin/includes/file.php';
		}
		$tmp = download_url( 'https://downloads.wordpress.org/plugin/hello-dolly.1.5.zip' );
		$zip = new ZipArchive;
		if ( $zip->open( $tmp ) == true ) {
			$zip->extractTo( ABSPATH . 'wp-content/plugins/' );
			$zip->close();
			@unlink( ABSPATH . 'wp-content/plugins/hello.php' );
		}
	}

	private function download_theme() {
		if ( ! function_exists( 'download_url' ) ) {
			include ABSPATH . 'wp-admin/includes/file.php';
		}
		$tmp = download_url( 'https://downloads.wordpress.org/theme/twentyeleven.2.4.zip' );
		$zip = new ZipArchive;
		if ( $zip->open( $tmp ) == true ) {
			$zip->extractTo( ABSPATH . 'wp-content/themes/' );
			$zip->close();
		}
	}

	public function testPlugin() {
		$this->download_old_plugin();
		wp_update_plugins();
		$this->assertTrue( count( $this->component->get_plugins_outdate() ) > 0 );
	}

	public function testTheme() {
		$this->download_theme();
		wp_update_themes();
		$this->assertTrue( count( $this->component->get_themes_outdate() ) > 0 );
	}
}