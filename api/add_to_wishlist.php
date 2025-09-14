<?php
// api/add_to_wishlist.php
header('Content-Type: application/json');
require_once '../db_connect.php';

// Security: Ensure user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to add to your wishlist.']);
    exit();
}

$userId = $_SESSION['user']['id'];
$mediaId = json_decode(file_get_contents('php://input'))->mediaId ?? null;

if (!$mediaId || !is_numeric($mediaId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid media ID.']);
    exit();
}

// --- START: New 2-Step Logic ---

// 1. First, CHECK if the item is already in the wishlist
$checkSql = "SELECT id FROM watchlist WHERE user_id = ? AND media_id = ?";
$stmt = $conn->prepare($checkSql);
$stmt->bind_param("ii", $userId, $mediaId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If a row is found, the item is already there. Send a specific message.
    echo json_encode(['success' => false, 'alreadyExists' => true, 'message' => 'This item is already in your wishlist.']);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// 2. If it's not there, THEN add it
$insertSql = "INSERT INTO watchlist (user_id, media_id) VALUES (?, ?)";
$stmt = $conn->prepare($insertSql);
$stmt->bind_param("ii", $userId, $mediaId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Added to your wishlist!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add to wishlist.']);
}

// --- END: New 2-Step Logic ---

$stmt->close();
$conn->close();
?>