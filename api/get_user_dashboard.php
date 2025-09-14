<?php
// api/get_user_dashboard.php
header('Content-Type: application/json');
require_once '../config/db_connect.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit();
}

$userId = $_SESSION['user']['id'];
$response = ['success' => true];

// 1. Get User Details
$stmt = $conn->prepare("SELECT username, email, subscription, profile_pic_url FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$response['userDetails'] = $stmt->get_result()->fetch_assoc();
$stmt->close();

// 2. Get Watch History (e.g., last 12 items)
$stmt = $conn->prepare("SELECT m.* FROM media m JOIN watch_history wh ON m.id = wh.media_id WHERE wh.user_id = ? ORDER BY wh.watched_at DESC LIMIT 12");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$history = [];
while ($row = $result->fetch_assoc()) {
    $history[] = $row;
}
$response['watchHistory'] = $history;
$stmt->close();

echo json_encode($response);
$conn->close();
?>