<?php
// api/logout.php

// The config/db_connect.php file starts the session, which is required
// before we can destroy it.
require_once '../config/db_connect.php';

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

// Set the response header to JSON and send a confirmation message.
header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'You have been logged out successfully.']);

?>