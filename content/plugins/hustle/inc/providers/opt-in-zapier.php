<?php

if( !class_exists("Opt_In_Zapier") ):

class Opt_In_Zapier extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface {

	const ID = "zapier";
	const NAME = "Zapier";

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
	 * Adds contact to the Zapier
	 *
	 * @param Hustle_Module_Model $module
	 * @param array $data
	 * @return mixed|bool|WP_Error
	 */
	public function subscribe( Hustle_Module_Model $module, array $data ) {
		$webhook_url 	= self::_get_webhook_url( $module );
		$err			= new WP_Error();

		$content_type = 'application/json';

		$blog_charset = get_option( 'blog_charset' );
		if ( ! empty( $blog_charset ) ) {
			$content_type .= '; charset=' . $blog_charset;
		}

		$args = array(
			'method'    => 'POST',
			'body'      => wp_json_encode( $data ),
			'headers'   => array(
				'Content-Type'  => $content_type,
			),
		);

		$res = wp_remote_post( $webhook_url, apply_filters( 'opt_in_zapier_args', $args ) );
		$body = !empty( $res['body'] ) ? json_decode( $res['body'], true ) : false;
		if ( is_wp_error( $res ) ) {
			$data['error'] 	= $res->get_error_message();
		} elseif ( !empty( $body['status'] ) && 'success' === $body['status'] ) {
			return true;
		} else {
			$data['error'] 	= !empty( $body['status'] ) ? 'Status: ' . $body['status'] : 'Something went wrong.';
		}

		$module->log_error( $data );

		return $err;
	}


	/**
	 * Retrieves initial options of the Zapier account with the given api_key
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
		$module     = Hustle_Module_Model::instance()->get( $module_id );
		$webhook_url    = self::_get_webhook_url( $module );

		return array(
			"optin_url_label" => array(
				"id"    => "optin_url_label",
				"for"   => "optin_url",
				"value" => __("Enter a Webhook URL:", Opt_In::TEXT_DOMAIN),
				"type"  => "label",
			),
			"optin_url_field_wrapper" => array(
				"id"        => "optin_url_id",
				"class"     => "optin_url_id_wrapper",
				"type"      => "wrapper",
				"elements"  => array(
					"optin_url_field" => array(
						"id"            => "optin_url",
						"name"          => "optin_api_key",
						"type"          => "text",
						"default"       => "",
						"value"         => $webhook_url,
						"placeholder"   => "",
						"class"         => "wpmudev-input_text",
					)
				)
			),
			"instructions" => array(
				"id"    => "optin_api_instructions",
				"for"   => "",
				"value" => sprintf( __("Create a trigger into <a href='%s' target='_blank'>Zapier</a> using \"Webhooks\" app and choose \"Catch Hook\" option. Then insert Webhook URL above.", Opt_In::TEXT_DOMAIN ), 'https://zapier.com/app/editor/' ),
				"type"  => "small",
			),
		);
	}

	private static function _get_webhook_url( Hustle_Module_Model $module ) {
		return self::_get_provider_details( $module, 'api_key' );
	}

	public function is_authorized(){
		return true;
	}

}

endif;