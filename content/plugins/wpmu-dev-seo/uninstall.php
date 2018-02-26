<?php
/**
 * Uninstall file
 *
 * @package wpmu-dev-seo
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

define( 'SMARTCRAWL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once( dirname( __FILE__ ) . '/config.php' );
require_once( SMARTCRAWL_PLUGIN_DIR . 'init.php' );

if ( ! class_exists( 'Smartcrawl_Settings' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_settings.php' ); }
if ( ! class_exists( 'Smartcrawl_Reset' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_reset.php' ); }

Smartcrawl_Reset::reset();