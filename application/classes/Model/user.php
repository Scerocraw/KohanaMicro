<?php

class Model_User extends ORM {

    /**
     * Rules
     * @var type 
     */
    protected $_rules = array(
        'id' => array(
            'max_length' => 11,
        ),
        'username' => array(
            'max_length' => 50,
        ),
        'email' => array(
            'max_length' => 250,
        ), 
       'password' => array(
            'max_length' => 100,
        ),
        'firstLogin' => array(
            'max_length' => 0,
        ),
        'lastLogin' => array(
            'max_length' => 0,
        ),
        'isAdmin' => array(
            'max_length' => 0,
        )
    );

    /**
     * Register function
     * @param type $postData
     * @return boolean
     */
    public static function register($postData) {
        // Can not register, if something isnt valid
        if (!isset($postData['username']) || empty($postData['username']) || !isset($postData['eMail']) || empty($postData['eMail']) || !filter_var($postData['eMail'], FILTER_VALIDATE_EMAIL) || !isset($postData['password']) || empty($postData['password']) || !isset($postData['passwordRepeat']) || empty($postData['passwordRepeat']) || $postData['password'] !== $postData['passwordRepeat'] || !isset($postData['agb'])) {
            return FALSE;
        }

        // Check if something already exists
        if (!self::alreadyExists('username', $postData['username']) && !self::alreadyExists('email', $postData['eMail'])) {
            // Get the userModel
            $userModel = ORM::factory('user');

            // Set properties
            $userModel->username = htmlentities($postData['username']);
            $userModel->email = htmlentities($postData['eMail']);
            $userModel->password = self::hashPassword(htmlentities($postData['password']));

            // Save
            $userModel->save();

            // Relocate
            header("Location: /");
        }

        // Return FALSE
        return FALSE;
    }

    /**
     * Login function
     * @param type $postData
     */
    public static function login($postData) {
        // Check if postData is valud
        if (isset($postData['usernameLogin']) && !empty($postData['usernameLogin']) && isset($postData['passwordLogin']) && !empty($postData['passwordLogin'])) {

            // Get userModel
            $userModel = ORM::factory('user');

            // Check if the entered username is a email
            if (filter_var($postData['usernameLogin'], FILTER_VALIDATE_EMAIL)) {
                $userModel->where('email', '=', htmlentities($postData['usernameLogin']))->find();
            } else {
                $userModel->where('username', '=', htmlentities($postData['usernameLogin']))->find();
            }

            // Check if we found something
            if ($userModel->id) {
                if (password_verify(htmlentities($postData['passwordLogin']), $userModel->password)) {
                    // Get the session
                    $session = Session::instance();
                    
                    // Get API Token
                    $apiTokenModel = ORM::factory('apitoken');
                    
                    // Generate a apiToken
                    $session->set('apiToken', $apiTokenModel::generateToken($userModel->id));

                    // Update session
                    $session->set('username', $userModel->username);
                    $session->set('userID', $userModel->id);
                    $session->set('isAdmin', $userModel->isAdmin);

                    // Check if this is the first login
                    if (!isset($userModel->firstLogin) || $userModel->firstLogin == '0000-00-00 00:00:00') {
                        $userModel->id = $userModel->id;
                        $userModel->firstLogin = date('Y-m-d H:i:s');
                    }

                    // Last login update
                    $userModel->lastLogin = date('Y-m-d H:i:s');

                    // Refresh
                    $userModel->save();

                    // Relocate
                    header("Location: /");
                } else {
                    var_dump("Password missmatch");
                }
            }
        }
    }

    /**
     * Hash password
     * @param type $password
     */
    protected static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, array('costs' => 12));
    }

    /**
     * Return TRUE if the value already exists
     * @param type $column
     * @param type $value
     * @return type
     */
    public static function alreadyExists($column, $value) {
        // Check if the value exists inside user
        $userNeedle = ORM::factory('user')->where($column, '=', htmlentities($value))->find();

        // Return true or false
        return ($userNeedle->id) ? TRUE : FALSE;
    }

}
