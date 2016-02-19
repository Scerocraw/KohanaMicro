<?php

defined('SYSPATH') or die('No direct script access.');
error_reporting(E_ALL & ~E_DEPRECATED);

/**
 *
 */
class Kohana_Micro extends Controller_Template {

    /**
     * Contains requestHandleObject
     * @var
     */
    protected static $_requestHandleObject;

    /**
     * Request Object
     * @var type 
     */
    private static $_requestObject;

    /**
     * Getter Request Object
     * @return type
     */
    public static function getRequestObject() {
        return self::$_requestObject;
    }

    /**
     * Setter Request Object
     * @param type $requestObject
     */
    public static function setRequestObject($requestObject) {
        self::$_requestObject = $requestObject;
    }
    
    /**
     * Contains the template
     * @var type 
     */
    private static $_template = 'welcome.tpl';
    
    /**
     * Setter template
     * @param type $template
     */
    public static function setTemplate($template) {
        self::$_template = $template;
    }
    
    /**
     * Getter template
     * @return type
     */
    public static function getTemplate() {
        return self::$_template;
    }

    /**
     * Response Object
     * @var type 
     */
    private static $_responseObject;

    /**
     * Getter Response Object
     * @return type
     */
    public static function getResponseObject() {
        return self::$_responseObject;
    }

    /**
     * Setter Response Object
     * @param type $responseObject
     */
    public static function setResponseObject($responseObject) {
        self::$_responseObject = $responseObject;
    }

    /**
     * Init function
     * @param $requestObject
     * @param $responseObject
     * @return string
     */
    public static function init($requestObject, $responseObject) {
        // Require request layer
        require_once MODPATH . '/micro/classes/Helper/RequestHandle.php';

        // Set request object
        self::setRequestObject($requestObject);

        // Set response object
        self::setResponseObject($responseObject);

        // Init the requestHandle
        $requestHandleObject = self::$_requestHandleObject = new Micro_RequestHandle();
        // Get the session
        $session = Session::instance();

        $requestHandleObject::init($requestObject);

        // Done
        return TRUE;
    }

}
