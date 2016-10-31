<?php
/*
Plugin Name: Alter - White Label Wordpress
Plugin URI: http://acmeedesign.com
Description: Alter - White label everything from WordPress. Powered by AcmeeDesign
Version: 1.1
Author: AcmeeDesign
Author URI: http://acmeedesign.com
Text-Domain: alter
 *
*/

/*
*   ALTER Version
*/

define( 'ALTER_VERSION' , '1.1' );

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

/*
*       Enabling Global Customization for Multi-site installation.
*       Delete below two lines if you want to give access to all blog admins to customizing their own blog individually.
*       Works only for multi-site installation
*/
if(is_multisite())
    define('NETWORK_ADMIN_CONTROL', true);
// Delete the above two lines to enable customization per blog


//AOF Framework Implementation
require_once( ALTER_PATH . '/includes/acmee-framework/acmee-framework.php' );
require_once( ALTER_PATH . '/includes/alter-options.php' );

/*
 * Main configuration for AOF class
 * put 'multi' => false for customizing the single or entire multi-site network admin panel as single super admin
 * put 'multi' => true for giving access to all blog admins to customizing their own blog individually
 *  (works only for multisite network install)
 */

if(!is_multisite()) {
    $multi_option = false;
}
 elseif(is_multisite() && !defined('NETWORK_ADMIN_CONTROL')) {
     $multi_option = false;
 }
 else {
     $multi_option = true;
 }
$config = array(
    'capability' => 'manage_options',
    'page_title' => __('Alter Settings', 'aof'),
    'menu_title' => __('Alter WLB', 'aof'),
    'menu_slug' => 'alter-options',
    'icon_url'   => 'dashicons-art',
    'position'   => 3,
    'tabs'  => $panel_tabs,
    'fields'    => $panel_fields,
    'multi' => $multi_option //default = false
  );

/*
 * Instantiate the AOF class
 */
$aof_instance = new AcmeeFramework($config);

include_once ALTER_PATH . '/includes/fa-icons.class.php';
include_once ALTER_PATH . '/includes/alter.class.php';
include_once ALTER_PATH . '/includes/alter.widgets.class.php';
include_once ALTER_PATH . '/includes/alter.menu.class.php';
include_once ALTER_PATH . '/includes/alter.redirectusers.class.php';
include_once ALTER_PATH . '/includes/alter-import-export.class.php';
