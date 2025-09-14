<?php
// api/add_to_history.php
header('Content-Type: application/json');
require_once '../config/db_connect.php';

if (!isset($_SESSION['user'])) { exit(); } // Silently exit if not logged in

$userId = $_SESSION['user']['id'];
$mediaId = json_decode(file_get_contents('php://input'))->mediaId ?? null;

if (!$mediaId) { exit(); }

// "INSERT ... ON DUPLICATE KEY UPDATE" will add a new record,
// or just update the 'watched_at' timestamp if the user re-watches something.
$sql = "INSERT INTO watch_history (user_id, media_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE watched_at = NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $mediaId);
$stmt->execute();
$stmt->close();
$conn->close();
echo json_encode(['success' => true]);
?>