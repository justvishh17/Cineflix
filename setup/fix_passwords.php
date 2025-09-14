<?php
/**
 * Password Hash Fix Script for Cineflix
 * This script generates correct password hashes and updates the database
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Cineflix Password Hash Fix</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; margin: 10px 0; }
        .error { color: #dc3545; margin: 10px 0; }
        .info { color: #007bff; margin: 10px 0; }
        .step { margin: 15px 0; padding: 10px; border-left: 4px solid #007bff; background: #f8f9fa; }
        .credential { background: #e9ecef; padding: 10px; margin: 5px 0; border-radius: 5px; font-family: monospace; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔐 Cineflix Password Hash Fix</h1>";

try {
    require_once '../config/db_connect.php';
    echo "<div class='success'>✅ Connected to database successfully!</div>";

    // Define the users and their passwords
    $users = [
        ['username' => 'admin', 'email' => 'admin@cineflix.com', 'password' => 'admin123', 'role' => 'super_admin', 'subscription' => 'Diamond+'],
        ['username' => 'testuser', 'email' => 'test@example.com', 'password' => 'test123', 'role' => 'user', 'subscription' => 'None'],
        ['username' => 'subscriber', 'email' => 'sub@example.com', 'password' => 'test123', 'role' => 'admin', 'subscription' => 'Diamond']
    ];

    echo "<div class='step'><strong>Step 1:</strong> Generating new password hashes...</div>";

    foreach ($users as &$user) {
        $user['hash'] = password_hash($user['password'], PASSWORD_DEFAULT);
        echo "<div class='info'>Generated hash for '{$user['username']}' (password: {$user['password']})</div>";
    }

    echo "<div class='step'><strong>Step 2:</strong> Updating database with correct hashes...</div>";

    // Clear existing users to avoid conflicts
    $conn->query("DELETE FROM users WHERE id IN (1, 2, 3)");
    echo "<div class='info'>🗑️ Cleared existing default users</div>";

    // Insert users with correct hashes
    foreach ($users as $user) {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, subscription, profile_pic_url) VALUES (?, ?, ?, ?, ?, 'https://i.pravatar.cc/150')");
        $stmt->bind_param("sssss", $user['username'], $user['email'], $user['hash'], $user['role'], $user['subscription']);
        
        if ($stmt->execute()) {
            echo "<div class='success'>✅ Updated user: {$user['username']}</div>";
        } else {
            echo "<div class='error'>❌ Failed to update user: {$user['username']} - " . $stmt->error . "</div>";
        }
        $stmt->close();
    }

    echo "<div class='step'><strong>Step 3:</strong> Verifying password hashes...</div>";

    // Test each password against its hash
    foreach ($users as $user) {
        $verified = password_verify($user['password'], $user['hash']);
        if ($verified) {
            echo "<div class='success'>✅ Password verification successful for: {$user['username']}</div>";
        } else {
            echo "<div class='error'>❌ Password verification failed for: {$user['username']}</div>";
        }
    }

    echo "<div class='step' style='border-color: #28a745; background: #d4edda;'>
            <h3 style='color: #155724; margin: 0;'>🎉 Password Hashes Fixed Successfully!</h3>
            <p style='margin: 10px 0 0 0; color: #155724;'>
                All user passwords have been updated with correct hashes. You can now login with:
            </p>
          </div>";

    echo "<h3>📋 Updated Login Credentials:</h3>";
    
    foreach ($users as $user) {
        echo "<div class='credential'>";
        echo "<strong>Username:</strong> {$user['username']} | <strong>Email:</strong> {$user['email']} | <strong>Password:</strong> {$user['password']}<br>";
        echo "<small>Role: {$user['role']} | Subscription: {$user['subscription']}</small>";
        echo "</div>";
    }

    echo "<div class='info' style='margin-top: 20px;'>
            <strong>Next Steps:</strong><br>
            1. Go to <a href='../index.php' target='_blank'>Cineflix Login Page</a><br>
            2. Try logging in with any of the above credentials<br>
            3. You can use either the username or email for login
          </div>";

} catch (Exception $e) {
    echo "<div class='error'>❌ <strong>Error:</strong> " . $e->getMessage() . "</div>";
    echo "<div class='info'>
            <strong>Troubleshooting:</strong><br>
            1. Make sure XAMPP MySQL is running<br>
            2. Run the database initialization script first<br>
            3. Check database connection settings
          </div>";
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}

echo "    </div>
</body>
</html>";
?>