<?php

/**
 * Utility class containing static methods for working with strings.
 */
abstract class FarReaches_String_Util {

    /**
     * Private constructor to deny instantiation
     */
    private function __construct() {
    }

    /**
     * Check whether string is empty or contains only whitespace characters
     *
     * @static
     * @param string $string
     * @throws InvalidArgumentException
     * @return boolean
     */
    public static function is_blank($string) {
        if (empty($string) && $string !== '0') {
            // empty strings get sent by jquery serialization as an empty json object
            return true;
        }
        if (!is_string($string)) {
            throw new InvalidArgumentException('Required argument of type string');
        }
        return strlen(trim($string)) < 1;
    }

    /**
     * Check whether string is non empty and contains non-whitespace characters
     *
     * @static
     * @param string $string
     * @throws InvalidArgumentException
     * @return boolean
     */
    public static function not_blank($string) {
        return !self::is_blank($string);
    }

}
