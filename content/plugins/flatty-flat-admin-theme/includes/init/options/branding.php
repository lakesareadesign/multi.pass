<?php

///////////////SHOW SITE NAME
function flatty_display_site_name(){
	$current_site = get_option('blogname');
	if (get_option('flatty_show_sitename') == true && get_option('flatty_wp_hide_topbar') == true) {
		echo '<div class="flatty-site-name">' . $current_site . '</div>';
	} elseif (get_option('flatty_show_sitename') == true && get_option('flatty_wp_hide_topbar') != true) {
		echo '<div class="flatty-site-name small">' . $current_site . '</div>';
	}
}
add_action('admin_head','flatty_display_site_name' );



///////////////SHOW SUPPORT BOX
function flatty_display_support_box(){
	if (get_option('flatty_show_site_developer_info') == true) {
		wp_register_style('flatty-addons-supportbox', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/addons/flatty-addons-supportbox.css'), null, FLATTY_VERSION, 'screen');
		wp_enqueue_style('flatty-addons-supportbox');
		if (get_option('flatty_sidebar_minimal') == true) {
			wp_register_style('flatty-sidebar_minimal', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/themes/sidebar-minimal.css'), null, FLATTY_VERSION, 'screen');
			wp_enqueue_style('flatty-sidebar_minimal');
		}

		echo '<div id="support-box" class="flatty-support-box">';
			if (get_option('flatty_show_site_developer_info_name') !== '') {
				$support_name = get_option('flatty_show_site_developer_info_name');
				echo '<div class="support-name">' . $support_name . '</div>';
			}
			if (get_option('flatty_show_site_developer_info_website') !== '') {
				$support_website = get_option('flatty_show_site_developer_info_website');
				echo '<div class="support-website"><a href="' . $support_website . '" target="_blank" title="'. $support_website .'"><i class="fa fa-globe"></i></a></div>';
			}
			if (get_option('flatty_show_site_developer_info_email') !== '') {
				$support_email = get_option('flatty_show_site_developer_info_email');
				echo '<div class="support-email"><a href="mailto:' . $support_email . '" title="'. $support_email .'"><i class="fa fa-envelope-o"></i></a></div>';
			}
			if (get_option('flatty_show_site_developer_info_phone') !== '') {
				$support_phone = get_option('flatty_show_site_developer_info_phone');
				echo '<div class="support-phone"><i class="fa fa-phone"></i><div class="support-phone-hover">'. $support_phone .'</div></div>';
			}
		echo '</div>';
	}
}
add_action('admin_head','flatty_display_support_box' );

///////////////SHOW CUSTOM LOGO
function flatty_display_custom_logo(){
	if (get_option('flatty_custom_logo') !== '' && get_option('flatty_hide_custom_logo') == false && get_option('flatty_show_sitename') == true) {
		$custom_logo = get_option('flatty_custom_logo');
		echo '<div class="flatty-top-bar-logo"><img src="' . $custom_logo . '"/></div>';
	}
}
add_action('admin_head','flatty_display_custom_logo' );

///////////////SHOW CUSTOM FAVICON
function flatty_display_custom_favicon(){
	if (get_option('flatty_custom_favicon') == true) {
	  	$favicon_url = get_option('flatty_custom_favicon');
		echo '<link rel="icon" href="' . $favicon_url . '" />';
	}
}
add_action('login_head', 'flatty_display_custom_favicon');
add_action('admin_head', 'flatty_display_custom_favicon');



?>
