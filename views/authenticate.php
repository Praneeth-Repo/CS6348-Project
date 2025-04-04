<?php
session_start();
require_once '../config/db_config.php';

// Capture user input
$username = $_POST['username'];
$password = $_POST['password'];
$ip_address = $_SERVER['REMOTE_ADDR'];

// Check credentials securely using PDO with prepared statements
$query = "SELECT id, username, password, role FROM users WHERE username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Log successful login
    $log_stmt = $pdo->prepare("INSERT INTO logs (user_id, action, ip_address) VALUES (:user_id, 'Successful Login', :ip)");
    $log_stmt->bindParam(':user_id', $user['id']);
    $log_stmt->bindParam(':ip', $ip_address);
    $log_stmt->execute();

    header("Location: ../views/dashboard.php");
    exit();
} else {
    // Log failed login
    $log_stmt = $pdo->prepare("INSERT INTO logs (user_id, action, ip_address) VALUES (NULL, 'Failed Login Attempt', :ip)");
    $log_stmt->bindParam(':ip', $ip_address);
    $log_stmt->execute();

    $_SESSION['error'] = "Invalid username or password.";
    header("Location: ../views/login.php");
    exit();
}
?>
