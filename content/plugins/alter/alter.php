<?php
/*
Plugin Name: Alter - White Label Wordpress
Plugin URI: http://acmeedesign.com
Description: White label branding for WordPress. Turn your WordPress admin to look like your own software!
Version: 2.3.9
Author: AcmeeDesign
Author URI: http://acmeedesign.com
Text-Domain: alter
 *
*/

/*
*   ALTER Version
*/

define( 'ALTER_VERSION' , '2.3.9' );

/*
*   ALTER Path Constant
*/
define( 'ALTER_PATH' , dirname(__FILE__) );

/*
*   ALTER URI Constant
*/
define( 'ALTER_DIR_URI' , plugin_dir_url(__FILE__) );

/*
*   ALTER Options slug Constants
*/
define( 'ALTER_OPTIONS_SLUG' , 'alter_options' );
define( 'ALTER_WIDGETS_LISTS_SLUG' , 'alter_active_widgets_list' );
define( 'ALTER_ADMINBAR_LISTS_SLUG' , 'alter_adminbar_list' );
define( 'ALTER_ADMIN_USERS_SLUG' , 'alter_admin_users' );
define( 'ALTER_ABOUT_SLUG' , 'about_alter' );

/*
*       Enabling Global Customization for Multi-site installation.
*       Delete below two lines if you want to give access to all blog admins to customizing their own blog individually.
*       Works only for multi-site installation
*/
if(is_multisite())
    define('NETWORK_ADMIN_CONTROL', true);
// Delete the above two lines to enable customization per blog

/* Stop editing after this */

//AOF Framework Implementation
require_once( ALTER_PATH . '/includes/alter-options.php' );

/*
 * Main configuration for AOF class
 */

if(!function_exists('aof_config')) {
  function aof_config() {
    if(!is_multisite()) {
        $multi_option = false;
    }
     elseif(is_multisite() && !defined('NETWORK_ADMIN_CONTROL')) {
         $multi_option = false;
     }
     else {
         $multi_option = true;
     }

     $aof_fields = get_aof_options();
     $config = array(
         'multi' => $multi_option, //default = false
         'aof_fields' => $aof_fields,
       );

       return $config;
  }
}

//Implement main settings
require_once( ALTER_PATH . '/main-settings.php' );

function aof_load_textdomain()
{
   load_plugin_textdomain('alter', false, dirname( plugin_basename( __FILE__ ) )  . '/languages' );
}
add_action('plugins_loaded', 'aof_load_textdomain');

include_once ALTER_PATH . '/includes/fa-icons.class.php';
include_once ALTER_PATH . '/includes/alter.class.php';
include_once ALTER_PATH . '/includes/alter.widgets.class.php';
include_once ALTER_PATH . '/includes/alter-adminbar.class.php';
include_once ALTER_PATH . '/includes/alter.menu.class.php';
include_once ALTER_PATH . '/includes/alter.redirectusers.class.php';
include_once ALTER_PATH . '/includes/alter.themes.class.php';
include_once ALTER_PATH . '/includes/alter-import-export.class.php';
include_once ALTER_PATH . '/includes/alter.help.php';
include_once ALTER_PATH . '/includes/alter.reload-priv-users.php';
