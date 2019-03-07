<?php
/**
 * Branda Administrator Message class.
 *
 * @package Branda
 * @subpackage AdminArea
 */
if ( ! class_exists( 'Branda_Admin_Message' ) ) {
	class Branda_Admin_Message extends Branda_Helper {

		protected $option_name = 'ub_admin_message';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			/**
			 * UB admin actions
			 */
			add_filter( 'ultimatebranding_settings_admin_message', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_admin_message_process', array( $this, 'update' ) );
			/**
			 * Render module's output for admin pages
			 */
			add_action( 'admin_notices', array( $this, 'admin_message_output' ) );
			/**
			 * Render module's output for network admin pages
			 */
			add_action( 'network_admin_notices', array( $this, 'admin_message_output' ) );
			/**
			 * upgrade option
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}

		/**
		 * set options
		 *
		 * @since 2.2.0
		 */
		protected function set_options() {
			$this->module = 'admin-message';
			$this->options = array(
				'admin' => array(
					'title' => __( 'Message', 'ub' ),
					'description' => __( 'This message will appear on top of every admin page. You can use this to show notifications or important announcements.', 'ub' ),
					'fields' => array(
						'message' => array(
							'type' => 'wp_editor',
							'hide-th' => true,
						),
					),
				),
			);
		}

		/**
		 * Upgrade option
		 *
		 * @since 2.2.0
		 */
		public function upgrade_options() {
			$value = $this->get_value();
			if ( ! empty( $value ) && ! is_array( $value ) ) {
				$data = array(
					'admin' => array(
						'message' => $value,
					),
				);
				$this->update_value( $data );
			}
			/**
			 * Change option name
			 *
			 * @since 3.0.0
			 */
			$old_name = 'admin_message';
			$value = ub_get_option( $old_name );
			if ( ! empty( $value ) ) {
				$this->update_value( $value );
				ub_delete_option( $old_name );
			}
		}

		/**
		 * Renders the admin message
		 *
		 * @since 1.8
		 */
		public function admin_message_output() {
			$v = $this->get_value( 'admin' );
			if ( empty( $v ) || ! is_array( $v ) ) {
				return;
			}
			$admin_message = '';
			if ( isset( $v['message_meta'] ) ) {
				$admin_message = $v['message_meta'];
			} else if ( isset( $v['message'] ) ) {
				$admin_message = $v['message'];
			}
			if ( empty( $admin_message ) ) {
				return;
			}
			printf(
				'<div id="ub-message" class="updated"><p>%s</p></div>',
				stripslashes( $admin_message )
			);
		}
	}
}
new Branda_Admin_Message;