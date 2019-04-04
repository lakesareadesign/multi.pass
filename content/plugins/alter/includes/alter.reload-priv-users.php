<?php
/*
 * ALTER
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
 * @since 2.3.9
*/

defined('ABSPATH') || die;

add_action('admin_menu', 'reload_privilege_users_data', 999);

function reload_privilege_users_data() {

  if(isset($_GET) && isset($_GET['action']) && $_GET['action'] == "reload-priv-users") {

    $alter_admin_users = array();
    $admin_user_query = null;

    if ( is_multisite() ) {
      $admin_user_query = get_super_admins();
    }
    if(empty($admin_user_query)) {
      $admin_user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
    }
    if(empty($admin_user_query)) {
      $admin_user_query = new WP_User_Query( array( 'meta_key' => 'wp_user_level', 'meta_value' => '10' ) );
    }

    if ( is_multisite() ) {

      if(!empty($admin_user_query) && is_array($admin_user_query)) {
        foreach ($admin_user_query as $admin_user_name) {
          $admin_user_id = get_user_by('login', $admin_user_name);
          $admin_user_id = $admin_user_id->ID;
          $alter_admin_users[$admin_user_id] = $admin_user_name;
        }
      }

    }
    else {

      foreach ($admin_user_query->results as $admin_data) {
        if(!empty($admin_data->data->display_name)) {
          $user_display_name = $admin_data->data->display_name;
        }
        else {
          $user_display_name = $admin_data->data->user_login;
        }
        $alter_admin_users[$admin_data->ID] = $user_display_name;
      }

    }

    if(!empty($alter_admin_users)) {
      update_option(ALTER_ADMIN_USERS_SLUG, $alter_admin_users);
    }

    wp_safe_redirect( admin_url( 'admin.php?page=' . ALTER_MENU_SLUG ) );

  }

}
