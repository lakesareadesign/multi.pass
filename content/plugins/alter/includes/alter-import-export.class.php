<?php
/*
 * ALTER
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

if (!class_exists('ALTER_IMP_EXP')) {

    class ALTER_IMP_EXP extends ALTER
    {
        public $aof_options;

        function __construct()
        {
            $this->aof_options = parent::alter_get_option_data(ALTER_OPTIONS_SLUG);
            add_action('admin_menu', array($this, 'add_impexp_menu'));
            add_action('plugins_loaded',array($this, 'alter_settings_action'));
        }

        function add_impexp_menu() {
            add_submenu_page( 'alter-options', __('Import/Export', 'alter'), __('Import/Export Settings', 'alter'), 'manage_options', 'alter_impexp_settings', array($this, 'alter_impexp_settings_page') );
        }

        function alter_impexp_settings_page() {
            global $aof_options;
            //$aof_options->licenseValidate();
            ?>
            <div class="wrap alter-wrap">
        <?php
            if(isset($_GET['page']) && $_GET['page'] == 'alter_impexp_settings' && isset($_GET['status']) && $_GET['status'] == 'updated')
            {
                ?>
                <div class="updated top">
                    <p><strong><?php echo __('Settings Imported!', 'alter'); ?></strong></p>
                </div>
        <?php
            }
            elseif(isset($_GET['page']) && $_GET['page'] == 'alter_impexp_settings' && isset($_GET['status']) && $_GET['status'] == 'dataerror')
            {
                ?>
                <div class="updated top">
                    <p><strong><?php echo __('Wrong data format.', 'alter'); ?></strong></p>
                </div>
        <?php
            }

            ?>
                <h3><?php echo __('Reset to default', 'alter'); ?></h3>
                <span><?php echo __('By resetting all settings will be deleted!', 'alter'); ?></span>
                <div style="padding: 15px 0">
                    <form name="alter_master_reset_form" method="post" onsubmit="return confirm('Do you really want to Reset?');">
                    <input type="hidden" name="reset_to_default" value="alter_master_reset" />
                    <?php wp_nonce_field('alter_reset_nonce','alter_reset_field'); ?>
                    <input class="button button-primary button-hero" type="submit" value="<?php echo __('Reset All Settings', 'alter'); ?>" />
                    </form>
                </div>

                <h3><?php echo __('Export Settings', 'alter'); ?></h3>
                <div style="padding: 15px 0">
                <span><?php echo __('Save the below contents to a text file.', 'alter'); ?></span>
                <textarea class="widefat" rows="10" ><?php echo $this->alter_get_settings(); ?></textarea>
                <!-- <textarea class="widefat" rows="10" ><?php //echo var_export(get_option('alter_options')); ?></textarea> -->
                </div>

                <h3><?php echo __('Import Settings', 'alter'); ?></h3>
                <div style="padding:15px 0">
                <form name="alter_import_settings_form" method="post" action="">
                        <input type="hidden" name="alter_import_settings" value="1" />
                        <textarea class="widefat" name="alter_import_settings_data" rows="10" ></textarea><br /><br />
                        <input class="button button-primary button-hero" type="submit" value="<?php echo __('Import Settings', 'alter'); ?>" />
                <?php wp_nonce_field('alter_import_settings_nonce','alter_import_settings_field'); ?>
                </form>
                </div>

            </div>

<?php
        }

        function alter_settings_action() {
            if(isset($_POST['alter_import_settings_field']) ) {
                if(!wp_verify_nonce( $_POST['alter_import_settings_field'], 'alter_import_settings_nonce' ) )
                    exit();
                $import_data = trim($_POST['alter_import_settings_data']);
                if(empty($import_data) || !is_serialized($import_data)) {
                    wp_safe_redirect( admin_url( 'admin.php?page=alter_impexp_settings&status=dataerror' ) );
                    exit();
                }
                else {
                    $data = (is_serialized($import_data)) ? unserialize($import_data) : $import_data; //to avoid double serialization
                    parent::updateOption(ALTER_OPTIONS_SLUG, $data);
                    wp_safe_redirect( admin_url( 'admin.php?page=alter_impexp_settings&status=updated' ) );
                    exit();
                }
            }

            if(isset($_POST['reset_to_default']) && $_POST['reset_to_default'] == "alter_master_reset") {
                if(!wp_verify_nonce( $_POST['alter_reset_field'], 'alter_reset_nonce' ) )
                        exit();

                global $aof_options;
                $aof_options->aofLoaddefault(true);
                wp_safe_redirect( admin_url( 'admin.php?page=alter-options' ) );
                exit();
            }
        }

        function alter_get_settings() {
           $saved_data = parent::alter_get_option_data(ALTER_OPTIONS_SLUG);
           if(!empty($saved_data)) {
               if(!is_serialized($saved_data)) {
                   return maybe_serialize($saved_data);
               }
               else {
                   return $saved_data;
               }
           }
        }

        function getDefaultOptions() {
            $default_data = 'a:80:{s:11:"design_type";s:1:"1";s:8:"h1_color";s:7:"#333333";s:8:"h2_color";s:7:"#222222";s:8:"h3_color";s:7:"#222222";s:8:"h4_color";s:7:"#555555";s:8:"h5_color";s:7:"#555555";s:8:"h6_color";s:7:"#555555";s:20:"disable_auto_updates";s:0:"";s:21:"disable_update_emails";s:0:"";s:14:"hide_admin_bar";s:0:"";s:25:"hide_profile_color_picker";s:0:"";s:20:"disable_styles_login";s:0:"";s:14:"login_bg_color";s:7:"#263237";s:12:"login_bg_img";s:0:"";s:19:"login_bg_img_repeat";b:1;s:18:"login_bg_img_scale";b:1;s:20:"login_form_margintop";s:3:"100";s:16:"login_form_width";s:2:"25";s:16:"admin_login_logo";s:0:"";s:17:"admin_logo_resize";s:0:"";s:23:"admin_logo_size_percent";s:1:"1";s:17:"admin_logo_height";s:2:"50";s:14:"login_logo_url";s:22:"http://localhost/alter";s:23:"login_divbg_transparent";b:1;s:21:"login_inputs_bg_color";s:7:"#324148";s:23:"login_inputs_text_color";s:7:"#e5e5e5";s:17:"login_divbg_color";s:7:"#f5f5f5";s:18:"login_formbg_color";s:7:"#423143";s:17:"form_border_color";s:7:"#e5e5e5";s:15:"form_text_color";s:7:"#cccccc";s:15:"form_link_color";s:7:"#777777";s:21:"form_link_hover_color";s:7:"#555555";s:15:"hide_backtoblog";s:0:"";s:13:"hide_remember";b:1;s:20:"login_footer_content";s:0:"";s:16:"login_custom_css";s:0:"";s:10:"admin_logo";s:0:"";s:15:"logo_top_margin";s:0:"";s:18:"logo_bottom_margin";s:0:"";s:23:"admin_bar_logo_bg_color";s:7:"#15232d";s:15:"admin_bar_color";s:7:"#cad2c5";s:20:"admin_bar_menu_color";s:7:"#ffffff";s:26:"admin_bar_menu_hover_color";s:7:"#ffffff";s:29:"admin_bar_menu_bg_hover_color";s:7:"#4ecdc4";s:27:"admin_bar_sbmenu_link_color";s:7:"#ffffff";s:33:"admin_bar_sbmenu_link_hover_color";s:7:"#eaeaea";s:8:"bg_color";s:7:"#e8e8e8";s:16:"pry_button_color";s:7:"#0090d8";s:21:"pry_button_text_color";s:7:"#ffffff";s:22:"pry_button_hover_color";s:7:"#007eb5";s:27:"pry_button_hover_text_color";s:7:"#ffffff";s:16:"sec_button_color";s:7:"#ced6c9";s:21:"sec_button_text_color";s:7:"#7a7a7a";s:22:"sec_button_hover_color";s:7:"#c9c8bf";s:27:"sec_button_hover_text_color";s:7:"#ffffff";s:16:"metabox_h3_color";s:7:"#bdbdbd";s:23:"metabox_h3_border_color";s:7:"#9e9e9e";s:20:"metabox_handle_color";s:7:"#ffffff";s:26:"metabox_handle_hover_color";s:7:"#949494";s:18:"metabox_text_color";s:7:"#ffffff";s:13:"msg_box_color";s:7:"#edb88b";s:17:"msgbox_text_color";s:7:"#ffffff";s:19:"msgbox_border_color";s:7:"#b38f70";s:17:"msgbox_link_color";s:7:"#efefef";s:23:"msgbox_link_hover_color";s:7:"#e5e5e5";s:21:"admin_page_custom_css";s:0:"";s:16:"admin_menu_width";s:3:"230";s:14:"nav_wrap_color";s:7:"#15232d";s:18:"sub_nav_wrap_color";s:7:"#121d28";s:16:"hover_menu_color";s:7:"#121d28";s:17:"active_menu_color";s:7:"#379392";s:14:"nav_text_color";s:7:"#8aa0a0";s:21:"menu_hover_text_color";s:7:"#ffffff";s:20:"menu_separator_color";s:7:"#141b21";s:21:"menu_updates_count_bg";s:7:"#ffffff";s:23:"menu_updates_count_text";s:7:"#000814";s:16:"admin_footer_txt";s:0:"";s:14:"email_settings";s:1:"1";s:15:"email_from_addr";s:0:"";s:15:"email_from_name";s:0:"";}';
            return $default_data;
        }

    }

}

new ALTER_IMP_EXP();
