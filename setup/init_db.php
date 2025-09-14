<?php
/**
 * Database Initialization Script for Cineflix
 * This script creates the database and all required tables
 * Run this file once after setting up XAMPP to initialize your database
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cineflix";

echo "<!DOCTYPE html>
<html>
<head>
    <title>Cineflix Database Initialization</title>
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
        <h1>🎬 Cineflix Database Initialization</h1>";

try {
    // Step 1: Connect to MySQL (without database)
    echo "<div class='step'><strong>Step 1:</strong> Connecting to MySQL server...</div>";
    $conn = new mysqli($servername, $username, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "<div class='success'>✅ Connected to MySQL server successfully!</div>";

    // Step 2: Create database if it doesn't exist
    echo "<div class='step'><strong>Step 2:</strong> Creating database '$dbname'...</div>";
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✅ Database '$dbname' created or already exists!</div>";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }

    // Step 3: Select the database
    $conn->select_db($dbname);
    echo "<div class='info'>📂 Selected database '$dbname'</div>";

    // Step 4: Create tables
    echo "<div class='step'><strong>Step 3:</strong> Creating database tables...</div>";
    
    // Disable foreign key checks to allow dropping tables in any order
    echo "<div class='info'>� Disabling foreign key checks...</div>";
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    
    // Drop all existing tables first
    echo "<div class='info'>🗑️ Dropping existing tables...</div>";
    $tables = ['likes', 'watchlist', 'watch_history', 'media', 'users', 'subscriptions', 'plans'];
    foreach ($tables as $table) {
        $conn->query("DROP TABLE IF EXISTS `$table`");
    }
    
    // Re-enable foreign key checks
    echo "<div class='info'>🔧 Re-enabling foreign key checks...</div>";
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");

    // Users table
    echo "<div class='info'>📋 Creating users table...</div>";
    $sql = "CREATE TABLE `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(50) NOT NULL,
        `email` varchar(100) NOT NULL,
        `password` varchar(255) NOT NULL,
        `subscription` varchar(50) NOT NULL DEFAULT 'None',
        `role` enum('user','admin','super_admin') NOT NULL DEFAULT 'user',
        `profile_pic_url` varchar(255) DEFAULT 'https://i.pravatar.cc/150',
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `username` (`username`),
        UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✅ Users table created successfully!</div>";
    } else {
        throw new Exception("Error creating users table: " . $conn->error);
    }

    // Media table
    echo "<div class='info'>📋 Creating media table...</div>";
    $sql = "CREATE TABLE `media` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `year` int(11) NOT NULL,
        `rating` decimal(3,1) NOT NULL,
        `poster` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `exclusive` tinyint(1) NOT NULL DEFAULT 0,
        `type` varchar(50) NOT NULL DEFAULT 'movie',
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✅ Media table created successfully!</div>";
    } else {
        throw new Exception("Error creating media table: " . $conn->error);
    }

    // Likes table
    echo "<div class='info'>📋 Creating likes table...</div>";
    $sql = "CREATE TABLE `likes` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `media_id` int(11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `user_media_like_unique` (`user_id`,`media_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✅ Likes table created successfully!</div>";
    } else {
        throw new Exception("Error creating likes table: " . $conn->error);
    }

    // Watchlist table
    echo "<div class='info'>📋 Creating watchlist table...</div>";
    $sql = "CREATE TABLE `watchlist` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `media_id` int(11) NOT NULL,
        `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `user_media_watchlist_unique` (`user_id`,`media_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✅ Watchlist table created successfully!</div>";
    } else {
        throw new Exception("Error creating watchlist table: " . $conn->error);
    }

    // Watch History table
    echo "<div class='info'>📋 Creating watch_history table...</div>";
    $sql = "CREATE TABLE `watch_history` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `media_id` int(11) NOT NULL,
        `watched_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `user_media_history_unique` (`user_id`,`media_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✅ Watch History table created successfully!</div>";
    } else {
        throw new Exception("Error creating watch_history table: " . $conn->error);
    }

    // Subscriptions table
    echo "<div class='info'>📋 Creating subscriptions table...</div>";
    $sql = "CREATE TABLE `subscriptions` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `price` decimal(10,2) NOT NULL,
        `billing_cycle` enum('monthly','annual') NOT NULL DEFAULT 'monthly',
        `features` text NOT NULL,
        `is_popular` tinyint(1) NOT NULL DEFAULT 0,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✅ Subscriptions table created successfully!</div>";
    } else {
        throw new Exception("Error creating subscriptions table: " . $conn->error);
    }

    // Plans table (alias for subscriptions for backward compatibility)
    echo "<div class='info'>📋 Creating plans table...</div>";
    $sql = "CREATE TABLE `plans` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `price` decimal(10,2) NOT NULL,
        `billing_cycle` enum('monthly','annual') NOT NULL DEFAULT 'monthly',
        `features` text NOT NULL,
        `is_popular` tinyint(1) NOT NULL DEFAULT 0,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✅ Plans table created successfully!</div>";
    } else {
        throw new Exception("Error creating plans table: " . $conn->error);
    }

    // Step 5: Insert sample data
    echo "<div class='step'><strong>Step 4:</strong> Inserting sample data...</div>";

    // Insert default users
    $sql = "INSERT INTO `users` (`id`, `username`, `email`, `password`, `subscription`, `role`) VALUES
        (1, 'admin', 'admin@cineflix.com', '$2y$10$EKKg28NCt35D2xI74tq/N.kG9E.VLz2T6sPTtEwT7G/G0x4A6fCUC', 'Diamond+', 'super_admin'),
        (2, 'testuser', 'test@example.com', '$2y$10$wAXJ5hH2P5E7fR.y8U.jZOJmX2fKbY3K6Z/1yQG.zG.8uY8wL9C.e', 'None', 'user'),
        (3, 'subscriber', 'sub@example.com', '$2y$10$9G9r8o7sP.fA3bE4C5D6E7fG8hI9jK0lM1nO2pQ3rS4tU5vW6xY7', 'Diamond', 'admin')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✅ Default users inserted!</div>";
        echo "<div class='info'>👤 Default admin: admin@cineflix.com / password: admin123</div>";
        echo "<div class='info'>👤 Test user: test@example.com / password: test123</div>";
    } else {
        echo "<div class='error'>⚠️ Warning: Could not insert default users (they may already exist)</div>";
    }

    // Insert subscription plans
    $sql = "INSERT INTO `subscriptions` (`id`, `name`, `price`, `billing_cycle`, `features`, `is_popular`) VALUES
        (1, 'Basic', 9.99, 'monthly', 'Good video quality (720p);Watch on 1 device at a time', 0),
        (2, 'Standard', 15.99, 'monthly', 'Great video quality (1080p);Watch on 2 devices at a time', 0),
        (3, 'Diamond', 19.99, 'monthly', 'Best video quality (4K+HDR);Watch on 4 devices at a time', 1),
        (4, 'Diamond+', 25.99, 'monthly', 'Ultimate video quality (4K+HDR);Watch on 6 devices at a time', 0),
        (5, 'Basic Annual', 99.99, 'annual', 'Good video quality (720p);Watch on 1 device at a time', 0),
        (6, 'Standard Annual', 159.99, 'annual', 'Great video quality (1080p);Watch on 2 devices at a time', 0),
        (7, 'Diamond Annual', 199.99, 'annual', 'Best video quality (4K+HDR);Watch on 4 devices at a time', 0),
        (8, 'Diamond+ Annual', 259.99, 'annual', 'Ultimate video quality (4K+HDR);Watch on 6 devices at a time', 0)";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✅ Subscription plans inserted!</div>";
    } else {
        echo "<div class='error'>⚠️ Warning: Could not insert subscription plans</div>";
    }

    // Copy subscription plans to plans table
    $sql = "INSERT INTO `plans` SELECT * FROM `subscriptions`";
    $conn->query($sql);

    // Step 6: Load media data from SQL file if it exists
    echo "<div class='step'><strong>Step 5:</strong> Loading media data...</div>";
    $sqlFile = __DIR__ . '/sql/cineflix.sql';
    
    if (file_exists($sqlFile)) {
        $sqlContent = file_get_contents($sqlFile);
        
        // Split SQL content into individual statements
        $statements = explode(';', $sqlContent);
        
        $mediaInserted = false;
        $likesInserted = false;
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            
            // Skip empty statements or comments
            if (empty($statement) || strpos($statement, '--') === 0 || strpos($statement, 'CREATE TABLE') !== false || strpos($statement, 'DROP TABLE') !== false) {
                continue;
            }
            
            // Handle media INSERT statements
            if (strpos($statement, 'INSERT INTO `media`') !== false) {
                if ($conn->query($statement . ';')) {
                    if (!$mediaInserted) {
                        echo "<div class='info'>📽️ Loading media data...</div>";
                        $mediaInserted = true;
                    }
                } else {
                    echo "<div class='error'>⚠️ Error inserting media: " . $conn->error . "</div>";
                }
            }
            
            // Handle likes INSERT statements
            if (strpos($statement, 'INSERT') !== false && strpos($statement, '`likes`') !== false) {
                if ($conn->query($statement . ';')) {
                    if (!$likesInserted) {
                        echo "<div class='info'>👍 Loading likes data...</div>";
                        $likesInserted = true;
                    }
                } else {
                    echo "<div class='error'>⚠️ Error inserting likes: " . $conn->error . "</div>";
                }
            }
        }
        
        if ($mediaInserted) {
            echo "<div class='success'>✅ Media data loaded from SQL file!</div>";
        }
        if ($likesInserted) {
            echo "<div class='success'>✅ Likes data loaded from SQL file!</div>";
        }
        
        if (!$mediaInserted && !$likesInserted) {
            echo "<div class='info'>� No INSERT statements found in SQL file, creating basic sample media...</div>";
            
            // Insert basic sample media
            $sql = "INSERT INTO `media` (`title`, `year`, `rating`, `poster`, `description`, `exclusive`, `type`) VALUES
                ('Inception', 2010, 8.8, 'https://image.tmdb.org/t/p/w500/oYuLEt3zVCKq27gApcjBJUuNXwg.jpg', 'A thief who steals corporate secrets through dream-sharing technology.', 1, 'movie'),
                ('The Dark Knight', 2008, 9.0, 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 'The Joker wreaks havoc on Gotham.', 0, 'movie'),
                ('Breaking Bad', 2008, 9.5, 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg', 'A chemistry teacher turns to manufacturing meth.', 1, 'webseries')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<div class='success'>✅ Sample media data inserted!</div>";
            }
        }
    } else {
        echo "<div class='info'>📁 SQL file not found, creating basic sample media...</div>";
        
        // Insert basic sample media
        $sql = "INSERT INTO `media` (`title`, `year`, `rating`, `poster`, `description`, `exclusive`, `type`) VALUES
            ('Inception', 2010, 8.8, 'https://image.tmdb.org/t/p/w500/oYuLEt3zVCKq27gApcjBJUuNXwg.jpg', 'A thief who steals corporate secrets through dream-sharing technology.', 1, 'movie'),
            ('The Dark Knight', 2008, 9.0, 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 'The Joker wreaks havoc on Gotham.', 0, 'movie'),
            ('Breaking Bad', 2008, 9.5, 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg', 'A chemistry teacher turns to manufacturing meth.', 1, 'webseries')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<div class='success'>✅ Sample media data inserted!</div>";
        }
    }

    echo "<div class='step' style='border-color: #28a745; background: #d4edda;'>
            <h3 style='color: #155724; margin: 0;'>🎉 Database Initialization Complete!</h3>
            <p style='margin: 10px 0 0 0; color: #155724;'>
                Your Cineflix database is now ready to use. You can access the application at:
                <br><strong>http://localhost/Cineflix/</strong>
            </p>
          </div>";
    
    echo "<div class='info'>
            <strong>Next Steps:</strong><br>
            1. Navigate to <a href='index.php'>http://localhost/Cineflix/</a><br>
            2. Login with admin@cineflix.com / admin123<br>
            3. Or create a new account via the signup page<br>
            4. Run <a href='check_setup.php'>check_setup.php</a> to verify everything is working
          </div>";

} catch (Exception $e) {
    echo "<div class='error'>❌ <strong>Error:</strong> " . $e->getMessage() . "</div>";
    echo "<div class='info'>
            <strong>Troubleshooting:</strong><br>
            1. Make sure XAMPP Apache and MySQL are running<br>
            2. Check if MySQL is accessible on localhost:3306<br>
            3. Verify the database credentials in config/db_connect.php<br>
            4. Run this script again after fixing any issues
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