<?php
session_start();

// Database connection
$mysqli = new mysqli("localhost", "root", "", "cs6314");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get raw inputs (intentionally NOT sanitized)
$userid = isset($_POST['userid']) ? $_POST['userid'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// ❗ SQL Injection Vulnerable Query: quotes added back around '$userid' and '$password'
$query = "SELECT * FROM user WHERE userid = '$userid' AND password = '$password'";

// Optional debug
// echo $query; exit;

$result = $mysqli->query($query);

// If user found
if ($result && $result->num_rows >= 1) {
    $user = $result->fetch_assoc();

    if ($user['user_status'] !== 'active') {
        $_SESSION['error'] = "Account is " . $user['user_status'];
        header("Location: login.php");
        exit;
    }

    $_SESSION['userid'] = $user['userid'];
    $_SESSION['user_type'] = $user['user_type'];
    $_SESSION['session_id'] = session_id();

    $log_query = "INSERT INTO userlog (userid, session_id) VALUES ('{$user['userid']}', '{$_SESSION['session_id']}')";
    $mysqli->query($log_query);

    if ($user['user_type'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: course_management.php");
    }
    exit;
} else {
    $_SESSION['error'] = "Invalid credentials.";
    header("Location: login.php");
    exit;
}
?>
 