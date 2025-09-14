<?php
/**
 * Login API Test Script
 * This script tests the login functionality directly
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Login API Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-result { margin: 10px 0; padding: 10px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
    </style>
</head>
<body>
    <h1>🔍 Login API Test</h1>";

// Test credentials
$testCredentials = [
    ['username' => 'admin', 'password' => 'admin123'],
    ['username' => 'admin@cineflix.com', 'password' => 'admin123'],
    ['username' => 'testuser', 'password' => 'test123'],
    ['username' => 'test@example.com', 'password' => 'test123']
];

foreach ($testCredentials as $cred) {
    echo "<div class='info'><strong>Testing:</strong> Username/Email: {$cred['username']} | Password: {$cred['password']}</div>";
    
    // Simulate POST request to login API
    $postData = http_build_query($cred);
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $postData
        ]
    ]);
    
    $url = 'http://localhost/Cineflix/api/login.php';
    $result = @file_get_contents($url, false, $context);
    
    if ($result) {
        $response = json_decode($result, true);
        if ($response && $response['success']) {
            echo "<div class='test-result success'>✅ LOGIN SUCCESS: {$response['message']}</div>";
        } else {
            $message = $response['message'] ?? 'Unknown error';
            echo "<div class='test-result error'>❌ LOGIN FAILED: $message</div>";
        }
    } else {
        echo "<div class='test-result error'>❌ API REQUEST FAILED: Could not connect to login API</div>";
    }
    
    echo "<hr>";
}

echo "<h2>💡 Instructions:</h2>";
echo "<p>If you see ✅ LOGIN SUCCESS above, the credentials are working!</p>";
echo "<p>Go to <a href='../index.php' target='_blank'>Cineflix</a> and try logging in with the successful credentials.</p>";

echo "</body></html>";
?>