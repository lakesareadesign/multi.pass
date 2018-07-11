<?php
/**
 * SendGrid API Helper
 **/
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! class_exists( 'Opt_In_SendGrid_Api' ) ) :
	require_once Opt_In::$vendor_path . 'sendgrid-php/vendor/autoload.php';

	class Opt_In_SendGrid_Api {
		/**
		 * @var (string) SendGrid API KEY
		 **/
		private $api_key;

		/**
		 * @var (object) \SendGrid class instance
		 **/
		private $api;


		public function __construct( $api_key ) {
			$this->api_key = $api_key;

			$this->api = new \SendGrid( $api_key );
		}


		/**
		 * Retrieve the list of lists from SendGrid installation.
		 **/
		public function get_lists() {
			try {
				$body = $this->api->client->contactdb()->lists()->get()->body();
				$lists = json_decode( $body, true );
				if ( isset( $lists['lists'] ) ) {
					return $lists['lists'];
				}
			} catch( Exception $e ) {
				return false;
			}
			return false;
		}


		/**
		 * Add contact to the SendGrid.
		 *
		 * @param (associative_array) $data			An array of contact details to add.
		 * @param (int) $list_id					List ID.
		 * @return Returns contact ID on success or WP_Error.
		 **/
		public function add_contact( $data, $list_id, Hustle_Module_Model $module ) {
			$err = new WP_Error();

			try {
				$body = $this->api->client->contactdb()->recipients()->post( array( $data ) )->body();
				$res = json_decode( $body, true );
				if ( !empty( $res['persisted_recipients'][0] ) ) {
					$status_code = $this->api->client->contactdb()->lists()->_($list_id)->recipients()->post( array( $res['persisted_recipients'][0] ) )->statusCode();
					if ( 201 === $status_code ) {
						return $res['persisted_recipients'][0];
					}
					$err->add( 'subscribe_error', __( 'Email hasn\'t been added to the list.', Opt_In::TEXT_DOMAIN ) );
				} elseif ( !empty( $res['errors'][0]['message'] ) ) {
					$err->add( 'subscribe_error', $res['errors'][0]['message'] );
				} else {
					$err->add( 'subscribe_error', __( 'Something went wrong. Please try again', Opt_In::TEXT_DOMAIN ) );
				}
			} catch( Exception $e ) {
				$error = $e->getMessage();
				$err->add( 'subscribe_error', $error );
			}

			return $err;
		}


		/**
		 * Check if an email is already used.
		 *
		 * @param (string) $email
		 * @return Returns true if the given email already in use otherwise false.
		 **/
		public function email_exist( $email, $list_id ) {
			$err = new WP_Error();

			try {
				$query_params = array(
					'email'		=> $email,
					'list_id'	=> $list_id,
				);
				$body = $this->api->client->contactdb()->recipients()->search()->get(null, $query_params)->body();
				$res = json_decode( $body, true );
				return empty( $res ) || !isset( $res['recipient_count'] ) || 0 !== $res['recipient_count'];
			} catch( Exception $e ) {
				$err->add( 'server_error', $e->getMessage() );
			}

			return $err;
		}

        /**
         * Add custom field
         *
         * @param Array $field_data (title, type)
         */
        public function add_custom_field( $field_data ) {
			return $this->api->client->contactdb()->custom_fields()->post( $field_data );
        }

	}
endif;