<?php
/**
 * Session Debug Script for Cineflix
 * This script shows the current session data and user state
 */

require_once '../config/db_connect.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Session Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .debug-box { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
        .error { border-left-color: #dc3545; background: #f8d7da; }
        .success { border-left-color: #28a745; background: #d4edda; }
        pre { background: #e9ecef; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🔍 Session Debug Information</h1>";

echo "<div class='debug-box'>";
echo "<h3>Session Status</h3>";
echo "<p><strong>Session Started:</strong> " . (session_status() === PHP_SESSION_ACTIVE ? "✅ Yes" : "❌ No") . "</p>";
echo "<p><strong>Session ID:</strong> " . session_id() . "</p>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Session Data</h3>";
if (!empty($_SESSION)) {
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";
} else {
    echo "<p>❌ No session data found</p>";
}
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>User Login State</h3>";
if (isset($_SESSION['user'])) {
    echo "<div class='success'>";
    echo "<p>✅ User is logged in</p>";
    echo "<p><strong>Username:</strong> " . $_SESSION['user']['username'] . "</p>";
    echo "<p><strong>Role:</strong> " . $_SESSION['user']['role'] . "</p>";
    echo "<p><strong>Subscription:</strong> " . $_SESSION['user']['subscription'] . "</p>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<p>❌ No user logged in</p>";
    echo "</div>";
}
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>JavaScript CurrentUser Value</h3>";
echo "<p>This is what gets passed to JavaScript:</p>";
echo "<pre>const currentUser = " . (isset($_SESSION['user']) ? json_encode($_SESSION['user']) : 'null') . ";</pre>";
echo "</div>";

echo "<div class='debug-box'>";
echo "<h3>Quick Actions</h3>";
echo "<p>";
echo "<a href='../index.php' style='background: #007bff; color: white; padding: 8px 15px; text-decoration: none; border-radius: 3px; margin-right: 10px;'>Go to Main Page</a>";
echo "<a href='test_login.php' style='background: #28a745; color: white; padding: 8px 15px; text-decoration: none; border-radius: 3px; margin-right: 10px;'>Test Login API</a>";
echo "<a href='javascript:location.reload()' style='background: #ffc107; color: black; padding: 8px 15px; text-decoration: none; border-radius: 3px;'>Refresh</a>";
echo "</p>";
echo "</div>";

echo "</body></html>";
?>