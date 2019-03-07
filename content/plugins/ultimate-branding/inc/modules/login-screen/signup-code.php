<?php
/**
 * Branda Signup Codes class.
 *
 * @package Branda
 * @subpackage Front-end
 */
if ( ! class_exists( 'Branda_Signup_Codes' ) ) {

	class Branda_Signup_Codes extends Branda_Helper {

		protected $option_name = 'ub_signup_codes';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			add_filter( 'ultimatebranding_settings_signup_code', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_signup_code_process', array( $this, 'update' ) );
			/**
			 * User Create Code
			 */
			add_action( 'register_form', array( $this, 'add_user_code' ) );
			add_action( 'signup_extra_fields', array( $this, 'add_user_code' ) );
			add_filter( 'registration_errors', array( $this, 'validate_user_signup_single' ) );
			add_filter( 'wpmu_validate_user_signup', array( $this, 'validate_user_signup' ) );
			/**
			 * Blog Create Code
			 */
			add_action( 'signup_blogform', array( $this, 'add_blog_code' ) );
			add_filter( 'wpmu_validate_blog_signup', array( $this, 'validate_blog_signup' ) );
			/**
			 * BuddyPress integration
			 */
			add_action( 'bp_account_details_fields', array( $this, 'add_user_code' ) );
			add_action( 'bp_blog_details_fields', array( $this, 'add_blog_code' ) );
			/**
			 * upgrade options
			 *
			 * @since 3.0.0
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}

		/**
		 * Set options
		 *
		 * @since 2.3.0
		 */
		protected function set_options() {
			$this->module = 'signup-code';
			$options = array(
				'user' => array(
					'title' => __( 'User Registration', 'ub' ),
					'description' => __( 'Choose whether anyone can register to your site or you want to restrict registration with a signup code only.', 'ub' ),
					'fields' => array(
						'case' => array(
							'label' => __( 'Case matching', 'ub' ),
							'type' => 'sui-tab',
							'options' => array(
								'insensitive' => __( 'Case Insensitive', 'ub' ),
								'sensitive' => __( 'Case Sensitive', 'ub' ),
							),
							'default' => 'sensitive',
							'master' => $this->get_name( 'user' ),
							'master-value' => 'on',
							'display' => 'sui-tab-content',
							'group' => array(
								'begin' => true,
							),
						),
						'code' => array(
							'type' => 'text',
							'label' => __( 'Signup Code', 'ub' ),
							'after_label' => __( 'Alphanumeric only', 'ub' ),
							'description' => __( 'Users must enter this code to successfully signup.', 'ub' ),
							'description-position' => 'bottom',
							'master' => $this->get_name( 'user' ),
							'master-value' => 'on',
							'display' => 'sui-tab-content',
						),
						'branding' => array(
							'type' => 'text',
							'label' => __( 'Field Label', 'ub' ),
							'description' => __( 'This label will appear on the signup form with the signup code field.', 'ub' ),
							'description-position' => 'bottom',
							'default' => __( 'User Create Code', 'ub' ),
							'master' => $this->get_name( 'user' ),
							'master-value' => 'on',
							'display' => 'sui-tab-content',
						),
						'help' => array(
							'type' => 'text',
							'label' => __( 'Field Description', 'ub' ),
							'description' => __( 'This will appear under the input field on the signup form.', 'ub' ),
							'description-position' => 'bottom',
							'default' => __( 'You need to enter the code to create a user.', 'ub' ),
							'master' => $this->get_name( 'user' ),
							'master-value' => 'on',
							'display' => 'sui-tab-content',
						),
						'error' => array(
							'type' => 'text',
							'label' => __( 'Error Message', 'ub' ),
							'description' => __( 'This will appear under the input field on the signup form.', 'ub' ),
							'description-position' => 'bottom',
							'default' => __( 'User create code is invalid.', 'ub' ),
							'master' => $this->get_name( 'user' ),
							'master-value' => 'on',
							'display' => 'sui-tab-content',
						),
						'settings' => array(
							'type' => 'sui-tab',
							'options' => array(
								'off' => __( 'Anyone', 'ub' ),
								'on' => __( 'With Signup Code', 'ub' ),
							),
							'default' => 'off',
							'slave-class' => $this->get_name( 'user' ),
							'group' => array(
								'end' => true,
							),
						),
					),
				),
				'blog' => array(
					'title' => __( 'Blog Registration', 'ub' ),
					'description' => __( 'Choose if anyone can register a blog to your site or you want to restrict registration with a signup code only.', 'ub' ),
					'network-only' => true,
					'fields' => array(
						'case' => array(
							'label' => __( 'Case matching', 'ub' ),
							'type' => 'sui-tab',
							'options' => array(
								'insensitive' => __( 'Case Insensitive', 'ub' ),
								'sensitive' => __( 'Case Sensitive', 'ub' ),
							),
							'default' => 'sensitive',
							'master' => $this->get_name( 'site' ),
							'master-value' => 'on',
							'display' => 'sui-tab-content',
							'group' => array(
								'begin' => true,
							),
						),
						'code' => array(
							'type' => 'text',
							'label' => __( 'Signup Code', 'ub' ),
							'after_label' => __( 'Alphanumeric only', 'ub' ),
							'description' => __( 'Users must enter this code to successfully signup.', 'ub' ),
							'description-position' => 'bottom',
							'master' => $this->get_name( 'site' ),
							'master-value' => 'on',
							'display' => 'sui-tab-content',
						),
						'branding' => array(
							'type' => 'text',
							'label' => __( 'Field Label', 'ub' ),
							'description' => __( 'This label will appear on the signup form with the signup code field.', 'ub' ),
							'description-position' => 'bottom',
							'default' => __( 'Blog Create Code', 'ub' ),
							'master' => $this->get_name( 'site' ),
							'master-value' => 'on',
							'display' => 'sui-tab-content',
						),
						'help' => array(
							'type' => 'text',
							'label' => __( 'Field Description', 'ub' ),
							'description' => __( 'This will appear under the input field on the signup form.', 'ub' ),
							'description-position' => 'bottom',
							'default' => __( 'You need to enter the code to create a blog.', 'ub' ),
							'master' => $this->get_name( 'site' ),
							'master-value' => 'on',
							'display' => 'sui-tab-content',
						),
						'error' => array(
							'type' => 'text',
							'label' => __( 'Error Message', 'ub' ),
							'description' => __( 'This will appear under the input field on the signup form.', 'ub' ),
							'description-position' => 'bottom',
							'default' => __( 'Blog create code is invalid.', 'ub' ),
							'master' => $this->get_name( 'site' ),
							'master-value' => 'on',
							'display' => 'sui-tab-content',
						),
						'settings' => array(
							'type' => 'sui-tab',
							'options' => array(
								'off' => __( 'Anyone', 'ub' ),
								'on' => __( 'With Signup Code', 'ub' ),
							),
							'default' => 'off',
							'slave-class' => $this->get_name( 'site' ),
							'group' => array(
								'end' => true,
							),
						),
					),
				),
			);
			/**
			 * change settings for single site
			 */
			if ( $this->is_network ) {
				/**
				 * handle settings
				 */
				$status = get_site_option( 'registration' );
				if ( 'none' === $status || 'user' === $status ) {
					$url = network_admin_url( 'settings.php' );
					$options['blog']['classes'] = array( 'branda-not-affected' );
					$options['blog']['notice'] = array(
						'position' => 'bottom',
						'class' => 'error',
						'message' => sprintf(
							__( 'Blog registration has been disabled. Click <a href="%s">here</a> to enable the site registration for your network.', 'ub' ),
							$url
						),
					);
				}
			}
			/**
			 * set users registration
			 */
			$options = $this->set_users_can_register( $options );
			$this->options = $options;
		}

		/**
		 * Upgrade option
		 *
		 * @since 3.0.0
		 */
		public function upgrade_options() {
			$data = $this->get_value();
			if ( isset( $data['settings'] ) ) {
				if ( isset( $data['settings']['user'] ) ) {
					$data['user']['settings'] = $data['settings']['user'];
					$update = true;
				}
				if ( isset( $data['settings']['blog'] ) ) {
					$data['blog']['settings'] = $data['settings']['blog'];
					$update = true;
				}
				unset( $data['settings'] );
				$this->update_value( $data );
			}
		}

		/**
		 * Set user registration is not allowed message
		 *
		 * @since 3.0.0
		 */
		private function set_users_can_register( $data ) {
			$is_open = $this->is_user_registration_open();
			if ( false === $is_open ) {
				return $data;
			}
			$url = $this->is_user_registration_open();
			$data['user']['classes'] = array( 'branda-not-affected' );
			$data['user']['notice'] = array(
				'position' => 'bottom',
				'class' => 'error',
				'message' => sprintf(
					__( 'User registration has been disabled. Click <a href="%s">here</a> to enable the user registration for your site.', 'ub' ),
					$url
				),
			);
			return $data;
		}

		/**
		 * Print code field.
		 *
		 * @since 2.3.0
		 *
		 * @param string $id ID of field.
		 * @param array $value Configuration of field.
		 * @param WP_Error $errors WP_Error object.
		 */
		private function print_field( $id, $value, $errors ) {
			$html_id = 'ultimate_branding_'.$id;
			$name = $this->get_name( $id );
			if ( isset( $value['branding'] ) && ! empty( $value['branding'] ) ) {
				printf(
					'<label for="%s">%s</label>',
					esc_attr( $html_id ),
					esc_html( $value['branding'] )
				);
			}
			/**
			 * error message
			 */
			if ( is_a( $errors, 'WP_Error' ) && $errmsg = $errors->get_error_message( $name ) ) {
				printf( '<p class="error">%s</p>', $errmsg );
			}
			printf(
				'<input type="text" name="%s" id="%s" autocomplete="off" />',
				esc_attr( $name ),
				esc_attr( $html_id )
			);
			if ( isset( $value['help'] ) && ! empty( $value['help'] ) ) {
				echo '<p class="description">';
				echo esc_html( $value['help'] );
				echo '</p>';
			}
		}

		/**
		 * Check is User Create Code in use?
		 *
		 * @since 2.3.0
		 */
		private function check_user_code() {
			if ( $this->is_network ) {
				$status = get_site_option( 'registration' );
				if ( 'blog' === $status ) {
					return false;
				}
				$show = $this->get_value( 'user', 'settings', 'off' );
				if ( 'on' === $show ) {
					$code = $this->get_value( 'user', 'code' );
					if ( empty( $code ) ) {
						return false;
					}
					return true;
				}
			} else {
				$code = $this->get_value( 'user', 'code' );
				if ( ! empty( $code ) ) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Add User Create Code to login form.
		 *
		 * @since 2.3.0
		 *
		 * @param WP_Error $errors WP_Error object.
		 */
		public function add_user_code( $errors ) {
			$show = $this->check_user_code();
			if ( ! $show ) {
				return;
			}
			/**
			 * get configuration
			 */
			$value = $this->get_value( 'user' );
			if ( ! isset( $value['branding'] ) || empty( $value['branding'] ) ) {
				$value['branding'] = __( 'User Create Code', 'ub' );
			}
			/**
			 * print
			 */
			$this->print_field( 'user_code', $value, $errors );
		}

		/**
		 * Validate User Create Code
		 *
		 * @since 2.3.0
		 *
		 * @param array $results Result of create accound form.
		 */
		public function validate_user_signup( $results ) {
			/**
			 * validate user signup
			 * check user code
			 */
			$show = $this->check_user_code();
			if ( $show ) {
				$name = $this->get_name( 'user_code' );
				$code_saved = $this->get_value( 'user', 'code' );
				$code_entered = filter_input( INPUT_POST, $name, FILTER_SANITIZE_STRING );
				/**
				 * Case sensitive/insensitive
				 */
				$case = $this->get_value( 'user', 'case', 'sensitive' );
				if ( 'insensitive' === $case ) {
					$code_saved = strtolower( $code_saved );
					$code_entered = strtolower( $code_entered );
				}
				/**
				 * Compare!
				 */
				if ( $code_saved != $code_entered ) {
					$results['errors']->add( $name, $this->get_value( 'user', 'error' ) );
				}
			}
			/**
			 * return
			 */
			return $results;
		}

		/**
		 * Validate User Create Code on single site
		 *
		 * @since 2.3.0
		 *
		 * @param WP_Error $errors WP_Error object.
		 */
		public function validate_user_signup_single( $errors ) {
			$results = array(
				'errors' => $errors,
			);
			$results = $this->validate_user_signup( $results );
			return $results['errors'];
		}

		/**
		 * Validate Blog Code
		 *
		 * @since 2.3.0
		 *
		 * @param array $results Result of create accound form.
		 */
		public function validate_blog_signup( $results ) {
			$results = $this->validate_user_signup( $results );
			/**
			 * check blog create code
			 */
			$show = $this->check_blog_code();
			if ( $show ) {
				$name = $this->get_name( 'blog_code' );
				$code_saved = $this->get_value( 'blog', 'code' );
				$code_entered = filter_input( INPUT_POST, $name, FILTER_SANITIZE_STRING );
				/**
				 * Case sensitive/insensitive
				 */
				$case = $this->get_value( 'blog', 'case', 'sensitive' );
				if ( 'insensitive' === $case ) {
					$code_saved = strtolower( $code_saved );
					$code_entered = strtolower( $code_entered );
				}
				/**
				 * Compare!
				 */
				if ( $code_saved != $code_entered ) {
					$results['errors']->add( $name, $this->get_value( 'blog', 'error' ) );
				}
			}
			/**
			 * return
			 */
			return $results;
		}

		/**
		 * Check is Clog Create Code in use?
		 *
		 * @since 2.3.0
		 */
		private function check_blog_code() {
			$show = $this->get_value( 'blog', 'settings', 'off' );
			if ( 'on' === $show ) {
				$code = $this->get_value( 'blog', 'code' );
				if ( empty( $code ) ) {
					return false;
				}
				return true;
			}
			return false;
		}

		/**
		 * Adds an additional field for Blog description,
		 * on signup form for WordPress or Buddypress
		 * @param type $errors
		 */
		public function add_blog_code( $errors ) {
			$show = $this->check_user_code();
			if ( $show ) {
				$name = $this->get_name( 'user_code' );
				if ( isset( $_POST[ $name ] ) ) {
					printf(
						'<input type="hidden" name="%s" value="%s" />',
						esc_attr( $name ),
						esc_attr( $_POST[ $name ] )
					);
				} else {
					if (
						class_exists( 'ProSites_View_Front_Registration' )
						&& isset( $_GET['action'] )
						&& 'new_blog' === $_GET['action']
					) {
					} else {
						return $errors;
					}
				}
			}
			$show = $this->check_blog_code();
			if ( ! $show ) {
				return;
			}
			/**
			 * get configuration
			 */
			$value = $this->get_value( 'blog' );
			if ( ! isset( $value['branding'] ) || empty( $value['branding'] ) ) {
				$value['branding'] = __( 'Blog Create Code', 'ub' );
			}
			/**
			 * print
			 */
			$this->print_field( 'blog_code', $value, $errors );
		}
	}
}
new Branda_Signup_Codes;