<?php
/**
 * Branda Email Headers class.
 *
 * @package Branda
 * @subpackage Emails
 */
if ( ! class_exists( 'Branda_Email_Headers' ) ) {

	/**
	 * Class Branda_Email_Headers
	 */
	class Branda_Email_Headers extends Branda_Helper {

		/**
		 * Module option name.
		 *
		 * @var string
		 */
		protected $option_name = 'ub_emails_headers';

		/**
		 * Constructor.
		 */
		public function __construct() {
			parent::__construct();
			$this->set_options();
			// Register hooks.
			add_filter( 'ultimatebranding_settings_emails_header', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_emails_header_process', array( $this, 'update' ), 10, 1 );
			add_filter( 'wp_mail_from', array( $this, 'from_email' ) );
			add_filter( 'wp_mail_from_name', array( $this, 'from_email_name' ) );
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}

		/**
		 * Upgrade module data to new structure.
		 *
		 * @since 3.0.0
		 */
		public function upgrade_options() {
			$ub_from_email = ub_get_option( 'ub_from_email', false );
			$ub_from_name  = ub_get_option( 'ub_from_name', false );
			if (
				false === $ub_from_email
				&& false === $ub_from_name
			) {
				return;
			}
			$data = array(
				'headers' => array(
					'email' => $ub_from_email,
					'name'  => $ub_from_name,
				),
			);
			$this->update_value( $data );
			ub_delete_option( 'ub_from_email' );
			ub_delete_option( 'ub_from_name' );
		}

		/**
		 * Set module options for admin page.
		 *
		 * @since 3.0.0
		 */
		protected function set_options() {
			$this->module = 'emails-headers';
			$options = array(
				'headers' => array(
					'title'       => __( 'Email From', 'ub' ),
					'description' => __( 'Choose the default sender email and sender name for all of your WordPress outgoing emails.', 'ub' ),
					'fields'      => array(
						'email' => array(
							'label' => __( 'Sender email address', 'ub' ),
							'type'  => 'email',
						),
						'name'  => array(
							'label' => __( 'Sender name', 'ub' ),
						),
					),
				),
			);
			$current_user = wp_get_current_user();
			if ( is_a( $current_user, 'WP_User' ) ) {
				$options['headers']['fields']['email']['placeholder'] = $current_user->user_email;
				$options['headers']['fields']['name']['placeholder'] = $current_user->display_name;
			}
			$this->options = $options;
		}

		/**
		 * Change email from address.
		 *
		 * @param string $email From email.
		 *
		 * @return mixed|null|string
		 */
		public function from_email( $email ) {
			$value = $this->get_value( 'headers', 'email' );
			if ( is_email( $value ) ) {
				return $value;
			}
			return $email;
		}

		/**
		 * Change email from name.
		 *
		 * @param string $from From name.
		 *
		 * @return mixed|null|string
		 */
		public function from_email_name( $from ) {
			$value = $this->get_value( 'headers', 'name' );
			if ( ! empty( $value ) ) {
				return $value;
			}
			return $from;
		}
	}
}
new Branda_Email_Headers;