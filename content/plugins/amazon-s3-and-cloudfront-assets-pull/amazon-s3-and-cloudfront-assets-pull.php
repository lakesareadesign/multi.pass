<?php
/*
Plugin Name: WP Offload S3 - Assets Pull Addon
Plugin URI: https://deliciousbrains.com/wp-offload-s3/doc/assets-pull-addon/
Description: An addon for WP Offload S3 to serve your site's JS, CSS, and other enqueued assets from Amazon CloudFront or another CDN.
Author: Delicious Brains
Version: 1.0
Author URI: https://deliciousbrains.com
Network: True

// Copyright (c) 2017 Delicious Brains. All rights reserved.
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************
*/

require_once dirname( __FILE__ ) . '/version.php';
require_once dirname( __FILE__ ) . '/classes/wp-aws-compatibility-check.php';
require_once dirname( __FILE__ ) . '/classes/addon-activation-data.php';

$as3cfpro_plugin_version_required = '1.5.1';

global $as3cf_assets_pull_compat_check;
$as3cf_assets_pull_compat_check = new WP_AWS_Compatibility_Check(
	'WP Offload S3 - Assets Pull Addon',
	'amazon-s3-and-cloudfront-assets-pull',
	__FILE__,
	'WP Offload S3',
	'amazon-s3-and-cloudfront-pro',
	$as3cfpro_plugin_version_required,
	null,
	false,
	'https://deliciousbrains.com/wp-offload-s3/'
);

function as3cf_assets_pull_init( $aws ) {
	global $as3cf_assets_pull_compat_check, $as3cf_assets_pull;
	if ( ! $as3cf_assets_pull_compat_check->is_compatible() ) {
		return;
	}

	$abspath = dirname( __FILE__ );
	require_once $abspath . '/classes/amazon-s3-and-cloudfront-assets-pull.php';
	require_once $abspath . '/wp-offload-s3-autoloader.php';

	new WP_Offload_S3_Autoloader( 'WP_Offload_S3_Assets_Pull', $abspath );
	$as3cf_assets_pull = new Amazon_S3_And_CloudFront_Assets_Pull( __FILE__, $aws );
}
add_action( 'aws_init', 'as3cf_assets_pull_init', 14 );

/**
 * Plugin activation handling.
 *
 * Must be registered before plugins_loaded.
 */
register_activation_hook( __FILE__, 'DeliciousBrains\\WP_Offload_S3_Assets_Pull\\Addon_Activation_Data::assets_pull_activated' );
add_action( 'activate_amazon-s3-and-cloudfront-assets/amazon-s3-and-cloudfront-assets.php', 'DeliciousBrains\\WP_Offload_S3_Assets_Pull\\Addon_Activation_Data::assets_s3_activated' );

/**
 * Deactivation handling.
 *
 * Must be registered before plugins_loaded.
 */
register_deactivation_hook( __FILE__, 'DeliciousBrains\\WP_Offload_S3_Assets_Pull\\Addon_Activation_Data::assets_pull_deactivated' );
add_action( 'deactivate_amazon-s3-and-cloudfront-assets/amazon-s3-and-cloudfront-assets.php', 'DeliciousBrains\\WP_Offload_S3_Assets_Pull\\Addon_Activation_Data::assets_s3_deactivated' );
