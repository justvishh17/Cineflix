<?php
/**
 * Setup Verification Script for Cineflix
 * This script checks if the database and all tables are properly set up
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Cineflix Setup Verification</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; margin: 10px 0; }
        .error { color: #dc3545; margin: 10px 0; }
        .warning { color: #ffc107; margin: 10px 0; }
        .info { color: #007bff; margin: 10px 0; }
        .check-item { padding: 15px; margin: 10px 0; border-left: 4px solid #ddd; background: #f8f9fa; }
        .check-item.pass { border-color: #28a745; background: #d4edda; }
        .check-item.fail { border-color: #dc3545; background: #f8d7da; }
        .check-item.warn { border-color: #ffc107; background: #fff3cd; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #f8f9fa; }
        .status-ok { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔍 Cineflix Setup Verification</h1>";

$checks = [];
$overallStatus = true;

// Test 1: Database Connection
echo "<h2>📡 Database Connection Tests</h2>";

try {
    require_once 'db_connect.php';
    echo "<div class='check-item pass'>✅ <strong>Database Connection:</strong> Successfully connected to MySQL database 'cineflix'</div>";
    $checks['db_connection'] = true;
} catch (Exception $e) {
    echo "<div class='check-item fail'>❌ <strong>Database Connection:</strong> Failed to connect - " . $e->getMessage() . "</div>";
    $checks['db_connection'] = false;
    $overallStatus = false;
}

if ($checks['db_connection']) {
    // Test 2: Check if all required tables exist
    echo "<h2>📋 Table Structure Tests</h2>";
    
    $requiredTables = [
        'users' => 'User accounts and authentication',
        'media' => 'Movies and TV shows data',
        'likes' => 'User likes/ratings for media',
        'watchlist' => 'User\'s saved watchlist',
        'watch_history' => 'User viewing history',
        'subscriptions' => 'Available subscription plans',
        'plans' => 'Subscription plans (alias table)'
    ];
    
    $existingTables = [];
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_array()) {
        $existingTables[] = $row[0];
    }
    
    foreach ($requiredTables as $table => $description) {
        if (in_array($table, $existingTables)) {
            // Check table structure
            $result = $conn->query("DESCRIBE $table");
            $columnCount = $result->num_rows;
            echo "<div class='check-item pass'>✅ <strong>Table '$table':</strong> Exists with $columnCount columns - $description</div>";
            $checks["table_$table"] = true;
        } else {
            echo "<div class='check-item fail'>❌ <strong>Table '$table':</strong> Missing - $description</div>";
            $checks["table_$table"] = false;
            $overallStatus = false;
        }
    }
    
    // Test 3: Check sample data
    echo "<h2>📊 Data Verification Tests</h2>";
    
    // Check users
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $userCount = $result->fetch_assoc()['count'];
    if ($userCount > 0) {
        echo "<div class='check-item pass'>✅ <strong>Users Data:</strong> Found $userCount user(s) in database</div>";
        
        // Check for admin user
        $result = $conn->query("SELECT username, email, role FROM users WHERE role IN ('admin', 'super_admin') LIMIT 1");
        if ($result && $result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            echo "<div class='info'>👤 Admin user found: {$admin['username']} ({$admin['email']})</div>";
        }
    } else {
        echo "<div class='check-item warn'>⚠️ <strong>Users Data:</strong> No users found. You may need to run the initialization script.</div>";
    }
    
    // Check media
    $result = $conn->query("SELECT COUNT(*) as count FROM media");
    $mediaCount = $result->fetch_assoc()['count'];
    if ($mediaCount > 0) {
        echo "<div class='check-item pass'>✅ <strong>Media Data:</strong> Found $mediaCount media item(s) in database</div>";
    } else {
        echo "<div class='check-item warn'>⚠️ <strong>Media Data:</strong> No media found. You may need to import sample data.</div>";
    }
    
    // Check subscriptions
    $result = $conn->query("SELECT COUNT(*) as count FROM subscriptions");
    $subCount = $result->fetch_assoc()['count'];
    if ($subCount > 0) {
        echo "<div class='check-item pass'>✅ <strong>Subscription Plans:</strong> Found $subCount subscription plan(s)</div>";
    } else {
        echo "<div class='check-item warn'>⚠️ <strong>Subscription Plans:</strong> No subscription plans found.</div>";
    }
    
    // Test 4: API Endpoint Tests
    echo "<h2>🔗 API Endpoint Tests</h2>";
    
    $apiFiles = [
        'login.php' => 'User authentication',
        'signup.php' => 'User registration',
        'get_user_dashboard.php' => 'User dashboard data',
        'get_wishlist.php' => 'User watchlist',
        'add_to_wishlist.php' => 'Add to watchlist',
        'remove_from_wishlist.php' => 'Remove from watchlist',
        'add_to_history.php' => 'Add to watch history',
        'subscribe.php' => 'Subscription management',
        'get_most_liked.php' => 'Popular content'
    ];
    
    foreach ($apiFiles as $file => $description) {
        $filePath = __DIR__ . "/api/$file";
        if (file_exists($filePath)) {
            echo "<div class='check-item pass'>✅ <strong>API: $file</strong> - $description</div>";
        } else {
            echo "<div class='check-item fail'>❌ <strong>API: $file</strong> - Missing file for $description</div>";
            $overallStatus = false;
        }
    }
    
    // Test 5: Configuration Tests
    echo "<h2>⚙️ Configuration Tests</h2>";
    
    // Check PHP version
    $phpVersion = phpversion();
    if (version_compare($phpVersion, '7.4', '>=')) {
        echo "<div class='check-item pass'>✅ <strong>PHP Version:</strong> $phpVersion (Compatible)</div>";
    } else {
        echo "<div class='check-item warn'>⚠️ <strong>PHP Version:</strong> $phpVersion (Recommended: 7.4+)</div>";
    }
    
    // Check required PHP extensions
    $requiredExtensions = ['mysqli', 'json', 'session'];
    foreach ($requiredExtensions as $ext) {
        if (extension_loaded($ext)) {
            echo "<div class='check-item pass'>✅ <strong>PHP Extension:</strong> $ext loaded</div>";
        } else {
            echo "<div class='check-item fail'>❌ <strong>PHP Extension:</strong> $ext missing</div>";
            $overallStatus = false;
        }
    }
    
    // Check file permissions
    $writableDirs = ['./'];
    foreach ($writableDirs as $dir) {
        if (is_writable($dir)) {
            echo "<div class='check-item pass'>✅ <strong>File Permissions:</strong> Directory '$dir' is writable</div>";
        } else {
            echo "<div class='check-item warn'>⚠️ <strong>File Permissions:</strong> Directory '$dir' may not be writable</div>";
        }
    }
    
    // Test 6: Show database summary
    echo "<h2>📈 Database Summary</h2>";
    echo "<table>";
    echo "<tr><th>Table</th><th>Records</th><th>Status</th></tr>";
    
    foreach (array_keys($requiredTables) as $table) {
        if (in_array($table, $existingTables)) {
            $result = $conn->query("SELECT COUNT(*) as count FROM $table");
            $count = $result->fetch_assoc()['count'];
            $status = $count > 0 ? "<span class='status-ok'>✅ Has Data</span>" : "<span class='status-error'>⚠️ Empty</span>";
            echo "<tr><td>$table</td><td>$count</td><td>$status</td></tr>";
        } else {
            echo "<tr><td>$table</td><td>-</td><td><span class='status-error'>❌ Missing</span></td></tr>";
        }
    }
    echo "</table>";
    
    $conn->close();
}

// Final Status
echo "<div style='margin-top: 30px; padding: 20px; border-radius: 8px; " . 
     ($overallStatus ? "background: #d4edda; border: 2px solid #28a745;" : "background: #f8d7da; border: 2px solid #dc3545;") . "'>";

if ($overallStatus) {
    echo "<h3 style='color: #155724; margin: 0;'>🎉 Setup Verification Passed!</h3>";
    echo "<p style='color: #155724; margin: 10px 0 0 0;'>Your Cineflix application is properly configured and ready to use.</p>";
    echo "<p style='margin: 15px 0 0 0;'>";
    echo "<a href='index.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🚀 Launch Cineflix</a>";
    echo "<a href='init_db.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔄 Re-initialize Database</a>";
    echo "</p>";
} else {
    echo "<h3 style='color: #721c24; margin: 0;'>⚠️ Setup Issues Found</h3>";
    echo "<p style='color: #721c24; margin: 10px 0 0 0;'>Please fix the issues above before using the application.</p>";
    echo "<p style='margin: 15px 0 0 0;'>";
    echo "<a href='init_db.php' style='background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🔧 Initialize Database</a>";
    echo "<a href='check_setup.php' style='background: #ffc107; color: black; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔍 Recheck Setup</a>";
    echo "</p>";
}

echo "</div>";

echo "    </div>
</body>
</html>";
?>