<?php

/**
 * TODO: all internal errors should be handled by method on farreaches-error-management.
 *
 * This class should be restricted to user errors.
 *
 * Utility class containing static methods to validate conditions. It is primarily useful to validate methods arguments
 *
 * TODO: Currently, FarReaches_Validate is confusingly used to check for both bad user input and internal errors.
 *
 * For example:
 * <code>
 * public function persist_page_alias($alias) {
 *     // If alias is blank then FarReaches_ValidationException will be thrown
 *     FarReaches_Validate::not_blank($alias, "Page alias has to contain alphanumeric characters");
 *     $db->persist($alias);
 * }
 * </code>
 * A generic validation methods could also come in handy:
 *
 * <code>
 * FarReaches_Validate::true($boolean_result, "Something is very false, should has been true");
 * FarReaches_Validate::false($boolean_result, "Something is very true, should has been false");
 * </code>
 *
 * It could be used for such assertion as well:
 *
 * <code>
 * FarReaches_Validate::should_never_reach_here(); // Useful in switches
 * </code>
 *
 */
abstract class FarReaches_Validate {

    /**
     * Private constructor to deny instantiation
     */
    private function __construct() {
    }

    /**
     * Validate that generic condition is true.
     *
     * @static
     * @param boolean $subject
     * @param string $message REQUIRED user-provided message - otherwise a useless message is displayed (TODO allow for a varargs message)
     * @return bool $subject to allow inline usage of the method
     */
    public static function true($subject, $message) {
        if (!$subject) {
            self::throwValidationException($message, 'Assertion failed: true');
        }
        return $subject;
    }

    /**
     * Validate that generic condition is false.
     *
     * @static
     * @param boolean $subject
     * @param string $message REQUIRED user-provided message - otherwise a useless message is displayed (TODO allow for a varargs message)
     * @return bool $subject to allow inline usage of the method
     */
    public static function false($subject, $message) {
        if ($subject) {
            self::throwValidationException($message, 'Assertion failed: false');
        }
        return $subject;
    }

    /**
     * Validate that subject is empty.
     *
     * @static
     * @param mixed $subject
     * @param string|null $message OPTIONAL user-provided message
     * @return mixed $subject to allow inline usage of the method
     */
    public static function is_empty($subject, $message = null) {
        if(!empty($subject)) {
            throw new FarReaches_ValidationException(is_null($message) ? 'Got non empty variable where empty was expected' : $message);
        }
        return $subject;
    }

    /**
     * Validate that subject is not empty.
     *
     * @static
     * @param mixed $subject
     * @param string|null $message OPTIONAL user-provided message
     * @return mixed $subject to allow inline usage of the method
     */
    public static function not_empty($subject, $message = null) {
        if(empty($subject)) {
            throw new FarReaches_ValidationException(is_null($message) ? 'Got empty variable where non empty was expected' : $message);
        }
        return $subject;
    }

    /**
     * Validate that subject is not blank.
     *
     * @static
     * @param string $subject
     * @param string|null $message OPTIONAL user-provided message
     * @return string $subject to allow inline usage of the method
     */
    public static function not_blank($subject, $message = null) {
        if(FarReaches_String_Util::is_blank($subject)) {
            throw new FarReaches_ValidationException(is_null($message) ? 'Got blank variable where non blank was expected' : $message);
        }
        return $subject;
    }

    /**
     * Validate that subject is null.
     *
     * @static
     * @param mixed $subject
     * @param string|null $message OPTIONAL user-provided message
     * @return mixed $subject to allow inline usage of the method
     */
    public static function is_null($subject, $message = null) {
        if(!is_null($subject)) {
            throw new FarReaches_ValidationException(is_null($message) ? 'Got non NULL variable where NULL was expected' : $message);
        }
        return $subject;
    }

    /**
     * Validate that subject is not null.
     *
     * @static
     * @param mixed $subject
     * @param string|null $message OPTIONAL user-provided message
     * @return mixed $subject to allow inline usage of the method
     */
    public static function not_null($subject, $message = null) {
        if(is_null($subject) ) {
            throw new FarReaches_ValidationException(is_null($message) ? 'Got unexpected NULL variable' : $message);
        }
        return $subject;
    }

    /**
     * Validate that subject is a callable.
     *
     * @static
     * @param callable $callable
     * @param string|null $message OPTIONAL user-provided message
     * @return callable $subject to allow inline usage of the method
     */
    public static function is_callable($callable, $message = null) {
        if ( !is_callable($callable)) {
            if ( is_array($callable)) {
                if ( is_null($callable[0])) {
                    $prefix = '(NULL::' . $callable[1] . ') : ';
                } else if ( is_string($callable[0])) {
                    $prefix = '('. $callable[0].'::' . $callable[1] . ') : ';
                } else {
                    $prefix = '('. get_class($callable[0]) .'::' . $callable[1] . ') : ';
                }
            } else if (is_null($callable)) {
                $prefix = "Null callable: ";
            } else {
                $prefix = $callable . ':' ;
            }
            // will throw exception
            throw new FarReaches_ValidationException( $prefix . (is_null($message) ?  'Variable is not callable' : $message));
        }
        return $callable;
    }

    /**
     * Validate that subject is null or callable.
     *
     * @static
     * @param callable $callable
     * @param string|null $message OPTIONAL user-provided message
     * @return callable|null $subject to allow inline usage of the method
     */
    public static function null_or_callable($callable, $message = null) {
        if (!is_null($callable)) {
            self::is_callable($callable, is_null($message) ? 'Variable is not callable' : $message);
        }
        return $callable;
    }

