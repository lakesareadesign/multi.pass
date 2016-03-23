<?php
/*
Plugin Name: Clientside
Plugin URI: http://frique.me/clientside/
Description: Clientside is a meticulous combination of a redesigned admin theme and a set of settings and tools that help customize and unclutter the WordPress interface for yourself or your clients.
Version: 1.1.12
Author: Berend de Jong
Author URI: http://frique.me/
*/

// Prevent direct access to this file
defined( 'ABSPATH' ) || die();

// Load plugin classes
include( plugin_dir_path( __FILE__ ) . 'inc/php-array-replace-recursive.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-setup.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-options.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-dashboard.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-toolbar.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-pages.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-menu.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-admin-menu-editor.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-admin-widget-manager.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-admin-column-manager.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-user.php' );
include( plugin_dir_path( __FILE__ ) . 'class-clientside-error-handler.php' );

// Plugin setup
add_action( 'admin_enqueue_scripts', array( 'Clientside_Setup', 'action_enqueue_admin_styles' ) );
add_action( 'admin_enqueue_scripts', array( 'Clientside_Setup', 'action_enqueue_admin_scripts' ) );
add_action( 'login_enqueue_scripts', array( 'Clientside_Setup', 'action_enqueue_login_styles' ) );
add_action( 'login_enqueue_scripts', array( 'Clientside_Setup', 'action_enqueue_login_scripts' ) );
add_filter( 'plugin_action_links', array( 'Clientside_Setup', 'filter_add_plugin_options_link' ), 10, 2 );
add_filter( 'plugin_action_links', array( 'Clientside_Setup', 'filter_remove_plugin_deactivation' ), 10, 4 );
add_filter( 'body_class', array( 'Clientside_Setup', 'filter_add_body_classes' ) );
add_filter( 'admin_body_class', array( 'Clientside_Setup', 'filter_add_body_classes' ) );
add_filter( 'login_body_class', array( 'Clientside_Setup', 'filter_add_body_classes' ) );
add_action( 'wp_enqueue_scripts', array( 'Clientside_Setup', 'action_dequeue_fonts' ) );
add_action( 'admin_enqueue_scripts', array( 'Clientside_Setup', 'action_enqueue_admin_fonts' ) );
add_action( 'login_enqueue_scripts', array( 'Clientside_Setup', 'action_enqueue_login_fonts' ) );
add_action( 'admin_init', array( 'Clientside_Setup', 'action_enqueue_editor_styles' ) );
add_action( 'plugins_loaded', array( 'Clientside_Setup', 'action_prepare_translations' ) );
add_filter( 'all_plugins', array( 'Clientside_Setup', 'filter_trim_plugin_list' ) );

// Register plugin options
add_action( 'admin_init', array( 'Clientside_Options', 'action_register_settings_and_fields' ) );
add_action( 'network_admin_edit_clientside_options', array( 'Clientside_Options', 'action_network_option_save' ) );

// General functionality
add_filter( 'login_headerurl', array( 'Clientside', 'filter_change_login_logo_link' ) );
add_filter( 'login_headertitle', array( 'Clientside', 'filter_change_login_logo_title' ) );
add_action( 'login_head', array( 'Clientside', 'action_change_login_logo' ) );
add_filter( 'admin_footer_text', array( 'Clientside', 'filter_footer_text' ) );
add_filter( 'update_footer', array( 'Clientside', 'filter_footer_version' ), 11 );
add_action( 'init', array( 'Clientside', 'action_hide_updates' ) );
add_action( 'init', array( 'Clientside', 'action_hide_screen_options' ) );
add_action( 'admin_head', array( 'Clientside', 'action_hide_help' ) );
add_filter( 'login_errors', array( 'Clientside', 'filter_login_errors' ) );
add_action( 'init', array( 'Clientside', 'action_remove_version_header' ) );
add_action( 'admin_init', array( 'Clientside', 'action_hide_post_list_date_filter' ) );
add_action( 'admin_init', array( 'Clientside', 'action_hide_post_list_category_filter' ) );
add_filter( 'edit_posts_per_page', array( 'Clientside', 'filter_paging_posts' ) );
add_filter( 'admin_menu', array( 'Clientside', 'action_disable_file_editor' ), 9 );

