<?php

///////////////HIDE WORDPRESS TOPBAR
function flatty_hide_wp_topbar(){
	if (get_option('flatty_wp_hide_topbar') == true) {
		echo '<style> #wpadminbar {display: none;} </style>';
		echo '
		<div class="flatty-top-bar">
			<a class="flatty-view-site" target="_blank" href="' . get_home_url() . '"><i class="fa fa-television"></i>
 View Site</a>
			<a class="flatty-logout" href="' . wp_logout_url() . '"><i class="fa fa-sign-out"></i> Logout</a>
		</div>
		';
	}
}
add_action( 'admin_head', 'flatty_hide_wp_topbar' );

/*/////////////////HIDE SIDEBAR SEPARATOR*/
function flatty_admin_hide_sidebar_separator(){
	if (get_option('flatty_hide_sidebar_separator') == true) {
		echo '<style>
		#adminmenu li.wp-menu-separator,
		#adminmenu div.separator {
			background-color:transparent;
		}</style>';
	}
}
add_action('in_admin_header','flatty_admin_hide_sidebar_separator' );

///////////////HIDE WORDPRESS TOPBAR LOGO
function flatty_hide_wp_topbar_logo(){
	if (get_option('flatty_wp_hide_topbar_logo') == true) {
		echo '<style> #wp-admin-bar-wp-logo{display: none!important;} </style>';
	}
}
add_action( 'admin_head', 'flatty_hide_wp_topbar_logo' );

///////////////HIDE WORDPRESS FOOTER
function flatty_hide_wp_footer(){
	if (get_option('flatty_wp_hide_footer') == true) {
		echo '<style> #wpfooter {display:none;} </style>';
	}
}
add_action( 'admin_head', 'flatty_hide_wp_footer' );

?>
