<?php
// index.php
require_once('../controllers/UserController.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $userController = new UserController();
    
    if ($userController->login($username, $password)) {
        header('Location: dashboard.php'); // Redirect to dashboard after successful login
    } else {
        echo "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="index.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
