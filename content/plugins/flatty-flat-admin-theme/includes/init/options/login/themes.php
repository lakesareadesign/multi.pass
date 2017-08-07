<?php
///////////////LOGIN THEME
if (get_option('flatty_login_theme_enable') == true) {

	add_action('login_head','flatty_login_themes' );
	function flatty_login_themes(){
		//LIGHT
		if (get_option('flatty_login_theme') === 'light') {
			echo '
			<style>
			body.login {
				background: rgb(238,238,238);
				background: linear-gradient(135deg, rgb(255, 255, 255) 0%,rgb(191, 191, 191) 100%);
			}
			.login form {
				border-top: solid 10px #0085ba;
				box-shadow: 0 80px 200px rgba(0, 0, 0, 0.2);
			}
			.flatty-login-footer {
				background-color: rgb(76, 76, 76);
				color:#fff;
			}
			.login form .input {
				border-bottom: solid 2px #eee;
			}
			</style>
			';
		}
		//DARK
		elseif (get_option('flatty_login_theme') === 'dark') {
			echo '
			<style>
			body.login {
				background: rgb(69,72,77);
				background: linear-gradient(to bottom, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%);
			}
			.login form {
				border-top: solid 10px #555d66;
				box-shadow: 0 80px 200px rgba(0, 0, 0, 0.2);
			}
			.login #backtoblog a, 
			.login #nav a {
				color:#ccc;
			}
			.flatty-login-footer {
				background-color: transparent;
				color: #ccc;
			}
			.login form .input {
				border-bottom: solid 2px #eee;
			}
			#login .button-primary {
				background-color:#555d66;
				text-shadow:none;
			}
			</style>
			';
		}
		//MINIMAL LIGHT
		elseif (get_option('flatty_login_theme') === 'minimal_light') {
			echo '
			<style>
			.login * {
				margin:initial;
			}
			body.login {
				background: rgb(236, 236, 236);
			}
			#login {
				max-width:100%;
				padding: 15% 0 0;
			}
			.login form {
			    display: flex;
			    flex-wrap: wrap;
			    justify-content:space-around;
			    align-items: center;
			    box-sizing: border-box;
			    padding: 20px;
			    width: 100%;
			    max-width: 600px;
			    background: none;
			    border: none;
			    box-shadow: none!important;
			    margin: 0;
			}
			.login label {
				color: #607D8B;
				font-size:14px;
			    font-weight: 200!important;
			    letter-spacing: 1px;
			}
			.login form .input {
				background:transparent!important;
				border-radius:0;
			}
			#login form p {
				margin-bottom:10px;
			}
			.login form .input, 
			.login form input[type=checkbox], 
			.login input[type=text] {
				background: #607D8B;
	    		border: 1px solid #607D8B;
	    		margin-right:10px;
			}
			input[type=checkbox]:checked:before {
				color:#fff;
				margin: -3px 0 0 -4px;
			}
			.login form .forgetmenot {
				width:100%;
				text-align:center;
			    margin-top: 0!important;
			    margin-bottom:50px!important;
			}
			.login #backtoblog a, 
			.login #nav a {
				color:#607D8B;
			}
			.flatty-login-footer {
				background-color: transparent;
				color: #607D8B;
			}
			#login .button-primary {
				background-color: transparent;
			    border: solid 2px #666;
			    border-radius: 10px;
			    box-shadow: none!important;
			    text-shadow: none;
			    height: auto;
			    padding: 5px 50px;
			}
			.login #login_error, .login .message {
			    box-sizing: border-box;
			    max-width: 355px;
			    margin: auto!important;
			    text-align: center;
			    border: none;
			    background: none;
			    color: #ff6e63;
			    box-shadow: none;
			}
			</style>
			';
		}
		//MINIMAL DARK 
		elseif (get_option('flatty_login_theme') === 'minimal_dark') {
			echo '
			<style>
			.login * {
				margin:initial;
			}
			body.login {
				background: rgb(38, 39, 41);
			}
			#login {
				max-width:100%;
				padding: 15% 0 0;
			}
			.login form {
			    display: flex;
			    flex-wrap: wrap;
			    justify-content:space-around;
			    align-items: center;
			    box-sizing: border-box;
			    padding: 20px;
			    width: 100%;
			    max-width: 600px;
			    background: none;
			    border: none;
			    box-shadow: none!important;
			    margin: 0;
			}
			.login label {
				color: #eee;
				font-size:14px;
			    font-weight: 200!important;
			    letter-spacing: 1px;
			}
			.login form .input {
				background:transparent!important;
				border-radius:0;
			}
			#login form p {
				margin-bottom:10px;
			}
			.login form .input, 
			.login form input[type=checkbox], 
			.login input[type=text] {
				background: #333;
	    		border: 1px solid #333;
	    		margin-right:10px;
			}
			input[type=checkbox]:checked:before {
				color:#ccc;
			}
			.login form .forgetmenot {
				width:100%;
				text-align:center;
			    margin-top: 0!important;
			    margin-bottom:50px!important;
			}
			.login #backtoblog a, 
			.login #nav a {
				color:#555;
			}
			.flatty-login-footer {
				background-color: transparent;
				color: #666;
			}
			#login .button-primary {
			    background-color: transparent;
			    border: solid 2px #eee;
			    border-radius: 10px;
			    box-shadow: none!important;
			    text-shadow: none;
			    height: auto;
			    padding: 5px 50px;
			}
			.login #login_error, .login .message {
			    box-sizing: border-box;
			    max-width: 355px;
			    margin: auto!important;
			    text-align: center;
			    border: none;
			    background: none;
			    color: #ff6e63;
			    box-shadow: none;
			}
			</style>
			';
		}
	}
}

///////////////CUSTOM CSS
if (get_option('flatty_login_custom_css_enable') == true) {
	if (get_option('flatty_login_custom_css_enable') !== '') {
		add_action('login_head','flatty_login_customcss' );
		function flatty_login_customcss(){
			$custom_css = get_option('flatty_login_custom_css');
			echo '<style>' . $custom_css . '</style>';
		}
	}
}
///////////////CUSTOM LOGO
if (get_option('flatty_custom_logo') !== '') {
	add_action('login_head','flatty_login_custom_logo' );
	function flatty_login_custom_logo(){
		$custom_logo = get_option('flatty_custom_logo');
		echo '<style> .login h1 a {background-image:url("' . $custom_logo . '"); background-size:contain; width:100%;}</style>';
	}
}
///////////////HIDE LOGO
if (get_option('flatty_login_logo_hide') == true) {
	add_action('login_head','flatty_login_logo_hide' );
	function flatty_login_logo_hide(){
		echo '<style> .login h1 a {display:none;}</style>';
	}
}
///////////////ADD LOGIN FOOTER
if (get_option('flatty_login_footer_show') !== '') {
	add_action('login_footer','flatty_login_show_footer' );
	function flatty_login_show_footer(){
		$login_footer = get_option('flatty_login_show-footer');
		echo '<div class="flatty-login-footer">' . $login_footer . '</div>';
	}
}
///////////////CUSTOM LOGIN BACKGROUND
if (get_option('flatty_login_background_enable') == true) {
	if (get_option('flatty_login_background_url') !== '') {
		add_action('login_head','flatty_login_custom_background' );
		function flatty_login_custom_background() {
			$custom_login_background = get_option('flatty_login_background_url');
			echo '<style> body.login {min-height:100vh; background-image:url("' . $custom_login_background . '"); background-size:cover; background-position:center;}</style>';
		}
	}
}
 
