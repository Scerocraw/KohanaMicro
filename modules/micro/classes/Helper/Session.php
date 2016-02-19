<?php

/**
 * 
 */
class Micro_Session {

    private static $_sessionInstance;

    /**
     * Instance the session
     * @return Session
     */
    public static function instance() {
        if(!self::$_sessionInstance) {
            self::$_sessionInstance = Session::instance();
        }
        return self::$_sessionInstance;
    }

    /**
     * Setter for the session
     * @param $key
     * @param $value
     */
    public static function set($key, $value) {
        // Check if session is given
        if(!self::$_sessionInstance) {
            // Instance if not
            self::instance();
        }
        self::$_sessionInstance->set($key, $value);
    }

    /**
     * Getter for the session
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        // Check if session is given
        if(!self::$_sessionInstance) {
            // Instance if not
            self::instance();
        }
        return self::$_sessionInstance->get($key);
    }
}