    /**
     * Validate that subject is numeric.
     *
     * @static
     * @param string|int $subject
     * @param string|null $message OPTIONAL user-provided message
     * @return string|int $subject to allow inline usage of the method
     */
    public static function is_numeric($subject, $message = null) {
        if (!is_numeric($subject)) {
            throw new FarReaches_ValidationException(is_null($message) ? 'Variable is not numeric: ' . $subject : $message);
        }
        return $subject;
    }

    /**
     * Validate that subject is numeric and positive.
     *
     * @static
     * @param string|int $subject
     * @param string|null $message OPTIONAL user-provided message
     * @return string|int $subject to allow inline usage of the method
     */
    public static function is_positive_numeric($subject, $message = null) {
        self::is_numeric($subject, $message);
        if(intval($subject) <= 0) {
            throw new FarReaches_ValidationException(is_null($message) ? 'Variable is not positive numeric' : $message);
        }
        return $subject;
    }

    /**
     * Validate that subject is array of numeric values.
     *
     * @static
     * @param array $subject
     * @param string|null $message OPTIONAL user-provided message
     * @return array $subject to allow inline usage of the method
     */
    public static function is_array_of_numeric($subject, $message = null) {
        self::true(is_array($subject), is_null($message) ? 'Variable is not an array' : $message);
        foreach ($subject as $value) {
            self::is_numeric($value, is_null($message) ? 'Array contains not a number' : $message);
        }
        return $subject;
    }

    /**
     * Validate that subject is array of string values.
     *
     * @static
     * @param array $subject
     * @param string|null $message OPTIONAL user-provided message
     * @return array $subject to allow inline usage of the method
     */
    public static function is_array_of_string($subject, $message = null) {
        self::true(is_array($subject), is_null($message) ? 'Variable is not an array' : $message);
        foreach ($subject as $value) {
            self::true(is_string($value), is_null($message) ? 'Array contains not a string' : $message);
        }
        return $subject;
    }

    /**
     * Checks if the $value can be found in the $array.
     *
     * @param array $array
     * @param unknown $value
     * @param string $message
     * @return the $value if it is present in the $array
     */
    public static function array_contains($array, $value, $message = null) {
        if(!is_array($array) || !in_array($value, $array)) {
            throw new FarReaches_ValidationException(is_null($message) ? 'Value is not in array' : $message);
        }
        return $value;
    }

    /**
     * Validate that array contains key.
     *
     * @static
     * @param array $subject array
     * @param mixed $key key
     * @param string|null $message OPTIONAL user-provided message
     * @return array $subject to allow inline usage of the method
     */
    public static function array_has_key($subject, $key, $message = null) {
        if(!is_array($subject) || !array_key_exists($key, $subject)) {
            throw new FarReaches_ValidationException(is_null($message) ? "Invalid array key: $key" : $message);
        }
        return $subject;
    }

    /**
     * Validate that string contains substring.
     *
     * @static
     * @param string $subject haystack
     * @param string $substring needle
     * @param string|null $message OPTIONAL user-provided message
     * @return array $subject to allow inline usage of the method
     */
    public static function string_contains($subject, $substring, $message = null) {
        if(strpos($subject, $substring) === false) {
            throw new FarReaches_ValidationException(is_null($message) ? sprintf('String "%s" does not contain substring "%s"', $subject, $substring) : $message);
        }
        return $subject;
    }

    /**
     * Validate that string not contains substring.
     *
     * @static
     * @param string $subject haystack
     * @param string $substring needle
     * @param string|null $message OPTIONAL user-provided message
     * @return array $subject to allow inline usage of the method
     */
    public static function string_not_contains($subject, $substring, $message = null) {
        if(strpos($subject, $substring) !== false) {
            throw new FarReaches_ValidationException(is_null($message) ? sprintf('String "%s" contains substring "%s"', $subject, $substring) : $message);
        }
        return $subject;
    }

    /**
     * Validate that object is a class.
     *
     * @static
     * @param object $subject object
     * @param string $class_name class
     * @param string|null $message OPTIONAL user-provided message
     * @return object $subject to allow inline usage of the method
     */
    public static function isA($subject, $class_name, $message = null) {
        if(!is_a($subject, $class_name)) {
            throw new FarReaches_ValidationException(is_null($message) ? sprintf('Variable is not an instance of %s', $class_name) : $message);
        }
        return $subject;
    }

    /**
     * Assertion method.
     *
     * @static
     * @param string|null $message
     */
    public static function should_never_reach_here($message = null) {
        throw new FarReaches_ValidationException(is_null($message) ? 'Program execution went wrong way' : $message);
    }

    /**
     * Stub for non-implemented methods.
     *
     * @static
     * @param string|null $message
     */
    public static function not_implemented($message = null) {
        throw new FarReaches_ValidationException(is_null($message) ? 'Function is not yet implemented' : $message);
    }

    private static function throwValidationException($message, $default) {
        if (is_null($message)) {
            $message = $default;
        }
        // TODO: use php trigger_error() so we can turn off minor issues on released code (where it would crash the plugin )
        // but leave on when doing development.
        // work with the error-management code
        throw new FarReaches_ValidationException($message);
    }
}

/**
 * Validation exception is thrown by every validation method
 */
class FarReaches_ValidationException extends Exception {
    public function __construct($message = null, $code = null) {
        parent::__construct($message, $code);
    }
}
