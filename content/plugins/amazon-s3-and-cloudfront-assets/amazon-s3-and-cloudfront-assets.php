<?php
/*
Plugin Name: WP Offload S3 - Assets Addon
Plugin URI: http://deliciousbrains.com/wp-offload-s3/#addons
Description: WP Offload S3 addon to serve your site's JS, CSS and other assets from S3. Requires Pro Upgrade.
Author: Delicious Brains
Version: 1.2.1
Author URI: http://deliciousbrains.com
Network: True

// Copyright (c) 2015 Delicious Brains. All rights reserved.
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************
//
*/

require_once dirname( __FILE__ ) . '/version.php';

$as3cfpro_plugin_version_required = '1.1.7';

require dirname( __FILE__ ) . '/classes/wp-aws-compatibility-check.php';
global $as3cf_assets_compat_check;
$as3cf_assets_compat_check = new WP_AWS_Compatibility_Check(
	'WP Offload S3 - Assets Addon',
	'amazon-s3-and-cloudfront-assets',
	__FILE__,
	'WP Offload S3',
	'amazon-s3-and-cloudfront-pro',
	$as3cfpro_plugin_version_required,
	null,
	false,
	'https://deliciousbrains.com/wp-offload-s3/'
);

function as3cf_assets_init( $aws ) {
	global $as3cf_assets_compat_check;
	if ( ! $as3cf_assets_compat_check->is_compatible() ) {
		return;
	}

	global $as3cf_assets;
	$abspath = dirname( __FILE__ );
	require_once $abspath . '/classes/amazon-s3-and-cloudfront-assets.php';
	require_once $abspath . '/classes/class-minify.php';
	require_once $abspath . '/classes/class-process-assets.php';
	require_once $abspath . '/classes/class-recursive-callback-filter-iterator.php';
	require_once $abspath . '/classes/class-upgrade.php';
	require_once $abspath . '/classes/async-requests/as3cf-scan-files-for-s3.php';
	require_once $abspath . '/classes/async-requests/as3cf-remove-files-from-s3.php';
	require_once $abspath . '/classes/background-processes/class-minify-background-process.php';
	require_once $abspath . '/classes/background-processes/class-process-assets-background-process.php';
	require_once $abspath . '/classes/minify/class-provider-interface.php';
	require_once $abspath . '/classes/minify/class-cssmin-provider.php';
	require_once $abspath . '/classes/minify/class-jshrink-provider.php';
	$as3cf_assets = new Amazon_S3_And_CloudFront_Assets( __FILE__, $aws );
}

add_action( 'aws_init', 'as3cf_assets_init', 12 );
