<?php
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
	add_action('login_enqueue_scripts','flatty_show_google_recaptcha' );
	function flatty_show_google_recaptcha(){
		if (get_option('flatty_login_recaptcha-use') == true) {
			wp_register_script('google_recaptcha', 'https://www.google.com/recaptcha/api.js' );
			wp_enqueue_script('google_recaptcha');
		}
	}
	///////////////INCLUDE GOOGLE RECAPTCHA
	add_action('login_form', 'flatty_include_google_recaptcha');
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
	add_filter('wp_authenticate_user', 'flatty_auth_google_recaptcha', 10, 2);
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
