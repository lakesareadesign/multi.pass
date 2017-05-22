<?php
/*
Plugin Name: Custom Login Screen
Plugin URI:
Description:
Author: Marcin (Incsub)
Version: 1.0
Author URI:
Network: true

Copyright 2017 Incsub (email: admin@incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if ( ! class_exists( 'ub_custom_login_screen' ) ) {

	class ub_custom_login_screen {

		private $options;
		private $proceed_gettext = false;
		private $patterns = array();

		public function __construct() {
			$this->set_options();
			add_action( 'ultimatebranding_settings_custom_login_screen', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_custom_login_screen_process', array( $this, 'update' ), 10, 1 );
			add_action( 'login_head', array( $this, 'output' ), 99 );
			add_filter( 'login_headerurl', array( $this, 'login_headerurl' ) );
			add_filter( 'login_headertitle', array( $this, 'login_headertitle' ) );
			add_filter( 'wp_login_errors', array( $this, 'wp_login_errors' ) );
			add_filter( 'gettext', array( $this, 'gettext_login_form_labels' ), 20, 3 );
		}

		public function update( $status ) {
			$value = $_POST['simple_options'];
			if ( $value == '' ) {
				$value = 'empty';
			}
			foreach ( $this->options as $section_key => $section_data ) {
				if ( ! isset( $section_data['fields'] ) ) {
					continue;
				}
				foreach ( $section_data['fields'] as $key => $data ) {
					switch ( $data['type'] ) {
						case 'media':
							if ( isset( $value[ $section_key ][ $key ] ) ) {
								$image = wp_get_attachment_image_src( $value[ $section_key ][ $key ], 'full' );
								if ( false !== $image ) {
									$value[ $section_key ][ $key.'_meta' ] = $image;
								}
							}
						break;
						case 'checkbox':
							if ( isset( $value[ $section_key ][ $key ] ) ) {
								$value[ $section_key ][ $key ] = 'on';
							} else {
								$value[ $section_key ][ $key ] = 'off';
							}
					}
				}
			}

			ub_update_option( 'global_login_screen' , $value );

			if ( $status === false ) {
				return $status;
			} else {
				return true;
			}
		}

		public function output() {
			$this->proceed_gettext = true;
			$value = ub_get_option( 'global_login_screen' );
			if ( $value == 'empty' ) {
				$value = '';
			}
			if ( empty( $value ) ) {
				return;
			}
			printf( '<style type="text/css" id="%s">', esc_attr( __CLASS__ ) );

			/**
			 * Logo & Background
			 */
			if ( isset( $value['logo_and_background'] ) ) {
				$v = $value['logo_and_background'];
				/**
				 * show_logo
				 */
				$this->css_hide( $v, 'show_logo', '.login h1' );
				/**
				 * logo
				 */
				if ( isset( $v['logo_upload_meta'] ) ) {
					$src = $v['logo_upload_meta'][0];
					if ( ! empty( $src ) ) {
						$image = $v['logo_upload_meta'];
						$width = $image[1];
						$height = $image[2];

						if ( isset( $v['logo_width'] ) ) {

							$scale = $v['logo_width'] / $width;
							$width = $v['logo_width'];
							$height = intval( $height * $scale );
						} elseif ( $width > 320 ) {
							$scale = 320 / $width ;
							$height = intval( $height * $scale );
							$width = intval( $width * $scale );
						}
?>
#login h1 a {
    background-image: url(<?php echo $src; ?>);
    background-size: 100%;
    height: <?php echo $height; ?>px;
    width: <?php echo $width; ?>px;
}
<?php
					}
				}
				/**
				 * logo_bottom_margin
				 */
				if ( isset( $v['logo_bottom_margin'] ) ) {
?>
#login h1 a {
    margin-bottom: <?php echo $v['logo_bottom_margin']; ?>px;
}
<?php
				}
				/**
				 * logo_transparency
				 */
				$this->css_opacity( $v, 'logo_transparency', '#login h1' );
				/**
				 * bg_color
				 */
				$this->css_background_color( $v, 'bg_color', 'body' );
				/**
				 * fullscreen_bg
				 */
				if ( isset( $v['fullscreen_bg_meta'] ) ) {
					$src = $v['fullscreen_bg_meta'][0];
					if ( ! empty( $src ) ) {
?>
html {
    background: url(<?php echo $src; ?>) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
body {
    background-color: transparent;
}
<?php
					}
				}
			}

			/**
			 * Form
			 */
			if ( isset( $value['form'] ) ) {
				$v = $value['form'];
				/**
				 * rounded_form
				 */
				if ( isset( $v['rounded_form'] ) && 'rounded' == $v['rounded_form'] ) {
?>
.login form {
    -webkit-border-radius: <?php echo intval( $v['rounded_nb'] ); ?>px;
    -moz-border-radius: <?php echo intval( $v['rounded_nb'] ); ?>px;
    border-radius: <?php echo intval( $v['rounded_nb'] ); ?>px;
}
<?php
				}
				/**
				 * label_color
				 */
				$this->css_color( $v, 'label_color', '.login form label' );

				/**
				 * form_bg
				 */
				if ( isset( $v['form_bg_meta'] ) ) {
					$src = $v['form_bg_meta'][0];
					if ( ! empty( $src ) ) {
?>
 .login form {
    background: url(<?php echo $src; ?>) no-repeat center center;
    -webkit-background-size: 100%;
    -moz-background-size: 100%;
    -o-background-size: 100%;
    background-size: 100%;
}
<?php
					}
				}

				/**
				 * form_bg_color
				 * form_bg_transparency
				 */
				$change = false;
				$bg_color = 'none';
				$bg_transparency = 0;
				if ( isset( $v['form_bg_color'] ) ) {
					$bg_color = $v['form_bg_color'];
					$change = true;
				}
				if ( isset( $v['form_bg_transparency'] ) ) {
					$bg_transparency = $v['form_bg_transparency'];
					$change = true;
				}

				if ( $change ) {
					if ( 'none' != $bg_color ) {
						echo '.login form {';
						if ( 0 < $bg_transparency ) {
							$bg_color = $this->convert_hex_to_rbg( $bg_color );
							printf( 'background-color: rgba( %s, %0.2f);', implode( ', ', $bg_color ), $bg_transparency / 100 );
						} else {
							printf( 'background-color: %s;', $bg_color );
						}
						echo '}';
					}
				}

				/**
				 * form_style
				 */
				if ( isset( $v['form_style'] ) && 'shadow' == $v['form_style'] ) {
?>
.login form {
    -webkit-box-shadow: 10px 10px 15px 0px rgba(0,0,0,0.5);
    -moz-box-shadow: 10px 10px 15px 0px rgba(0,0,0,0.5);
    box-shadow: 10px 10px 15px 0px rgba(0,0,0,0.5);
}
<?php
				}
				/**
				 * form_button_color
				 */
				$this->css_background_color( $v, 'form_button_color', '.login form .button,.login form .button:hover' );
				/**
				 * form_button_text_color
				 */
				$this->css_color( $v, 'form_button_text_color', '.login form .button' );
				/**
				 * show_remember_me
				 */
				$this->css_hide( $v, 'show_remember_me', '.login .forgetmenot' );
			}

			/**
			 * Form Error Messages
			 */
			if ( isset( $value['form_errors'] ) ) {
				$v = $value['form_errors'];
				/**
				 * login_error_background_color
				 */
				$this->css_background_color( $v, 'login_error_background_color', '.login #login #login_error' );

				/**
				 * login_error_border_color
				 */
				if ( isset( $v['login_error_border_color'] ) ) {
?>
.login #login #login_error {
    border-color: <?php echo $v['login_error_border_color']; ?>;
}
<?php
				}
				/**
				 * login_error_text_color
				 */
				$this->css_color( $v, 'login_error_text_color', '.login #login #login_error' );
			}

			/**
			 * below_form
			 */
			if ( isset( $value['below_form'] ) ) {
				$v = $value['below_form'];
				/**
				 * show_register_and_lost
				 */
				$this->css_hide( $v, 'show_register_and_lost', '.login #nav' );
				/**
				 * show_back_to
				 */
				$this->css_hide( $v, 'show_back_to', '.login #backtoblog' );
				/**
				 * register_and_lost_color_link
				 */
				$this->css_color( $v, 'register_and_lost_color_link', '.login #nav a' );
				/**
				 * register_and_lost_color_hover
				 */
				$this->css_color( $v, 'register_and_lost_color_hover', '.login #nav a:hover' );
				/**
				 * back_to_color_link
				 */
				$this->css_color( $v, 'back_to_color_link', '.login #backtoblog a' );
				/**
				 * back_to_color_hover
				 */
				$this->css_color( $v, 'back_to_color_hover', '.login #backtoblog a:hover' );
			}

			echo '</style>';
		}

		public function admin_options_page() {
			$value = ub_get_option( 'global_login_screen' );
			if ( $value == 'empty' ) {
				$value = '';
			}
			$simple_options = new simple_options();
			echo $simple_options->build_options( $this->options, $value );
		}

		private function set_options() {

			$login_header_url   = __( 'https://wordpress.org/', 'ub' );
			$login_header_title = __( 'Powered by WordPress', 'ub' );

			if ( is_multisite() ) {
				$login_header_url   = network_home_url();
				$login_header_title = get_network()->site_name;
			}

			/**
			 * invalid username
			 */
			$invalid_username = __( '<strong>ERROR</strong>: Invalid username.' );
			$invalid_username .= ' <a href="WP_LOSTPASSWORD_URL">';
			$invalid_username  .= __( 'Lost your password?', 'ub' );
			$invalid_username  .= '</a>';

			$invalid_password = __( '<strong>ERROR</strong>: The password you entered for the username %s is incorrect.', 'ub' );
			$invalid_password .= ' <a href="WP_LOSTPASSWORD_URL">';
			$invalid_password .= __( 'Lost your password?', 'ub' );
			$invalid_password .= '</a>';

			$this->options = array(
				'logo_and_background' => array(
					'title' => __( 'Logo & Background', 'ub' ),
					'fields' => array(
						'show_logo' => array(
							'type' => 'checkbox',
							'label' => __( 'Logo', 'ub' ),
							'description' => __( 'Would you like to show the logo?', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'logo-related',
						),
						'logo_upload' => array(
							'type' => 'media',
							'label' => __( 'Logo image', 'ub' ),
							'description' => __( 'Upload your own logo. Max width: 320px', 'ub' ),
							'master' => 'logo-related',
						),
						'logo_width' => array(
							'type' => 'number',
							'label' => __( 'Logo width', 'ub' ),
							'default' => 84,
							'min' => 0,
							'max' => 320,
							'classes' => array( 'ui-slider' ),
							'master' => 'logo-related',
						),
						'logo_transparency' => array(
							'type' => 'number',
							'label' => __( 'Logo Transparency', 'ub' ),
							'min' => 0,
							'max' => 100,
							'default' => 100,
							'classes' => array( 'ui-slider' ),
							'master' => 'logo-related',
						),
						'login_header_url' => array(
							'type' => 'text',
							'label' => __( 'Logo URL', 'ub' ),
							'default' => $login_header_url,
							'classes' => array( 'logo-related' ),
							'master' => 'logo-related',
						),
						'login_header_title' => array(
							'type' => 'text',
							'label' => __( 'Logo Alt text', 'ub' ),
							'default' => $login_header_title,
							'classes' => array( 'logo-related' ),
							'master' => 'logo-related',
						),
						'logo_bottom_margin' => array(
							'type' => 'number',
							'label' => __( 'Logo bottom margin', 'ub' ),
							'description' => __( 'Default is\'s a good value, but if you want to increase this margin...', 'ub' ),
							'attributes' => array( 'placeholder' => '25' ),
							'default' => 25,
							'min' => 0,
							'classes' => array( 'ui-slider' ),
							'master' => 'logo-related',
						),
						'bg_color' => array(
							'type' => 'color',
							'label' => __( 'Background color', 'ub' ),
							'default' => '#f1f1f1',
						),
						'fullscreen_bg' => array(
							'type' => 'media',
							'label' => __( 'Background Image', 'ub' ),
							'description' => __( 'You can upload a background image here. The image will stretch to fit the page, and will automatically resize as the window size changes. You\'ll have the best results by using images with a minimum width of 1024px.', 'ub' ),
						),
					),
				),
				'form' => array(
					'title' => __( 'Form corners', 'ub' ),
					'fields' => array(
						'rounded_form' => array(
							'type' => 'radio',
							'label' => __( 'Form corners', 'ub' ),
							'options' => array(
								'rounded' => __( 'Show rounded corners', 'ub' ),
								'straight' => __( 'Show straight corners', 'ub' ),
							),
							'default' => 'straight',
						),
						'rounded_nb' => array(
							'type' => 'number',
							'label' => __( 'Radius', 'ub' ),
							'description' => __( 'How much would you like to round the border?', 'ub' ),
							'attributes' => array( 'placeholder' => '20' ),
							'default' => '20',
							'min' => 0,
							'classes' => array( 'ui-slider' ),
						),
						'show_remember_me' => array(
							'type' => 'radio',
							'label' => __( '"Remember Me" checkbox', 'ub' ),
							'description' => __( 'Would you like to show the "Remember Me" checkbox?', 'ub' ),
							'options' => array(
								'show' => __( 'Show "Remember Me" checkbox.', 'ub' ),
								'hide' => __( 'Hide "Remember Me" checkbox.', 'ub' ),
							),
							'default' => 'show',
						),
						'label_color' => array(
							'type' => 'color',
							'label' => __( 'Label color', 'ub' ),
							'default' => '#777777',
						),
						'form_bg_color' => array(
							'type' => 'color',
							'label' => __( 'Background color', 'ub' ),
							'default' => '#ffffff',
						),
						'form_bg' => array(
							'type' => 'media',
							'label' => __( 'Background Image', 'ub' ),
						),
						'form_bg_transparency' => array(
							'type' => 'number',
							'label' => __( 'Background Transparency', 'ub' ),
							'min' => 0,
							'max' => 100,
							'default' => 100,
							'description' => __( 'It will not affected if you set for background image.', 'ub' ),
							'classes' => array( 'ui-slider' ),
						),
						'form_style' => array(
							'type' => 'radio',
							'label' => __( 'Form Style', 'ub' ),
							'options' => array(
								'flat' => __( 'Flat', 'ub' ),
								'shadow' => __( 'Shadowed Box', 'ub' ),
							),
							'description' => __( 'Choose the style of the form.', 'ub' ),
							'default' => 'flat',
						),
						'form_button_color' => array(
							'type' => 'color',
							'label' => __( 'Button color', 'ub' ),
							'default' => '#2ea2cc',
						),
						'form_button_text_color' => array(
							'type' => 'color',
							'label' => __( 'Button Text color', 'ub' ),
							'default' => '#ffffff',
						),
					),
				),
				/**
				 * Form labels
				 */
				'form_labels' => array(
					'title' => __( 'Form labels', 'ub' ),
					'fields' => array(
						'label_username' => array(
							'type' => 'text',
							'label' => __( 'Label username text', 'ub' ),
							'default' => __( 'Username or Email Address', 'ub' ),
						),
						'label_password' => array(
							'type' => 'text',
							'label' => __( 'Label password text', 'ub' ),
							'default' => __( 'Password', 'ub' ),
						),
						'label_log_in' => array(
							'type' => 'text',
							'label' => __( 'Login button text', 'ub' ),
							'default' => __( 'Log In', 'ub' ),
						),
					),
				),
				/**
				 * Form error messages
				 */
				'form_errors' => array(
					'title' => __( 'Error messages', 'ub' ),
					'fields' => array(
						'empty_username' => array(
							'type' => 'text',
							'label' => __( 'Empty username', 'ub' ),
							'default' => __( '<strong>ERROR</strong>: The username field is empty.', 'ub' ),
						),
						'invalid_username' => array(
							'type' => 'text',
							'label' => __( 'Invalid username', 'ub' ),
							'description' => __( 'Use "WP_LOSTPASSWORD_URL" placeholder to replace it by WordPress.', 'ub' ),
							'default' => $invalid_username,
						),
						'empty_password' => array(
							'type' => 'text',
							'label' => __( 'Empty password', 'ub' ),
							'default' => __( '<strong>ERROR</strong>: The password field is empty.', 'ub' ),
						),
						'incorrect_password' => array(
							'type' => 'text',
							'label' => __( 'Invalid password', 'ub' ),
							'description' => __( 'Use "WP_LOSTPASSWORD_URL", "USERNAME" placeholder to replace it by WordPress.', 'ub' ),
							'default' => $invalid_password,
						),
						'login_error_background_color' => array(
							'type' => 'color',
							'label' => __( 'Error message background color.', 'ub' ),
							'default' => '#ffffff',
						),
						'login_error_border_color' => array(
							'type' => 'color',
							'label' => __( 'Error message border color.', 'ub' ),
							'default' => '#dc3232',
						),
						'login_error_text_color' => array(
							'type' => 'color',
							'label' => __( 'Error message text color.', 'ub' ),
							'default' => '#444444',
						),
					),
				),
				/**
				 * Below Form Links
				 */
				'below_form' => array(
					'title' => __( 'Below Form Links', 'ub' ),
					'fields' => array(
						'show_register_and_lost' => array(
							'type' => 'checkbox',
							'label' => __( '"Register | Lost your password?" links', 'ub' ),
							'description' => __( 'Would you like to show the "Register | Lost your password?" links?', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
						),
						'show_back_to' => array(
							'type' => 'checkbox',
							'label' => __( '"Back to" link', 'ub' ),
							'description' => __( 'Would you like to show the "&larr; Back to" link?', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
						),
						'register_and_lost_color_link' => array(
							'type' => 'color',
							'label' => __( '"Register | Lost your password?" links color', 'ub' ),
							'default' => '#999999',
						),
						'register_and_lost_color_hover' => array(
							'type' => 'color',
							'label' => __( '"Register | Lost your password?" link hover color', 'ub' ),
							'default' => '#2ea2cc',
						),
						'back_to_color_link' => array(
							'type' => 'color',
							'label' => __( '"Back to" link color', 'ub' ),
							'default' => '#999999',
						),
						'back_to_color_hover' => array(
							'type' => 'color',
							'label' => __( '"Back to" link hover color', 'ub' ),
							'default' => '#2ea2cc',
						),
					),
				),
			);
		}

		private function get_value( $section, $name = null ) {
			$value = ub_get_option( 'global_login_screen' );
			if ( $value == 'empty' ) {
				$value = '';
			}
			if ( empty( $value ) ) {
				return null;
			}
			if ( isset( $value[ $section ] ) ) {
				if ( empty( $name ) ) {
					return $value[ $section ];
				} else if ( isset( $value[ $section ][ $name ] )
				) {
					return $value[ $section ][ $name ];
				}
			}
			return null;
		}

		public function login_headerurl( $value ) {
			$new = $this->get_value( 'logo_and_background', 'login_header_url' );
			if ( null === $new ) {
				return $value;
			}
			return $new;
		}

		public function login_headertitle( $value ) {
			$new = $this->get_value( 'logo_and_background', 'login_header_title' );
			if ( null === $new ) {
				return $value;
			}
			return $new;
		}

		public function wp_login_errors( $errors ) {
			$value = $this->get_value( 'form_errors' );
			if ( is_array( $value ) ) {
				foreach ( $value as $code => $message ) {
					if ( isset( $errors->errors[ $code ] ) ) {
						$errors->errors[ $code ][0] = $this->replace_placeholders( $message );
					}
				}
			}
			return $errors;
		}

		public function gettext_login_form_labels( $translated_text, $text, $domain ) {
			if ( $this->proceed_gettext && 'default' == $domain ) {
				if ( empty( $this->patterns ) ) {
					$options = $this->options['form_labels'];
					foreach ( $options['fields'] as $key => $data ) {
						$this->patterns[ $data['default'] ] = $this->get_value( 'form_labels', $key );
					}
				}
				if ( isset( $this->patterns[ $translated_text ] ) ) {
					return $this->patterns[ $translated_text ];
				}
			}

			return $translated_text;
		}

		private function replace_placeholders( $string ) {
			$string = preg_replace( '/WP_LOSTPASSWORD_URL/', wp_lostpassword_url(), $string );
			$username = '';
			if ( isset( $_POST['log'] ) ) {
				$username = esc_attr( $_POST['log'] );
			}
			$string = preg_replace( '/USERNAME/', $username, $string );
			return $string;
		}

		private function convert_hex_to_rbg( $hex ) {
			if ( preg_match( '/^#.{6}$/', $hex ) ) {
				return sscanf( $hex, '#%02x%02x%02x' );
			}
			return $hex;
		}

		private function css_color( $data, $key, $selector ) {
			if ( isset( $data[ $key ] ) && ! empty( $data[ $key ] ) ) {
				printf( '%s{color:%s}', $selector, $data[ $key ] );
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					echo PHP_EOL;
				}
			}
		}

		private function css_background_color( $data, $key, $selector ) {
			if ( isset( $data[ $key ] ) && ! empty( $data[ $key ] ) ) {
				printf( '%s{background-color:%s}', $selector, $data[ $key ] );
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					echo PHP_EOL;
				}
			}
		}

		private function css_opacity( $data, $key, $selector ) {
			if ( isset( $data[ $key ] ) && ! empty( $data[ $key ] ) ) {
				printf( '%s{opacity:%0.2f}', $selector, $data[ $key ] / 100 );
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					echo PHP_EOL;
				}
			}
		}

		private function css_hide( $data, $key, $selector ) {
			if ( isset( $data[ $key ] ) && 'off' == $data[ $key ] ) {
				printf( '%s{display:none}', $selector );
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					echo PHP_EOL;
				}
			}
		}
	}

	new ub_custom_login_screen();
}
