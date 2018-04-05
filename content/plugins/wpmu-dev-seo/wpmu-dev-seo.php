<?php
/**
 * Plugin Name: SmartCrawl
 * Plugin URI: http://premium.wpmudev.org/project/wpmu-dev-seo/
 * Description: Every SEO option that a site requires, in one easy bundle.
 * Version: 2.2.1
 * Network: true
 * Text Domain: wds
 * Author: WPMU DEV
 * Author URI: http://premium.wpmudev.org
 * WDP ID: 167
 */

/*
* Copyright 2010-2011 Incsub (http://incsub.com/)
* Author - Ulrich Sossou (Incsub)
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.

* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.

* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/


define( 'SMARTCRAWL_VERSION', '2.1.1' );

class Smartcrawl_Loader {

	/**
	 * Construct the Plugin object
	 */
	public function __construct() {
		$this->plugin_init();
	}

	/**
	 * Init Plugin
	 */
	public function plugin_init() {
		require_once( plugin_dir_path( __FILE__ ) . 'config.php' );

		// Init plugin.
		require_once( SMARTCRAWL_PLUGIN_DIR . 'init.php' );
	}

	/**
	 * Activate the plugin
	 *
	 * @return void
	 */
	public static function activate() {
		require_once( plugin_dir_path( __FILE__ ) . 'config.php' );

		// Init plugin
		require_once( SMARTCRAWL_PLUGIN_DIR . 'init.php' );

		require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/settings.php' );

		require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/settings/dashboard.php' );
		Smartcrawl_Settings_Dashboard::get_instance()->defaults();

		require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/settings/checkup.php' );
		Smartcrawl_Checkup_Settings::get_instance()->defaults();

		require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/settings/onpage.php' );
		Smartcrawl_Onpage_Settings::get_instance()->defaults();

		require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/settings/social.php' );
		Smartcrawl_Social_Settings::get_instance()->defaults();

		require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/settings/sitemap.php' );
		Smartcrawl_Sitemap_Settings::get_instance()->defaults();

		require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/settings/autolinks.php' );
		Smartcrawl_Autolinks_Settings::get_instance()->defaults();

		require_once( SMARTCRAWL_PLUGIN_DIR . 'admin/settings/settings.php' );
		Smartcrawl_Settings_Settings::get_instance()->defaults();
	}

	/**
	 * Deactivate the plugin
	 *
	 * @return void
	 */
	public static function deactivate() {}

	/**
	 * Gets the version number string
	 *
	 * @return string Version number info
	 */
	public static function get_version() {
		static $version;
		if ( empty( $version ) ) {
			$version = defined( 'SMARTCRAWL_VERSION' ) && SMARTCRAWL_VERSION ? SMARTCRAWL_VERSION : null;
		}
		return $version;
	}
}

define( 'SMARTCRAWL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// Plugin Activation and Deactivation hooks
register_activation_hook( __FILE__, array( 'Smartcrawl_Loader', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Smartcrawl_Loader', 'deactivate' ) );

if ( defined( 'SMARTCRAWL_CONDITIONAL_EXECUTION' ) && SMARTCRAWL_CONDITIONAL_EXECUTION ) {
	add_action(
		'plugins_loaded',
		array( 'Smartcrawl_Loader', 'plugin_init' )
	);
} else {
	$Smartcrawl_Loader = new Smartcrawl_Loader();
}