<?php

/**
 * 
 */
class Micro_RequestHandle {

    /**
     * Contains URI 
     * @var type 
     */
    private static $_uri = NULL;

    /**
     * Setter URI
     * @param type $uri
     */
    public static function setUri($uri) {
        self::$_uri = $uri;
    }

    /**
     * Getter URI
     * @return type
     */
    public static function getUri() {
        return self::$_uri;
    }

    /**
     * Contains URI params
     * @var type 
     */
    private static $_uriParams = NULL;

    /**
     * Setter URI params
     * @param type $uriParams
     */
    public static function setUriParams($uriParams) {
        self::$_uriParams = $uriParams;
    }

    /**
     * Getter URI params
     * @return type
     */
    public static function getUriParams() {
        return self::$_uriParams;
    }
    
    /**
     * Contains the bool for isAjax
     * @var type 
     */
    private static $_isAjax;

    /**
     * Setter isAjax
     * @param type Ajax
     */
    public static function setIsAjax($isAjax) {
        self::$_isAjax = $isAjax;
    }

    /**
     * Getter isAjax
     * @return type
     */
    public static function getIsAjax() {
        return self::$_isAjax;
    }

    /**
     * Contains the acutal protocol
     * @var type 
     */
    private static $_protocol;

    /**
     * Setter protocol
     * @param type $protocol
     */
    public static function setProtocol($protocol) {
        self::$_protocol = $protocol;
    }

    /**
     * Getter protocol
     * @return type
     */
    public static function getProtocol() {
        return self::$_protocol;
    }

    /**
     * Contains sanitized postData
     * @var type 
     */
    private static $_postData;

    /**
     * Setter postData
     * @param type $postData
     */
    public static function setPostData($postData) {
        self::$_postData = $postData;
    }

    /**
     * Getter postData
     * @return type
     */
    public static function getPostData() {
        return self::$_postData;
    }

    /**
     * Check if AJAX Request
     * @return boolean
     */
    protected static function checkIfAjax() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Returns HTTPS|HTTP
     * @return type
     */
    protected static function checkProtocol() {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "HTTPS" : "HTTP";
    }

    /**
     * Inits the RequestHandle
     * @param $requestObject
     * @return bool|void
     */
    public static function init($requestObject) {
        // Set the postData
        self::setPostData($requestObject->post());
        
        // Sanitize the URI
        $explodedURI = explode('/', $requestObject::detect_uri());;
        $sanitizedArrayURI = array();
        
        // Iterate the exploded stuff
        foreach($explodedURI as $part) {
            if(!empty($part)) {
                $sanitizedArrayURI[] = htmlentities($part);
            }
        }
        
        // Check if the first element is given
        if(isset($sanitizedArrayURI[0])) {
            // Set URI
            self::setUri(htmlentities($sanitizedArrayURI[0]));
        }
        
        // Check if there is anything else
        if(isset($sanitizedArrayURI[1])) {
            // Unset the first element (it is the uri part inside "_uri"
            unset($sanitizedArrayURI[0]);
            
            // Sanitize the array
            $sanitizedArrayURI = array_values($sanitizedArrayURI);
            
            // And set the uri params
            self::setUriParams($sanitizedArrayURI);
        }

        // Set protocol
        self::setProtocol(self::checkProtocol());

        // Set ajax bool
        self::setIsAjax(self::checkIfAjax());

        if (!self::getIsAjax()) {
            // Require HTTP layer
            require_once MODPATH . '/micro/classes/Helper/Http.php';

            // Require HTTP layer
            $controllerToCall = new Micro_Http;
        } else {
            // Require AJAX layer
            require_once MODPATH . '/micro/classes/Helper/Ajax.php';

            $controllerToCall = new Micro_Ajax;
        }
        
        // Call the layer
        return $controllerToCall::route(self::getUri(), self::getUriParams(), self::getPostData());
    }

}
