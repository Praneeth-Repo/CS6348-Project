<?php
// logActivity.php
function logActivity($activity) {
    $logFile = '../logs/activity.log'; // Path to log file
    $date = date('Y-m-d H:i:s');
    file_put_contents($logFile, "$date - $activity\n", FILE_APPEND);
}

function logSuspiciousActivity($activity) {
    $logFile = '../logs/suspicious.log'; // Path to suspicious activity log
    $date = date('Y-m-d H:i:s');
    file_put_contents($logFile, "$date - Suspicious Activity: $activity\n", FILE_APPEND);
}
?>
