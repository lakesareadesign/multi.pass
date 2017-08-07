<?php
/*
 * ALTER
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

if (!class_exists('ALTERHELP')) {

    class ALTERHELP extends ALTER
    {
        function __construct()
        {
          add_action('admin_menu', array($this, 'add_alter_help_menu'));
        }

        function add_alter_help_menu()
        {
            add_submenu_page( 'alter-options', __('About', 'alter') . ' Alter', __('About', 'alter') . ' Alter', 'manage_options', 'about_alter', array($this, 'alter_help_resources') );
        }

        function alter_help_resources() {
          ?>
          <div class="clearfix wrap alter-wrap">
            <h1 style="line-height: 1.2em;font-size: 3.9em;font-weight: 400;"><?php echo __('Welcome to', 'alter'); ?> WpAlter <?php echo ALTER_VERSION ?></h1>
            <p class="plugin_desc"><?php
            echo __('Congratulations! You have made the right choice of choosing WpAlter. You are about to use the most powerful white labelling solution for WordPress admin.', 'alter');
            ?></p>
            <div class="alter_kb_link">
              <a target="_blank" href="http://kb.acmeedesign.com/kbase_categories/alter-white-label-wordpress-plugin/">
                <?php echo __('Visit Knowledgebase', 'alter'); ?>
              </a>
              <a href="<?php echo admin_url( 'admin.php?page=alter-options' ); ?>">
                <?php echo 'Alter ' . __('Settings', 'alter'); ?>
              </a>
            </div>

            <h2 style="margin-top:45px; margin-bottom:0px;font-size:18px;">ONLINE RESOURCES</h2>
            <div class="left col-6">
              <h2>Customization help</h2>
              <ul>
                  <li><a target="_blank" href="http://kb.acmeedesign.com/kbase/wpalter-general-options/">General Options</a></li>
                  <li><a target="_blank" href="http://kb.acmeedesign.com/kbase/wpalter-login-options/">Login Options</a></li>
                  <li><a target="_blank" href="http://kb.acmeedesign.com/kbase/wpalter-add-custom-dashboard-widgets/">How to add custom dashboard widgets?</a></li>
              		<li><a target="_blank" href="http://kb.acmeedesign.com/kbase/wpalter-remove-dashboard-widgets/">How to remove dashboard widgets?</a></li>
                  <li><a target="_blank" href="http://kb.acmeedesign.com/kbase/wpalter-admin-bar-options/">Adminbar Options</a></li>
                  <li><a target="_blank" href="http://kb.acmeedesign.com/kbase/wpalter-footer-options/">Footer options</a></li>
              </ul>
            </div>
            <div class="left col-6">
              <h2>How to's</h2>
              <ul>
                  <li><a href="http://kb.acmeedesign.com/kbase/im-building-a-site-for-a-client-and-dont-want-them-to-see-unnecessary-parts-of-the-admin-page-can-i-hide-certain-menu-options-such-as-the-themes-and-plugins-menus/">How to hide certain menu items from admin menu?</a></li>
              		<li><a href="http://kb.acmeedesign.com/kbase/how-to-remove-or-add-new-menu-links-to-the-admin-bar/">How to add new menu items to admin bar?</a></li>
              		<li><a href="http://kb.acmeedesign.com/kbase/can-i-use-shortcodes-in-the-custom-dashboard-widgets/">Is it possible to use shortcodes in custom dashboard widgets?</a></li>
              		<li><a href="http://kb.acmeedesign.com/kbase/some-menu-icons-missing-out-after-plugin-activation/">Some menu icons missing out after plugin activation?</a></li>
              		<li><a href="http://kb.acmeedesign.com/kbase/is-it-compatible-with-other-3rd-party-plugins/">Is it compatible with other 3rd party plugins?</a></li>
              		<li><a href="http://kb.acmeedesign.com/kbase/ive-hidden-some-menus-but-i-can-still-see-them/">I’ve hidden some menus, but I can still see them. why?</a></li>
              		<li><a href="http://kb.acmeedesign.com/kbase/can-i-use-this-plugin-for-multiple-clients-or-projects/">Can I use this plugin for multiple clients or projects?</a></li>
              </ul>
            </div>
          </div>
          <?php
        }

    }

}

new ALTERHELP();
