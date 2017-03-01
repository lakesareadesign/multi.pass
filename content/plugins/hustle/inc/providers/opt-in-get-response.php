<?php

if( !class_exists("Opt_In_Get_Response") ):

include_once 'opt-in-get-response-api.php';

/**
 * Defines and adds neeed methods for GetResponse email service provider
 *
 * Class Opt_In_Get_Response
 */
class Opt_In_Get_Response extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface {

    const ID = "get_response";
    const NAME = "GetResponse";


    /**
     * @var $api GetResponse
     */
    protected  static $api;

    protected  static $errors;


    static function instance(){
        return new self;
    }

    /**
     * Updates api option
     *
     * @param $option_key
     * @param $option_value
     * @return bool
     */
    function update_option($option_key, $option_value){
        return update_site_option( self::ID . "_" . $option_key, $option_value);
    }

    /**
     * Retrieves api option from db
     *
     * @param $option_key
     * @param $default
     * @return mixed
     */
    function get_option($option_key, $default){
        return get_site_option( self::ID . "_" . $option_key, $default );
    }

    /**
     * @param $api_key
     * @return Opt_In_Get_Response_Api
     */
    protected static function api( $api_key ){

        if( empty( self::$api ) ){
            try {
                self::$api = new Opt_In_Get_Response_Api( $api_key, array("debug" => true) );
                self::$errors = array();
            } catch (Exception $e) {
                self::$errors = array("api_error" => $e) ;
            }

        }

        return self::$api;
    }

    /**
     * Adds contact to the the campaign
     *
     * @param Opt_In_Model $optin
     * @param array $data
     * @return array|mixed|object|WP_Error
     */
    public function subscribe( Opt_In_Model $optin, array $data ){

        $email =  $data['email'];
        unset(  $data['email'] );

        $geo = new Opt_In_Geo();

        $name = array();
        if( isset( $data['f_name'] ) )
            $name[] = $data['f_name'];

        if( isset( $data['l_name'] ) )
            $name[] = $data['l_name'];

        $data = array(
            'email' => $email,
            "dayOfCycle" => "10",
            'campaign' => array(
                "campaignId" => $optin->optin_mail_list
            ),
            "ipAddress" => $geo->get_user_ip()
        );

        if( count( $name ) )
            $data['name'] = implode(" ", $name);

       return self::api( $optin->api_key )->subscribe( $data );

    }

    /**
     * Retrieves initial options of the GetResponse account with the given api_key
     *
     * @param $optin_id
     * @return array
     */
    function get_options( $optin_id ){
        $campains = self::api( $this->api_key )->get_campains();

        if( is_wp_error( $campains ) )
            wp_send_json_error(  __("No active campaign is found for the API. Please set up a campaign in GetResponse or check your API.", Opt_In::TEXT_DOMAIN)  );

        $lists = array();
        foreach(  ( array) $campains as $campain ){
            $lists[ $campain->campaignId ]['value'] = $campain->campaignId;
            $lists[ $campain->campaignId ]['label'] = $campain->name;
        }

        $first = count( $lists ) > 0 ? reset( $lists ) : "";
        if( !empty( $first ) )
            $first = $first['value'];

        return  array(
            "label" => array(
                "id" => "optin_email_list_label",
                "for" => "optin_email_list",
                "value" => __("Choose campaign:", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
            "choose_email_list" => array(
                "type" => 'select',
                'name' => "optin_email_list",
                'id' => "optin_email_list",
                "default" => "",
                'options' => $lists,
                'value' => $first,
                'selected' => $first,
                "attributes" => array(
                    "data-nonce" => wp_create_nonce("get_response_choose_campaign"),
                    'class' => "get_response_choose_campaign"
                )
            )
        );

    }

    /**
     * Returns initial account options
     *
     * @param $optin_id
     * @return array
     */
    function get_account_options( $optin_id ){
        return array(
            "label" => array(
                "id" => "optin_api_key_label",
                "for" => "optin_api_key",
                "value" => __("Enter your API key:", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
            "wrapper" => array(
                "id" => "wpoi-get-lists",
                "class" => "block-notification",
                "type" => "wrapper",
                "elements" => array(
                    "api_key" => array(
                        "id" => "optin_api_key",
                        "name" => "optin_api_key",
                        "type" => "text",
                        "default" => "",
                        "value" => "",
                        "placeholder" => "",
                    ),
                    'refresh' => array(
                        "id" => "refresh_get_response_lists",
                        "name" => "refresh_get_response_lists",
                        "type" => "button",
                        "value" => __("Get Lists"),
                        'class' => "wph-button wph-button--filled wph-button--gray optin_refresh_provider_details"
                    ),
                )
            ),
            "instructions" => array(
                "id" => "optin_api_instructions",
                "for" => "",
                "value" => __("Log in to your <a href='https://app.getresponse.com/manage_api.html' target='_blank'>GetResponse account</a> to get your API Key.", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
        );
    }

    function is_authorized(){
        return true;
    }

}

endif;