// Admin widget manipulation
add_action( 'wp_dashboard_setup', array( 'Clientside_Dashboard', 'action_add_dashboard_widgets' ) );
add_action( 'do_meta_boxes', array( 'Clientside_Admin_Widget_Manager', 'action_remove_dashboard_widgets' ) );
add_action( 'do_meta_boxes', array( 'Clientside_Admin_Widget_Manager', 'action_remove_post_edit_screen_widgets' ) );

// List Column manipulation
add_filter( 'manage_posts_columns', array( 'Clientside_Admin_Column_Manager', 'filter_remove_posts_columns' ) );
add_filter( 'manage_pages_columns', array( 'Clientside_Admin_Column_Manager', 'filter_remove_pages_columns' ) );
add_filter( 'manage_users_columns', array( 'Clientside_Admin_Column_Manager', 'filter_remove_users_columns' ) );
add_filter( 'manage_media_columns', array( 'Clientside_Admin_Column_Manager', 'filter_remove_media_columns' ) );

// Menu manipulation
add_action( 'admin_menu', array( 'Clientside_Menu', 'action_add_menu_entries' ), 2000 );
add_action( 'network_admin_menu', array( 'Clientside_Menu', 'action_add_network_menu_entries' ) );
add_action( 'admin_menu', array( 'Clientside_Admin_Menu_Editor', 'action_gather_admin_menu' ), 2010 );
add_action( 'init', array( 'Clientside_Admin_Menu_Editor', 'action_prepare_menu_changes' ) );
add_filter( 'parent_file', array( 'Clientside_Menu', 'filter_admin_menu_active_states' ) );
add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', array( 'Clientside_Admin_Menu_Editor', 'filter_apply_custom_menu_order' ), 2020 );
add_action( 'admin_menu', array( 'Clientside_Admin_Menu_Editor', 'action_apply_custom_menu_removal' ), 2030 );
add_action( 'admin_menu', array( 'Clientside_Admin_Menu_Editor', 'action_apply_custom_menu_unremoval' ), 2030 );
add_action( 'admin_menu', array( 'Clientside_Menu', 'action_add_numbers' ) );
add_action( 'admin_menu', array( 'Clientside_Admin_Menu_Editor', 'action_apply_custom_menu_renaming' ), 99 );

// Toolbar manipulation
add_action( 'admin_bar_menu', array( 'Clientside_Toolbar', 'action_add_toolbar_nodes_sooner' ), 0 );
add_action( 'admin_bar_menu', array( 'Clientside_Toolbar', 'action_add_toolbar_nodes_later' ) );
add_action( 'admin_bar_menu', array( 'Clientside_Toolbar', 'action_remove_toolbar_nodes' ), 999 );
add_action( 'init', array( 'Clientside_Toolbar', 'action_hide_toolbar' ) );
add_action( 'wp_enqueue_scripts', array( 'Clientside_Toolbar', 'action_enqueue_site_toolbar_styles' ) );
add_filter( 'admin_bar_menu', array( 'Clientside_Toolbar', 'filter_user_greeting' ) );
add_action( 'init', array( 'Clientside_Toolbar', 'action_remove_toolbar_css_injection' ) );

// Uninstallation hook
register_uninstall_hook( __FILE__, array( 'Clientside_Setup', 'action_uninstall' ) );

// Update script
include( plugin_dir_path( __FILE__ ) . 'inc/wp-updates-plugin.php' );
new WPUpdatesPluginUpdater_989( 'http://wp-updates.com/api/2/plugin', plugin_basename( __FILE__ ) );

// Custom error handling
add_action( 'init', array( 'Clientside_Error_Handler', 'action_collect_php_errors' ) );
add_action( 'all_admin_notices', array( 'Clientside_Error_Handler', 'action_output_php_errors' ) );