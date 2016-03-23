<?php
/**
 * @Package: WordPress Plugin
 * @Subpackage: Ultra WordPress Admin Theme
 * @Since: Ultra 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Ultra WordPress Admin Theme Plugin.
 */

//Activation Code
function ultra_admin_activation() {
    //global $wpdb;
    //add_option("ultra_admin_version", "1.0");
}

//Deactivation Code
function ultra_admin_deactivation() {

	delete_option( "ultraadmin_plugin_access");
	delete_option( "ultraadmin_plugin_page");
	delete_option( "ultraadmin_plugin_userid");
	delete_option( "ultraadmin_menumng_page");
	delete_option( "ultraadmin_admin_menumng_page");
	delete_option( "ultraadmin_admintheme_page");
	delete_option( "ultraadmin_logintheme_page");
	delete_option( "ultraadmin_master_theme");


  delete_site_option( "ultraadmin_plugin_access");
  delete_site_option( "ultraadmin_plugin_page");
  delete_site_option( "ultraadmin_plugin_userid");
  delete_site_option( "ultraadmin_menumng_page");
  delete_site_option( "ultraadmin_admin_menumng_page");
  delete_site_option( "ultraadmin_admintheme_page");
  delete_site_option( "ultraadmin_logintheme_page");
  delete_site_option( "ultraadmin_master_theme");


/*
       delete_option("ultraadmin_menuorder");
       delete_option("ultraadmin_submenuorder");
       delete_option("ultraadmin_menurename");
       delete_option("ultraadmin_submenurename");
       delete_option("ultraadmin_menudisable");
       delete_option("ultraadmin_submenudisable");
*/



    /* 	
      delete_option('ultra_admin_version');
     */
}

?>