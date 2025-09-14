<?php
// api/delete_media.php

// Set the response header to JSON
header('Content-Type: application/json');

// Include the database connection, which also starts the session
require_once '../config/db_connect.php';

// --- Security Check: Ensure the user is an authenticated admin ---
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['role'] !== 'super_admin')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

// --- Get the Media ID from the POST request (JSON format) ---
$data = json_decode(file_get_contents('php://input'), true);
$mediaId = $data['id'] ?? 0;

// --- Validate the received ID ---
if (empty($mediaId) || !is_numeric($mediaId)) {
    // If the ID is missing or invalid, send an error response
    echo json_encode(['success' => false, 'message' => 'Invalid or missing Media ID.']);
    exit();
}

// --- Prepare the SQL DELETE statement to prevent SQL injection ---
$sql = "DELETE FROM media WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    // Handle potential errors during statement preparation
    echo json_encode(['success' => false, 'message' => 'Database prepare failed: ' . $conn->error]);
    exit();
}

// Bind the integer ID parameter
$stmt->bind_param("i", $mediaId);

// --- Execute the statement and respond accordingly ---
if ($stmt->execute()) {
    // Check if any row was actually deleted
    if ($stmt->affected_rows > 0) {
        // Deletion was successful
        echo json_encode(['success' => true, 'message' => 'Media item deleted successfully.']);
    } else {
        // No rows were affected, meaning the ID was not found
        echo json_encode(['success' => false, 'message' => 'Media item not found or already deleted.']);
    }
} else {
    // The execute call failed for some reason
    echo json_encode(['success' => false, 'message' => 'Failed to delete media item: ' . $stmt->error]);
}

// --- Clean up and close connections ---
$stmt->close();
$conn->close();

?>