<?php
/**
 * Very low level interface / class to allow mocking out actual call to the wireserver
 * or logging.
 * @author patmoore
 *
 */
interface FarReaches_Http_Handler {
    const FULL_API_URI = 'full_api_uri';
    const HTTP_ARGS = 'http_args';
    const RESPONSE = 'response';

    /**
     * A http post is performed
     * @param unknown $full_api_uri
     * @param unknown $http_args
     */
    function http_post($full_api_uri, $http_args);
    /**
     * An http get is performed
     * @param unknown $full_api_uri
     * @param string $http_args
     */
    function http_get($full_api_uri, $http_args = null);
    /**
     * generate a unique RANDOM nonce for the plugin.
     * This randomly generated value is used on  wireserver callback step of secured api call.
     * Plugin then detects if user's meta contains callback data associated with this key.
     *
     */
    function nonce();
}