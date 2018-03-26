<?php
/*
 * WPSHAPERE
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

if(!class_exists('DEACTIVATELICENSE')) {
    class DEACTIVATELICENSE extends WPSHAPERE {

        function __construct()
        {
            $this->aof_options = parent::get_wps_option_data(WPSHAPERE_OPTIONS_SLUG);
            add_action('admin_menu', array($this, 'add_remove_license_menu'));
            add_action('plugins_loaded', array($this, 'remove_license'));
        }

        function add_remove_license_menu()
        {
            add_submenu_page( WPSHAPERE_MENU_SLUG , __('Deactivate License for this site', 'wps'), __('Deactivate License', 'wps'), 'manage_options', 'wps_deactivate_license', array($this, 'wps_deactivate_license_form') );
        }

        function wps_deactivate_license_form() {
          ?>
          <div class="wrap wps-wrap">
            <h2><?php _e('Deactivate License for this site', 'wps'); ?></h2>
            <form name="wps_deactiate_license" method="post">
              <br />
              <p><label for="wps_remove_license"><input type="checkbox" name="remove_license" value="1" /> <?php _e('Remove license key for this site.', 'wps'); ?></label></p>
              <input type="submit" name="submit" class="button button-primary button-hero" value="Deactivate License" />
            </form>
          </div>
          <?php
        }

        function remove_license() {
          if(isset($_POST['remove_license']) && $_POST['remove_license'] == 1) {
              delete_option('wps_purchase_data');
              wp_safe_redirect( admin_url( 'admin.php?page=' . WPSHAPERE_MENU_SLUG ) );
              exit();
          }
        }

    }
}new DEACTIVATELICENSE();
