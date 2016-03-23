<?php
/**
 * @author: Hoang Ngo
 */
// If uninstall is not called from WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

$options_name = 'wp_defender';
delete_option( $options_name );
delete_site_option( $options_name );
//clear cache
delete_transient( 'wd_content_files' );
delete_transient( 'wd_core_files' );
delete_transient( 'wd_scan_percent' );
delete_transient( 'wd_core_scan_index' );
delete_transient( 'wd_suspicious_scan_index' );
delete_transient( 'wd_signatures_cache' );
delete_transient( 'wd_nested_wp' );
delete_transient( 'wd_no_md5' );
delete_site_option( 'wd_scanned_file' );
delete_option( 'wd_scanned_file' );
delete_site_option( 'wd_scan_lock' );
delete_option( 'wd_scan_lock' );
delete_site_option( 'wd_scan_processing' );
delete_option( 'wd_scan_processing' );
delete_site_option( 'wd_flash_data' );
delete_transient( 'wd_content_filescount' );
delete_transient( 'wd_core_filescount' );
