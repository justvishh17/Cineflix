<?php
// api/remove_from_wishlist.php
header('Content-Type: application/json');
require_once '../db_connect.php';

// --- Security: Ensure a user is logged in ---
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to modify your wishlist.']);
    exit();
}

// Get the user's ID from their session
$userId = $_SESSION['user']['id'];

// Get the media ID from the POST request body
$data = json_decode(file_get_contents('php://input'));
$mediaId = $data->mediaId ?? null;

// --- Input Validation ---
if (!$mediaId || !is_numeric($mediaId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid media ID provided.']);
    exit();
}

// --- Prepare and Execute SQL Statement ---
// The query will only delete the entry if it matches BOTH the user's ID and the media's ID.
// This prevents one user from deleting items from another user's wishlist.
$sql = "DELETE FROM watchlist WHERE user_id = ? AND media_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $mediaId);

if ($stmt->execute()) {
    // Check if a row was actually deleted.
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Removed from your wishlist!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Item was not in your wishlist.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to remove item from wishlist.']);
}

// --- Clean up ---
$stmt->close();
$conn->close();
?>