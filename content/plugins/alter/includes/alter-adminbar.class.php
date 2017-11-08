<?php
/*
 * ALTER
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

if (!class_exists('ALTERADMINBAR')) {

  class ALTERADMINBAR extends ALTER
  {
      function __construct()
      {
        $this->aof_options = parent::alter_get_option_data(ALTER_OPTIONS_SLUG);
        add_action('admin_menu', array($this, 'add_admin_bar_management_menu'));
      }

      function add_admin_bar_management_menu()
      {
        add_submenu_page( ALTER_MENU_SLUG , __('Manage Admin bar', 'alter'), __('Manage Admin bar', 'alter'), 'manage_options', 'admin_bar_management', array($this, 'alter_admin_bar_management') );
      }

      function alter_admin_bar_management()
      {
        //get adminbar items
        if(is_wps_single()) {
          $adminbar_items = (is_serialized(get_option(ALTER_ADMINBAR_LISTS_SLUG))) ? unserialize(get_option(ALTER_ADMINBAR_LISTS_SLUG)) : get_option(ALTER_ADMINBAR_LISTS_SLUG);
        }
        else {
          $adminbar_items = (is_serialized(get_site_option(ALTER_ADMINBAR_LISTS_SLUG))) ? unserialize(get_site_option(ALTER_ADMINBAR_LISTS_SLUG)) : get_site_option(ALTER_ADMINBAR_LISTS_SLUG);
        }

        //echo '<pre>'; print_r($adminbar_items); echo '</pre>';

        echo "<form name='customize_adminbar'>";

        foreach ($adminbar_items as $key => $value) {
          echo "<label for='remove_adminbar_items'><input type='checkbox' name='remove_adminbar_items[]' value='{$key}'>";
          echo " {$value} </label>";
        }
        echo "</form>";
      }

    }

    new ALTERADMINBAR();

}
