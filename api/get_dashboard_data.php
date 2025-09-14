
<?php
// api/get_dashboard_data.php

// Set the response header to JSON
header('Content-Type: application/json');

// Include the database connection, which also starts the session
require_once '../db_connect.php';

// --- Security Check: Ensure the user is an authenticated admin ---
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['role'] !== 'super_admin')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access. Admin privileges required.']);
    exit();
}

try {
    $response = ['success' => true];

    // 1. Get total users count
    $result = $conn->query("SELECT COUNT(*) as total FROM users");
    $response['totalUsers'] = $result->fetch_assoc()['total'];

    // 2. Get total subscriptions count (users with non-null subscription)
    $result = $conn->query("SELECT COUNT(*) as total FROM users WHERE subscription IS NOT NULL AND subscription != 'None'");
    $response['totalSubs'] = $result->fetch_assoc()['total'];

    // 3. Get all users data
    $result = $conn->query("SELECT id, username, email, subscription, role FROM users ORDER BY id");
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $response['users'] = $users;

    // 4. Get all media data
    $result = $conn->query("SELECT id, title, year, rating, poster, description, exclusive, type FROM media ORDER BY id DESC");
    $media = [];
    while ($row = $result->fetch_assoc()) {
        $media[] = $row;
    }
    $response['media'] = $media;

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

// --- Clean up and close connection ---
$conn->close();

?>