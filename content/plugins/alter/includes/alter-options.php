<?php
/*
 * Options Configuration
 */

function is_wps_single() {
   if(!is_multisite())
	return true;
   elseif(is_multisite() && !defined('NETWORK_ADMIN_CONTROL'))
	return true;
   else return false;
}

function get_aof_options() {

  if(is_wps_single()) {
    $alter_get_options = (is_serialized(get_option(ALTER_OPTIONS_SLUG))) ? unserialize(get_option(ALTER_OPTIONS_SLUG)) : get_option(ALTER_OPTIONS_SLUG);
  }
  else {
    $alter_get_options = (is_serialized(get_site_option(ALTER_OPTIONS_SLUG))) ? unserialize(get_site_option(ALTER_OPTIONS_SLUG)) : get_site_option(ALTER_OPTIONS_SLUG);
  }

  //get dashboard widgets
  if(is_wps_single()) {
    $dash_widgets_list = (is_serialized(get_option(ALTER_WIDGETS_LISTS_SLUG))) ? unserialize(get_option(ALTER_WIDGETS_LISTS_SLUG)) : get_option(ALTER_WIDGETS_LISTS_SLUG);
  }
  else {
    $dash_widgets_list = (is_serialized(get_site_option(ALTER_WIDGETS_LISTS_SLUG))) ? unserialize(get_site_option(ALTER_WIDGETS_LISTS_SLUG)) : get_site_option(ALTER_WIDGETS_LISTS_SLUG);
  }

  $alter_dash_widgets = array();
  if(!empty($dash_widgets_list)) {
      foreach( $dash_widgets_list as $dash_widget ) {
          $alter_dash_widgets[$dash_widget[0]] = $dash_widget[1];
      }
  }
  $alter_dash_widgets['welcome_panel'] = "Welcome Panel";

  //get adminbar items
  if(is_wps_single()) {
    $adminbar_items = (is_serialized(get_option(ALTER_ADMINBAR_LISTS_SLUG))) ? unserialize(get_option(ALTER_ADMINBAR_LISTS_SLUG)) : get_option(ALTER_ADMINBAR_LISTS_SLUG);
  }
  else {
    $adminbar_items = (is_serialized(get_site_option(ALTER_ADMINBAR_LISTS_SLUG))) ? unserialize(get_site_option(ALTER_ADMINBAR_LISTS_SLUG)) : get_site_option(ALTER_ADMINBAR_LISTS_SLUG);
  }

  /**
  * @since 2.0
  * get all admin users
  */
 $admin_users_array = (is_serialized(get_option(ALTER_ADMIN_USERS_SLUG))) ? unserialize(get_option(ALTER_ADMIN_USERS_SLUG)) : get_option(ALTER_ADMIN_USERS_SLUG);

  $blog_email = get_option('admin_email');
  $blog_from_name = get_option('blogname');

  $panel_tabs = array(
      'general' => __( 'General Options', 'alter' ),
      'login' => __( 'Login Options', 'alter' ),
      'dash' => __( 'Dashboard Widgets', 'alter' ),
      'adminbar' => __( 'Adminbar Options', 'alter' ),
      'adminop' => __( 'Button/Metabox colors', 'alter' ),
      'messagebox' => __( 'Message Colors', 'alter' ),
      'adminmenu' => __( 'Admin menu Colors', 'alter' ),
      'footer' => __( 'Footer Options', 'alter' ),
      );

  $panel_fields = array();

  //General Options
  $panel_fields[] = array(
      'name' => __( 'General Options', 'alter' ),
      'type' => 'openTab'
  );

  $panel_fields[] = array(
      'name' => __( 'Enable/Disable admin pages styles', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Disable Alter styles for admin pages.', 'alter' ),
      'id' => 'disable_admin_pages_styles',
      'type' => 'checkbox',
      'desc' => __( 'Check to disable custom admin styles.', 'alter' ),
      'default' => false,
      );

  $panel_fields[] = array(
      'name' => __( 'Choose design type', 'alter' ),
      'id' => 'design_type',
      'type' => 'radio',
      'options' => array(
          '1' => __( 'Flat design', 'alter' ),
          '2' => __( 'Default design', 'alter' ),
      ),
      'default' => '1',
      );

  $panel_fields[] = array(
      'name' => __( 'Page background color', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Background color', 'alter' ),
      'id' => 'bg_color',
      'type' => 'wpcolor',
      'default' => '#e8e8e8',
      );

  $panel_fields[] = array(
      'name' => __( 'Heading H1 color', 'alter' ),
      'id' => 'h1_color',
      'type' => 'wpcolor',
      'default' => '#333333',
      );

  $panel_fields[] = array(
      'name' => __( 'Heading H2 color', 'alter' ),
      'id' => 'h2_color',
      'type' => 'wpcolor',
      'default' => '#222222',
      );

  $panel_fields[] = array(
      'name' => __( 'Heading H3 color', 'alter' ),
      'id' => 'h3_color',
      'type' => 'wpcolor',
      'default' => '#222222',
      );

  $panel_fields[] = array(
      'name' => __( 'Heading H4 color', 'alter' ),
      'id' => 'h4_color',
      'type' => 'wpcolor',
      'default' => '#555555',
      );

  $panel_fields[] = array(
      'name' => __( 'Heading H5 color', 'alter' ),
      'id' => 'h5_color',
      'type' => 'wpcolor',
      'default' => '#555555',
      );

  $panel_fields[] = array(
      'name' => __( 'Heading H6 color', 'alter' ),
      'id' => 'h6_color',
      'type' => 'wpcolor',
      'default' => '#555555',
      );

  $panel_fields[] = array(
      'name' => __( 'Remove unwanted items', 'alter' ),
      'id' => 'admin_generaloptions',
      'type' => 'multicheck',
      'desc' => __( 'Select whichever you want to remove.', 'alter' ),
      'options' => array(
          '1' => __( 'Wordpress Help tab.', 'alter' ),
          '2' => __( 'Screen Options.', 'alter' ),
          '3' => __( 'Wordpress update notifications.', 'alter' ),
          '4' => __( 'Plugin update notifications from plugins page.', 'alter' ),
      ),
      );

  $panel_fields[] = array(
      'name' => __( 'Disable automatic updates', 'alter' ),
      'id' => 'disable_auto_updates',
      'type' => 'checkbox',
      'desc' => __( 'Select to disable all automatic background updates.', 'alter' ),
      'default' => false,
      );

  $panel_fields[] = array(
      'name' => __( 'Disable update emails', 'alter' ),
      'id' => 'disable_update_emails',
      'type' => 'checkbox',
      'desc' => __( 'Select to disable emails regarding automatic updates.', 'alter' ),
      'default' => false,
      );

  $panel_fields[] = array(
      'name' => __( 'Hide Admin bar', 'alter' ),
      'id' => 'hide_admin_bar',
      'type' => 'checkbox',
      'desc' => __( 'Select to hideadmin bar on frontend.', 'alter' ),
      'default' => false,
      );

  $panel_fields[] = array(
      'name' => __( 'Hide Color picker from user profile', 'alter' ),
      'id' => 'hide_profile_color_picker',
      'type' => 'checkbox',
      'desc' => __( 'Select to hide Color picker from user profile.', 'alter' ),
      'default' => false,
      );

  $panel_fields[] = array(
      'name' => __( 'Menu Customization options', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Disable Menu customization', 'alter' ),
      'id' => 'disable_menu_customize',
      'type' => 'checkbox',
      'desc' => __( 'Select to disable Alter menu customization feature.', 'alter' ),
      'default' => false,
      );

  $panel_fields[] = array(
          'name' => __( 'Menu display', 'alter' ),
          'id' => 'show_all_menu_to_admin',
          'type' => 'radio',
      'options' => array(
          '1' => __( 'Show all Menu links to all admin users', 'alter' ),
          '2' => __( 'Show all Menu links to specific admin users', 'alter' ),
      ),
      );

  if(isset($admin_users_array)) {
    $panel_fields[] = array(
        'name' => __( 'Select Privilege users', 'alter' ),
        'id' => 'privilege_users',
        'type' => 'multicheck',
        'desc' => __( 'Select admin users who can have access to all menu items.', 'alter' ) .
        '<br /><a class="button reload-priv-users" href="'. admin_url( 'admin.php?page=' . ALTER_MENU_SLUG . '&action=reload-priv-users' ) .'">' . __( 'Reload Privilege users data.', 'alter' ) . '</a>',
        'options' => $admin_users_array,
        );
  }

  $panel_fields[] = array(
      'name' => __( 'Custom CSS', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Custom CSS for Admin pages', 'alter' ),
      'id' => 'admin_page_custom_css',
      'type' => 'css',
      );


  //Login Options
  $panel_fields[] = array(
      'name' => __( 'Login Options', 'alter' ),
      'type' => 'openTab'
      );

      if($alter_get_options['disable_styles_login'] == 1) {
        $panel_fields[] = array(
            'desc' => __( 'Login page styles are disabled. Your customization would not work. Please enable it to display Alter custom styles.', 'alter' ),
            'type' => 'note'
            );
      }

  $panel_fields[] = array(
      'name' => __( 'Disable Alter styles for login page.', 'alter' ),
      'id' => 'disable_styles_login',
      'type' => 'checkbox',
      'desc' => __( 'Check to disable', 'alter' ),
      'default' => false,
      );

  $panel_fields[] = array(
      'name' => __( 'Login Style', 'alter' ),
      'id' => 'login_form_style',
      'type' => 'radio',
      'options' => array(
          '1' => __( 'Wide Transparent (New)', 'alter' ),
          '2' => __( 'Default style', 'alter' ),
      ),
      'default' => '1',
      );

  $panel_fields[] = array(
      'name' => __( 'Background color', 'alter' ),
      'id' => 'login_bg_color',
      'type' => 'wpcolor',
      'default' => '#263237',
      );

  $panel_fields[] = array(
      'name' => __( 'External background url', 'alter' ),
      'id' => 'login_external_bg_url',
      'type' => 'text',
      'desc' => __( 'Load image from external source.', 'alter' ),
  );

  $panel_fields[] = array(
      'name' => __( 'Background image', 'alter' ),
      'id' => 'login_bg_img',
      'type' => 'upload',
      );

  $panel_fields[] = array(
      'name' => __( 'Disable background image', 'alter' ),
      'id' => 'disable_login_bg_img',
      'type' => 'checkbox',
      'desc' => __( 'Check to disable', 'alter' ),
      'default' => false,
      );

  // $panel_fields[] = array(
  //     'name' => __( 'Background Repeat', 'alter' ),
  //     'id' => 'login_bg_img_repeat',
  //     'type' => 'checkbox',
  //     'desc' => __( 'Check to repeat', 'alter' ),
  //     'default' => true,
  //     );

  $panel_fields[] = array(
      'name' => __( 'Scale background image', 'alter' ),
      'id' => 'login_bg_img_scale',
      'type' => 'checkbox',
      'desc' => __( 'Scale image to fit Screen size.', 'alter' ),
      'default' => true,
      );

  // $panel_fields[] = array(
  //     'name' => __( 'Login Form Top margin in %', 'alter' ),
  //     'id' => 'login_form_margintop',
  //     'type' => 'number',
  //     'default' => '7',
  //     'min' => '0',
  //     'max' => '100',
  //     );

  $panel_fields[] = array(
      'name' => __( 'Login Form Width in px', 'alter' ),
      'id' => 'login_form_width_in_px',
      'type' => 'number',
      'default' => '760',
      'min' => '480',
      'max' => '900',
      'desc' => __( 'Recommended minimum width for Wide style is 550px.', 'alter' ),
  );

  $panel_fields[] = array(
      'name' => __( 'External Logo url', 'alter' ),
      'id' => 'login_external_logo_url',
      'type' => 'text',
      'desc' => __( 'Load image from external source.', 'alter' ),
  );

  $panel_fields[] = array(
      'name' => __( 'Upload Logo', 'alter' ),
      'id' => 'admin_login_logo',
      'type' => 'upload',
      'desc' => __( 'Image to be displayed on login page. Maximum width should be under 450pixels.', 'alter' ),
  );

  $panel_fields[] = array(
      'name' => __( 'Resize Logo?', 'alter' ),
      'id' => 'admin_logo_resize',
      'type' => 'checkbox',
      'default' => false,
      'desc' => __( 'Select to resize logo size.', 'alter' ),
      );

  $panel_fields[] = array(
      'name' => __( 'Set Logo size in %', 'alter' ),
      'id' => 'admin_logo_size_percent',
      'type' => 'number',
      'default' => '1',
      'max' => '100',
      );

  $panel_fields[] = array(
      'name' => __( 'Logo Height', 'alter' ),
      'id' => 'admin_logo_height',
      'type' => 'number',
      'default' => '50',
      'max' => '150',
      );

  $panel_fields[] = array(
      'name' => __( 'Logo url', 'alter' ),
      'id' => 'login_logo_url',
      'type' => 'text',
      'default' => get_bloginfo('url'),
  );

  $panel_fields[] = array(
      'name' => __( 'Logo background color', 'alter' ),
      'id' => 'login_logo_bg_color',
      'type' => 'wpcolor',
      'default' => '#211723',
      );

  $panel_fields[] = array(
      'name' => __( 'Top margin for Logo', 'alter' ),
      'id' => 'login_logo_top_margin',
      'type' => 'number',
      'default' => '80',
      'min' => '10',
      'max' => '300',
      );

  // $panel_fields[] = array(
  //     'name' => __( 'Short Description', 'alter' ),
  //     'id' => 'login_logo_desc',
  //     'type' => 'wpeditor',
  //     'desc' => __( 'Short description under logo.', 'alter' ),
  //     );

  $panel_fields[] = array(
      'name' => __( 'Login form background color', 'alter' ),
      'id' => 'login_formbg_color',
      'type' => 'wpcolor',
      'default' => '#423143',
      );

  $panel_fields[] = array(
      'name' => __( 'Login button color', 'alter' ),
      'id' => 'login_button_color',
      'type' => 'wpcolor',
      'default' => '#122133',
      );

  $panel_fields[] = array(
      'name' => __( 'Login button hover color', 'alter' ),
      'id' => 'login_button_hover_color',
      'type' => 'wpcolor',
      'default' => '#101e2f',
      );

  $panel_fields[] = array(
      'name' => __( 'Login button text color', 'alter' ),
      'id' => 'login_button_text_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  // $panel_fields[] = array(
  //     'name' => __( 'Transparent Form', 'alter' ),
  //     'id' => 'login_divbg_transparent',
  //     'type' => 'checkbox',
  //     'default' => true,
  //     'desc' => __( 'Select to show transparent form background.', 'alter' ),
  //     );
  //
  //   $panel_fields[] = array(
  //       'name' => __( 'Transparent Form inputs', 'alter' ),
  //       'id' => 'login_inputs_transparent',
  //       'type' => 'checkbox',
  //       'default' => true,
  //       'desc' => __( 'Select to show transparent form inputs.', 'alter' ),
  //       );

  // $panel_fields[] = array(
  //     'name' => __( 'Form inputs background color', 'alter' ),
  //     'id' => 'login_inputs_bg_color',
  //     'type' => 'wpcolor',
  //     'default' => '#324148',
  //     );

  $panel_fields[] = array(
      'name' => __( 'Form inputs text color', 'alter' ),
      'id' => 'login_inputs_text_color',
      'type' => 'wpcolor',
      'default' => '#d5d5d5',
      );

  $panel_fields[] = array(
      'name' => __( 'Form inputs placeholder text color', 'alter' ),
      'id' => 'login_inputs_plholder_color',
      'type' => 'wpcolor',
      'default' => '#5a8b93',
      );

  $panel_fields[] = array(
      'name' => __( 'Form inputs border color', 'alter' ),
      'id' => 'login_inputs_border_color',
      'type' => 'wpcolor',
      'default' => '#d5d5d5',
      );

  // $panel_fields[] = array(
  //     'name' => __( 'Form inputs border hover color', 'alter' ),
  //     'id' => 'login_inputs_border_hover_color',
  //     'type' => 'wpcolor',
  //     'default' => '#756c6c',
  //     );

  // $panel_fields[] = array(
  //     'name' => __( 'Login div background color', 'alter' ),
  //     'id' => 'login_divbg_color',
  //     'type' => 'wpcolor',
  //     'default' => '#f5f5f5',
  //     );


  // $panel_fields[] = array(
  //     'name' => __( 'Form border color', 'alter' ),
  //     'id' => 'form_border_color',
  //     'type' => 'wpcolor',
  //     'default' => '#e5e5e5',
  //     );

  $panel_fields[] = array(
      'name' => __( 'Form text color', 'alter' ),
      'id' => 'form_text_color',
      'type' => 'wpcolor',
      'default' => '#cccccc',
      );

  $panel_fields[] = array(
      'name' => __( 'Form link color', 'alter' ),
      'id' => 'form_link_color',
      'type' => 'wpcolor',
      'default' => '#b7b7b7',
      );

  $panel_fields[] = array(
      'name' => __( 'Form link hover color', 'alter' ),
      'id' => 'form_link_hover_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Hide Back to blog link', 'alter' ),
      'id' => 'hide_backtoblog',
      'type' => 'checkbox',
      'default' => false,
      'desc' => __( 'select to hide', 'alter' ),
      );

  $panel_fields[] = array(
      'name' => __( 'Hide Remember me', 'alter' ),
      'id' => 'hide_remember',
      'type' => 'checkbox',
      'default' => true,
      'desc' => __( 'select to hide', 'alter' ),
      );

  $panel_fields[] = array(
      'name' => __( 'Custom Footer content', 'alter' ),
      'id' => 'login_footer_content',
      'type' => 'wpeditor',
      );

  $panel_fields[] = array(
      'name' => __( 'Custom CSS', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Custom CSS for Login page', 'alter' ),
      'id' => 'login_custom_css',
      'type' => 'css',
      );


  //Dash Options
  $panel_fields[] = array(
      'name' => __( 'Dashboard Widgets', 'alter' ),
      'type' => 'openTab'
      );

  if(!empty($alter_dash_widgets) && is_array($alter_dash_widgets)) {
      $panel_fields[] = array(
          'name' => __( 'Remove unwanted Widgets', 'alter' ),
          'id' => 'remove_dash_widgets',
          'type' => 'multicheck',
          'desc' => __( 'Select whichever you want to remove.', 'alter' ),
          'options' => $alter_dash_widgets,
          );
  }


  //AdminBar Options
  $panel_fields[] = array(
      'name' => __( 'Adminbar Options', 'alter' ),
      'type' => 'openTab'
  );

  $panel_fields[] = array(
    'name' => __( 'Set default adminbar height.', 'alter' ),
    'id' => 'default_adminbar_height',
    'type' => 'checkbox',
    'default' => false,
    'desc' => __( 'Select this option to set default admin bar height.', 'alter' ),
  );

  $panel_fields[] = array(
      'name' => __( 'External Logo url', 'alter' ),
      'id' => 'admin_external_logo_url',
      'type' => 'text',
      'desc' => __( 'Load image from external source.', 'alter' ),
  );

  $panel_fields[] = array(
      'name' => __( 'Upload Logo', 'alter' ),
      'id' => 'admin_logo',
      'type' => 'upload',
      'desc' => __( 'Image to be displayed in all pages. Maximum size 200x50 pixels.', 'alter' ),
      );

  $panel_fields[] = array(
      'name' => __( 'Autofit logo', 'alter' ),
      'id' => 'logo_autofit',
      'type' => 'checkbox',
      'default' => false,
      'desc' => __( 'Select to autofit logo in to admin bar.', 'alter' ),
      );

  $panel_fields[] = array(
      'name' => __( 'Logo horizontal position', 'alter' ),
      'id' => 'logo_position',
      'options' => array(
          '20px' => __( 'Left', 'alter' ),
          'center' => __( 'Center', 'alter' ),
      ),
      'type' => 'radio',
      'default' => '20px',
      'desc' => __( 'Select logo position.', 'alter' ),
  );

  $panel_fields[] = array(
      'name' => __( 'Move logo Top by', 'alter' ),
      'id' => 'logo_top_margin',
      'type' => 'number',
      'desc' => __( "Can be used in case of logo position haven't matched the menu position.", 'alter' ),
      'default' => '0',
      'max' => '20',
      );

  $panel_fields[] = array(
      'name' => __( 'Move logo Bottom by', 'alter' ),
      'id' => 'logo_bottom_margin',
      'type' => 'number',
      'desc' => __( "Can be used in case of logo position haven't matched the menu position.", 'alter' ),
      'default' => '0',
      'max' => '20',
      );

  $panel_fields[] = array(
      'name' => __( 'Logo background color', 'alter' ),
      'id' => 'admin_bar_logo_bg_color',
      'type' => 'wpcolor',
      'default' => '#15232d',
      );

  $panel_fields[] = array(
      'name' => __( 'Admin bar color', 'alter' ),
      'id' => 'admin_bar_color',
      'type' => 'wpcolor',
      'default' => '#cad2c5',
      );

  $panel_fields[] = array(
      'name' => __( 'Menu Link color', 'alter' ),
      'id' => 'admin_bar_menu_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Menu Link hover color', 'alter' ),
      'id' => 'admin_bar_menu_hover_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Menu Link background hover color', 'alter' ),
      'id' => 'admin_bar_menu_bg_hover_color',
      'type' => 'wpcolor',
      'default' => '#4ecdc4',
      );

  $panel_fields[] = array(
      'name' => __( 'Submenu Link color', 'alter' ),
      'id' => 'admin_bar_sbmenu_link_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Submenu Link hover color', 'alter' ),
      'id' => 'admin_bar_sbmenu_link_hover_color',
      'type' => 'wpcolor',
      'default' => '#eaeaea',
      );

  $panel_fields[] = array(
      'name' => __( 'Enable Admin bar shadow', 'alter' ),
      'id' => 'admin_bar_shadow',
      'type' => 'checkbox',
      'default' => true,
      );

  $panel_fields[] = array(
      'name' => __( 'Enable Admin bar Logo shadow', 'alter' ),
      'id' => 'admin_bar_logo_shadow',
      'type' => 'checkbox',
      'default' => true,
      'desc'  => __('Using this option you can enable shadow only for Logo by disabling Admin bar shadow.
      Logo shadow cannot be removed if Admin bar shadow option is enabled.', 'alter' ),
      );

  $panel_fields[] = array(
      'name' => __( 'Remove items from Admin bar', 'alter' ),
      'id' => 'remove_adminbar_items',
      'type' => 'multicheck',
      'options' => $adminbar_items,
      );



  //Buttons Options
  $panel_fields[] = array(
      'name' => __( 'Button/Metabox Colors', 'alter' ),
      'type' => 'openTab'
  );

  if(isset($alter_get_options['disable_admin_pages_styles']) && $alter_get_options['disable_admin_pages_styles'] == 1) {
    $panel_fields[] = array(
        'desc' => __( 'Admin styles are disabled. Your customization would not work. Please enable it to display Alter custom styles.', 'alter' ),
        'type' => 'note'
        );
  }

  $panel_fields[] = array(
      'name' => __( 'Primary button colors', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Button background  color', 'alter' ),
      'id' => 'pry_button_color',
      'type' => 'wpcolor',
      'default' => '#0090d8',
      );

  if(isset($alter_get_options['design_type']) && $alter_get_options['design_type'] != 1) {
  $panel_fields[] = array(
      'name' => __( 'Button border color', 'alter' ),
      'id' => 'pry_button_border_color',
      'type' => 'wpcolor',
      'default' => '#86b520',
      );

  $panel_fields[] = array(
      'name' => __( 'Button shadow color', 'alter' ),
      'id' => 'pry_button_shadow_color',
      'type' => 'wpcolor',
      'default' => '#98ce23',
      );
      }

  $panel_fields[] = array(
      'name' => __( 'Button text color', 'alter' ),
      'id' => 'pry_button_text_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Button hover background color', 'alter' ),
      'id' => 'pry_button_hover_color',
      'type' => 'wpcolor',
      'default' => '#007eb5',
      );

  if(isset($alter_get_options['design_type']) && $alter_get_options['design_type'] != 1) {
  $panel_fields[] = array(
      'name' => __( 'Button hover border color', 'alter' ),
      'id' => 'pry_button_hover_border_color',
      'type' => 'wpcolor',
      'default' => '#259633',
      );

  $panel_fields[] = array(
      'name' => __( 'Button hover shadow color', 'alter' ),
      'id' => 'pry_button_hover_shadow_color',
      'type' => 'wpcolor',
      'default' => '#3d7a0c',
      );
      }

  $panel_fields[] = array(
      'name' => __( 'Button hover text color', 'alter' ),
      'id' => 'pry_button_hover_text_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Secondary button colors', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Button background color', 'alter' ),
      'id' => 'sec_button_color',
      'type' => 'wpcolor',
      'default' => '#ced6c9',
      );

  if(isset($alter_get_options['design_type']) && $alter_get_options['design_type'] != 1) {
  $panel_fields[] = array(
      'name' => __( 'Button border color', 'alter' ),
      'id' => 'sec_button_border_color',
      'type' => 'wpcolor',
      'default' => '#bdc4b8',
      );

  $panel_fields[] = array(
      'name' => __( 'Button shadow color', 'alter' ),
      'id' => 'sec_button_shadow_color',
      'type' => 'wpcolor',
      'default' => '#dde5d7',
      );
      }

  $panel_fields[] = array(
      'name' => __( 'Button text color', 'alter' ),
      'id' => 'sec_button_text_color',
      'type' => 'wpcolor',
      'default' => '#7a7a7a',
      );

  $panel_fields[] = array(
      'name' => __( 'Button hover background color', 'alter' ),
      'id' => 'sec_button_hover_color',
      'type' => 'wpcolor',
      'default' => '#c9c8bf',
      );

  if(isset($alter_get_options['design_type']) && $alter_get_options['design_type'] != 1) {
  $panel_fields[] = array(
      'name' => __( 'Button hover border color', 'alter' ),
      'id' => 'sec_button_hover_border_color',
      'type' => 'wpcolor',
      'default' => '#babab0',
      );

  $panel_fields[] = array(
      'name' => __( 'Button hover shadow color', 'alter' ),
      'id' => 'sec_button_hover_shadow_color',
      'type' => 'wpcolor',
      'default' => '#9ea59b',
      );
      }

  $panel_fields[] = array(
      'name' => __( 'Button hover text color', 'alter' ),
      'id' => 'sec_button_hover_text_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Metabox Colors', 'alter' ),
      'type' => 'title',
  );

  $panel_fields[] = array(
      'name' => __( 'Metabox header box', 'alter' ),
      'id' => 'metabox_h3_color',
      'type' => 'wpcolor',
      'default' => '#bdbdbd',
      );

  $panel_fields[] = array(
      'name' => __( 'Metabox header box border', 'alter' ),
      'id' => 'metabox_h3_border_color',
      'type' => 'wpcolor',
      'default' => '#9e9e9e',
      );

  $panel_fields[] = array(
      'name' => __( 'Metabox header Click button color', 'alter' ),
      'id' => 'metabox_handle_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Metabox header Click button hover color', 'alter' ),
      'id' => 'metabox_handle_hover_color',
      'type' => 'wpcolor',
      'default' => '#949494',
      );

  $panel_fields[] = array(
      'name' => __( 'Metabox header text color', 'alter' ),
      'id' => 'metabox_text_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  //Message color Options
  $panel_fields[] = array(
      'name' => __( 'Message Colors', 'alter' ),
      'type' => 'openTab'
  );

  $panel_fields[] = array(
      'name' => __( 'Message box (Updates)', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Message box color', 'alter' ),
      'id' => 'msg_box_color',
      'type' => 'wpcolor',
      'default' => '#edb88b',
      );

  $panel_fields[] = array(
      'name' => __( 'Message text color', 'alter' ),
      'id' => 'msgbox_text_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Message box border color', 'alter' ),
      'id' => 'msgbox_border_color',
      'type' => 'wpcolor',
      'default' => '#b38f70',
      );

  $panel_fields[] = array(
      'name' => __( 'Message link color', 'alter' ),
      'id' => 'msgbox_link_color',
      'type' => 'wpcolor',
      'default' => '#efefef',
      );

  $panel_fields[] = array(
      'name' => __( 'Message link hover color', 'alter' ),
      'id' => 'msgbox_link_hover_color',
      'type' => 'wpcolor',
      'default' => '#e5e5e5',
      );

  $panel_fields[] = array(
      'name' => __( 'Message box (Warnings)', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Message box color', 'alter' ),
      'id' => 'warn_box_color',
      'type' => 'wpcolor',
      'default' => '#f0f3ed',
      );

  $panel_fields[] = array(
      'name' => __( 'Message text color', 'alter' ),
      'id' => 'warn_text_color',
      'type' => 'wpcolor',
      'default' => '#2f2d2d',
      );

  $panel_fields[] = array(
      'name' => __( 'Message box border color', 'alter' ),
      'id' => 'warn_border_color',
      'type' => 'wpcolor',
      'default' => '#c79b84',
      );

  $panel_fields[] = array(
      'name' => __( 'Message link color', 'alter' ),
      'id' => 'warn_link_color',
      'type' => 'wpcolor',
      'default' => '#000000',
      );

  $panel_fields[] = array(
      'name' => __( 'Message link hover color', 'alter' ),
      'id' => 'warn_link_hover_color',
      'type' => 'wpcolor',
      'default' => '#323232',
      );

  $panel_fields[] = array(
      'name' => __( 'Message box (Error)', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Message box color', 'alter' ),
      'id' => 'error_box_color',
      'type' => 'wpcolor',
      'default' => '#ce642f',
      );

  $panel_fields[] = array(
      'name' => __( 'Message text color', 'alter' ),
      'id' => 'error_text_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Message box border color', 'alter' ),
      'id' => 'error_border_color',
      'type' => 'wpcolor',
      'default' => '#ce642f',
      );

  $panel_fields[] = array(
      'name' => __( 'Message link color', 'alter' ),
      'id' => 'error_link_color',
      'type' => 'wpcolor',
      'default' => '#f2f2f2',
      );

  $panel_fields[] = array(
      'name' => __( 'Message link hover color', 'alter' ),
      'id' => 'error_link_hover_color',
      'type' => 'wpcolor',
      'default' => '#d8d8d8',
      );


  //Admin menu Options
  $panel_fields[] = array(
      'name' => __( 'Admin menu Colors', 'alter' ),
      'type' => 'openTab'
      );

      if(isset($alter_get_options['disable_admin_pages_styles']) && $alter_get_options['disable_admin_pages_styles'] == 1) {
        $panel_fields[] = array(
            'desc' => __( 'Admin styles are disabled. Your customization would not work. Please enable it to display Alter custom styles.', 'alter' ),
            'type' => 'note'
            );
      }

  $panel_fields[] = array(
      'name' => __( 'Admin menu width', 'alter' ),
      'id' => 'admin_menu_width',
      'type' => 'number',
      'default' => '230',
      'min' => '160',
      'max' => '400',
      );

  $panel_fields[] = array(
      'name' => __( 'Admin Menu Color options', 'alter' ),
      'type' => 'title',
      );

  $panel_fields[] = array(
      'name' => __( 'Left menu wrap color', 'alter' ),
      'id' => 'nav_wrap_color',
      'type' => 'wpcolor',
      'default' => '#15232d',
      );

  $panel_fields[] = array(
      'name' => __( 'Submenu wrap color', 'alter' ),
      'id' => 'sub_nav_wrap_color',
      'type' => 'wpcolor',
      'default' => '#121d28',
      );

  $panel_fields[] = array(
      'name' => __( 'Menu text color', 'alter' ),
      'id' => 'nav_text_color',
      'type' => 'wpcolor',
      'default' => '#8aa0a0',
      );

  $panel_fields[] = array(
      'name' => __( 'Menu hover color', 'alter' ),
      'id' => 'hover_menu_color',
      'type' => 'wpcolor',
      'default' => '#121d28',
      );

  $panel_fields[] = array(
      'name' => __( 'Menu hover text color', 'alter' ),
      'id' => 'menu_hover_text_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Active Menu color', 'alter' ),
      'id' => 'active_menu_color',
      'type' => 'wpcolor',
      'default' => '#379392',
      );

  $panel_fields[] = array(
      'name' => __( 'Active Menu text color', 'alter' ),
      'id' => 'menu_active_text_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Submenu text color', 'alter' ),
      'id' => 'submenu_active_text_color',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Menu separator line color', 'alter' ),
      'id' => 'menu_separator_color',
      'type' => 'wpcolor',
      'default' => '#141b21',
      );

  $panel_fields[] = array(
      'name' => __( 'Updates Count notification background', 'alter' ),
      'id' => 'menu_updates_count_bg',
      'type' => 'wpcolor',
      'default' => '#ffffff',
      );

  $panel_fields[] = array(
      'name' => __( 'Updates Count text color', 'alter' ),
      'id' => 'menu_updates_count_text',
      'type' => 'wpcolor',
      'default' => '#000814',
      );




  //Footer Options
  $panel_fields[] = array(
      'name' => __( 'Footer Options', 'alter' ),
      'type' => 'openTab'
      );

  $panel_fields[] = array(
      'name' => __( 'Footer Text', 'alter' ),
      'id' => 'admin_footer_txt',
      'type' => 'wpeditor',
      'desc' => __( 'Put any text you want to show on admin footer.', 'alter' ),
      );


  //Email Options
  $panel_fields[] = array(
      'name' => __( 'Email Options', 'alter' ),
      'type' => 'openTab'
  );

  $panel_fields[] = array(
      'name' => __( 'White Label emails', 'alter' ),
      'id' => 'email_settings',
      'options' => array(
          '3' => __( 'Disable White Label emails', 'alter' ),
          '1' => sprintf( __( 'Set Email address as <strong> %1$s </strong> From name as <strong> %2$s', 'alter' ), $blog_email, $blog_from_name ),
          '2' => __( 'Set different', 'alter' ),
      ),
      'type' => 'radio',
      'default' => '1',
      );

  $panel_fields[] = array(
      'name' => __( 'Email From address', 'alter' ),
      'id' => 'email_from_addr',
      'type' => 'text',
      'desc' => __( 'Enter valid email address', 'alter' ),
      );

  $panel_fields[] = array(
      'name' => __( 'Email From name', 'alter' ),
      'id' => 'email_from_name',
      'type' => 'text',
      );

  $output = array('aof_tabs' => $panel_tabs, 'aof_fields' => $panel_fields);
  return $output;

}
