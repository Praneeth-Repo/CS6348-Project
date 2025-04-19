<?php
session_start();

// DB Connection
$mysqli = new mysqli("localhost", "root", "", "cs6314");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Sanitize inputs
$userid = isset($_POST['userid']) ? trim($_POST['userid']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Initialize login attempt counter
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = [];
}
if (!isset($_SESSION['login_attempts'][$userid])) {
    $_SESSION['login_attempts'][$userid] = 0;
}

// Fetch user
$stmt = $mysqli->prepare("SELECT * FROM user WHERE userid = ?");
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // If account is already revoked or inactive
    if ($user['user_status'] !== 'active') {
        $_SESSION['error'] = "Account is " . $user['user_status'];
        header("Location: login.php");
        exit;
    }

    // Hashed password match
    if (password_verify($password, $user['password'])) {
        // ✅ Successful login — reset attempts
        $_SESSION['userid'] = $user['userid'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['session_id'] = session_id();
        $_SESSION['login_attempts'][$userid] = 0;

        // Log the login
        $log_stmt = $mysqli->prepare("INSERT INTO userlog (userid, session_id) VALUES (?, ?)");
        $log_stmt->bind_param("ss", $_SESSION['userid'], $_SESSION['session_id']);
        $log_stmt->execute();

        // Redirect based on role
        if ($user['user_type'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: course_management.php");
        }
        exit;
    } else {
        // ❌ Incorrect password — track attempt
        $_SESSION['login_attempts'][$userid]++;

        if ($_SESSION['login_attempts'][$userid] >= 3) {
            // Revoke account after 3 failures
            $update_stmt = $mysqli->prepare("UPDATE user SET user_status = 'revoked' WHERE userid = ?");
            $update_stmt->bind_param("s", $userid);
            $update_stmt->execute();

            $_SESSION['error'] = "Account has been revoked after 3 failed login attempts.";
        } else {
            $_SESSION['error'] = "Invalid password. Attempt {$_SESSION['login_attempts'][$userid]} of 3.";
        }

        header("Location: login.php");
        exit;
    }
} else {
    $_SESSION['error'] = "User not found.";
    header("Location: login.php");
    exit;
}
?>
