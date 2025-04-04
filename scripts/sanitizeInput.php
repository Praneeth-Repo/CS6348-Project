<?php
// sanitizeInput.php
function sanitizeInput($data) {
    $data = trim($data); // Remove extra spaces
    $data = stripslashes($data); // Remove backslashes
    $data = htmlspecialchars($data); // Convert special characters to HTML entities
    return $data;
}
?>
