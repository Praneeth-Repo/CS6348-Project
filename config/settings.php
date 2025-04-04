<?php
// settings.php
define('SESSION_TIMEOUT', 1800); // Session timeout in seconds
define('LOGGING_LEVEL', 'DEBUG'); // Logging level (DEBUG, INFO, WARNING, ERROR)

function logMessage($message) {
    if (LOGGING_LEVEL == 'DEBUG') {
        error_log($message); // Log to PHP error log
    }
}
?>
