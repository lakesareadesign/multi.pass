<?php

if( !class_exists("Opt_In_Mailchimp") ):

if( !class_exists( "Mailchimp" ) )
    require_once Opt_In::$vendor_path . 'mailchimp/mailchimp/src/Mailchimp.php';

class Opt_In_Mailchimp extends Opt_In_Provider_Abstract implements  Opt_In_Provider_Interface {

    const ID = "mailchimp";
    const NAME = "MailChimp";


    /**
     * @var $api Mailchimp
     */
    protected  static $api;
    protected  static $errors;

    const GROUP_TRANSIENT = "hustle-mailchimp-group-transient";

    static function instance(){
        return new self;
    }

    public static function register_ajax_endpoints(){
        add_action("wp_ajax_hustle_mailchimp_get_list_groups", array( __CLASS__ , "ajax_get_list_groups" ) );
        add_action("wp_ajax_hustle_mailchimp_get_group_interests", array( __CLASS__ , "ajax_get_group_interests" ) );
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
     * @return Mailchimp
     */
    protected static function api( $api_key ){

        if( empty( self::$api ) ){
            try {
                self::$api = new Mailchimp( $api_key, array("debug" => true) );
                self::$errors = array();
            } catch (Mailchimp_Error $e) {
                self::$errors = array("api_error" => $e) ;
            }

        }

        return self::$api;
    }

    public function subscribe( Opt_In_Model $optin, array $data ){
        $email =  $data['email'];
        unset(  $data['email'] );

        $merge_vals = array();
        if( isset( $data['f_name'] ) )
            $merge_vals['MERGE1'] = $data['f_name'];

        if( isset( $data['l_name'] ) )
            $merge_vals['MERGE2'] = $data['l_name'];


        /**
         * Add args for interest groups
         */
        if( !empty( $data['inc_optin_mailchimp_group_id'] ) && !empty( $data['inc_optin_mailchimp_group_interest'] ) ){

            $merge_vals['groupings'] = array(
                array(
                    "id" => $data['inc_optin_mailchimp_group_id'],
                    "groups" => (array) $data['inc_optin_mailchimp_group_interest']
                )
            );

        }

        if( isset( $optin->provider_args->group ) && !empty( $optin->provider_args->group->selected ) ){

            $interests = array();
            foreach( $optin->provider_args->group->groups as $interest ){
                if( in_array( $interest->value, (array) $optin->provider_args->group->selected ) )
                    $interests[] = $interest->label;
            }
            $merge_vals['groupings'] = array(
                array(
                    "id" => $optin->provider_args->group->id,
                    "groups" => $interests
                )
            );

        }

        $result = self::api( $optin->api_key )->lists->subscribe( $optin->optin_mail_list, array( "email" => $email ), $merge_vals, 'html', true, true);

        if( empty( self::$errors ) )
            return $result;

        return self::$errors;
    }

    function get_options( $optin_id ){
        $_lists = self::api( $this->api_key )->lists->getList();
        $lists = array();
        if( $_lists['total'] ){
            $data = $_lists['data'];
            foreach( $data as $list ){
                $list = (array) $list;
                $lists[ $list['id'] ]['value'] = $list['id'];
                $lists[ $list['id'] ]['label'] = $list['name'];
            }
        }

        $first = count( $lists ) > 0 ? reset( $lists ) : "";
        if( !empty( $first ) )
            $first = $first['value'];




        $default_options =  array(
            "label" => array(
                "id" => "optin_email_list_label",
                "for" => "optin_email_list",
                "value" => __("Choose email list:", Opt_In::TEXT_DOMAIN),
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
                    "data-nonce" => wp_create_nonce("mailchimp_choose_email_list"),
                    'class' => "mailchimp_optin_email_list"
                )
            )
        );

        $list_group_options = self::_get_list_group_options( $this->api_key, $first );

        return array_merge( $default_options,  array(
            "wpoi-list-groups-wrapper" => array(
                "id" => "wpoi-list-groups",
                "class" => "wpoi-list-groups",
                "type" => "wrapper",
                "elements" =>  is_a( $list_group_options, "Mailchimp_Error" ) ? array() : $list_group_options
            ),
            "wpoi-list-group-interests-wrapper" => array(
                "id" => "wpoi-list-group-interests-wrap",
                "class" => "wpoi-list-group-interests-wrap",
                "type" => "wrapper",
                "elements" =>  array()
            )
        ));

    }

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
                "value" => __("Log in to your <a href='https://admin.mailchimp.com/account/api/' target='_blank'>MailChimp account</a> to get your API Key.", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
        );
    }

    function is_authorized(){
        return true;
    }

    /**
     * Returns options for the given $list_id
     *
     * @param $api_key
     * @param $list_id
     * @return array|Exception
     */
    private static function _get_list_group_options( $api_key, $list_id ){
        $group_options = array();
        $options = array(
            -1 => array(
                "value" => -1,
                "label" => __("No group", Opt_In::TEXT_DOMAIN),
                "interests" => __("First choose interest group", Opt_In::TEXT_DOMAIN)
            )
        );

        try{
            $groups = (array) self::api( $api_key )->lists->interestGroupings( $list_id );
            set_site_transient( self::GROUP_TRANSIENT  . $list_id, $groups );
        }catch (Exception $e){
                return $e;
        }

        if( !count( $groups ) ) return $group_options;

        foreach( $groups as $group ){
            $options[ $group['id'] ]['value'] = $group['id'];
            $options[ $group['id'] ]['label'] = $group['name'] . " ( " . ucfirst( $group['form_field'] ) . " )";
        }

        $first = current( $options );
        return array(
            "mailchimp_groups_label" => array(
                "id" => "mailchimp_groups_label",
                "for" => "mailchimp_groups",
                "value" => __("Choose interest group:", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            ),
            "mailchimp_groups" => array(
                "type" => 'select',
                'name' => "mailchimp_groups",
                'id' => "mailchimp_groups",
                "default" => "",
                'options' => $options,
                'value' => $first,
                'selected' => $first,
                "attributes" => array(
                    "data-nonce" => wp_create_nonce("mailchimp_groups")
                )
            ),
            "mailchimp_groups_instructions" => array(
                "id" => "mailchimp_groups_instructions",
                "for" => "",
                "value" => __("Leave this option blank if you would like to opt-in users without adding them to a group first", Opt_In::TEXT_DOMAIN),
                "type" => "label",
            )
        );

    }

    /**
     * Normalizes api response for groups interests
     *
     *
     * @since 1.0.1
     *
     * @param $interest
     * @return mixed
     */
    function normalize_group_interest( $interest ){
        $interest["label"] = $interest['name'];
        $interest["value"] = $interest['id'];

        unset( $interest['name'] );
        unset( $interest['id'] );
        unset( $interest['subscribers'] );

        return $interest;
    }
    /**
     * Returns interest for given $list_id, $group_id
     *
     * @since 1.0.1
     *
     * @param $list_id
     * @param $group_id
     * @return array
     */
    private static function _get_group_interests( $list_id, $group_id ){

        $interests = array(
            -1 => array(
                "id" => -1,
                "label" => __("No default choice", Opt_In::TEXT_DOMAIN)
            )
        );

        $groups = get_site_transient( self::GROUP_TRANSIENT  . $list_id );

        if( !count( $groups ) ) return $interests;

        $the_group = array();

        foreach( $groups as $group ){
            if( $group["id"] == $group_id )
                $the_group = $group;
        }

        if( $the_group === array() ) return $interests;

        if( in_array($the_group['form_field'], array("radio", "checkboxes", "hidden")) )
            $interests = array();

        $interests = array_merge( $interests,  array_map( array(__CLASS__, "normalize_group_interest" ),  $the_group['groups']) );

        if(  "hidden" === $the_group['form_field'] && isset( $the_group['groups'][0] ) )
            $the_group['selected'] = $the_group['groups'][0]['id'];

        return array(
            'group' => $the_group,
            "interests" => $interests,
            "type" => $the_group['form_field']
        );
    }

    /**
     * @used by array_map in _get_group_interest_args to map interests to their id/value
     *
     * @since 1.0.1
     * @param $interest
     * @return mixed
     */
    private function _map_interests_to_ids( $interest ){
        return $interest['value'];
    }

    /**
     * Returns interest args for the given $group_id and $list_id
     *
     * @since 1.0.1
     *
     * @param $list_id
     * @param $group_id
     * @return array
     */
    private static function _get_group_interest_args($list_id, $group_id ){
        $interests_config = self::_get_group_interests( $list_id, $group_id );
        $interests = $interests_config['interests'];

        $_type = $interests_config['type'];

        $type = "radio" === $interests_config['type'] ? "radios" : $interests_config['type'];
        $type = "dropdown" === $type || "hidden" === $type ? "select" : $type;

        $first = current( $interests );

        $interests_config['group']['groups'] = array_map( array(__CLASS__, "normalize_group_interest" ), $interests_config['group']['groups'] );

        $name = "mailchimp_groups_interests";

        if( $type === "checkboxes" )
            $name .= "[]";

        $choose_prompt = __("Choose default interest:", Opt_In::TEXT_DOMAIN);

        if( $_type === "checkboxes" )
            $choose_prompt = __("Choose default interest(s):", Opt_In::TEXT_DOMAIN);

        if( $_type === "hidden" )
            $choose_prompt = __("Set default interest:", Opt_In::TEXT_DOMAIN);

        if( $type === "radios" )
            $choose_prompt .= sprintf(" ( <a href='#' data-name='mailchimp_groups_interests' class='wpoi-leave-group-intrests-blank wpoi-leave-group-intrests-blank-radios' >%s</a> )", __("clear selection", Opt_In::TEXT_DOMAIN) );

        return array(
            'group' => $interests_config['group'],
            "fields" => array(
                "mailchimp_groups_interest_label" => array(
                    "id" => "mailchimp_groups_interest_label",
                    "for" => "mailchimp_groups_interests",
                    "value" => $choose_prompt,
                    "type" => "label",
                ),
                "mailchimp_groups_interests" => array(
                    "type" => $type,
                    'name' => $name,
                    'id' => "mailchimp_groups_interests",
                    "default" => "",
                    'options' => $interests,
                    'value' => $first,
                    'selected' => array(),
                    "item_attributes" => array(
//                        "class" => 'mailchimp_groups_interests'
                    )
                ),
                "mailchimp_groups_interest_instructions" => array(
                    "id" => "mailchimp_groups_interest_instructions",
                    "for" => "",
                    "value" =>  __("What you select here will appear pre-selected for users. If this is a hidden group, the interest will be set but not shown to users.", Opt_In::TEXT_DOMAIN),
                    "type" => "label",
                )
            )
        );
    }

    /**
     * Ajax endpoint to render html for group options based on given $list_id and $api_key
     *
     * @since 1.0.1
     */
    function ajax_get_list_groups(){
        Opt_In_Utils::validate_ajax_call( 'mailchimp_choose_email_list' );

        $list_id = filter_input( INPUT_GET, 'optin_email_list' );
        $api_key = filter_input( INPUT_GET, 'optin_api_key' );
        $options = self::_get_list_group_options( $api_key, $list_id );

        $html = "";
        if( is_array( $options ) && !is_a($options, "Mailchimp_Error")  ){
            foreach( $options as $option )
                $html .= Opt_In::render("general/option", $option , true);

            wp_send_json_success( $html );
        }

        wp_send_json_error( $options );
    }

    /**
     * Ajax call endpoint to return interest options of give list id and group id
     *
     * @since 1.0.1
     */
    function ajax_get_group_interests(){
        Opt_In_Utils::validate_ajax_call( 'mailchimp_groups' );

        $list_id = filter_input( INPUT_GET, 'optin_email_list' );
        $group_id = filter_input( INPUT_GET, 'mailchimp_groups' );

        $groups_config = get_site_transient( self::GROUP_TRANSIENT  . $list_id );
        if( !$groups_config || !is_array( $groups_config ) )
            wp_send_json_error( __("Invalid list id: ", Opt_In::TEXT_DOMAIN) . $list_id );

        $args = self::_get_group_interest_args( $list_id, $group_id );
        $fields = $args['fields'];
        $html = "";
        foreach( $fields as $field )
            $html .= Opt_In::render("general/option", $field , true);

        wp_send_json_success(  array(
            "html" => $html,
            "group" => $args['group']
        ) );
    }
}

    Opt_In_Mailchimp::register_ajax_endpoints();
endif;