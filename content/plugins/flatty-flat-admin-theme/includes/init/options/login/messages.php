<?php
///////////////HIDE LOGIN LOST PASSWORD
if (get_option('flatty_login_hide_lostpassword') == true) {
	add_action('login_head','flatty_login_hide_lostpassword' );
	function flatty_login_hide_lostpassword(){
		echo '<style> .login #nav a {display:none!important;}</style>';
	}
}
///////////////HIDE LOGIN BACK TO BLOG
if (get_option('flatty_login_hide_lostpassword') == true) {
	add_action('login_head','flatty_login_hide_backtoblog' );
	function flatty_login_hide_backtoblog(){
		echo '<style> .login #backtoblog {display:none!important;}</style>';
	}
}
///////////////HIDE LOGIN MESSAGES
if (get_option('flatty_login_hide_messages') == true) {
	add_action('login_head','flatty_login_hide_messages' );
	function flatty_login_hide_messages(){
		echo '<style> .login .message {display:none!important;}</style>';
	}
}
///////////////HIDE LOGIN ERRORS
if (get_option('flatty_login_hide-errors') == true) {
	add_action('login_head','flatty_login_hide_errors' );
	function flatty_login_hide_errors(){
		echo '<style> .login #login_error {display:none!important;}</style>';
	}
}
