<?php


if( !class_exists("Opt_In_Sendy") ):


class Opt_In_Sendy extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface {

	const ID = "sendy";
	const NAME = "Sendy";

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

	/**
	 * Adds contact to the the campaign
	 *
	 * @param Hustle_Module_Model $module
	 * @param array $data
	 * @return array|mixed|object|WP_Error
	 */
	public function subscribe( Hustle_Module_Model $module, array $data ) {
		$api_key    		= self::_get_api_key( $module );
		$email_list 		= self::_get_email_list( $module );
		$installation_url 	= self::_get_api_url( $module );

		$err 				= new WP_Error();
		$_data = array(
			"boolean" => 'true',
			"list" => $email_list
		);
		$_data['email'] =  $data['email'];

		$name = array();

		if ( ! empty( $data['first_name'] ) ) {
			$name['first_name'] = $data['first_name'];
		}
		elseif ( ! empty( $data['f_name'] ) ) {
			$name['first_name'] = $data['f_name']; // Legacy
		}
		if ( ! empty( $data['last_name'] ) ) {
			$name['last_name'] = $data['last_name'];
		}
		elseif ( ! empty( $data['l_name'] ) ) {
			$name['last_name'] = $data['l_name']; // Legacy
		}

		if( count( $name ) )
			$_data['name'] = implode(" ", $name);

		// Add extra fields
		$extra_fields = array_diff_key( $data, array(
			'email' => '',
			'first_name' => '',
			'last_name' => '',
			'f_name' => '',
			'l_name' => '',
		) );
		$extra_fields = array_filter( $extra_fields );

		if ( ! empty( $extra_fields ) ) {
			$_data = array_merge( $_data, $extra_fields );
		}

		if ( !empty( $installation_url ) ) {
			$url = trailingslashit( $installation_url ) . "subscribe";
		} else {
			$err->add( 'broke', __( 'Empty installation url', Opt_In::TEXT_DOMAIN ) );
			return $err;
		}

		$res = wp_remote_post( $url, array(
			"header" => 'Content-type: application/x-www-form-urlencoded',
			"body" => $_data
		));

		if ( is_wp_error( $res ) ) {
			return $res;
		}

		if ( $res['response']['code'] <= 204 ) {
			if ( 'Already subscribed.' === $res['body'] ) {
				$err->add( 'email_exist', __( 'This email address has already subscribed.', Opt_In::TEXT_DOMAIN ) );
				return $err;
			} elseif ( 'Invalid list ID.' === $res['body'] ) {
				$err->add( 'invalid_list_id', __( 'Invalid list id.', Opt_In::TEXT_DOMAIN ) );
				return $err;
			} elseif ( 'Some fields are missing.' === $res['body'] ) {
				$err->add( 'field_missing', __( 'Some fields are missing.', Opt_In::TEXT_DOMAIN ) );
				return $err;
			} elseif ( 'Invalid email address.' === $res['body'] ) {
				$err->add( 'invalid_email', __( 'Invalid email address.', Opt_In::TEXT_DOMAIN ) );
				return $err;
			}
			return true;
		} else {
			$err->add( $res['response']['code'], $res['response']['message']  );
			return $err;
		}
	}

	/**
	 * Retrieves initial options of the GetResponse account with the given api_key
	 *
	 * @return array
	 */
	public function get_options() {
		return array();
	}

	/**
	 * Returns initial account options
	 *
	 * @param $module_id
	 * @return array
	 */
	public function get_account_options( $module_id ) {
		$module     		= Hustle_Module_Model::instance()->get( $module_id );
		$api_key    		= self::_get_api_key( $module );
		$email_list 		= self::_get_email_list( $module );
		$installation_url 	= self::_get_api_url( $module );

		return array(
			"label" => array(
				"id"    => "optin_api_key_label",
				"for"   => "optin_api_key",
				"value" => __("Enter your API key:", Opt_In::TEXT_DOMAIN),
				"type"  => "label",
			),
			"api_wrapper" => array(
				"id"    => "wpoi-sendy-api-text",
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
				)
			),

			"choose_email_list_label" => array(
				"id"    => "optin_email_list_label",
				"for"   => "wpoi-sendy-get-lists",
				"value" => __("Enter list id:", Opt_In::TEXT_DOMAIN),
				"type"  => "label",
			),
			"list_wrapper" => array(
				"id"    => "wpoi-sendy-get-lists",
				"class" => "wpmudev-provider-group",
				"type"  => "wrapper",
				"elements" => array(
					"choose_email_list" => array(
						"type"          => 'text',
						'name'          => "optin_email_list",
						'id'            => "optin_email_list",
						'value'         => $email_list,
						"placeholder"   => "",
						"class"         => "wpmudev-input_text"
					),
				)
			),

			"installation_url_label" => array(
				"id"    => "optin_installation_url_label",
				"for"   => "optin_installation_url",
				"value" => __("Enter Sendy installation URL:", Opt_In::TEXT_DOMAIN),
				"type"  => "label",
			),
			"installation_wrapper" => array(
				"id"    => "wpoi-sendy-installation-url",
				"class" => "wpmudev-provider-group",
				"type"  => "wrapper",
				"elements" => array(
					"installation_url" => array(
						"id"            => "optin_sendy_installation_url",
						"name"          => "optin_sendy_installation_url",
						"type"          => "text",
						"default"       => "",
						"value"         => $installation_url,
						"placeholder"   => "",
						"class"         => "wpmudev-input_text"
					),
				)
			),

			"instructions" => array(
				"id"    => "optin_api_instructions",
				"for"   => "",
				"value" => __("Log in to your Sendy installation to get your API Key and list id.", Opt_In::TEXT_DOMAIN),
				"type"  => "small",
			),
		);
	}

	private static function _get_api_url( Hustle_Module_Model $module ) {
		return self::_get_provider_details( $module, 'installation_url' );
	}

	private static function _get_api_key( Hustle_Module_Model $module ) {
		return self::_get_provider_details( $module, 'api_key' );
	}

	private static function _get_email_list( Hustle_Module_Model $module ) {
		return self::_get_provider_details( $module, 'list_id' );
	}

	public function is_authorized(){
		return true;
	}

	/**
	 *
	 *
	 * @param $module Hustle_Module_Model
	 * @return bool
	 */
	public static function show_selected_list( $val, $module ){
		if( self::ID === $module->content->active_email_service )
			return false;

		return true;
	}

	public static function add_values_to_previous_optins( $option, $module  ){
		if( self::ID !== $module->content->active_email_service ) return $option;

		$list   = self::_get_email_list( $module );
		$url    = self::_get_api_url( $module );

		if( "wpoi-sendy-get-lists" === $option['id'] ){
			$option['elements']['choose_email_list']['value'] = $list;
		}

		if( "wpoi-sendy-installation-url" === $option['id'] && isset( $url ) ){
			$option['elements']['installation_url']['value'] = $url;
		}

		return $option;
	}
}

add_filter("wpoi_optin_sendy_show_selected_list",  array( "Opt_In_Sendy", "show_selected_list" ), 10, 2 );
add_filter("wpoi_optin_filter_optin_options",  array( "Opt_In_Sendy", "add_values_to_previous_optins" ), 10, 2 );

endif;