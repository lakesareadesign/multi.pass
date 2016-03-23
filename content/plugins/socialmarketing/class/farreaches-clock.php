<?php

/**
 * This class is used to have a possibility to mock time in tests
 */
class FarReaches_Clock {

    private static $time = null;

    public static function setTime($time) {
        self::$time = $time;
    }

    public static function time() {
        return is_null(self::$time) ? time() : self::$time;
    }

    public static function resetTime() {
        self::setTime(null);
    }

    public static function journey_into_the_future($seconds) {
        FarReaches_Validate::is_positive_numeric($seconds);
        self::$time += $seconds;
    }

}