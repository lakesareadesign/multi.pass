<?php
/*
 * Plugin Name: Genesis Dambuster
 * Plugin URI: https://www.genesisdambuster.com/
 * Description: A Genesis only WordPress plugin that makes it easy to set up your pages for edge to edge content. Ideal for full width Beaver Builder templates. 
 * Version: 1.11.0
 * Author: Russell Jamieson
 * Author URI: https://www.diywebmastery.com/about/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */ 
if ( ! defined( 'ABSPATH' ) ) { exit; }
define('GENESIS_DAMBUSTER_VERSION','1.11.0');
define('GENESIS_DAMBUSTER_NAME', 'Genesis Dambuster');
define('GENESIS_DAMBUSTER_SLUG', 'genesis-dambuster') ;
define('GENESIS_DAMBUSTER_PATH', plugin_basename(__FILE__));
define('GENESIS_DAMBUSTER_DOMAIN', 'GENESIS_DAMBUSTER_DOMAIN');
define('GENESIS_DAMBUSTER_HOME', 'https://www.genesisdambuster.com');
define('GENESIS_DAMBUSTER_HELP', 'help@genesisdambuster.com');
define('GENESIS_DAMBUSTER_ICON', plugins_url('images/genesisdambuster.png', __FILE__));
define('GENESIS_DAMBUSTER_NEWS', 'https://www.diywebmastery.com/tags/genesis-newsfeed/feed/?images=1&featured_only=1');
require_once(dirname(__FILE__) . '/classes/class-plugin.php');
Genesis_Dambuster_Plugin::get_instance();
