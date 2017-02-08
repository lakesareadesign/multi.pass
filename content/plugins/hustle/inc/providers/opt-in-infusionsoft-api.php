<?php

if( class_exists("Opt_In_Infusionsoft_Api") ) return;

class Opt_In_Infusionsoft_Api
{

    /**
     * @var string $_api_key
     */
    private $_api_key;

    /**
     * @var string $_app_name
     */
    private $_app_name;

    /**
     * Opt_In_Infusionsoft_Api constructor.
     *
     * @param $api_key
     * @param $app_name
     */
    function __construct( $api_key, $app_name ){
        $this->_api_key = $api_key;
        $this->_app_name = $app_name;
        return  $this;
    }

    /**
     * Add contact to contacts list
     *
     * @param $contact
     * @return SimpleXMLElement|WP_Error
     */
    public function add_contact( $contact ){

        $data = wp_parse_args($contact, array(
           "Email" => "",
           "FirstName" => "",
           "LastName" => ""
        ));

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
        <methodCall>
            <methodName>ContactService.addWithDupCheck</methodName>
            <params>
                <param>
                <value>
                    <string>{$this->_api_key}</string>
                </value>
                </param>
                <param>
                    <value>
                        <struct>
                            <member>
                                <name>FirstName</name>
                                <value>
                                    <string>{$data['FirstName']}</string>
                                </value>
                            </member>
                            <member>
                                <name>LastName</name>
                                <value>
                                    <string>{$data['LastName']}</string>
                                </value>
                            </member>
                            <member>
                                <name>Email</name>
                                <value>
                                    <string>{$data['Email']}</string>
                                </value>
                            </member>
                        </struct>
                    </value>
                </param>
                <param>
                    <value>
                        <string>Email</string>
                    </value>
                </param>
            </params>
        </methodCall>";

        $res = $this->_request( $xml );

        if( is_wp_error( $res ) )
            return res;

        return $res->get_value();
    }

    /**
     * Adds contact with $contact_id to group with $group_id
     *
     * @param $contact_id
     * @param $tag_id
     * @return Opt_In_Infusionsoft_XML_Res|WP_Error
     */
    public function add_tag_to_contact( $contact_id, $tag_id ){
        $xml = "<?xml version='1.0' encoding='UTF-8'?>
                <methodCall>
                  <methodName>ContactService.addToGroup</methodName>
                  <params>
                    <param>
                      <value>
                        <string>{$this->_api_key}</string>
                      </value>
                    </param>
                    <param>
                      <value>
                        <int>$contact_id</int>
                      </value>
                    </param>
                    <param>
                      <value>
                        <int>$tag_id</int>
                      </value>
                    </param>
                  </params>
                </methodCall>";

        $res = $this->_request( $xml );

        if( is_wp_error( $res ) )
            return res;

        return $res->get_value();

    }

    function get_lists(){
        $page = 0;
        $xml = "<?xml version='1.0' encoding='UTF-8'?>
                <methodCall>
                  <methodName>DataService.query</methodName>
                  <params>
                    <param>
                      <value>
                        <string>{$this->_api_key}</string>
                      </value>
                    </param>
                    <param>
                      <value>
                        <string>ContactGroup</string>
                      </value>
                    </param>
                    <param>
                      <value>
                        <int>1000</int>
                       </value>
                    </param>
                    <param>
                      <value>
                        <int>$page</int>
                      </value>
                    </param>
                    <param>
                      <value><struct>
                        <member>
                              <name>Id</name>
                              <value>
                                <string>%</string>
                              </value>
                        </member>
                      </struct></value>
                    </param>
                    <param>
                      <value><array>
                        <data>
                          <value><string>Id</string></value>
                          <value><string>GroupName</string></value>
                        </data>
                      </array></value>
                    </param>
                  </params>
                </methodCall>";

        $res = $this->_request( $xml );

        if( is_wp_error( $res ) )
            return $res;

        return $res->get_tags_list();
    }

    /**
     * Dispatches the request to the Infusionsoft server
     *
     * @param $query_str
     * @return Opt_In_Infusionsoft_XML_Res|WP_Error
     */
    private function _request( $query_str ){
        $url = esc_url_raw( 'https://' . $this->_app_name . '.infusionsoft.com/api/xmlrpc' );

        $headers = array(
            "Content-Type" =>  "text/xml",
            "Accept-Charset" => "UTF-8,ISO-8859-1,US-ASCII",
        );

        $res = wp_remote_post($url, array(
            'sslverify'  => false,
            "headers" => $headers,
            "body" => $query_str
        ));

        $code = wp_remote_retrieve_response_code( $res );
        $message = wp_remote_retrieve_response_message( $res );
        $err = new WP_Error();

        if( $code < 204 ){
            $xml = simplexml_load_string( wp_remote_retrieve_body( $res ), "Opt_In_Infusionsoft_XML_Res" );
            if( empty( $xml ) ){
                $err->add("Invalid_app_name", __("Invalid app name, please check app name and try again", Opt_In::TEXT_DOMAIN) );
                return $err;
            }

            if( $xml->is_faulty() )
                return $xml->get_fault();

            return $xml;
        }

        $err->add( $code, $message );
        return $err;
    }
}

class Opt_In_Infusionsoft_XML_Res extends  SimpleXMLElement{

    /**
     * Returns value from xml like the template
     *  <methodResponse>
            <params>
                 <param>
                    <value><i4>contactIDNumber</i4></value>
                </param>
            </params>
        </methodResponse>
     *
     * @return mixed
     */
    function get_value(){
        return reset( $this->params->param->value );
    }

    /**
     * Retrieves tag list from the query result
     *
     * @return array
     */
    function get_tags_list(){
        $lists = array();

        for( $i = 0; $i < count( $this->get_value()->data->value ); $i++ ){
            $list = $this->get_value()->data->value[$i];
            $lists[ $i ]["label"] = (string) $list->struct->member[0]->value;
            $lists[ $i ]["value"] = (int) reset( $list->struct->member[1]->value );
        }

        return $lists;
    }

    /**
     * Checks if responsive is faulty
     *
     * @return bool
     */
    function is_faulty(){
        return isset( $this->fault );
    }

    /**
     * Returns bool false in case response is not faulty or a WP_Error with the fault code and message
     *
     * @return bool|WP_Error
     */
    function get_fault(){
        if( !$this->is_faulty() ) return false;

        $err = new WP_Error();
        $err->add( (int) $this->fault->value->struct->member[0]->value, (string) $this->fault->value->struct->member[1]->value  );
        return $err;
    }
}