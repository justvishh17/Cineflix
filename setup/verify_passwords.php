<?php
// Test script to verify password hashes

echo "<h3>Password Verification Test</h3>";

$passwords = [
    'admin123',
    'test123'
];

$hashes = [
    '$2y$10$EKKg28NCt35D2xI74tq/N.kG9E.VLz2T6sPTtEwT7G/G0x4A6fCUC',
    '$2y$10$wAXJ5hH2P5E7fR.y8U.jZOJmX2fKbY3K6Z/1yQG.zG.8uY8wL9C.e'
];

for ($i = 0; $i < count($passwords); $i++) {
    $password = $passwords[$i];
    $hash = $hashes[$i];
    $result = password_verify($password, $hash);
    echo "<p>Password '$password' vs hash: " . ($result ? "✅ MATCH" : "❌ NO MATCH") . "</p>";
}

// Generate correct hashes
echo "<h3>Generating Fresh Hashes</h3>";
foreach ($passwords as $password) {
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    echo "<p>Password '$password': $newHash</p>";
}
?>