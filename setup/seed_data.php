<?php
/**
 * Sample Data Script for Cineflix
 * This script adds additional sample content and test data
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Cineflix Sample Data</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .info { color: #007bff; }
        .step { margin: 15px 0; padding: 10px; border-left: 4px solid #007bff; background: #f8f9fa; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🎬 Cineflix Sample Data Generator</h1>";

try {
    require_once '../config/db_connect.php';
    echo "<div class='success'>✅ Connected to database</div>";

    // Check if we should load the full SQL file data
    echo "<div class='step'><strong>Loading Media Content...</strong></div>";
    
    $sqlFile = __DIR__ . '/sql/cineflix.sql';
    if (file_exists($sqlFile)) {
        $sqlContent = file_get_contents($sqlFile);
        
        // Clear existing media to avoid duplicates
        $conn->query("DELETE FROM likes WHERE media_id > 0");
        $conn->query("DELETE FROM watchlist WHERE media_id > 0");
        $conn->query("DELETE FROM watch_history WHERE media_id > 0");
        $conn->query("DELETE FROM media WHERE id > 0");
        $conn->query("ALTER TABLE media AUTO_INCREMENT = 1");
        
        // Extract and execute media INSERT statements
        if (preg_match_all('/INSERT INTO `media`[^;]+;/s', $sqlContent, $matches)) {
            foreach ($matches[0] as $statement) {
                if ($conn->query($statement)) {
                    echo "<div class='info'>📽️ Inserted media batch</div>";
                } else {
                    echo "<div class='error'>❌ Error inserting media: " . $conn->error . "</div>";
                }
            }
        }
        
        // Extract and execute likes INSERT statements
        if (preg_match_all('/INSERT[^;]*INTO `likes`[^;]+;/s', $sqlContent, $matches)) {
            foreach ($matches[0] as $statement) {
                if ($conn->query($statement)) {
                    echo "<div class='info'>👍 Inserted likes data</div>";
                } else {
                    echo "<div class='error'>❌ Error inserting likes: " . $conn->error . "</div>";
                }
            }
        }
        
        echo "<div class='success'>✅ Media content loaded from SQL file</div>";
    } else {
        echo "<div class='info'>📁 SQL file not found, creating basic sample data...</div>";
        
        // Basic sample media if SQL file doesn't exist
        $sampleMedia = [
            ["Inception", 2010, 8.8, "https://image.tmdb.org/t/p/w500/oYuLEt3zVCKq27gApcjBJUuNXwg.jpg", "A thief who steals corporate secrets through dream-sharing technology.", 1, "movie"],
            ["The Dark Knight", 2008, 9.0, "https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg", "The Joker wreaks havoc on Gotham.", 0, "movie"],
            ["Breaking Bad", 2008, 9.5, "https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg", "A chemistry teacher turns to manufacturing meth.", 1, "webseries"],
            ["Stranger Things", 2016, 8.7, "https://image.tmdb.org/t/p/w500/49WJfeN0moxb9IPfGn8AIqMGskD.jpg", "Kids uncover supernatural mysteries.", 1, "webseries"],
            ["Parasite", 2019, 8.5, "https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg", "A poor family infiltrates a wealthy household.", 0, "movie"]
        ];
        
        foreach ($sampleMedia as $media) {
            $stmt = $conn->prepare("INSERT INTO media (title, year, rating, poster, description, exclusive, type) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sidssds", $media[0], $media[1], $media[2], $media[3], $media[4], $media[5], $media[6]);
            $stmt->execute();
        }
        echo "<div class='success'>✅ Basic sample media created</div>";
    }

    // Create sample user interactions
    echo "<div class='step'><strong>Creating Sample User Interactions...</strong></div>";
    
    // Add some items to test user's watchlist
    $testUserId = 2; // testuser
    $sampleWatchlist = [1, 3, 5]; // Movie/series IDs to add to watchlist
    
    foreach ($sampleWatchlist as $mediaId) {
        $stmt = $conn->prepare("INSERT IGNORE INTO watchlist (user_id, media_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $testUserId, $mediaId);
        $stmt->execute();
    }
    echo "<div class='success'>✅ Sample watchlist items created for test user</div>";
    
    // Add some viewing history
    $sampleHistory = [2, 4]; // Movie/series IDs for viewing history
    foreach ($sampleHistory as $mediaId) {
        $stmt = $conn->prepare("INSERT IGNORE INTO watch_history (user_id, media_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $testUserId, $mediaId);
        $stmt->execute();
    }
    echo "<div class='success'>✅ Sample viewing history created for test user</div>";

    // Get final counts
    $mediaCount = $conn->query("SELECT COUNT(*) as count FROM media")->fetch_assoc()['count'];
    $userCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
    $likesCount = $conn->query("SELECT COUNT(*) as count FROM likes")->fetch_assoc()['count'];
    $watchlistCount = $conn->query("SELECT COUNT(*) as count FROM watchlist")->fetch_assoc()['count'];
    $historyCount = $conn->query("SELECT COUNT(*) as count FROM watch_history")->fetch_assoc()['count'];

    echo "<div class='step' style='border-color: #28a745; background: #d4edda;'>
            <h3 style='color: #155724; margin: 0;'>🎉 Sample Data Generation Complete!</h3>
            <ul style='margin: 10px 0; color: #155724;'>
                <li>📽️ Media Items: $mediaCount</li>
                <li>👥 Users: $userCount</li>
                <li>👍 Likes: $likesCount</li>
                <li>📋 Watchlist Items: $watchlistCount</li>
                <li>📺 History Items: $historyCount</li>
            </ul>
          </div>";

    echo "<div class='info'>
            <strong>Test Account Details:</strong><br>
            <strong>Admin:</strong> admin@cineflix.com / admin123<br>
            <strong>Test User:</strong> test@example.com / test123<br>
            <strong>Subscriber:</strong> sub@example.com / test123<br>
            <br>
            <strong>Next:</strong> <a href='index.php'>Go to Cineflix</a> | 
            <a href='check_setup.php'>Verify Setup</a>
          </div>";

} catch (Exception $e) {
    echo "<div class='error'>❌ <strong>Error:</strong> " . $e->getMessage() . "</div>";
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}

echo "    </div>
</body>
</html>";
?>