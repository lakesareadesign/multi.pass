<?php
/*
Plugin Name: WPSHAPERE
Plugin URI: http://acmeedesign.com
Description: WPShapere is a wordpress plugin to customize the WordPress Admin theme and elements as your wish. Make WordPress a complete CMS with WPShapere.
Version: 4.2
Author: KannanC
Author URI: http://acmeedesign.com
Text-Domain: wps
 * 
*/

/*
*   WPSHAPERE Version
*/

define( 'WPSHAPERE_VERSION' , '4.2' );    

/*
*   WPSHAPERE Path Constant
*/
define( 'WPSHAPERE_PATH' , dirname(__FILE__) . "/"); 

/*
*   WPSHAPERE URI Constant
*/
define( 'WPSHAPERE_DIR_URI' , plugin_dir_url(__FILE__) );

/*
*       Enabling Global Customization for Multi-site installation.
*       Delete below two lines if you want to give access to all blog admins to customizing their own blog individually.
*       Works only for multi-site installation
*/
if(is_multisite())
    define('NETWORK_ADMIN_CONTROL', true);
// Delete the above two lines to enable customization per blog



//AOF Framework Implementation
require_once( WPSHAPERE_PATH . 'includes/acmee-framework/acmee-framework.php' );
require_once( WPSHAPERE_PATH . 'includes/wps-options.php' );

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
    'page_title' => __('WPShapere Settings', 'aof'),
    'menu_title' => __('WPShapere', 'aof'),
    'menu_slug' => 'wpshapere-options',
    'icon_url'   => 'dashicons-art',
    'position'   => 3,
    'tabs'  => $panel_tabs,
    'fields'    => $panel_fields,
    'multi' => $multi_option //default = false
  );  

/*
 * Instantiate the AOF class
 */
$aof_options = new AcmeeFramework($config);

                        
include_once WPSHAPERE_PATH . 'includes/wpshapere.class.php';
include_once WPSHAPERE_PATH . 'includes/wpsthemes.class.php';


//register_deactivation_hook( __FILE__, array( 'WPSHAPERE', 'deleteOptions') );

/*add_action('plugins_loaded', 'wps_load_textdomain');

function wps_load_textdomain()
        {
            load_plugin_textdomain('wps', false, dirname( plugin_basename( __FILE__ ) )  . '/languages' );
        }
 * 
 */
