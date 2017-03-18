<?php
/**
 * ConvertKit API
 *
 * @class Opt_In_ConvertKit_Api
 **/
class Opt_In_ConvertKit_Api {

	private $_api_key;
	private $_endpoint = 'https://api.convertkit.com/v3/';

	/**
     * Constructs class with required data
     *
     * Opt_In_ConvertKit_Api constructor.
     * @param $api_key
     */
	function __construct( $api_key ) {
		$this->_api_key = $api_key;
	}

	/**
     * Sends request to the endpoint url with the provided $action
     *
     * @param string $verb
     * @param string $action rest action
     * @param array $args
     * @return object|WP_Error
     */
    private function _request( $verb = "GET", $action, $args = array() ){
        $url = trailingslashit( $this->_endpoint )  . $action;

        $_args = array(
            "method" => $verb,
            "headers" =>  array(
				'X-Auth-Token' => 'api-key '. $this->_api_key,
                'Content-Type' => 'application/json;charset=utf-8'
            )
        );

        if( "GET" === $verb ){
            $url .= ( "?" . http_build_query( $args ) );
        }else{
            $_args['body'] = json_encode( $args['body'] );
        }

        $res = wp_remote_request( $url, $_args );
        if( $res['response']['code'] <= 204 )
            return json_decode(  wp_remote_retrieve_body( $res ) );

        $err = new WP_Error();
        $err->add($res['response']['code'], $res['response']['message'] );
        return  $err;
    }

    /**
     * Sends rest GET request
     *
     * @param $action
     * @param array $args
     * @return array|mixed|object|WP_Error
     */
    private function _get( $action, $args = array() ){
        return $this->_request( "GET", $action, $args );
    }

    /**
     * Sends rest POST request
     *
     * @param $action
     * @param array $args
     * @return array|mixed|object|WP_Error
     */
    private function _post( $action, $args = array()  ){
        return $this->_request( "POST", $action, $args );
    }

    /**
     * Retrieves ConvertKit forms as array of objects
     *
     * @return array|WP_Error
     */
    public function get_forms(){
        return $this->_get( "forms", array(
			'api_key' => $this->_api_key
		) )->forms;
    }

	/**
     * Retrieves ConvertKit form's custom fields as array of objects
     *
     * @return array|WP_Error
     */
    public function get_form_custom_fields(){
        return $this->_get( "custom_fields", array(
			'api_key' => $this->_api_key
		) )->custom_fields;
    }

	/**
     * Add new custom fields to subscription
     *
     * @param $field_data
     * @return array|mixed|object|WP_Error
     */
    public function create_custom_fields( $field_data ){
        $res =  $this->_post("custom_fields", array(
            "body" =>  $field_data
        ));

        return empty( $res ) ? __("Successfully added custom field", Opt_In::TEXT_DOMAIN) : $res;
    }

    /**
     * Add new subscriber
     *
     * @param $form_id
     * @param $data
     * @return array|mixed|object|WP_Error
     */
    public function subscribe( $form_id, $data ){
        $res =  $this->_post("forms/". $form_id ."/subscribe", array(
            "body" =>  $data
        ));

        return empty( $res ) ? __("Successful subscription", Opt_In::TEXT_DOMAIN) : $res;
    }
}