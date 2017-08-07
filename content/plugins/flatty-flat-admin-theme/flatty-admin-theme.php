<?php
/*
Plugin Name: Flatty - UI Admin Theme
Plugin URI: http://www.michelemarri.me
Text Domain: flatty-flat-admin-theme
Domain Path: /lang
Version: 2.0.0
Description: <strong>The professional Wordpress Admin theme</strong> that we all need in 2017+.
Author: michelemarri
Author URI: http://www.michelemarri.me
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * Flatty
 * Copyright (C) 2017, Michele Marri
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//DEFINE
require_once( dirname( __FILE__ ) . '/includes/init/define.php' );
if ( ! defined( 'FLATTY_VERSION' ) ) {
	define( 'FLATTY_VERSION', '2.0.0' );
}

function flatty_load_textdomain() {
	load_plugin_textdomain( 'flatty-flat-admin-theme', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
}
add_action('plugins_loaded', 'flatty_load_textdomain');

// REGISTER STYLES
require_once( dirname( __FILE__ ) . '/includes/register/styles.php' );

// REGISTER SCRIPTS
require_once( dirname( __FILE__ ) . '/includes/register/scripts.php' );

add_action('admin_enqueue_scripts', 'flatty_styles');
add_action('login_enqueue_scripts', 'flatty_styles');

// SCRIPTS
add_action('admin_enqueue_scripts', 'flatty_scripts');
add_action('login_enqueue_scripts', 'flatty_scripts');

// COLOR PICKER
add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );
function wp_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker');
}

// INIT
require_once( dirname( __FILE__ ) . '/includes/init/options_loader.php' );
require_once( dirname( __FILE__ ) . '/includes/init/media_loader.php' );
require_once( dirname( __FILE__ ) . '/includes/init/action_links.php' );

// LOAD FLATTY MENU
require_once( dirname( __FILE__ ) . '/includes/menu/menu-main.php' );
require_once( dirname( __FILE__ ) . '/includes/menu/menu-sub-login.php' );
require_once( dirname( __FILE__ ) . '/includes/menu/menu-sub-dashboard.php' );
require_once( dirname( __FILE__ ) . '/includes/menu/menu-sub-appearance.php' );
require_once( dirname( __FILE__ ) . '/includes/menu/menu-sub-business_card.php' );
require_once( dirname( __FILE__ ) . '/includes/menu/menu-sub-postspages.php' );

// LOAD FLATTY OPTIONS PAGE
require_once( dirname( __FILE__ ) . '/includes/pages/introduction.php' );
require_once( dirname( __FILE__ ) . '/includes/pages/main_login.php' );
require_once( dirname( __FILE__ ) . '/includes/pages/main_dashboard.php' );
require_once( dirname( __FILE__ ) . '/includes/pages/main_appearance.php' );
require_once( dirname( __FILE__ ) . '/includes/pages/main_business_card.php' );
require_once( dirname( __FILE__ ) . '/includes/pages/main_postspages.php' );
?>
