<?php
/*
 * Alter
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

/*
*   ALTER menu slug Constant
*/
define( 'ALTER_MENU_SLUG' , 'alter-options' );

//AOF Framework Implementation
require_once( ALTER_PATH . '/includes/acmee-framework/acmee-framework.php' );

//Instantiate the AOF class
$aof_options = new AcmeeFramework();

add_action( 'admin_enqueue_scripts', 'aofAssets', 99 );
function aofAssets($page) {
  if( $page == "toplevel_page_alter-options" || $page == "alter_page_alter_change_text" || $page == "alter_page_admin_menu_management"
  || $page == "alter_page_alter_add_dash_widgets" || $page == "alter_page_alter_redirect_users" ) {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'jquery-ui-slider' );
    wp_enqueue_style('aof-ui-css', ALTER_DIR_URI . 'includes/acmee-framework/assets/css/jquery-ui.css');
    wp_enqueue_style('aofOptions-css', ALTER_DIR_URI . 'includes/acmee-framework/assets/css/aof-framework.css');
    wp_enqueue_script( 'responsivetabsjs', ALTER_DIR_URI . 'includes/acmee-framework/assets/js/easyResponsiveTabs.js', array( 'jquery' ), '', true );
    // Add the color picker css file
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'aof-scriptjs', ALTER_DIR_URI . 'includes/acmee-framework/assets/js/script.js', array( 'jquery', 'wp-color-picker' ), false, true );
  }

}

add_action('admin_menu', 'createOptionsmenu');
function createOptionsmenu() {
  $aof_page = add_menu_page( 'Alter', 'Alter', 'manage_options', 'alter-options', 'generateFields', 'dashicons-art' );
}

function generateFields() {
  global $aof_options;
  $config = aof_config();
  $aof_options->generateFields($config);
}

add_action('plugins_loaded', 'SaveSettings');
function SaveSettings() {
  global $aof_options;
  if($_POST) {
    $aof_options->SaveSettings($_POST);
  }
}
