<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
	//die;
}

define( 'WDS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once(dirname(__FILE__) . '/config.php');
require_once( WDS_PLUGIN_DIR . 'init.php' );

if (!class_exists('WDS_Settings')) require_once(WDS_PLUGIN_DIR . '/core/class_wds_settings.php');
if (!class_exists('WDS_Reset')) require_once(WDS_PLUGIN_DIR . '/core/class_wds_reset.php');

WDS_Reset::reset();