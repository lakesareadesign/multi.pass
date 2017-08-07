<?php
///////////////HIDE DASHBOARD WIDGETS
add_action('wp_dashboard_setup', 'flatty_hide_dashboard_widgets' );
function flatty_hide_dashboard_widgets(){
	global $wp_meta_boxes;

	if (get_option('flatty_wp_hide_dashboard_recent_comments') == true) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); //Recent comments
	}
	if (get_option('flatty_wp_hide_dashboard_quickpress') == true) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); //Quick Press widget
	}
	if (get_option('flatty_wp_hide_dashboard_drafts') == true) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); //Recent Drafts
	};
	if (get_option('flatty_wp_hide_dashboard_primary') == true) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); //WordPress.com Blog
	};
	if (get_option('flatty_wp_hide_dashboard_news') == true) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); //Other WordPress News
	};
	if (get_option('flatty_wp_hide_dashboard_links') == true) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); //Incoming Links
	};
	if (get_option('flatty_wp_hide_dashboard_plugins') == true) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); //Plugins
	};
	if (get_option('flatty_wp_hide_dashboard_activity') == true) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']); //Activity
	};
	if (get_option('flatty_wp_hide_dashboard_right_now') == true) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); //Right Now
	};
}