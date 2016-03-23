<?php

abstract class FarReaches_Base extends FarReaches_Util_Using {

    protected $farReaches_Communication;

    protected function __construct(FarReaches_Util $farReaches_Util, FarReaches_Communication $farReaches_Communication) {
        parent::__construct($farReaches_Util);
        $this->farReaches_Communication = $farReaches_Communication;
    }

    /**
     * return true if this blog has an account code with the farreaches server.
     * Account is not guaranteed to be valid. The server may decide to cancel an account at any moment.
     */
    protected function is_registered() {
        return $this->farReaches_Communication->is_registered();
    }

    protected function is_response_in_error($response) {
        return $this->farReaches_Communication->is_response_in_error($response);
    }

    protected function check_response_in_error($response, $message=null) {
        return $this->farReaches_Communication->check_response_in_error($response, $message);
    }

    // a signed api request to farreaches server.
    protected function api_call($api_call, $request = null, $user = null) {
        return $this->farReaches_Communication->api_call($api_call, $request, $user);
    }

    protected function initiate_secured_api_call($phase_two_api_call, array $saved_for_callback = array(), array $initial_call_parameters = null, $user = null, $topic = null) {
        return $this->farReaches_Communication->initiate_secured_api_call($phase_two_api_call, $saved_for_callback, $initial_call_parameters, $user, $topic);
    }

    protected function async_api_call($apiCall, $saved_for_callback, $user = null, $initial_call_parameters = array()) {
        return $this->farReaches_Communication->async_api_call($apiCall, $saved_for_callback, $user, $initial_call_parameters);
    }

    /**
     * @param string|FarReaches_Api_Call $api_call_key
     * @param unknown $value
     * @param unknown $expire_in_secs
     */
    protected function cache_results($api_call_key, $value, $expire_in_secs) {
        $this->farReaches_Communication->cache_results($api_call_key, $value, $expire_in_secs);
    }

    protected function get_api_call_definition($api_call_key) {
        return $this->farReaches_Communication->get_api_call_definition($api_call_key);
    }
}
