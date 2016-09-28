<?php
/*
Plugin Name: Flatty - UI Admin Theme
Plugin URI: http://www.michelemarri.me
Version: 0.9.6
Description: <strong>The professional Wordpress Admin theme</strong> that we all need in 2016+.
Author: michelemarri
Author URI: http://www.michelemarri.me
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * Flatty - UI Admin Theme
 * Copyright (C) 2016, Michele Marri
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
	define( 'FLATTY_VERSION', '0.9.6' );
}

// REGISTER STYLES
require_once( dirname( __FILE__ ) . '/includes/register/styles.php' );

// REGISTER SCRIPTS
require_once( dirname( __FILE__ ) . '/includes/register/scripts.php' );

add_action('admin_enqueue_scripts', 'flatty_styles');
add_action('login_enqueue_scripts', 'flatty_styles');

// SCRIPTS
add_action('admin_enqueue_scripts', 'flatty_scripts');
add_action('login_enqueue_scripts', 'flatty_scripts');

// INIT
require_once( dirname( __FILE__ ) . '/includes/init/options_loader.php' );
require_once( dirname( __FILE__ ) . '/includes/init/media_loader.php' );
require_once( dirname( __FILE__ ) . '/includes/init/action_links.php' );

// LOAD FLATTY MENU
require_once( dirname( __FILE__ ) . '/includes/menu/menu-main.php' );
require_once( dirname( __FILE__ ) . '/includes/menu/menu-sub-login.php' );
require_once( dirname( __FILE__ ) . '/includes/menu/menu-sub-branding.php' );
require_once( dirname( __FILE__ ) . '/includes/menu/menu-sub-theme.php' );
require_once( dirname( __FILE__ ) . '/includes/menu/menu-sub-dashboard.php' );

// LOAD FLATTY OPTIONS PAGE
require_once( dirname( __FILE__ ) . '/includes/pages/introduction.php' );
require_once( dirname( __FILE__ ) . '/includes/pages/main_login.php' );
require_once( dirname( __FILE__ ) . '/includes/pages/main_theme.php' );
require_once( dirname( __FILE__ ) . '/includes/pages/main_branding.php' );
require_once( dirname( __FILE__ ) . '/includes/pages/main_dashboard.php' );

?>
