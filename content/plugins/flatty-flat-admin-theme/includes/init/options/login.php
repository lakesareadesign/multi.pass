<?php

///////////////CUSTOM LOGO
function flatty_login_custom_logo(){
	if (get_option('flatty_custom_logo') !== '') {
		$custom_logo = get_option('flatty_custom_logo');
		echo '<style> .login h1 a {background-image:url("' . $custom_logo . '"); background-size:contain; width:100%;}</style>';
	}
}
add_action('login_head','flatty_login_custom_logo' );

///////////////HIDE LOGIN LOGO
function flatty_login_logo_hide(){
	if (get_option('flatty_logo_hide') == true) {
		echo '<style> .login h1 a {display:none;}</style>';
	} else {
	    echo '<style> .login h1 a {display:block;}</style>';
	}
}
add_action('login_head','flatty_login_logo_hide' );

///////////////CHANGE LOGIN LINK
if (get_option('flatty_login_custom-link') !== '') {

	function flatty_login_custom_link(){
    return get_option('flatty_login_custom-link');
  }

	function flatty_login_custom_link_title(){
    return get_option('flatty_login_custom-link_title');
  }
    add_filter('login_headerurl', 'flatty_login_custom_link');
		add_filter('login_headertitle', 'flatty_login_custom_link_title');
}

///////////////HIDE LOGIN LOST PASSWORD
function flatty_login_hide_lostpassword(){
	if (get_option('flatty_login_hide-lostpassword') == true)
		echo '<style> .login #nav a {display:none!important;}</style>';
}
add_action('login_head','flatty_login_hide_lostpassword' );

///////////////HIDE LOGIN BACK TO BLOG
function flatty_login_hide_backtoblog(){
	if (get_option('flatty_login_hide-lostpassword') == true)
		echo '<style> .login #backtoblog {display:none!important;}</style>';

}
add_action('login_head','flatty_login_hide_backtoblog' );

///////////////HIDE LOGIN MESSAGES
function flatty_login_hide_messages(){
	if (get_option('flatty_login_hide-messages') == true)
		echo '<style> .login .message {display:none!important;}</style>';

}
add_action('login_head','flatty_login_hide_messages' );

///////////////HIDE LOGIN ERRORS
function flatty_login_hide_errors(){
	if (get_option('flatty_login_hide-errors') == true)
		echo '<style> .login #login_error {display:none!important;}</style>';

}
add_action('login_head','flatty_login_hide_errors' );

///////////////SHOW LOGIN FOOTER
function flatty_login_show_footer(){
	$login_footer = get_option('flatty_login_show-footer');

	if (get_option('flatty_login_show-footer') !== '')
		echo '<div class="flatty-login-footer">' . $login_footer . '</div>';
}
add_action('login_footer','flatty_login_show_footer' );

?>
