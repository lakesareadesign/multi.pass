<?php
/**
 * Uninstall WP Offload S3 - Assets Addon
 *
 * @package     amazon-s3-and-cloudfront-assets
 * @subpackage  uninstall
 * @copyright   Copyright (c) 2015, Delicious Brains
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

require dirname( __FILE__ ) . '/classes/wp-aws-uninstall.php';

$options = array(
	'as3cf_assets',
	'as3cf_assets_files',
	'as3cf_assets_files_to_process',
	'as3cf_assets_enqueued_scripts',
	'as3cf_assets_location_versions',
	'as3cf_assets_upgrade_session',
	'as3cf_assets_failures',
);

$crons = array(
	'as3cf_assets_scan_files_for_s3_cron',
	'as3cf_assets_process_files_for_s3_cron',
);

$transients = array(
	'as3cf-assets-scanning',
	'as3cf-assets-processing',
);

$as3cf_uninstall = new WP_AWS_Uninstall( $options, array(), $crons, $transients );
