<?php

class UM_reCAPTCHA_Enqueue {

	function __construct() {

		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 0);

	}

	/***
	***	@enqueue recaptcha
	***/
	function wp_enqueue_scripts(){

		wp_register_style('um_recaptcha', um_recaptcha_url . 'assets/css/um-recaptcha.css' );
		wp_enqueue_style('um_recaptcha');

		$language = um_get_option('g_recaptcha_language_code');

		wp_register_script('um_recaptcha', 'https://www.google.com/recaptcha/api.js?hl=' . $language, '', '', true );
		wp_enqueue_script('um_recaptcha');

	}

}
