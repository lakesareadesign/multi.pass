<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_recaptcha_config', 20 );
	function um_recaptcha_config($sections){

		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'Google reCAPTCHA','um-recaptcha'),
			'fields'     => array(

				array(
					'id'       		=> 'g_recaptcha_status',
					'type'     		=> 'switch',
					'title'   		=> __( 'Enable Google reCAPTCHA','um-recaptcha' ),
					'default' 		=> 1,
					'desc' 	   		=> __('Turn on or off your Google reCAPTCHA on your site registration and login forms by default.','um-recaptcha'),
				),

				array(
					'id'       		=> 'g_recaptcha_sitekey',
					'type'     		=> 'text',
					'title'   		=> __( 'Site Key','um-recaptcha' ),
					'desc' 	   		=> __('You can register your site and generate a site key via <a href="https://www.google.com/recaptcha/">Google reCAPTCHA</a>','um-recaptcha'),
				),

				array(
					'id'       		=> 'g_recaptcha_secretkey',
					'type'     		=> 'text',
					'title'   		=> __( 'Secret Key','um-recaptcha' ),
					'desc' 	   		=> __('Keep this a secret. You can get your secret key via <a href="https://www.google.com/recaptcha/">Google reCAPTCHA</a>','um-recaptcha'),
				),

				array(
					'id'       		=> 'g_recaptcha_language_code',
	                'type'     		=> 'select',
					'select2'		=> array( 'allowClear' => 0, 'minimumResultsForSearch' => 0 ),
	                'title'   		=> __( 'Language','ultimatemember' ),
					'default' 		=> 'en',
					'desc' 	   		=> __('Select the language to be used in your reCAPTCHA.','ultimatemember'),
					'options' 		=> array(
										'ar'     => 'Arabic',
										'af'     => 'Afrikaans',
										'am'     => 'Amharic',
										'hy'     => 'Armenian',
										'az'     => 'Azerbaijani',
										'eu'     => 'Basque',
										'bn'     => 'Bengali',
										'bg'     => 'Bulgarian',
										'ca'     => 'Catalan',
										'zh-HK'  => 'Chinese (Hong Kong)',
										'zh-CN'  => 'Chinese (Simplified)',
										'zh-TW'  => 'Chinese (Traditional)',
										'hr'     => 'Croatian',
										'cs'     => 'Czech',
										'da'     => 'Danish',
										'nl'     => 'Dutch',
										'en-GB'  => 'English (UK)',
										'en'     => 'English (US)',
										'et'     => 'Estonian',
										'fil'    => 'Filipino',
										'fi'     => 'Finnish',
										'fr'     => 'French',
										'fr-CA'  => 'French (Canadian)',
										'gl'     => 'Galician',
										'ka'     => 'Georgian',
										'de'     => 'German',
										'de-AT'  => 'German (Austria)',
										'de-CH'  => 'German (Switzerland)',
										'el'     => 'Greek',
										'gu'     => 'Gujarati',
										'iw'     => 'Hebrew',
										'hi'     => 'Hindi',
										'hu'     => 'Hungarain',
										'is'     => 'Icelandic',
										'id'     => 'Indonesian',
										'it'     => 'Italian',
										'ja'     => 'Japanese',
										'kn'     => 'Kannada',
										'ko'     => 'Korean',
										'lo'     => 'Laothian',
										'lv'     => 'Latvian',
										'lt'     => 'Lithuanian',
										'ms'     => 'Malay',
										'ml'     => 'Malayalam',
										'mr'     => 'Marathi',
										'mn'     => 'Mongolian',
										'no'     => 'Norwegian',
										'fa'     => 'Persian',
										'pl'     => 'Polish',
										'pt'     => 'Portuguese',
										'pt-BR'  => 'Portuguese (Brazil)',
										'pt-PT'  => 'Portuguese (Portugal)',
										'ro'     => 'Romanian',
										'ru'     => 'Russian',
										'sr'     => 'Serbian',
										'si'     => 'Sinhalese',
										'sk'     => 'Slovak',
										'sl'     => 'Slovenian',
										'es'     => 'Spanish',
										'es-419' => 'Spanish (Latin America)',
										'sw'     => 'Swahili',
										'sv'     => 'Swedish',
										'ta'     => 'Tamil',
										'te'     => 'Telugu',
										'th'     => 'Thai',
										'tr'     => 'Turkish',
										'uk'     => 'Ukrainian',
										'ur'     => 'Urdu',
										'vi'     => 'Vietnamese',
										'zu'     => 'Zulu'
					)
				)

			)

		);

		return $sections;

	}
