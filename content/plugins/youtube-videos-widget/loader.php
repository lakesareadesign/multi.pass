<?php
/*
Plugin Name: YouTube Featured Video
Plugin URI: http://premium.wpmudev.org/project/youtube-featured-video
Description: YouTube videos widget for WPMU.org
Version: 1.1.1
Text Domain: ytvw
Author: Ve Bailovity (Incsub)
Author URI: http://premium.wpmudev.org
Contributor: Rheinard Korf (Incsub)
WDP ID: 690027

Copyright 2009-2011 Incsub (http://incsub.com)

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

define ('YTVW_PROTOCOL', (@$_SERVER["HTTPS"] == 'on' ? 'https://' : 'http://'), true);
define ('YTVW_PLUGIN_SELF_DIRNAME', basename(dirname(__FILE__)), true);

//Setup proper paths/URLs and load text domains
if (is_multisite() && defined('WPMU_PLUGIN_URL') && defined('WPMU_PLUGIN_DIR') && file_exists(WPMU_PLUGIN_DIR . '/' . basename(__FILE__))) {
	define ('YTVW_PLUGIN_LOCATION', 'mu-plugins', true);
	define ('YTVW_PLUGIN_BASE_DIR', WPMU_PLUGIN_DIR, true);
	define ('YTVW_PLUGIN_URL', str_replace('http://', YTVW_PROTOCOL, WPMU_PLUGIN_URL), true);
	$textdomain_handler = 'load_muplugin_textdomain';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . YTVW_PLUGIN_SELF_DIRNAME . '/' . basename(__FILE__))) {
	define ('YTVW_PLUGIN_LOCATION', 'subfolder-plugins', true);
	define ('YTVW_PLUGIN_BASE_DIR', WP_PLUGIN_DIR . '/' . YTVW_PLUGIN_SELF_DIRNAME, true);
	define ('YTVW_PLUGIN_URL', str_replace('http://', YTVW_PROTOCOL, WP_PLUGIN_URL) . '/' . YTVW_PLUGIN_SELF_DIRNAME, true);
	$textdomain_handler = 'load_plugin_textdomain';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . basename(__FILE__))) {
	define ('YTVW_PLUGIN_LOCATION', 'plugins', true);
	define ('YTVW_PLUGIN_BASE_DIR', WP_PLUGIN_DIR, true);
	define ('YTVW_PLUGIN_URL', str_replace('http://', YTVW_PROTOCOL, WP_PLUGIN_URL), true);
	$textdomain_handler = 'load_plugin_textdomain';
} else {
	// No textdomain is loaded because we can't determine the plugin location.
	// No point in trying to add textdomain to string and/or localizing it.
	wp_die(__('There was an issue determining where YouTube video widget plugin is installed. Please reinstall.'));
}
$textdomain_handler('ytvw', false, YTVW_PLUGIN_SELF_DIRNAME . '/languages/');

//require_once YTVW_PLUGIN_BASE_DIR . '/lib/class_wdsb_options.php';
//require_once YTVW_PLUGIN_BASE_DIR . '/lib/functions.php';

require_once YTVW_PLUGIN_BASE_DIR . '/lib/class_ytvw_video_widget.php';
Ytvw_YouTubeVideo_Widget::serve();