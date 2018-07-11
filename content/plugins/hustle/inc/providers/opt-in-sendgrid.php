<?php

if( !class_exists("Opt_In_SendGrid") ):
include_once 'opt-in-sendgrid-api.php';

class Opt_In_SendGrid extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface {

	const ID = "sendgrid";
	const NAME = "SendGrid";

	protected $id = self::ID;


	/**
	 * @return Opt_In_Provider_Interface|Opt_In_Provider_Abstract class
	 */
	public static function instance(){
		return new self();
	}

	/**
	 * Get Provider Details
	 * General function to get provider details from database based on key
	 *
	 * @param Hustle_Module_Model $module
	 * @param String $field - the field name
	 *
	 * @return String
	 */
	protected static function _get_provider_details( Hustle_Module_Model $module, $field ) {
		$details = '';
		$name = self::ID;
		if ( isset( $module->content->email_services[$name][$field] ) ) {
 			$details = $module->content->email_services[$name][$field];
		}
		return $details;
	}

	private static function api( $api_key = '' ) {
		try {
			return new Opt_In_SendGrid_Api( $api_key );
		} catch ( Exception $e ) {
			return $e;
		}
	}

	/**
	 * Adds contact to the the SendGrid
	 *
	 * @param Hustle_Module_Model $module
	 * @param array $data
	 * @return mixed|bool|WP_Error
	 */
	public function subscribe( Hustle_Module_Model $module, array $data ) {
		$api_key 	= self::_get_api_key( $module );
		$list_id 	= self::_get_list_id( $module );

		$err 		= new WP_Error();
		$api 		= self::api( $api_key );
		$email 		= $data['email'];

		$existing_member = $api->email_exist( $email, $list_id );
		if ( $existing_member ) {
			$err->add( 'email_exist', __( 'This email address has already subscribed.', Opt_In::TEXT_DOMAIN ) );
			return $err;
		}

		if ( empty( $data['first_name'] ) && isset( $data['f_name'] ) ) {
			$data['first_name'] = $data['f_name']; // Legacy
		}

		if ( empty( $data['last_name'] ) && isset( $data['l_name'] ) ) {
			$data['last_name'] = $data['l_name']; // Legacy
		}
		unset( $data['f_name'], $data['f_name'] );

		$res = $api->add_contact( $data, $list_id, $module );
		if ( !is_wp_error( $res ) ) {
			return true;
		} else {
			$data['error'] 	= $res->get_error_message();
			$module->log_error( $data );
		}

		return $err;
	}


	/**
	 * Retrieves initial options of the SendGrid account with the given api_key
	 *
	 * @return array
	 */
	public function get_options() {

		$api 		= self::api( $this->api_key );
		$value 		= '';
		$options	= array();

		if ( $api ) {
			$lists = $api->get_lists();
		}

		if ( ! empty( $lists ) ) {
			foreach ( $lists as $list ) {
				$options[ $list['id'] ] = array(
					'value' => $list['id'],
					'label' => $list['name'],
				);
			}
		}

		return array(
			array(
				'type' 	=> 'label',
				'for' 	=> 'optin_email_list',
				'value' => __( 'Choose List', Opt_In::TEXT_DOMAIN ),
			),
			array(
				'label' 	=> __( 'Choose List', Opt_In::TEXT_DOMAIN ),
				'id' 		=> 'optin_email_list',
				'name' 		=> 'optin_email_list',
				'type' 		=> 'select',
				'value' 	=> $value,
				'options' 	=> $options,
				'selected' 	=> $value,
				"attributes"    => array(
					'class'         => "wpmudev-select"
				)
			),
		);
	}


	/**
	 * Returns initial account options
	 *
	 * @param $module_id
	 * @return array
	 */
	public function get_account_options( $module_id ) {
		$module     = Hustle_Module_Model::instance()->get( $module_id );
		$api_key    = self::_get_api_key( $module );

		return array(
			"label" => array(
				"id"    => "optin_api_key_label",
				"for"   => "optin_api_key",
				"value" => __("Enter your API key:", Opt_In::TEXT_DOMAIN),
				"type"  => "label",
			),
			"wrapper" => array(
				"id"    => "wpoi-get-lists",
				"class" => "wpmudev-provider-group",
				"type"  => "wrapper",
				"elements" => array(
					"api_key" => array(
						"id"            => "optin_api_key",
						"name"          => "optin_api_key",
						"type"          => "text",
						"default"       => "",
						"value"         => $api_key,
						"placeholder"   => "",
						"class"         => "wpmudev-input_text"
					),
					'refresh' => array(
						"id"    => "refresh_sendgrid_lists",
						"name"  => "refresh_sendgrid_lists",
						"type"  => "ajax_button",
						"value" => "<span class='wpmudev-loading-text'>" . __( "Fetch Lists", Opt_In::TEXT_DOMAIN ) . "</span><span class='wpmudev-loading'></span>",
						'class' => "wpmudev-button wpmudev-button-sm optin_refresh_provider_details"
					),
				)
			),
			"instructions" => array(
				"id"    => "optin_api_instructions",
				"for"   => "",
				"value" => sprintf( __("Log in to your <a href='%s' target='_blank'>SendGrid account</a> to get your API (version 3) Key.", Opt_In::TEXT_DOMAIN ), 'https://app.sendgrid.com/settings/api_keys' ),
				"type"  => "small",
			),
		);
	}

	private static function _get_api_key( Hustle_Module_Model $module ) {
		return self::_get_provider_details( $module, 'api_key' );
	}

	private static function _get_list_id( Hustle_Module_Model $module ) {
		return self::_get_provider_details( $module, 'list_id' );
	}


	public function is_authorized(){
		return true;
	}

	public static function add_custom_field( $fields, $module_id ) {
		$module 	= Hustle_Module_Model::instance()->get( $module_id );
		$api_key    = self::_get_api_key( $module );
		$api = self::api( $api_key );
		foreach ( $fields as $field ) {
			$type = strtolower( $field['type'] );
			if ( !in_array( $type, array( 'text', 'number', 'date' ), true ) ) {
				$type = 'text';
			}
			$api->add_custom_field( array(
				"name"	=> strtolower( $field['name'] ),
				"type"  => $type,
			) );
		}
	}
}

endif;