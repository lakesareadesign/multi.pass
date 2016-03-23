<?php

/**
 * Utility class that provides various static helper methods to type-safely obtain values by keys from $_REQUEST.
 *
 * @abstract to deny instantiation
 */
abstract class FarReaches_Request {

    private function __construct() {
        // Private constructor to prohibit instantiation
    }

    /**
     * Get value by key or default.
     *
     * @static
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed value by its key. If key is not present in array then $default_value
     */
    public static function get($param_name, $default_value = null) {
        return FarReaches_Params::def($_REQUEST, $param_name, $default_value);
    }
    
    public static function get_all() {
    	return $_REQUEST;
    }

    /**
     * Return integer value by key or default.
     *
     * @static
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed integer value by its key. If key is not present in array then $default_value
     */
    public static function int($param_name, $default_value = null) {
        return FarReaches_Params::int($_REQUEST, $param_name, $default_value);
    }

    /**
     * Return positive integer value by key or default.
     *
     * @static
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed integer value by its key. If key is not present in array then $default_value
     */
    public static function abs_int($param_name, $default_value = null) {
        return FarReaches_Params::abs_int($_REQUEST, $param_name, $default_value);
    }

    /**
     * Return float value by key or default.
     *
     * @static
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed float value by its key. If key is not present in array then $default_value
     */
    public static function float($param_name, $default_value = null) {
        return FarReaches_Params::float($_REQUEST, $param_name, $default_value);
    }

    /**
     * Return positive float value by key or default.
     *
     * @static
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed positive float value by its key. If key is not present in array then $default_value
     */
    public static function abs_float($param_name, $default_value = null) {
        return FarReaches_Params::abs_float($_REQUEST, $param_name, $default_value);
    }

    /**
     * Get boolean value by key or default.
     *
     * @static
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed boolean value by its key. If key is not present in array then $default_value
     */
    public static function boolean($param_name, $default_value = false) {
        return FarReaches_Params::boolean($_REQUEST, $param_name, $default_value);
    }

    /**
     * Get string value by key or default.
     *
     * @static
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed string value by its key. If key is not present in array then $default_value
     */
    public static function string($param_name, $default_value = '') {
        return FarReaches_Params::string($_REQUEST, $param_name, $default_value);
    }

    /**
     * Fail-fast method that returns value by key from $_REQUEST.
     * If key is not present function throws exception.
     *
     * @static
     * @param string $param_name array key
     * @param string $message exception message
     * @return mixed numeric value
     * @throws InvalidArgumentException
     */
    public static function get_or_fail($param_name, $message = null) {
        if (is_null($message)) {
            $message = sprintf("\$_REQUEST['%s'] value is required", $param_name);
        }
        return FarReaches_Params::get_or_fail($_REQUEST, $param_name, $message);
    }

    /**
     * Fail-fast method that returns numeric value by key from $_REQUEST.
     * If key is not present or value is not numeric function throws exception.
     *
     * @static
     * @param string $param_name array key
     * @param string $message exception message
     * @return mixed numeric value
     * @throws InvalidArgumentException
     */
    public static function numeric_or_fail($param_name, $message = null) {
        if (is_null($message)) {
            $message = sprintf("\$_REQUEST['%s'] value is not numeric or not set", $param_name);
        }
        return FarReaches_Params::numeric_or_fail($_REQUEST, $param_name, $message);
    }

}
