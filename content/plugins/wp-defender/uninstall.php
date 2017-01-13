<?php
/**
 * @author: Hoang Ngo
 */
// If uninstall is not called from WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

//require needed files
$path = dirname( __FILE__ );
include_once $path . DIRECTORY_SEPARATOR . 'wp-defender.php';
WD_Scan_Module::get_instance();
WD_Hardener_Module::get_instance();

WD_Scan_Api::clear_cache();
//cache cleared, now we have to remove htaccess
$hardeners = WD_Hardener_Module::find_controller( 'hardener' );
$hardeners->load_modules();
$rules = $hardeners->get_loaded_modules();

foreach ( $rules as $rule ) {
	if ( $rule->id == 'protect_core_dir' ) {
		$rule->revert( null, true );
	}

	//remove htaccess content from wp-content and wp-includes
	if ( $rule->id == 'protect_upload_dir' ) {
		$rule->revert();
		$uploads_dir = wp_upload_dir();
		$paths       = array(
			ABSPATH . WPINC . '/.htaccess',
			WP_CONTENT_DIR . '/.htaccess',
			$uploads_dir['basedir'] . '/.htaccess'
		);

		foreach ( $paths as $path ) {
			if ( file_exists( $path ) ) {
				$content = file_get_contents( $path );
				$content = trim( $content );
				if ( strlen( $content ) == 0 ) {
					unlink( $path );
				}
			}
		}
	}
}
$options_name = 'wp_defender';
if ( function_exists( 'delete_site_option' ) ) {
	delete_site_option( $options_name );
}

delete_option( 'wd_lockdown_settings' );