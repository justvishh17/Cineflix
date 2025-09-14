<?php
/**
 * Configuration Checker for Cineflix
 * This script validates XAMPP setup and server configuration
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Cineflix Configuration Check</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        .info { color: #007bff; }
        .check-item { padding: 15px; margin: 10px 0; border-left: 4px solid #ddd; background: #f8f9fa; }
        .check-item.pass { border-color: #28a745; background: #d4edda; }
        .check-item.fail { border-color: #dc3545; background: #f8d7da; }
        .check-item.warn { border-color: #ffc107; background: #fff3cd; }
        .config-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .config-table th, .config-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .config-table th { background: #f8f9fa; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>⚙️ Cineflix Configuration Check</h1>";

$allGood = true;

// Check 1: XAMPP Environment
echo "<h2>🖥️ Server Environment</h2>";

// Check if running on localhost
$serverName = $_SERVER['SERVER_NAME'] ?? 'unknown';
if (in_array($serverName, ['localhost', '127.0.0.1', '::1'])) {
    echo "<div class='check-item pass'>✅ <strong>Server:</strong> Running on localhost ($serverName)</div>";
} else {
    echo "<div class='check-item warn'>⚠️ <strong>Server:</strong> Running on $serverName (Expected: localhost)</div>";
}

// Check web server
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';
if (stripos($serverSoftware, 'apache') !== false) {
    echo "<div class='check-item pass'>✅ <strong>Web Server:</strong> $serverSoftware</div>";
} else {
    echo "<div class='check-item warn'>⚠️ <strong>Web Server:</strong> $serverSoftware (Expected: Apache)</div>";
}

// Check PHP version and configuration
echo "<h2>🐘 PHP Configuration</h2>";

$phpVersion = phpversion();
if (version_compare($phpVersion, '7.4', '>=')) {
    echo "<div class='check-item pass'>✅ <strong>PHP Version:</strong> $phpVersion</div>";
} else {
    echo "<div class='check-item fail'>❌ <strong>PHP Version:</strong> $phpVersion (Minimum required: 7.4)</div>";
    $allGood = false;
}

// Check required PHP extensions
$requiredExtensions = [
    'mysqli' => 'MySQL database connectivity',
    'json' => 'JSON processing',
    'curl' => 'HTTP requests (optional)',
    'openssl' => 'Secure connections',
    'session' => 'Session management'
];

foreach ($requiredExtensions as $ext => $description) {
    if (extension_loaded($ext)) {
        echo "<div class='check-item pass'>✅ <strong>PHP Extension ($ext):</strong> $description</div>";
    } else {
        $severity = in_array($ext, ['mysqli', 'json', 'session']) ? 'fail' : 'warn';
        $icon = $severity === 'fail' ? '❌' : '⚠️';
        echo "<div class='check-item $severity'>$icon <strong>PHP Extension ($ext):</strong> Missing - $description</div>";
        if ($severity === 'fail') $allGood = false;
    }
}

// Check important PHP settings
echo "<h3>📋 PHP Settings</h3>";
echo "<table class='config-table'>";
echo "<tr><th>Setting</th><th>Current Value</th><th>Recommended</th><th>Status</th></tr>";

$phpSettings = [
    'max_execution_time' => ['min' => 30, 'recommended' => 60],
    'memory_limit' => ['min' => '128M', 'recommended' => '256M'],
    'upload_max_filesize' => ['min' => '2M', 'recommended' => '10M'],
    'post_max_size' => ['min' => '8M', 'recommended' => '20M'],
    'display_errors' => ['value' => '1', 'for_dev' => true]
];

foreach ($phpSettings as $setting => $config) {
    $currentValue = ini_get($setting);
    $status = '✅ OK';
    
    if (isset($config['min'])) {
        // For size settings, convert to bytes for comparison
        if (strpos($setting, 'memory') !== false || strpos($setting, 'size') !== false) {
            $currentBytes = return_bytes($currentValue);
            $minBytes = return_bytes($config['min']);
            if ($currentBytes < $minBytes) {
                $status = '⚠️ Low';
            }
        } else {
            // For numeric settings
            if (intval($currentValue) < intval($config['min'])) {
                $status = '⚠️ Low';
            }
        }
    }
    
    $recommended = $config['recommended'] ?? $config['value'] ?? 'System default';
    echo "<tr><td>$setting</td><td>$currentValue</td><td>$recommended</td><td>$status</td></tr>";
}

echo "</table>";

// Check 2: MySQL Connection
echo "<h2>🗄️ MySQL Database</h2>";

try {
    // Try to connect without selecting database first
    $testConn = new mysqli('localhost', 'root', '');
    if ($testConn->connect_error) {
        throw new Exception("MySQL connection failed: " . $testConn->connect_error);
    }
    echo "<div class='check-item pass'>✅ <strong>MySQL Server:</strong> Connection successful</div>";
    
    // Check MySQL version
    $mysqlVersion = $testConn->server_info;
    echo "<div class='check-item pass'>✅ <strong>MySQL Version:</strong> $mysqlVersion</div>";
    
    // Check if cineflix database exists
    $result = $testConn->query("SHOW DATABASES LIKE 'cineflix'");
    if ($result && $result->num_rows > 0) {
        echo "<div class='check-item pass'>✅ <strong>Cineflix Database:</strong> Database exists</div>";
        
        // Select the database and check tables
        $testConn->select_db('cineflix');
        $result = $testConn->query("SHOW TABLES");
        $tableCount = $result ? $result->num_rows : 0;
        
        if ($tableCount > 0) {
            echo "<div class='check-item pass'>✅ <strong>Database Tables:</strong> Found $tableCount table(s)</div>";
        } else {
            echo "<div class='check-item warn'>⚠️ <strong>Database Tables:</strong> No tables found</div>";
        }
    } else {
        echo "<div class='check-item warn'>⚠️ <strong>Cineflix Database:</strong> Database doesn't exist</div>";
    }
    
    $testConn->close();
    
} catch (Exception $e) {
    echo "<div class='check-item fail'>❌ <strong>MySQL:</strong> " . $e->getMessage() . "</div>";
    $allGood = false;
}

// Check 3: File System
echo "<h2>📁 File System Checks</h2>";

// Check if key files exist
$requiredFiles = [
    'index.php' => 'Main application entry point',
    'config/db_connect.php' => 'Database connection configuration',
    'css/style.css' => 'Application stylesheets',
    'js/script.js' => 'Application JavaScript',
    'api/login.php' => 'Login API endpoint',
    'sql/cineflix.sql' => 'Database schema and sample data'
];

foreach ($requiredFiles as $file => $description) {
    if (file_exists(__DIR__ . '/' . $file)) {
        $fileSize = filesize(__DIR__ . '/' . $file);
        $fileSizeKB = round($fileSize / 1024, 1);
        echo "<div class='check-item pass'>✅ <strong>$file:</strong> $description ({$fileSizeKB}KB)</div>";
    } else {
        echo "<div class='check-item fail'>❌ <strong>$file:</strong> Missing - $description</div>";
        $allGood = false;
    }
}

// Check directory permissions
$checkDirs = ['./', './api/', './css/', './js/', './images/'];
foreach ($checkDirs as $dir) {
    if (is_dir(__DIR__ . '/' . $dir)) {
        if (is_readable(__DIR__ . '/' . $dir)) {
            echo "<div class='check-item pass'>✅ <strong>Directory $dir:</strong> Readable</div>";
        } else {
            echo "<div class='check-item fail'>❌ <strong>Directory $dir:</strong> Not readable</div>";
            $allGood = false;
        }
    }
}

// Check 4: Network/URL Configuration
echo "<h2>🌐 Network Configuration</h2>";

$currentUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$currentUrl = dirname($currentUrl);
echo "<div class='check-item pass'>✅ <strong>Current URL:</strong> $currentUrl</div>";

$expectedUrl = "http://localhost/Cineflix";
if (strpos($currentUrl, 'localhost') !== false) {
    echo "<div class='check-item pass'>✅ <strong>URL Structure:</strong> Accessible via localhost</div>";
    echo "<div class='info'>🔗 <strong>Application URL:</strong> <a href='$currentUrl/index.php'>$currentUrl/index.php</a></div>";
} else {
    echo "<div class='check-item warn'>⚠️ <strong>URL Structure:</strong> Not on localhost (current: $currentUrl)</div>";
}

// Final Summary
echo "<div style='margin-top: 30px; padding: 20px; border-radius: 8px; " . 
     ($allGood ? "background: #d4edda; border: 2px solid #28a745;" : "background: #f8d7da; border: 2px solid #dc3545;") . "'>";

if ($allGood) {
    echo "<h3 style='color: #155724; margin: 0;'>🎉 Configuration Check Passed!</h3>";
    echo "<p style='color: #155724; margin: 10px 0 0 0;'>Your XAMPP environment is properly configured for Cineflix.</p>";
    echo "<div style='margin-top: 15px;'>";
    echo "<a href='init_db.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🚀 Initialize Database</a>";
    echo "<a href='check_setup.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🔍 Check Setup</a>";
    echo "<a href='index.php' style='background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📱 Launch App</a>";
    echo "</div>";
} else {
    echo "<h3 style='color: #721c24; margin: 0;'>⚠️ Configuration Issues Found</h3>";
    echo "<p style='color: #721c24; margin: 10px 0 0 0;'>Please fix the issues above before proceeding.</p>";
    echo "<div style='margin-top: 15px;'>";
    echo "<a href='config_check.php' style='background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🔄 Recheck Config</a>";
    echo "<p style='margin: 15px 0 0 0; color: #721c24;'>";
    echo "<strong>Common Solutions:</strong><br>";
    echo "• Make sure XAMPP Apache and MySQL services are running<br>";
    echo "• Check that PHP extensions are enabled in php.ini<br>";
    echo "• Verify file permissions and paths<br>";
    echo "• Restart XAMPP services if needed";
    echo "</p>";
    echo "</div>";
}

echo "</div>";

echo "    </div>
</body>
</html>";

// Helper function to convert PHP size strings to bytes
function return_bytes($size_str) {
    switch (substr($size_str, -1)) {
        case 'M': case 'm': return (int)$size_str * 1048576;
        case 'K': case 'k': return (int)$size_str * 1024;
        case 'G': case 'g': return (int)$size_str * 1073741824;
        default: return $size_str;
    }
}
?>