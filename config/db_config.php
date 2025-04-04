<?php
// Database connection using PDO
$host = 'localhost';
$dbname = 'secure_db';
$username = 'root'; // Change if needed
$password = ''; // Change if you set a password in MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
