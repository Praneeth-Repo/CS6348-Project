<?php
// UserController.php
require_once('../config/db_config.php');
require_once('../models/UserModel.php');

class UserController {

    public function register($username, $password) {
        $userModel = new UserModel();
        return $userModel->register($username, $password);
    }

    public function login($username, $password) {
        $userModel = new UserModel();
        return $userModel->login($username, $password);
    }
}
?>
