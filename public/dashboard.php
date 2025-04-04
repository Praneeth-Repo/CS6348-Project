<?php
// dashboard.php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php'); // Redirect to login if not logged in
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <p>Dashboard content goes here...</p>
</body>
</html>
