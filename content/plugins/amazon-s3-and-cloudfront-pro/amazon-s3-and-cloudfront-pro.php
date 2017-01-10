<?php
/*
Plugin Name: WP Offload S3
Plugin URI:  http://deliciousbrains.com/wp-offload-s3/
Description: Speed up your WordPress site by offloading your media and assets to Amazon S3 & CloudFront.
Author: Delicious Brains
Version: 1.3
Author URI: http://deliciousbrains.com/
Network: True
Text Domain: amazon-s3-and-cloudfront
Domain Path: /languages/

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

$aws_plugin_version_required = '1.0.1';

require_once dirname( __FILE__ ) . '/classes/wp-aws-compatibility-check.php';
require_once dirname( __FILE__ ) . '/classes/pro/as3cf-pro-installer.php';
require_once dirname( __FILE__ ) . '/classes/pro/as3cf-pro-plugin-installer.php';
require_once dirname( __FILE__ ) . '/classes/as3cf-utils.php';

add_action( 'activated_plugin', array( 'AS3CF_Utils', 'deactivate_other_instances' ) );

global $as3cfpro_compat_check;
$as3cfpro_compat_check = new AS3CF_Pro_Installer( __FILE__, $aws_plugin_version_required );

function as3cf_pro_init( $aws ) {
	global $as3cfpro_compat_check, $as3cf_compat_check;
	$as3cf_compat_check = $as3cfpro_compat_check;
	if ( ! $as3cfpro_compat_check->are_required_plugins_activated() ) {
		return;
	}

	if ( ! $as3cfpro_compat_check->is_compatible() ) {
		return;
	}

	if ( method_exists( 'WP_AWS_Compatibility_Check', 'is_plugin_active' ) && $as3cfpro_compat_check->is_plugin_active( 'amazon-s3-and-cloudfront/wordpress-s3.php' ) ) {
		// Deactivate the the WP Offload Lite if activated
		AS3CF_Utils::deactivate_other_instances( 'amazon-s3-and-cloudfront-pro/amazon-s3-and-cloudfront-pro.php' );
	}

	global $as3cf, $as3cfpro;
	$abspath = dirname( __FILE__ );
	// Lite files
	require_once $abspath . '/include/functions.php';
	require_once $abspath . '/classes/as3cf-error.php';
	require_once $abspath . '/classes/as3cf-upgrade.php';
	require_once $abspath . '/classes/as3cf-upgrade-filter-post.php';
	require_once $abspath . '/classes/upgrades/as3cf-region-meta.php';
	require_once $abspath . '/classes/upgrades/as3cf-file-sizes.php';
	require_once $abspath . '/classes/upgrades/as3cf-meta-wp-error.php';
	require_once $abspath . '/classes/as3cf-filter.php';
	require_once $abspath . '/classes/filters/as3cf-local-to-s3.php';
	require_once $abspath . '/classes/filters/as3cf-s3-to-local.php';
	require_once $abspath . '/classes/upgrades/as3cf-filter-edd.php';
	require_once $abspath . '/classes/upgrades/as3cf-filter-post-content.php';
	require_once $abspath . '/classes/upgrades/as3cf-filter-post-excerpt.php';
	require_once $abspath . '/classes/as3cf-notices.php';
	require_once $abspath . '/classes/as3cf-stream-wrapper.php';
	require_once $abspath . '/classes/as3cf-plugin-compatibility.php';
	require_once $abspath . '/classes/amazon-s3-and-cloudfront.php';
	// Pro files
	require_once $abspath . '/vendor/deliciousbrains/autoloader.php';
	require_once $abspath . '/classes/pro/as3cf-pro-licences-updates.php';
	require_once $abspath . '/classes/pro/amazon-s3-and-cloudfront-pro.php';
	require_once $abspath . '/classes/pro/as3cf-pro-plugin-compatibility.php';
	require_once $abspath . '/classes/pro/as3cf-pro-utils.php';
	require_once $abspath . '/classes/pro/as3cf-sidebar-presenter.php';
	require_once $abspath . '/classes/pro/as3cf-tool.php';
	require_once $abspath . '/classes/pro/tools/as3cf-uploader.php';
	require_once $abspath . '/classes/pro/tools/as3cf-downloader.php';
	require_once $abspath . '/classes/pro/tools/as3cf-download-and-remover.php';
	require_once $abspath . '/classes/pro/as3cf-async-request.php';
	require_once $abspath . '/classes/pro/as3cf-background-process.php';
	$as3cf = new Amazon_S3_And_CloudFront_Pro( __FILE__, $aws );
	$as3cfpro = $as3cf; // Pro global alias
}

add_action( 'aws_init', 'as3cf_pro_init', 11 );
