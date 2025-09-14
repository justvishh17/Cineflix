<?php
// api/cancel_subscription.php (Correct Version)

header('Content-Type: application/json');
require_once '../db_connect.php';

// 1. Security check: Ensure a user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit();
}

$userId = $_SESSION['user']['id'];

// 2. Prepare and execute the database update
$stmt = $conn->prepare("UPDATE users SET subscription = 'None' WHERE id = ?");
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    // 3. Update the session and send success message
    $_SESSION['user']['subscription'] = 'None';
    echo json_encode(['success' => true, 'message' => 'Your subscription has been cancelled.']);
    
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to cancel subscription.']);
}

$stmt->close();
$conn->close();
?>