<?php

include_once 'Admin.php';
include_once 'Customer.php';

class UserFactory { //Used In Login

    public function __construct() {
        // ... //
    }

    public static function build ($className = '') {

        if($className == '') {
            throw new Exception('Invalid User Type.');
        } else {
            // Assuming Class files are already loaded using autoload concept
            if(true) {
                return new $className();
            } else {
                throw new Exception('User type not found.');
            }
        }
    }
}

?>
