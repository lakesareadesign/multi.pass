<?php
/*
Plugin Name: Ultra WordPress Admin
Plugin URI: http://codecanyon.net/item/ultra-wordpress-admin-theme/9220673
Description: Advanced Admin Theme with White Label Branding for WordPress.
Author: themepassion
Version: 7.4
Author URI: http://codecanyon.net/user/themepassion/portfolio
*/

/* --------------- Load Custom functions ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-functions.php' );

/* --------------- Ultra CSS based on WP Version ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-css-version.php' );

/* --------------- Custom colors ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-custom-colors.php' );

/* --------------- Color Library ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-color-lib.php' );

/* --------------- Ultra Fonts ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-fonts.php' );

/* --------------- CSS Library ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-css-lib.php' );

/* --------------- Logo and Favicon Settings ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-logo.php' );

/* --------------- Login  ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-login.php' );

/* --------------- Top Bar ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-topbar.php' );

/* --------------- Page Loader ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-pageloader.php' );

/* --------------- Admin Settings ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/ultra-settings.php' );


/* --------------- Load  framework ---------------- */

function ultra_load_framework(){
    

	if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/framework/core/framework.php' ) ) {
	    require_once( dirname( __FILE__ ) . '/framework/core/framework.php' );
	}
	if (!isset( $ultra_demo ) && file_exists( dirname( __FILE__ ) . '/framework/options/ultra-config.php')) {
	    require_once( dirname( __FILE__ ) . '/framework/options/ultra-config.php' );
	}
}

add_action('plugins_loaded', 'ultra_load_framework', 11);

//ultra_load_framework();


/* ---------------- Dynamic CSS - after plugins loaded ------------------ */
add_action('plugins_loaded', 'ultra_core', 12);
add_action('admin_menu', 'ultra_panel_settings', 12);


/* ---------------- On Options saved hook ------------------ */
add_action ('redux/options/ultra_demo/saved', 'ultra_framework_settings_saved');


/* ------------------------------------------------
Regenerate All Color Files again - 
Uncommenting this might affect the speed depending on server
Don't Uncomment it.
------------------------------------------------- */
//add_action('plugins_loaded', 'ultra_regenerate_all_dynamic_css_file', 12);


/* ------------------------------------------------
Load Settings Panel only if demo_settings is present. Only for demo purpose. Don't Uncomment it.
------------------------------------------------- */
//add_action('admin_footer', 'ultra_admin_footer_function');


/* ------------------------------------------------
Regenerate All Inbuilt Theme import Files - 
Uncommenting this might affect the speed depending on server
Don't Uncomment it.
------------------------------------------------- */
//add_action('plugins_loaded', 'ultra_generate_inbuilt_theme_import_file', 12);




/* ------------------------------------------------
      Auto Update Envato Plugins using Envato WordPress toolkit and 
      Envato Automatic Plugin Update
  ------------------------------------------------- */
add_action( 'plugins_loaded', 'ultra_my_envato_updates_init' );

function ultra_my_envato_updates_init() {

    include plugin_dir_path( __FILE__ ) . 'lib/envato-plugin-update.php';

    PresetoPluginUpdateEnvato::instance()->add_item( array(
            'id' => 9220673,
            'basename' => plugin_basename( __FILE__ )
        ) );

}




/* --------------- Registration Hook Library---------------- */
require_once( trailingslashit(dirname(__FILE__)) . 'lib/ultra-register-hook.php' );
register_activation_hook(__FILE__, 'ultra_admin_activation');
register_deactivation_hook(__FILE__, 'ultra_admin_deactivation');
?>