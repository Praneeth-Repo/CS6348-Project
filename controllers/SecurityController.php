<?php
// SecurityController.php
require_once('../scripts/sanitizeInput.php');
require_once('../scripts/logActivity.php');

class SecurityController {

    public function sanitizeUserInput($input) {
        return sanitizeInput($input);
    }

    public function logSuspiciousActivity($activity) {
        logActivity($activity);
    }
}
?>
