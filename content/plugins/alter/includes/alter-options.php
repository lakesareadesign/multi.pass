<?php
/*
 * Options Configuration
 */
$blog_email = get_option('admin_email');
$blog_from_name = get_option('blogname');
if(is_serialized(get_option(ALTER_OPTIONS_SLUG))) {
    $alter_get_options = unserialize(get_option(ALTER_OPTIONS_SLUG));
}
else {
    $alter_get_options = get_option(ALTER_OPTIONS_SLUG);
}

//get dashboard widgets
if(is_serialized(get_option(ALTER_WIDGETS_LISTS_SLUG))) {
    $dash_widgets_list = unserialize(get_option(ALTER_WIDGETS_LISTS_SLUG));
}
else {
    $dash_widgets_list = get_option(ALTER_WIDGETS_LISTS_SLUG);
}

$alter_dash_widgets = array();
if(!empty($dash_widgets_list)) {
    foreach( $dash_widgets_list as $dash_widget ) {
        $alter_dash_widgets[$dash_widget[0]] = $dash_widget[1];
    }
}
$alter_dash_widgets['welcome_panel'] = "Welcome Panel";

//get adminbar items
if(is_serialized(get_option(ALTER_ADMINBAR_LISTS_SLUG))) {
    $adminbar_items = unserialize(get_option(ALTER_ADMINBAR_LISTS_SLUG));
}
else {
    $adminbar_items = get_option(ALTER_ADMINBAR_LISTS_SLUG);
}

$panel_tabs = array(
    'general' => __( 'General Options', 'alter' ),
    'login' => __( 'Login Options', 'alter' ),
    'dash' => __( 'Dashboard Widgets', 'alter' ),
    'adminbar' => __( 'Adminbar Options', 'alter' ),
    'adminop' => __( 'Button/Metabox colors', 'alter' ),
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
    'name' => __( 'Custom CSS', 'alter' ),
    'type' => 'title',
    );

$panel_fields[] = array(
    'name' => __( 'Custom CSS for Admin pages', 'alter' ),
    'id' => 'admin_page_custom_css',
    'type' => 'textarea',
    );


//Login Options
$panel_fields[] = array(
    'name' => __( 'Login Options', 'alter' ),
    'type' => 'openTab'
    );

$panel_fields[] = array(
    'name' => __( 'Disable Alter styles for login page.', 'alter' ),
    'id' => 'disable_styles_login',
    'type' => 'checkbox',
    'desc' => __( 'Check to disable', 'alter' ),
    'default' => false,
    );

$panel_fields[] = array(
    'name' => __( 'Background color', 'alter' ),
    'id' => 'login_bg_color',
    'type' => 'wpcolor',
    'default' => '#263237',
    );

$panel_fields[] = array(
    'name' => __( 'Background image', 'alter' ),
    'id' => 'login_bg_img',
    'type' => 'upload',
    );

$panel_fields[] = array(
    'name' => __( 'Background Repeat', 'alter' ),
    'id' => 'login_bg_img_repeat',
    'type' => 'checkbox',
    'desc' => __( 'Check to repeat', 'alter' ),
    'default' => true,
    );

$panel_fields[] = array(
    'name' => __( 'Scale background image', 'alter' ),
    'id' => 'login_bg_img_scale',
    'type' => 'checkbox',
    'desc' => __( 'Scale image to fit Screen size.', 'alter' ),
    'default' => true,
    );

$panel_fields[] = array(
    'name' => __( 'Login Form Top margin', 'alter' ),
    'id' => 'login_form_margintop',
    'type' => 'number',
    'default' => '100',
    'min' => '0',
    'max' => '700',
    );

$panel_fields[] = array(
    'name' => __( 'Login Form Width in %', 'alter' ),
    'id' => 'login_form_width',
    'type' => 'number',
    'default' => '25',
    'min' => '20',
    'max' => '100',
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
    'name' => __( 'Transparent Form', 'alter' ),
    'id' => 'login_divbg_transparent',
    'type' => 'checkbox',
    'default' => true,
    'desc' => __( 'Select to show transparent form background.', 'alter' ),
    );

$panel_fields[] = array(
    'name' => __( 'Form inputs background color', 'alter' ),
    'id' => 'login_inputs_bg_color',
    'type' => 'wpcolor',
    'default' => '#324148',
    );

$panel_fields[] = array(
    'name' => __( 'Form inputs text color', 'alter' ),
    'id' => 'login_inputs_text_color',
    'type' => 'wpcolor',
    'default' => '#e5e5e5',
    );

$panel_fields[] = array(
    'name' => __( 'Login div bacground color', 'alter' ),
    'id' => 'login_divbg_color',
    'type' => 'wpcolor',
    'default' => '#f5f5f5',
    );

$panel_fields[] = array(
    'name' => __( 'Login form bacground color', 'alter' ),
    'id' => 'login_formbg_color',
    'type' => 'wpcolor',
    'default' => '#423143',
    );

$panel_fields[] = array(
    'name' => __( 'Form border color', 'alter' ),
    'id' => 'form_border_color',
    'type' => 'wpcolor',
    'default' => '#e5e5e5',
    );

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
    'default' => '#777777',
    );

$panel_fields[] = array(
    'name' => __( 'Form link hover color', 'alter' ),
    'id' => 'form_link_hover_color',
    'type' => 'wpcolor',
    'default' => '#555555',
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
    'type' => 'textarea',
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
    'name' => __( 'Upload Logo', 'alter' ),
    'id' => 'admin_logo',
    'type' => 'upload',
    'desc' => __( 'Image to be displayed in all pages. Maximum size 200x50 pixels.', 'alter' ),
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
    'name' => __( 'Remove items from Admin bar', 'alter' ),
    'id' => 'remove_adminbar_items',
    'type' => 'multicheck',
    'options' => $adminbar_items,
    );



//Admin Options
$panel_fields[] = array(
    'name' => __( 'Button/Metabox Colors', 'alter' ),
    'type' => 'openTab'
);

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

$panel_fields[] = array(
    'name' => __( 'Message box (Post/Page updates)', 'alter' ),
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

//Admin menu Options
$panel_fields[] = array(
    'name' => __( 'Admin menu Colors', 'alter' ),
    'type' => 'openTab'
    );

$panel_fields[] = array(
    'name' => __( 'Admin menu width', 'alter' ),
    'id' => 'admin_menu_width',
    'type' => 'number',
    'default' => '230',
    'min' => '180',
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
    'name' => __( 'Menu hover color', 'alter' ),
    'id' => 'hover_menu_color',
    'type' => 'wpcolor',
    'default' => '#121d28',
    );	

$panel_fields[] = array(
    'name' => __( 'Active Menu color', 'alter' ),
    'id' => 'active_menu_color',
    'type' => 'wpcolor',
    'default' => '#379392',
    );	

$panel_fields[] = array(
    'name' => __( 'Menu text color', 'alter' ),
    'id' => 'nav_text_color',
    'type' => 'wpcolor',
    'default' => '#8aa0a0',
    );	

$panel_fields[] = array(
    'name' => __( 'Menu hover text color', 'alter' ),
    'id' => 'menu_hover_text_color',
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
