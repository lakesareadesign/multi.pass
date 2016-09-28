<?php
///////////////LOGIN THEMES
function flatty_login_themes(){

	if (get_option('flatty_login_style') === 'light') {
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
	} elseif (get_option('flatty_login_style') === 'dark') {
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
	} elseif (get_option('flatty_login_style') === 'minimal-light') {
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
		    box-shadow: none;
		    margin: 0;
		}
		.login label {
			color: #607D8B;
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
			background-color: #607D8B;
			text-shadow:none;
    		padding: 10px 40px;
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
	} elseif (get_option('flatty_login_style') === 'minimal-dark') {
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
		    box-shadow: none;
		    margin: 0;
		}
		.login label {
			color: #666;
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
			background-color: #303538;
			text-shadow:none;
    		padding: 10px 40px;
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
	} elseif (get_option('flatty_login_style') === 'custom_css') {
		$custom_css = get_option('flatty_login_custom_css');
		echo '<style>' . $custom_css . '</style>';
	}

}
add_action('login_head','flatty_login_themes' );

///////////////CUSTOM LOGIN BACKGROUND
function flatty_login_custom_background(){
	if (get_option('flatty_login_custom_bkg') !== '') {
		$custom_login_background = get_option('flatty_login_custom_bkg');
		echo '<style> body.login {min-height:100vh; background-image:url("' . $custom_login_background . '"); background-size:cover; background-position:center;}</style>';
	}
}
add_action('login_head','flatty_login_custom_background' );

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

///////////////AUTHENTICATE GOOGLE RECAPTCHA
if (get_option('flatty_login_recaptcha-use') == true) {

	///////////////RECAPTCHA CHECK IF SET
	function flatty_recaptcha_is_configured() {
		if (get_option('flatty_login_recaptcha-secret') && get_option('flatty_login_recaptcha-site') ) {
			return true;
		} else {
			return false;
		}
	}

	///////////////SHOW GOOGLE RECAPTCHA
	function flatty_show_google_recaptcha(){
		if (get_option('flatty_login_recaptcha-use') == true) {
			wp_register_script('google_recaptcha', 'https://www.google.com/recaptcha/api.js' );
			wp_enqueue_script('google_recaptcha');
		}
	}
	add_action('login_enqueue_scripts','flatty_show_google_recaptcha' );

	///////////////INCLUDE GOOGLE RECAPTCHA
	function flatty_include_google_recaptcha() {
		if  (flatty_recaptcha_is_configured()) {
			echo '<div class="g-recaptcha" data-sitekey="' . get_option('flatty_login_recaptcha-site') . '"></div>';
			echo '
			<noscript>
			  <div style="width: 302px; height: 495px; margin-bottom: 20px; margin-left: -15px;">
			    <div style="width: 302px; height: 425px; position: relative;">
			      <div style="width: 302px; height: 425px; position: absolute;">
			        <iframe src="https://www.google.com/recaptcha/api/fallback?k=' . get_option("flatty_login_recaptcha-site") . '"
			                frameborder="0" scrolling="no"
			                style="width: 302px; height:425px; border-style: none;">
			        </iframe>
			      </div>
			      <div style="width: 300px; height: 60px; border-style: none;
			                  bottom: 12px; left: 1px; margin: 0px; padding: 0px; right: 1px;
			                  background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px; position: absolute; top: 435px;">
			        <textarea id="g-recaptcha-response" name="g-recaptcha-response"
			                  class="g-recaptcha-response"
			                  style="width: 250px; height: 40px; border: 1px solid #eee;
			                         margin: 10px 25px; padding: 0px; resize: none;" >
			                           
			        </textarea>
			      </div>
			    </div>
			  </div>
			</noscript>
			';
		}
	}
	add_action('login_form', 'flatty_include_google_recaptcha');


	function flatty_auth_google_recaptcha($user, $password) {
		if (isset( $_POST['g-recaptcha-response'] ) ) {
			$recaptcha_secret = get_option('flatty_login_recaptcha-secret');
			$response = wp_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $_POST['g-recaptcha-response'] );
			$response = json_decode( $response['body'], true );
			if ( true === $response['success'] ) {
				return $user;
			} else {
				return new WP_Error( 'Captcha Invalid',  flatty_auth_google_recaptcha_custom_error() );
			}
		} else if ( ! flatty_recaptcha_is_configured() ) {
			return $user;
		}
	}
	add_filter('wp_authenticate_user', 'flatty_auth_google_recaptcha', 10, 2);

	///////////////RECAPTCHA CUSTOM ERROR MESSAGE
	function flatty_auth_google_recaptcha_custom_error() {
		$flatty_recaptcha_custom_error = get_option('flatty_login_recaptcha-error');
		if ( $flatty_recaptcha_custom_error ) {
			return __($flatty_recaptcha_custom_error);
		} else {
			return __('<strong>Google is telling me you are not a human...</strong> Try again.');
		}
	}
}



?>
