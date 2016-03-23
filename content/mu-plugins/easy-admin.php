<?php
/*
Plugin Name: Easy Administration
Plugin URI: http://www.lakesareadesign.com
Description: Simplifies WordPress administration panels.
Version: 1.2
Author: Lakes Area Design
*/

// remove administration page header logo
add_action('admin_head', 'remove_admin_logo');
function remove_admin_logo() {
	echo '<style>img#header-logo { display: none; }</style>';
}

// remove upgrade notification
//add_action('admin_notices', 'no_update_notification', 1);
function no_update_notification() {
	if (!current_user_can('activate_plugins')) remove_action('admin_notices', 'update_nag', 3);
}

/**/
// remove unnecessary dashboard widgets
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
function remove_dashboard_widgets(){
	global $wp_meta_boxes;
	// do not remove "Right Now" for administrators
	if (!current_user_can('activate_plugins')) {
		//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	}
	// remove widgets for everyone
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}

// remove unnecessary menus
add_action('jetpack_admin_menu', 'jetpack_hide_for_all');
function jetpack_hide_for_all() {
   if ( ! current_user_can('activate_plugins') ) {
    remove_menu_page( 'jetpack' );
   }
}


?>