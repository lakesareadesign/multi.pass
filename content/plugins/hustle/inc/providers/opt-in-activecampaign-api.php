<?php
/**
 * ActiveCampaign API implementation
 *
 * Class Opt_In_Activecampaign_Api
 */
class Opt_In_Activecampaign_Api
{

    private $_url;
    private $_key;

    function __construct( $url, $api_key ){
        $this->_url = trailingslashit( $url ) . 'admin/api.php';
        $this->_key = $api_key;
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
        $url = $this->_url;

        $apidata = array(
            'api_action' => $action,
            'api_key' => $this->_key,
            'api_output' => 'serialize',
        );

        $url = add_query_arg( $apidata, $url );

        $request = curl_init($url); // initiate curl object
        curl_setopt($request, CURLOPT_HEADER, false); // set to 0 to eliminate header info from response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true); // Returns response data instead of TRUE(1)
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);


        if( array() !== $args ){
            if( "POST" === $verb ){
                curl_setopt($request, CURLOPT_POSTFIELDS, http_build_query( array_merge( $apidata, $args ) ) );
                curl_setopt($request, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/x-www-form-urlencoded'
                ));
            }else{
                $url = add_query_arg($args, $url);
                curl_setopt($request, CURLOPT_URL, $url);
            }
        }

        $response = (string)curl_exec($request); //execute curl fetch and store results in $response

        curl_close($request);

        return unserialize($response);

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
     * Retrieves lists as array of objects
     *
     * @return array|WP_Error
     */
    public function get_lists(){
        $res = $this->_get( "list_list", array(
            'ids' => 'all',
            'global_fields' => 0
        ) );

        if( is_wp_error( $res ) )
            return $res;

        //$res = $res;
        $res2 = array();
        foreach ($res as $key => $value) {
            if( is_numeric( $key ) ) {
                array_push($res2,$value);
            }
        }

        return $res2;
    }

    /**
     * Add new contact
     *
     * @param $data
     * @return array|mixed|object|WP_Error
     */
    public function subscribe( $list, array $data ){

        if ( (int) $list > 0 ) {
            $data['p'] = array( $list => $list );
            $data['status'] = array( $list => 1 );
            $res = $this->_post( 'contact_sync', $data );
        } else {
            $res = $this->_post( 'contact_add', $data );
        }

        return empty( $res ) ? __("Successful subscription", Opt_In::TEXT_DOMAIN) : $res;
    }

}