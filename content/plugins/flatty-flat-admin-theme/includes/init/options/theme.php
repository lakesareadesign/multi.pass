<?php
///////////////USE SYSTEM FONT
function flatty_use_system_font(){
	if (get_option('flatty_system_font') == false) {
		wp_enqueue_style('flatty-font', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,700');
		echo '<style> body{font-family:"Source Sans Pro", -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif} </style>';
	}
}
add_action( 'admin_head', 'flatty_use_system_font' );


///////////////HIDE WORDPRESS TOPBAR LOGO
function flatty_hide_wp_topbar_logo(){
	if (get_option('flatty_wp_hide_topbar_logo') == true) {
		echo '<style> #wp-admin-bar-wp-logo{display: none!important;} </style>';
	}
}
add_action( 'admin_head', 'flatty_hide_wp_topbar_logo' );

///////////////ENABLE FOLDED SIDEBAR
if (get_option('flatty_sidebar_folded') == true) {
	wp_register_style('flatty-flatty_sidebar_folded', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/themes/sidebar-folded.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-flatty_sidebar_folded');
}

///////////////FOOTER OPTIONS
if (get_option('flatty_wp_flatty_footer_show') == true) {

	function flatty_wp_flatty_remove_footer(){
		echo '<style> #wpfooter {display:none;}</style>';
	}
	add_action('admin_head', 'flatty_wp_flatty_remove_footer');

	function flatty_custom_footer() {
		echo '<div class="flatty-custom-footer">';

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
