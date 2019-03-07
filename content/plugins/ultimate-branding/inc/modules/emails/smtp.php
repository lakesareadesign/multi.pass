<?php
/**
 * Branda SMTP class.
 *
 * @package Branda
 * @subpackage Emails
 */
if ( ! class_exists( 'Branda_SMTP' ) ) {

	class Branda_SMTP extends Branda_Helper {
		protected $option_name = 'ub_smtp';
		private $is_ready = false;

		public function __construct() {
			parent::__construct();
			$this->check();
			$this->set_options();
			/**
			 * hooks
			 */
			if ( $this->is_network ) {
				add_action( 'network_admin_notices', array( $this, 'configure_credentials_notice' ) );
			} else {
				add_action( 'admin_notices', array( $this, 'configure_credentials_notice' ) );
			}
			add_action( 'phpmailer_init', array( $this, 'init_smtp' ), 999 );
			add_filter( 'ultimatebranding_settings_smtp', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_smtp_process', array( $this, 'update' ) );
			add_filter( 'ultimatebranding_settings_smtp_reset', array( $this, 'reset_module' ) );
			add_action( 'wp_ajax_'.$this->get_name( 'send' ), array( $this, 'ajax_send_test_email' ) );
			/**
			 * upgrade options
			 *
			 * @since 3.0.0
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
			/**
			 * Add "Send Test Email" button.
			 *
			 * @since 3.0.0
			 */
			add_filter( 'branda_settings_after_box_title', array( $this, 'add_button_after_title' ), 10, 2 );
			/**
			 * Add dialog
			 *
			 * @since 3.0,0
			 */
			add_filter( 'branda_get_module_content', array( $this, 'add_dialog' ), 10, 2 );
			/**
			 * add to javascript messages
			 *
			 * @since 3.0.0
			 */
			add_filter( 'branda_admin_messages_array', array( $this, 'add_messages' ) );
		}

		/**
		 * Add messages to js localize
		 */
		public function add_messages( $array ) {
			$array['messages']['smtp'] = array(
				'empty' => __( 'Field "To" can not be empty!', 'ub' ),
				'sending' => __( 'Sending message, please wait...', 'ub' ),
				'send' => __( 'The test message was send successful.', 'ub' ),
			);
			return $array;
		}

		/**
		 * Upgrade option
		 *
		 * @since 2.1.0
		 */
		public function upgrade_options() {
			$value = $this->get_value();
			if ( empty( $value ) || ! is_array( $value ) || ! isset( $value['settings'] ) ) {
				return;
			}
			$data = array(
				'header' => array(
					'from_email' => '',
					'from_name_force' => 'on',
					'from_name' => '',
				),
				'server' => array(
					'smtp_host' => '',
					'smtp_type_encryption' => 'ssl',
					'smtp_port' => '25',
					'smtp_insecure_ssl' => 'on',
				),
				'smtp_authentication' => array(
					'smtp_authentication' => 'on',
					'smtp_username' => '',
					'smtp_password' => '',
				),
			);
			foreach ( $data as $g => $keys ) {
				foreach ( $keys as $k => $v ) {
					if ( isset( $value['settings'][ $k ] ) ) {
						$data[ $g ][ $k ] = $value['settings'][ $k ];
					}
				}
			}
			$this->update_value( $data );
		}

		/**
		 * Add "add feed" button.
		 *
		 * @since 3.0.0
		 */
		public function add_button_after_title( $content, $module ) {
			if ( $this->module !== $module['module'] ) {
				return $content;
			}
			$args = array(
				'data' => array(
					'a11y-dialog-show' => $this->get_name( 'send' ),
				),
				'text' => __( 'Send Test Email', 'ub' ),
				'sui' => 'ghost',
			);
			$content .= '<div class="sui-actions-left">';
			$content .= $this->button( $args );
			$content .= '</div>';
			return $content;
		}

		/**
		 * Send test email
		 *
		 * @since 2.0.0
		 */
		public function ajax_send_test_email() {
			$nonce_action = $this->get_nonce_action( 'send' );
			$this->check_input_data( $nonce_action, array( 'email' ) );
			if ( is_wp_error( $this->is_ready ) ) {
				$this->json_error( $this->is_ready->get_error_message() );
			}
			$email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING );
			$email = sanitize_email( $email );
			if ( ! is_email( $email ) ) {
				$this->json_error( __( 'Unable to send: wrong email address.', 'ub' ) );
			}
			$errors = '';
			$config = $this->get_value();
			require_once( ABSPATH . WPINC . '/class-phpmailer.php' );
			$mail = new PHPMailer();
			$charset = get_bloginfo( 'charset' );
			$mail->CharSet = $charset;
			$from_name = $this->get_value( 'header', 'from_name' );
			$from_email = $this->get_value( 'header', 'from_email' );
			$mail->IsSMTP();
			// send plain text test email
			$mail->ContentType = 'text/plain';
			$mail->IsHTML( false );
			/* If using smtp auth, set the username & password */
			$use_auth = $this->get_value( 'smtp_authentication', 'smtp_authentication' );
			if ( 'on' === $use_auth ) {
				$mail->SMTPAuth = true;
				$mail->Username = $this->get_value( 'smtp_authentication', 'smtp_username' );
				$mail->Password = $this->get_value( 'smtp_authentication', 'smtp_password' );
			}
			/* Set the SMTPSecure value, if set to none, leave this blank */
			$type = $this->get_value( 'server', 'smtp_type_encryption' );
			if ( 'none' !== $type ) {
				$mail->SMTPSecure = $type;
			}
			/* PHPMailer 5.2.10 introduced this option. However, this might cause issues if the server is advertising TLS with an invalid certificate. */
			$mail->SMTPAutoTLS = false;
			$insecure_ssl = $this->get_value( 'server', 'smtp_insecure_ssl' );
			if ( 'on' === $insecure_ssl ) {
				// Insecure SSL option enabled
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true,
					),
				);
			}
			/* Set the other options */
			$mail->Host = $this->get_value( 'server', 'smtp_host' );
			$mail->Port = $this->get_value( 'server', 'smtp_port' );
			$mail->SetFrom( $from_email, $from_name );
			//This should set Return-Path header for servers that are not properly handling it, but needs testing first
			//$mail->Sender = $mail->From;
			$mail->Subject = sprintf( __( 'This is test email sent from "%s"', 'ub' ), get_bloginfo( 'name' ) );
			$mail->Body = __( 'This is a test mail...', 'ub' );
			$mail->Body .= PHP_EOL;
			$mail->Body .= PHP_EOL;
			$mail->Body .= sprintf( __( 'Send date: %s.', 'ub' ), date( 'c' ) );
			$mail->Body .= PHP_EOL;
			$mail->Body .= PHP_EOL;
			$mail->Body .= '-- ';
			$mail->Body .= PHP_EOL;
			$mail->Body .= sprintf( __( 'Site: %s.', 'ub' ), get_bloginfo( 'url' ) );
			$mail->AddAddress( $email );
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$mail->SMTPDebug = 1;
				ob_start();
			}
			/* Send mail and return result */
			if ( ! $mail->Send() ) {
				$errors = $mail->ErrorInfo;
			}
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$debug = ob_get_contents();
				ob_end_clean();
				error_log( $debug );
			}
			$mail->ClearAddresses();
			$mail->ClearAllRecipients();
			if ( ! empty( $errors ) ) {
				$data = array(
					'message' => __( 'Failed to send the test email. Please check your SMTP credentials and try again.', 'ub' ),
					'errors' => $errors,
				);
				wp_send_json_error( $data );
			}
			$success_message = sprintf( __( 'Test email sent to %s.', 'ub' ), '<strong>' . $email . '</strong>' );
			wp_send_json_success( array( 'message' => $success_message ) );
		}

		/**
		 * Check required credentials
		 *
		 * @since 2.0.0
		 */
		private function check() {
			if (
				isset( $_POST['simple_options'] )
				&& isset( $_POST['simple_options']['server'] )
				&& isset( $_POST['simple_options']['server']['smtp_host'] )
				&& ! empty( $_POST['simple_options']['server']['smtp_host'] )
			) {
				$this->is_ready = true;
				return $this->is_ready;
			}
			$this->is_ready = new WP_Error( 'credentials', __( 'Please configure credentials first.', 'ub' ) );
			$config = $this->get_value();
			if ( empty( $config ) ) {
				return $this->is_ready;
			}
			if ( ! isset( $config['header'] ) ) {
				return $this->is_ready;
			}
			$config = $this->get_value( 'server', 'smtp_host', false );
			if ( empty( $config ) ) {
				return $this->is_ready;
			}
			$this->is_ready = true;
			return $this->is_ready;
		}

		/**
		 * Init SMTP
		 *
		 * @since 2.0.0
		 */
		public function init_smtp( &$phpmailer ) {
			/**
			 * check if SMTP credentials have been configured.
			 */
			if ( is_wp_error( $this->is_ready ) ) {
				return $this->is_ready->get_error_message();
			}
			/* Set the mailer type as per config above, this overrides the already called isMail method */
			$phpmailer->IsSMTP();
			/**
			 * from name
			 */
			$from_name = $this->get_value( 'header', 'from_name' );
			$force = $this->get_value( 'header', 'from_name_force' );
			if ( 'off' === $force && ! empty( $phpmailer->FromName ) ) {
				$from_name = $phpmailer->FromName;
			}
			/**
			 * from email
			 */
			$from_email = $this->get_value( 'header', 'from_email' );
			/**
			 * set PHPMailer
			 */
			$phpmailer->From = $from_email;
			$phpmailer->FromName = $from_name;
			$phpmailer->SetFrom( $phpmailer->From, $phpmailer->FromName );
			/* Set the SMTPSecure value */
			$type = $this->get_value( 'server', 'smtp_type_encryption' );
			if ( 'none' !== $type  ) {
				$phpmailer->SMTPSecure = $type;
			}
			/* Set the other options */
			$phpmailer->Host = $this->get_value( 'server', 'smtp_host' );
			$phpmailer->Port = $this->get_value( 'server', 'smtp_port' );
			/* If we're using smtp auth, set the username & password */
			$use_auth = $this->get_value( 'smtp_authentication', 'smtp_authentication' );
			if ( 'on' === $use_auth ) {
				$phpmailer->SMTPAuth = true;
				$phpmailer->Username = $this->get_value( 'smtp_authentication', 'smtp_username' );
				$phpmailer->Password = $this->get_value( 'smtp_authentication', 'smtp_password' );
			}
			//PHPMailer 5.2.10 introduced this option. However, this might cause issues if the server is advertising TLS with an invalid certificate.
			$phpmailer->SMTPAutoTLS = false;
			/* Set the SMTPSecure value, if set to none, leave this blank */
			$insecure_ssl = $this->get_value( 'server', 'smtp_insecure_ssl' );
			if ( 'on' === $insecure_ssl ) {
				$phpmailer->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true,
					),
				);
			}
		}

		/**
		 * modify option name
		 *
		 * @since 2.0.0
		 */
		public function get_module_option_name( $option_name, $module ) {
			if ( is_string( $module ) && $this->module == $module ) {
				return $this->option_name;
			}
			return $option_name;
		}

		/**
		 * Set options
		 *
		 * @since 2.0.0
		 */
		protected function set_options() {
			$this->module = 'smtp';
			$options = array(
				'reset-module' => true,
				'header' => array(
					'title' => __( 'From Headers', 'ub' ),
					'description' => __( 'Choose the default from email id and from name for all of your WordPress outgoing emails.', 'ub' ),
					'fields' => array(
						'from_email' => array(
							'label' => __( 'Sender email address', 'ub' ),
							'description' => __( 'You can specify the email address that emails should be sent from.', 'ub' ),
							'default' => get_bloginfo( 'admin_email' ),
						),
						'from_name' => array(
							'label' => __( 'Sender name', 'ub' ),
							'placeholder' => __( 'Enter the sender email', 'ub' ),
							'description' => __( 'For example, you can use your website’s title as the default sender name.', 'ub' ),
							'description-position' => 'bottom',
							'master' => 'from-name',
							'master-value' => 'on',
							'display' => 'sui-tab-content',
						),
						'from_name_force' => array(
							'type' => 'sui-tab',
							'label' => __( 'From name replacement', 'ub' ),
							'description' => __( 'Set your own from name for each email sent from your website. Be carefully since it will override the from name provided by other plugins such as Contact Form.', 'ub' ),
							'options' => array(
								'on' => __( 'Enable', 'ub' ),
								'off' => __( 'Disable', 'ub' ),
							),
							'default' => 'on',
							'slave-class' => 'from-name',
						),
					),
				),
				'server' => array(
					'title' => __( 'SMTP Server', 'ub' ),
					'description' => __( 'Choose the SMTP server options such as host, port details, encryption etc.', 'ub' ),
					'fields' => array(
						'smtp_host' => array(
							'label' => __( 'Host', 'ub' ),
							'description' => __( 'Enter the host name of your mail server.', 'ub' ),
							'placeholder' => __( 'E.g. smtp.example.com', 'ub' ),
						),
						'smtp_type_encryption' => array(
							'type' => 'sui-tab',
							'label' => __( 'Encryption', 'ub' ),
							'options' => array(
								'none' => __( 'None', 'ub' ),
								'ssl' => __( 'SSL', 'ub' ),
								'tls' => __( 'TLS', 'ub' ),
							),
							'default' => 'ssl',
							'description' => __( 'Choose the encryption for your mail server. For most servers, SSL is recommended.', 'ub' ),
						),
						'smtp_port' => array(
							'type' => 'number',
							'label' => __( 'Port', 'ub' ),
							'description' => __( 'Choose the SMTP port as recommended by your mail server.', 'ub' ),
							'default' => 25,
							'min' => 1,
						),
						'smtp_insecure_ssl' => array(
							'type' => 'sui-tab',
							'label' => __( 'Insecure SSL certificates', 'ub' ),
							'description' => __( 'You can enable the insecure and self-signed SSL certificates on SMTP server. However, it\'s highly recommended to keep this option disabled.', 'ub' ),
							'options' => array(
								'on' => __( 'Enable', 'ub' ),
								'off' => __( 'Disable', 'ub' ),
							),
							'default' => 'off',
						),
					),
				),
				'smtp_authentication' => array(
					'title' => __( 'SMTP Authentication', 'ub' ),
					'description' => __( 'Choose whether you want to use SMTPAuth or not. It is recommended to keep this enabled.', 'ub' ),
					'fields' => array(
						'smtp_username' => array(
							'label' => __( 'Username', 'ub' ),
							'placeholder' => __( 'Enter your SMTP username here', 'ub' ),
							'master' => 'smtp-authentication',
							'master-value' => 'on',
							'display' => 'sui-tab-content',
						),
						'smtp_password' => array(
							'type' => 'password',
							'label' => __( 'Password', 'ub' ),
							'placeholder' => __( 'Enter your SMTP password here', 'ub' ),
							'master' => 'smtp-authentication',
							'master-value' => 'on',
							'display' => 'sui-tab-content',
							'class' => 'large-text',
						),
						'smtp_authentication' => array(
							'type' => 'sui-tab',
							'options' => array(
								'on' => __( 'Enable', 'ub' ),
								'off' => __( 'Disable', 'ub' ),
							),
							'default' => 'on',
							'slave-class' => 'smtp-authentication',
						),
					),
				),
			);
			$this->options = $options;
		}

		/**
		 * Add admin notice about configuration.
		 *
		 * @since 2.0.0
		 */
		public function configure_credentials_notice() {
			if ( true === $this->is_ready ) {
				return;
			}
			if ( ! is_a( $this->uba, 'Branda_Admin' ) ) {
				return;
			}
			/**
			 * Only show in Branda plugin
			 */
			if ( ! isset( $_GET['page'] ) || strpos( $_GET['page'], 'branding' ) === false ) {
				return;
			}
			$module_data = $this->uba->get_module_by_module( $this->module );
			$settings_url = add_query_arg(
				array(
					'page' => 'branding_group_'.$module_data['group'],
					'module' => $this->module,
				),
				network_admin_url( 'admin.php' )
			);
			$message = array(
				'class' => 'error sui-cant-dismiss',
				'message' => sprintf(
					__( 'Please configure your <a href="%s">SMTP credentials</a> in order to send email using SMTP module.', 'ub' ),
					esc_url( $settings_url )
				),
				'no-dissmiss' => true,
			);
			$this->uba->add_message( $message );
		}

		/**
		 * Add SUI dialog
		 *
		 * @since 3.0.0
			 *
			 * @param string $content Current module content.
			 * @param array $module Current module.
		 */
		public function add_dialog( $content, $module ) {
			if ( $this->module !== $module['module'] ) {
				return $content;
			}
			$template = '/admin/common/dialogs/test-email';
			$args = array(
				'id' => $this->get_name( 'send' ),
				'description' => __( 'Send a dummy email to test the SMTP configurations.', 'ub' ),
				'nonce' => $this->get_nonce_value( 'send' ),
				'action' => $this->get_name( 'send' ),
			);
			$content .= $this->render( $template, $args, true );
			return $content;
		}
	}
}
new Branda_SMTP;