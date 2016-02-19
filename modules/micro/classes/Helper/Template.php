<?php

class Micro_Template {

    /**
     * Contains the template variables
     * @var array
     */
    private static $_templateVariable = array();

    /**
     * Setter for the template variable container
     * @param $key
     * @param $value
     */
    public static function setTemplateVariable($key, $value) {
        // Check if key is given, also make sure, that value is given
        if(isset($key) && !empty($key) && isset($value) && !empty($value)) {
            // Set into template variable container
            self::$_templateVariable[$key] = $value;
        }
    }

    /**
     * Return a special element inside the template variable container
     * @param $key
     * @return bool
     */
    public static function getTemplateVariable($key) {
        // Return the template var
        return (isset(self::$_templateVariable[$key]) ? self::$_templateVariable[$key] : FALSE);
    }

    /**
     * Get all template variables
     * @return array
     */
    public static function getAllTemplateVariables() {
        return self::$_templateVariable;
    }

    /**
     * Flushes the templateVariable Container
     */
    public static function flush() {
        self::$_templateVariable = array();
    }
}