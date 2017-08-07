<?php
///////////////CHANGE LOGIN LOGO LINK
if (get_option('flatty_login_logo_customlink_url') !== '') {
	add_filter('login_headerurl', 'flatty_login_custom_link');
	function flatty_login_custom_link(){
		return get_option('flatty_login_logo_customlink_url');
	}
	add_filter('login_headertitle', 'flatty_login_custom_link_title');
	function flatty_login_custom_link_title(){
		return get_option('flatty_login_logo_customlink_title');
	}
}

