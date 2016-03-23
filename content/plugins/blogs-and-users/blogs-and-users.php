<?php
/*
Plugin Name: Blogs And Users
Plugin URI: http://premium.wpmudev.org/project/blog-and-user-creator
Description: The blog and user creator plugin is an amazing powerful feature that allows you, and your users, to batch create gazillions of blogs and/or users while setting passwords, urls, titles and more!
Version: 2.3
Text Domain: bau
Author: WPMU DEV
Author URI: http://premium.wpmudev.org
WDP ID: 80

Copyright 2009-2014 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* --------------------------------------------------------------------- */

define( 'BAU_PLUGIN_BASE_DIR', rtrim( plugin_dir_path( __FILE__  ), '/' ) );
define( 'BAU_PLUGIN_URL', rtrim( plugin_dir_url( __FILE__  ), '/' ) );

add_action( 'plugins_loaded', 'bau_load_text_domain' );
function bau_load_text_domain() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'bau' );

	load_textdomain( 'bau', WP_LANG_DIR . '/' . 'bau' . '/' . 'bau' . '-' . $locale . '.mo' );
	load_plugin_textdomain( 'bau', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

class Bau_Exception extends Exception {};

require_once BAU_PLUGIN_BASE_DIR . '/lib/class_bau_installer.php';
Bau_Installer::check();

require_once BAU_PLUGIN_BASE_DIR . '/lib/class_bau_options.php';

if (is_admin()) {
	require_once BAU_PLUGIN_BASE_DIR . '/lib/class_bau_admin_form_renderer.php';
	require_once BAU_PLUGIN_BASE_DIR . '/lib/class_bau_admin_pages.php';
	Bau_AdminPages::serve();
}

global $wpmudev_notices;
$wpmudev_notices[] = array( 'id'=> 80,'name'=> 'Blogs And Users', 'screens' => array( 'settings_page_bau-network', 'users_page_bau' ) );	     	 	  	   	  
include_once( BAU_PLUGIN_BASE_DIR . '/dash-notice/wpmudev-dash-notification.php' );