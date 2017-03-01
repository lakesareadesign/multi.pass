<?php

if( !class_exists("Opt_In_Campaignmonitor") ):

if( !class_exists( "CS_REST_General" ) )
    require_once Opt_In::$vendor_path . 'campaignmonitor/createsend-php/csrest_general.php';

if( !class_exists( "CS_REST_Subscribers" ) )
    require_once Opt_In::$vendor_path . 'campaignmonitor/createsend-php/csrest_subscribers.php';

if( !class_exists( "CS_REST_Clients" ) )
    require_once Opt_In::$vendor_path . 'campaignmonitor/createsend-php/csrest_clients.php';

class Opt_In_Campaignmonitor extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface
{

    const ID = "campaignmonitor";
    const NAME = "Campaignmonitor";

    /**
     * @var $api AWeberAPI
     */
    protected  static $api;

    /**
     * @var
     */
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
     * @return CS_REST_General
     */
    protected static function api( $api_key ){
        if( empty( self::$api ) ){
            try {
                self::$api = new CS_REST_General( array('api_key' => $api_key) );
                self::$errors = array();
            } catch (Exception $e) {
                self::$errors = array("api_error" => $e) ;
            }

        }

        return self::$api;
    }

    public function subscribe( Opt_In_Model $optin, array $data ){
        $email = $data['email'];
        $name = isset( $data['f_name'] ) ? $data['f_name'] : "";
        $name .= ( isset( $data['l_name'] ) ? $data['l_name'] : "" );

        unset( $data['email'] );
        unset( $data['last_name'] );

        $custom_fields = array();
        if( !empty( $data ) ){
            foreach( $data as $key => $d ){
                $custom_fields[]['Key'] = $key;
                $custom_fields[]['Value'] = $d;
            }
        }

        $api = new CS_REST_Subscribers( $optin->optin_mail_list, array('api_key' => $optin->api_key));
        $is_subscribed = $api->get( $email );

        if ( $is_subscribed->was_successful() ) {
            self::$errors["already_subscribed"] =  __( 'Already subscribed', Opt_In::TEXT_DOMAIN );
        } else {
            $res = $api->add( array(
                'EmailAddress' => $email,
                'Name'         => $name,
                'Resubscribe'  => true,
                'CustomFields' => $custom_fields
            ) );

            if( $res->was_successful() ) {
                self::$errors["success"] = 'success';
            } else {
                self::$errors["error"] = $res->response->message;
            }
        }

        return self::$errors;
    }

    function get_options( $optin_id ){
        $cids = array();
        $lists = array();
        $clients = self::api( $this->api_key )->get_clients();
        if( !$clients->was_successful() ) return false;

        foreach( $clients->response as $client => $details ) {
            $cids[] = $details->ClientID;
        }

        if ( ! empty( $cids ) ) {
            foreach( $cids as $id ) {
                $client = new CS_REST_Clients( $id,  array('api_key' => $this->api_key) );
                $_lists = $client->get_lists();

                foreach ( $_lists->response as $key => $list ) {
                    $lists[ $list->ListID ]['value'] = $list->ListID;
                    $lists[ $list->ListID ]['label'] = $list->Name;

                }
            }
        }

        $first = count( $lists ) > 0 ? reset( $lists ) : "";
        if( !empty( $first ) )
            $first = $first['value'];

        return array(
            "label" => array(
                "id" => "optin_email_list_label",
                "for" => "optin_email_list",
                "value" => __("Choose Email List:", Opt_In::TEXT_DOMAIN),
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
            )
        );
    }

    function get_account_options( $optin_id ){
        $api_key_tooltip = '<span class="wpoi-tooltip tooltip-right" tooltip="' . __('Once logged in, click on your profile picture at the top-right corner to open te menu, then click on Manage Account and finally click on API keys.', Opt_In::TEXT_DOMAIN) . '"><span class="dashicons dashicons-warning wpoi-icon-info"></span></span>';
        return array(
            "label" => array(
                "id" => "optin_api_key_label",
                "for" => "optin_api_key",
                "value" => __("Enter Your API Key:", Opt_In::TEXT_DOMAIN),
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
                        "id" => "refresh_mailchimp_lists",
                        "name" => "refresh_mailchimp_lists",
                        "type" => "button",
                        "value" => __("Get Lists"),
                        'class' => "wph-button wph-button--filled wph-button--gray optin_refresh_provider_details"
                    ),
                )
            ),
            "instructions" => array(
                "id" => "optin_api_instructions",
                "for" => "",
                "value" => __("To get your API key, log in to your <a href='https://login.createsend.com/l/?ReturnUrl=%2Faccount%2Fapikeys' target='_blank'>Campaign Monitor account</a>, then click on your profile picture at the top-right corner to open a menu, then select <strong>Manage Account</strong> and finally click on <strong>API keys</strong>.", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
        );
    }

    function is_authorized(){
        return true;
    }

}
endif;