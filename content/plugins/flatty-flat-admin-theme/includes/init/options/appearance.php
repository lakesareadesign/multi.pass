<?php

///////////////SHOW CUSTOM FAVICON
add_action('login_head', 'flatty_display_custom_favicon');
add_action('admin_head', 'flatty_display_custom_favicon');
function flatty_display_custom_favicon(){
	$favicon_url = "";
	if (get_option('flatty_custom_favicon') == true) {
	  	$favicon_url = get_option('flatty_custom_favicon');
		echo '<link rel="icon" href="' . $favicon_url . '" />';
	}
}

///////////////HIDE WORDPRESS TOOLBAR
if (get_option('flatty_hide_worpdress_toolbar_frontend') == true) {
	add_filter('show_admin_bar', '__return_false');
};

///////////////USE FLATTY TOPBAR
if (get_option('flatty_use_flatty_topbar') == true) {
	require_once( dirname( __FILE__ ) . '/appearance/topbar.php' );
}

///////////////SUPPORT WIDGET PANEL
if (get_option('flatty_support_widget_show') == true && get_option('flatty_support_widget_placement') === 'panel') {
	require_once( dirname( __FILE__ ) . '/appearance/support_widget_panel.php' );
}

///////////////HIDE WORDPRESS TOPBAR LOGO
function flatty_hide_wp_topbar_logo(){
	if (get_option('flatty_wp_hide_topbar_logo') == true) {
		echo '<style> #wp-admin-bar-wp-logo{display: none!important;} </style>';
	}
}
add_action( 'admin_head', 'flatty_hide_wp_topbar_logo' );

///////////////ALWAYS FOLDED SIDEBAR
if (get_option('flatty_sidebar_folded') == true) {
	add_filter( 'admin_body_class', 'add_folded_body_class' );

	function add_folded_body_class( $classex ) {
		$classex .= ' ' . 'folded';
	    return $classex; 
	}
}

///////////////FOOTER OPTIONS
if (get_option('flatty_wp_flatty_footer_show') == true) {

	function flatty_wp_flatty_remove_footer(){
		echo '<style> #wpfooter {display:none;}</style>';
	}
	add_action('admin_head', 'flatty_wp_flatty_remove_footer');

	function flatty_custom_footer() {
		echo '<div class="flatty-custom-footer">';

			if (get_option('flatty_wp_flatty_footer_custom_text') !== '') {
				$custom_text = get_option('flatty_wp_flatty_footer_custom_text');
				echo '<div class="flatty-custom-footer-item"><i class="dashicons dashicons-info"></i>' . $custom_text . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_wordpress') == true) {
				$blogversion = get_bloginfo('version');
				echo '<div class="flatty-custom-footer-item"><i class="dashicons dashicons-wordpress-alt"></i>' . $blogversion . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_mysql') == true) {
				$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD );
				$mysql_server = explode( '-', mysqli_get_server_info( $mysqli ) );
				$mysqli->close();
				echo '<div class="flatty-custom-footer-item"><i style="font-style:italic; font-weight:700;">MYSQL</i>' . $mysql_server[0] . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_php') == true) {
				echo '<div class="flatty-custom-footer-item"><i style="font-style:italic; font-weight:700;">PHP</i>' . phpversion() . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_server_protocol') == true) {
				echo '<div class="flatty-custom-footer-item"><i class="dashicons dashicons-admin-site"></i>' . $_SERVER['SERVER_PROTOCOL'] . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_server_address') == true) {
				echo '<div class="flatty-custom-footer-item"><i style="font-style:italic; font-weight:700;">IP</i>' . $_SERVER['SERVER_ADDR'] . '</div>';
			}

			if (get_option('flatty_wp_flatty_footer_show_server_software') == true) {
				echo '<div class="flatty-custom-footer-item"><i style="font-style:italic; font-weight:700;">INFO</i>' . $_SERVER['SERVER_SOFTWARE'] . '</div>';
			}


		echo '</div>';
	}
	add_action('admin_footer', 'flatty_custom_footer');
}
?>
