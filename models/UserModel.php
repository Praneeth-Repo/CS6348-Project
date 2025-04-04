<?php
// UserModel.php
require_once('../config/db_config.php');

class UserModel {

    public function register($username, $password) {
        global $pdo;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    public function login($username, $password) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true; // Successful login
        }
        return false; // Invalid credentials
    }
}
?>
