<?php
$version = '1.2.3';

// We set versions for both slugs to avoid undefined index errors for free slug
$GLOBALS['aws_meta']['amazon-s3-and-cloudfront-pro']['version'] = $version;
$GLOBALS['aws_meta']['amazon-s3-and-cloudfront']['version']     = $version;

$GLOBALS['aws_meta']['amazon-s3-and-cloudfront-pro']['supported_addon_versions'] = array(
	'amazon-s3-and-cloudfront-edd'                  => '1.0.4',
	'amazon-s3-and-cloudfront-woocommerce'          => '1.0.5',
	'amazon-s3-and-cloudfront-assets'               => '1.2',
	'amazon-s3-and-cloudfront-meta-slider'          => '1.0',
	'amazon-s3-and-cloudfront-enable-media-replace' => '1.0.2',
	'amazon-s3-and-cloudfront-wpml'                 => '1.0',
	'amazon-s3-and-cloudfront-acf-image-crop'       => '1.0',
);
