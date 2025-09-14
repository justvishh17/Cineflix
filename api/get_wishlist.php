<?php
// api/get_wishlist.php
header('Content-Type: application/json');
require_once '../config/db_connect.php';

// Security: Ensure user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to view your wishlist.']);
    exit();
}

$userId = $_SESSION['user']['id'];

// SQL to get all media details for items in the user's watchlist
$sql = "SELECT m.* FROM media m JOIN watchlist w ON m.id = w.media_id WHERE w.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$wishlistItems = [];
while ($row = $result->fetch_assoc()) {
    $wishlistItems[] = $row;
}

echo json_encode(['success' => true, 'wishlist' => $wishlistItems]);

$stmt->close();
$conn->close();
?>