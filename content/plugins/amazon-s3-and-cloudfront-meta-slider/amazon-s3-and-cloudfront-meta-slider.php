<?php
/*
Plugin Name: WP Offload S3 - Meta Slider Addon
Plugin URI: http://deliciousbrains.com/wp-offload-s3/#meta-slider-addon
Description: WP Offload S3 addon to integrate Meta Slider with Amazon S3. Requires Pro Upgrade.
Author: Delicious Brains
Version: 1.0.1
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

$as3cfpro_plugin_version_required = '1.1';

require dirname( __FILE__ ) . '/classes/wp-aws-compatibility-check.php';
global $as3cf_meta_slider_compat_check;
$as3cf_meta_slider_compat_check = new WP_AWS_Compatibility_Check(
	'WP Offload S3 - Meta Slider Addon',
	'amazon-s3-and-cloudfront-meta-slider',
	__FILE__,
	'WP Offload S3',
	'amazon-s3-and-cloudfront-pro',
	$as3cfpro_plugin_version_required,
	null,
	false,
	'https://deliciousbrains.com/wp-offload-s3/'
);

function as3cf_meta_slider_init( $aws ) {
	global $as3cf_meta_slider_compat_check;
	if ( ! $as3cf_meta_slider_compat_check->is_compatible() ) {
		return;
	}

	global $as3cfmeta_slider;
	$abspath = dirname( __FILE__ );
	require_once $abspath . '/classes/amazon-s3-and-cloudfront-meta-slider.php';
	$as3cfmeta_slider = new Amazon_S3_And_CloudFront_Meta_Slider( __FILE__ );
}

add_action( 'aws_init', 'as3cf_meta_slider_init', 12 );
