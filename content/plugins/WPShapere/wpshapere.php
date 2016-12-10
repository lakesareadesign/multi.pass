<?php
/*
Plugin Name: WPSHAPERE
Plugin URI: https://codecanyon.net/item/wordpress-admin-theme-wpshapere/8183353
Description: WPShapere is a wordpress plugin to customize the WordPress Admin theme and elements as your wish. Make WordPress a complete CMS with WPShapere.
Version: 4.8
Author: AcmeeDesign Softwares and Solutions
Author URI: http://acmeedesign.com
Text-Domain: wps
Domain Path: /languages
 *
*/

/*
*   WPSHAPERE Version
*/

define( 'WPSHAPERE_VERSION' , '4.8' );

/*
*   WPSHAPERE Path Constant
*/
define( 'WPSHAPERE_PATH' , dirname(__FILE__) . "/");

/*
*   WPSHAPERE URI Constant
*/
define( 'WPSHAPERE_DIR_URI' , plugin_dir_url(__FILE__) );

/*
*   WPSHAPERE Options slug Constant
*/
define( 'WPSHAPERE_OPTIONS_SLUG' , 'wpshapere_options' );

/*
* Enabling Global Customization for Multi-site installation.
* Delete below two lines if you want to give access to all blog admins to customizing their own blog individually.
* Works only for multi-site installation
*/
if(is_multisite())
    define('NETWORK_ADMIN_CONTROL', true);
// Delete the above two lines to enable customization per blog


require_once( WPSHAPERE_PATH . 'includes/wps-options.php' );

/*
 * Main configuration for AOF class
 */

if(!function_exists('wps_config')) {
  function wps_config() {
    if(!is_multisite()) {
        $multi_option = false;
    }
     elseif(is_multisite() && !defined('NETWORK_ADMIN_CONTROL')) {
         $multi_option = false;
     }
     else {
         $multi_option = true;
     }

     /* Stop editing after this */
     $wps_fields = get_wps_options();
     $config = array(
         'multi' => $multi_option, //default = false
         'wps_fields' => $wps_fields,
       );

       return $config;
  }
}

//Implement main settings
require_once( WPSHAPERE_PATH . 'main-settings.php' );

function wps_load_textdomain()
{
   load_plugin_textdomain('wps', false, dirname( plugin_basename( __FILE__ ) )  . '/languages' );
}
add_action('plugins_loaded', 'wps_load_textdomain');


include_once WPSHAPERE_PATH . 'includes/wpshapere.class.php';
include_once WPSHAPERE_PATH . 'includes/wpsthemes.class.php';


//register_deactivation_hook( __FILE__, array( 'WPSHAPERE', 'deleteOptions') );
