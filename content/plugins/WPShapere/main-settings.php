<?php
/*
 * WPSHAPERE
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

/*
*   WPSHAPERE menu slug Constant
*/
define( 'WPSHAPERE_MENU_SLUG' , 'wpshapere-options' );

/*
*   WPSHAPERE users list slug Constant
*/
define( 'WPS_ADMIN_USERS_SLUG' , 'wps_admin_users' );

/*
*   WPSHAPERE admin bar items list Constant
*/
define( 'WPS_ADMINBAR_LIST_SLUG' , 'wps_adminbar_list' );

//AOF Framework Implementation
require_once( WPSHAPERE_PATH . 'includes/acmee-framework/acmee-framework.php' );

//Instantiate the AOF class
$aof_options = new AcmeeFramework();

add_action( 'admin_enqueue_scripts', 'aofAssets', 99 );
function aofAssets($page) {
  if( $page != "toplevel_page_wpshapere-options" )
      return;
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'jquery-ui-core' );
  wp_enqueue_script( 'jquery-ui-sortable' );
  wp_enqueue_script( 'jquery-ui-slider' );
  wp_enqueue_style('aofOptions-css', AOF_DIR_URI . 'assets/css/aof-framework.css');
  wp_enqueue_style('aof-ui-css', AOF_DIR_URI . 'assets/css/jquery-ui.css');
  wp_enqueue_script( 'responsivetabsjs', AOF_DIR_URI . 'assets/js/easyResponsiveTabs.js', array( 'jquery' ), '', true );
  // Add the color picker css file
  wp_enqueue_style( 'wp-color-picker' );
  wp_enqueue_script( 'aof-scriptjs', AOF_DIR_URI . 'assets/js/script.js', array( 'jquery', 'wp-color-picker' ), false, true );

}

add_action('admin_menu', 'createOptionsmenu');
function createOptionsmenu() {
  $aof_page = add_menu_page( 'WPShapere', 'WPShapere', 'manage_options', 'wpshapere-options', 'generateFields', 'dashicons-art' );
}

function generateFields() {
  global $aof_options;
  $config = wps_config();
  $aof_options->generateFields($config);
}

add_action('admin_menu', 'SaveSettings');
function SaveSettings() {
  global $aof_options;
  if($_POST) {
    $aof_options->SaveSettings($_POST);
  }
}
