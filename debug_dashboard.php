<?php
// debug_dashboard.php - Simple test to check dashboard functionality
session_start();
require_once 'config/db_connect.php';

echo "<h2>Dashboard Debug Information</h2>";

// Check if user is logged in
if (isset($_SESSION['user'])) {
    echo "<p><strong>✅ User is logged in:</strong></p>";
    echo "<pre>" . print_r($_SESSION['user'], true) . "</pre>";
    
    // Test database connection
    $userId = $_SESSION['user']['id'];
    
    // Test user details query
    $stmt = $conn->prepare("SELECT username, email, subscription, profile_pic_url FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userDetails = $stmt->get_result()->fetch_assoc();
    
    echo "<p><strong>✅ User Details from DB:</strong></p>";
    echo "<pre>" . print_r($userDetails, true) . "</pre>";
    
    // Test watch history query
    $stmt = $conn->prepare("SELECT m.* FROM media m JOIN watch_history wh ON m.id = wh.media_id WHERE wh.user_id = ? ORDER BY wh.watched_at DESC LIMIT 12");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
    
    echo "<p><strong>✅ Watch History:</strong></p>";
    echo "<pre>" . print_r($history, true) . "</pre>";
    
} else {
    echo "<p><strong>❌ No user logged in</strong></p>";
    echo "<p>Current session data:</p>";
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";
}

// Test direct API call
echo "<hr><h3>Testing API Endpoint Directly:</h3>";
echo "<iframe src='api/get_user_dashboard.php' width='100%' height='300'></iframe>";
?>