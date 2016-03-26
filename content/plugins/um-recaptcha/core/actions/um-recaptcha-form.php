<?php

	/***
	***	@add recaptcha
	***/
	add_action('um_after_register_fields', 'um_recaptcha_add_captcha', 500);
	add_action('um_after_login_fields', 'um_recaptcha_add_captcha', 500);
	function um_recaptcha_add_captcha($args){
		global $um_recaptcha, $ultimatemember;
		if ( !$um_recaptcha->captcha_allowed( $args ) ) return;

		$your_sitekey = um_get_option('g_recaptcha_sitekey');
		$id = 'gcaptch' . rand(0, 100) . time();

		?>

		<div id="<?php echo $id; ?>" class="g-recaptcha"></div>
		<script>
		var renderCaptcha = function() {
			grecaptcha.render('<?php echo $id; ?>', {
    			sitekey: '<?php echo $your_sitekey; ?>'
    		});
		}
		if(typeof grecaptcha === "undefined") {
			jQuery(window).load(function() {
				grecaptcha.render('<?php echo $id; ?>', {
	    			sitekey: '<?php echo $your_sitekey; ?>'
	    		});
			});
		} else {
			renderCaptcha();
		}
		</script>

		<?php

		if ($ultimatemember->form->has_error('recaptcha')) {
			echo '<div class="um-field-error">' . $ultimatemember->form->errors['recaptcha'] . '</div>';
		}

	}

	/***
	***	@form error handling
	***/
	add_action('um_submit_form_errors_hook', 'um_recaptcha_validate', 20);
	function um_recaptcha_validate( $args ){
		global $um_recaptcha, $ultimatemember;

		if ( isset($args['mode']) && !in_array( $args['mode'], array('login','register') ) && ! isset( $args['_social_login_form'] ) ) return;

		if ( !$um_recaptcha->captcha_allowed( $args ) ) return;

		$your_secret = um_get_option('g_recaptcha_secretkey');
		$client_captcha_response = $_POST['g-recaptcha-response'];
		$user_ip = $_SERVER['REMOTE_ADDR'];

		$response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=$your_secret&response=$client_captcha_response&remoteip=$user_ip");
		if( is_array($response) ) {

			$result = json_decode( $response['body'] );

			if ( ! $result->success ) {
				$ultimatemember->form->add_error('recaptcha', __('Please confirm you are not a robot','um-recaptcha') );
			}

		} else {

			$ultimatemember->form->add_error('recaptcha', __('Please confirm you are not a robot','um-recaptcha') );

		}

	}
