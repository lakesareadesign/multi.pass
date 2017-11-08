<?php
/*
 * ALTER
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

if (!class_exists('ALTER_REDIRECT_USERS')) {

    class ALTER_REDIRECT_USERS extends ALTER
    {
        public $aof_options;

        function __construct()
        {
            $this->aof_options = parent::alter_get_option_data(ALTER_OPTIONS_SLUG);
            add_action('admin_menu', array($this, 'add_redirect_users_menu'));
            add_action('plugins_loaded', array($this, 'alter_save_redirection'));
            add_filter( 'login_redirect', array($this, 'alter_login_redirect_user'), 10, 3 );
        }

        function add_redirect_users_menu() {
            add_submenu_page( ALTER_MENU_SLUG , __('Redirect Users after login', 'alter'), __('Redirect Users', 'alter'), 'manage_options', 'alter_redirect_users', array($this, 'alter_redirect_users_page') );
        }

        function alter_redirect_users_page() {
            global $menu, $submenu;
            $redirect_users_data = (isset($this->aof_options['alter_redirect_users'])) ? $this->aof_options['alter_redirect_users'] : null;
            ?>

            <div class="wrap">
                <h2><?php esc_html_e('Redirect Users after login', 'alter'); ?></h2>
        <?php
            if(isset($_GET['page']) && $_GET['page'] == 'alter_redirect_users' && isset($_GET['status']) && $_GET['status'] == 'updated')
            {
                ?>
                <div class="updated top">
                    <p><strong><?php echo __('Settings Updated!', 'alter'); ?></strong></p>
                </div>
        <?php
            }
            ?>
                <div class="alter-wrap redirect_users_to">
                    <h3><?php esc_html_e('Set redirection for user roles.', 'alter'); ?></h3>
                    <h5><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php esc_html_e('Make sure the user role has permission to access to the page where the user to be redirected to. Otherwise the redirection will end up in Permission error!', 'alter'); ?></h5>
                    <form name="redirect_users_to" method="post">
                    <?php
                        $alter_wp_roles = parent::alter_get_wproles();
                        foreach($alter_wp_roles as $alter_wp_role_key => $alter_wp_role_value) {
                            $custom_url = false;
                            if (isset($redirect_users_data[$alter_wp_role_key]) && $this->is_page_type($redirect_users_data[$alter_wp_role_key]) == "custom" ) {
                                $custom_url = true;
                            }
                            ?>
                            <div class="redirect-users role-<?php echo $alter_wp_role_key; ?>">
                                <h4><?php esc_html_e('User role:', 'alter'); ?> <?php echo $alter_wp_role_value; ?></h4>
                                <div class="pages">
                                    <label for="redirect-to"><strong><?php esc_html_e('Redirect to page', 'alter'); ?> </strong></label>
                                    <select class="select_redirect_page" name="redirect-role-to-page[<?php echo $alter_wp_role_key; ?>]">
                                    <option value=""><?php esc_html_e('Default Page', 'alter'); ?></option>
                                    <option value="custom_url" <?php if($custom_url === true) echo "selected=selected"; ?>>- <?php esc_html_e('Custom url', 'alter'); ?> -</option>
                                <?php
                                foreach($menu as $menu_key => $top_lv_menu) {
                                    if(!empty($top_lv_menu[0])) {
                                        $top_lv_menu_slug =parent::alter_clean_slug($top_lv_menu[2]);
                                        ?>
                                        <option value="<?php echo $top_lv_menu[2]; ?>" <?php if(isset($redirect_users_data[$alter_wp_role_key]) && $top_lv_menu[2] == $redirect_users_data[$alter_wp_role_key]) echo "selected=selected" ?>><?php echo parent::clean_title($top_lv_menu[0]); ?></option>
                                        <?php
                                        if(isset($submenu[$top_lv_menu[2]]) && !empty($submenu[$top_lv_menu[2]])) {
                                            foreach($submenu[$top_lv_menu[2]] as $sub_menu_key => $sub_menu_value) {
                                            ?>
                                        <option value="<?php echo $sub_menu_value[2]; ?>" <?php if(isset($redirect_users_data[$alter_wp_role_key]) && $sub_menu_value[2] == $redirect_users_data[$alter_wp_role_key]) echo "selected=selected" ?>> &nbsp;&nbsp; &raquo; <?php echo parent::clean_title($sub_menu_value[0]); ?></option>
                                        <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                                </select>
                                </div>
                                <div class="custom_url">
                                    <label for="redirect-to"><?php esc_html_e('Redirect to Custom url', 'alter'); ?></label><br />
                                    <input type="text" name="redirect-role-to-url[<?php echo $alter_wp_role_key; ?>]" value="<?php if(isset( $redirect_users_data[$alter_wp_role_key]) && $custom_url === true) echo  $redirect_users_data[$alter_wp_role_key]; ?>" size="50" />
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                        <br /><br />
                        <input type="hidden" name="alter_redirect_users" value="" />
                        <input type="submit" class="button button-primary button-large" value="<?php esc_html_e('Save Changes', 'alter'); ?>" />
                    </form>
                </div>
            </div>
        <?php

        }

        function alter_save_redirection() {
            if(isset($_POST) && isset($_POST['alter_redirect_users'])) {
                foreach ($_POST['redirect-role-to-page'] as $usr_role => $value) {
                    if(!empty($value)) {
                        if($value != "custom_url") {
                            $redirect_to_pages[$usr_role] = $value;
                        }
                        elseif(isset($_POST['redirect-role-to-url'][$usr_role]) && !empty($_POST['redirect-role-to-url'][$usr_role])) {
                            $redirect_to_pages[$usr_role] = $_POST['redirect-role-to-url'][$usr_role];
                        }
                    }
                }
                $redirect_users = array('alter_redirect_users' => $redirect_to_pages);
                $saved_data = parent::alter_get_option_data(ALTER_OPTIONS_SLUG);
                $data = array_merge($saved_data, $redirect_users);
                parent::updateOption(ALTER_OPTIONS_SLUG, $data);
                wp_safe_redirect( admin_url( 'admin.php?page=alter_redirect_users&status=updated' ) );
                exit();
            }
        }

        function alter_login_redirect_user($redirect_to, $request, $user) {
            if ( isset( $user->roles ) && is_array( $user->roles ) ) {

                $the_user_role = $user->roles;

                $redirect_page = isset($this->aof_options['alter_redirect_users'][$the_user_role[0]]) ? $this->aof_options['alter_redirect_users'][$the_user_role[0]] : null;
                if(!empty($redirect_page)) {
                    if($this->is_page_type($redirect_page) == "toplevel") {
                        return admin_url( $redirect_page );
                    }
                    elseif($this->is_page_type($redirect_page) == "pluginspage") {
                        return admin_url( "admin.php?page=".$redirect_page );
                    }
                    elseif(!empty($redirect_page)) {
                        return $redirect_page;
                    }
                }
            }

            return $redirect_to;

        }

        function is_page_type($url) {
            if(strpos($url, 'http') !== false) {
                return "custom";
            }
            elseif(strpos($url, '.php') !== false) {
                return "toplevel";
            }
            else {
                return "pluginspage";
            }
        }

    }

}

new ALTER_REDIRECT_USERS();
