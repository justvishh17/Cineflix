<?php
// api/get_wishlist.php (Corrected Version)
header('Content-Type: application/json');
require_once '../db_connect.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to view your wishlist.']);
    exit();
}

$userId = $_SESSION['user']['id'];

// This powerful query finds the user's wishlist items AND counts the likes for each one.
$sql = "
    SELECT
        m.*,
        COUNT(l.media_id) AS like_count
    FROM
        media m
    JOIN
        watchlist w ON m.id = w.media_id
    LEFT JOIN
        likes l ON m.id = l.media_id
    WHERE
        w.user_id = ?
    GROUP BY
        m.id
    ORDER BY
        w.added_at DESC;
";

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