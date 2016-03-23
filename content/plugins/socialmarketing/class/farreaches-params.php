<?php

/**
 * Utility class that provides various static helper methods to obtain type-safe values from arrays by keys.
 * If you want to use it to retrieve HTTP request parameter values then consider specialized helper classes:
 *
 * $_GET - FarReaches_Get
 * $_POST - FarReaches_Post
 * $_REQUEST - FarReaches_Request
 */
abstract class FarReaches_Params {

    private function __construct() {
        // Private constructor to prohibit instantiation
    }

    /**
     * Get array value by key or default.
     *
     * @static
     * @param array $array array to get value from
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed value from array by its key. If key is not present in array then $default_value
     */
    public static function def($array, $param_name, $default_value = null) {
        if (self::key_exists($param_name, $array)) {
            return $array[$param_name];
        } else {
            return $default_value;
        }
    }
    /**
     * like def() but the parameter_names are a list of possible choices. The first key that has a value is returned (even if the value is null)
     * @param array $array
     * @param array $parameter_names
     * @param unknown_type $default_value
     */
    public static function def_first(array $array, array $parameter_names, $default_value = null) {
        foreach($parameter_names as $param_name) {
            if (self::key_exists($param_name, $array)) {
                return $array[$param_name];
            }
        }
        return $default_value;
    }

    /**
     * Return array integer value by key or default.
     *
     * @static
     * @param array $array array to get value from
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed integer value from array by its key. If key is not present in array then $default_value
     */
    public static function int($array, $param_name, $default_value = null) {
        if (self::key_exists($param_name, $array)) {
            return intval($array[$param_name]);
        } else {
            return $default_value;
        }
    }

    /**
     * Return positive integer array value by key or default.
     *
     * @static
     * @param array $array array to get value from
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed integer value from array by its key. If key is not present in array then $default_value
     */
    public static function abs_int($array, $param_name, $default_value = null) {
        if (self::key_exists($param_name, $array)) {
            return abs(intval($array[$param_name]));
        } else {
            return $default_value;
        }
    }

    /**
     * Return array float value by key or default.
     *
     * @static
     * @param array $array array to get value from
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed float value from array by its key. If key is not present in array then $default_value
     */
    public static function float($array, $param_name, $default_value = null) {
        if (self::key_exists($param_name, $array)) {
            return floatval($array[$param_name]);
        } else {
            return $default_value;
        }
    }

    /**
     * Return positive float array value by key or default.
     *
     * @static
     * @param array $array array to get value from
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed float value from array by its key. If key is not present in array then $default_value
     */
    public static function abs_float($array, $param_name, $default_value = null) {
        if (self::key_exists($param_name, $array)) {
            return abs(floatval($array[$param_name]));
        } else {
            return $default_value;
        }
    }

    /**
     * Get boolean array value by key or default.
     *
     * @static
     * @param array $array array to get value from
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed boolean value from array by its key. If key is not present in array then $default_value
     */
    public static function boolean($array, $param_name, $default_value = false) {
        if (self::key_exists($param_name, $array)) {
            $value = $array[$param_name];
            //See http://stackoverflow.com/a/15075609/272824
            //Unlike casting to (boolean) this method doesn't resolve
            //'false' string to true.
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        } else {
            return $default_value;
        }
    }

    /**
     * Get string array value by key or default.
     *
     * @static
     * @param array $array array to get value from
     * @param mixed $param_name array key
     * @param mixed $default_value OPTIONAL if specified will be returned if key is not present in array
     * @return mixed string value from array by its key. If key is not present in array then $default_value
     */
    public static function string($array, $param_name, $default_value = '') {
        if (self::key_exists($param_name, $array)) {
            return (string)$array[$param_name];
        } else {
            return $default_value;
        }
    }
    public static function string_if_not_blank($array, $param_name, $default_value = '') {
        if (self::key_exists($param_name, $array)) {
            $string = (string)$array[$param_name];
            if ( FarReaches_String_Util::not_blank($string)) {
                return $string;
            }
        }
        return $default_value;
    }

    /**
     * Fail-fast method that returns value by key from array.
     * If key is not present function throws exception.
     *
     * @static
     * @param array $array array to get value from
     * @param string $param_name array key
     * @param string $message exception message
     * @return mixed numeric value
     * @throws InvalidArgumentException
     */
    public static function get_or_fail(array $array, $param_name, $message = 'Value expected') {
        FarReaches_Validate::array_has_key($array, $param_name, $message);
        return $array[$param_name];
    }
    public static function get(array $array, $param_name) {
        if ( is_array($array) && array_key_exists($param_name, $array) ) {
            return $array[$param_name];
        } else {
            return null;
        }
    }

    /**
     * Fail-fast method that returns numeric value by key from array.
     * If key is not present or value is not numeric function throws exception.
     *
     * @static
     * @param array $array array to get value from
     * @param string $param_name array key
     * @param string $message exception message
     * @return mixed numeric value
     * @throws InvalidArgumentException
     */
    public static function numeric_or_fail($array, $param_name, $message = 'Numeric value expected') {
        $result = self::get_or_fail($array, $param_name, $message);
        FarReaches_Validate::is_numeric($result, $message);
        return $result;
    }

    /**
     * Handles null array case.
     * TODO: handle objects as well.
     *
     * parameter order matches array_key_exists($key, $array)
     *
     * @param unknown_type $param_name
     * @param unknown_type $array
     * @return boolean
     */
    public static function key_exists($param_name, $array) {
    	if (empty($array)) {
    		return false;
    	} else{
    		FarReaches_Validate::true(is_array($array), "Expected array or null as second parameter");
    		return array_key_exists($param_name, $array);
    	}
    }
}
