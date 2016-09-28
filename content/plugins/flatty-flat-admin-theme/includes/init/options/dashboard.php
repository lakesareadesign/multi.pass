<?php
///////////////HIDE DASHBOARD WIDGETS
function flatty_hide_dashboard_widgets(){
	if (get_option('flatty_wp_hide_dashboard_quickpress') == true) {
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); //Quick Press widget
	}

	if (get_option('flatty_wp_hide_dashboard_drafts') == true) {
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' ); //Recent Drafts
	};

	if (get_option('flatty_wp_hide_dashboard_primary') == true) {
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); //WordPress.com Blog
	};

	if (get_option('flatty_wp_hide_dashboard_news') == true) {
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' ); //Other WordPress News
	};

	if (get_option('flatty_wp_hide_dashboard_links') == true) {
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' ); //Incoming Links
	};

	if (get_option('flatty_wp_hide_dashboard_plugins') == true) {
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' ); //Plugins
	};

	if (get_option('flatty_wp_hide_dashboard_activity') == true) {
		remove_meta_box( 'dashboard_activity', 'dashboard', 'side' ); //Activity
	};

	if (get_option('flatty_wp_hide_dashboard_right_now') == true) {
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); //Right Now
	};

	if (get_option('flatty_wp_hide_dashboard_welcome_panel') !== '') {
		echo '<style> #welcome-panel {display:none}</style>';
	}

}

add_action( 'wp_dashboard_setup', 'flatty_hide_dashboard_widgets' );

?>
