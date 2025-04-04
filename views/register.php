<?php
// register.php
require_once('../controllers/UserController.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $userController = new UserController();
    
    if ($userController->register($username, $password)) {
        echo "Registration successful!";
    } else {
        echo "Registration failed!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
